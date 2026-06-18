<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;
use Midtrans\Notification;

class OrderController extends Controller
{
    public function __construct()
    {
        MidtransConfig::$serverKey        = config('midtrans.server_key');
        MidtransConfig::$isProduction     = config('midtrans.is_production');
        MidtransConfig::$isSanitized      = config('midtrans.is_sanitized');
        MidtransConfig::$is3ds            = config('midtrans.is_3ds');
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'phone'            => 'required|string|max:20',
        ]);

        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $order = DB::transaction(function () use ($request, $cartItems) {
            $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

            $order = Order::create([
                'user_id'          => auth()->id(),
                'total_price'      => $total,
                'status'           => 'pending',
                'shipping_address' => $request->shipping_address,
                'phone'            => $request->phone,
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            CartItem::where('user_id', auth()->id())->delete();

            return $order;
        });

        Cache::forget('dashboard.stats');

        $order->load('items.product', 'user');
        Mail::to($order->user->email)->send(new OrderConfirmation($order));

        return redirect()->route('payment.page', $order);
    }

    public function paymentPage(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order);
        }

        $order->load('items.product');
        $user = auth()->user();

        $params = [
            'transaction_details' => [
                'order_id'     => 'ORDER-' . $order->id . '-' . time(),
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $order->phone,
            ],
            'item_details' => $order->items->map(fn($item) => [
                'id'       => $item->product_id,
                'price'    => (int) $item->price,
                'quantity' => $item->quantity,
                'name'     => substr($item->product->name, 0, 50),
            ])->toArray(),
            'callbacks' => [
                'finish' => route('payment.finish', $order),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap token error: ' . $e->getMessage());
            return redirect()->route('orders.show', $order)
                ->with('error', 'Gagal menghubungi payment gateway. Coba lagi nanti.');
        }

        $snapUrl    = config('midtrans.snap_url');
        $clientKey  = config('midtrans.client_key');

        return view('orders.payment', compact('order', 'snapToken', 'snapUrl', 'clientKey'));
    }

    public function paymentFinish(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Terima kasih! Pembayaran Anda sedang diproses.');
    }

    public function paymentNotification(Request $request)
    {
        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status;
            $orderId           = $notification->order_id;

            // order_id format: ORDER-{id}-{timestamp}
            $orderId = (int) explode('-', $orderId)[1];
            $order   = Order::findOrFail($orderId);

            $oldStatus = $order->status;

            if ($transactionStatus === 'capture') {
                $order->status = $fraudStatus === 'accept' ? 'paid' : 'pending';
            } elseif ($transactionStatus === 'settlement') {
                $order->status = 'paid';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->status = 'cancelled';
            } elseif ($transactionStatus === 'pending') {
                $order->status = 'pending';
            }

            $order->payment_ref = $notification->transaction_id ?? null;
            $order->save();

            if ($oldStatus !== $order->status) {
                $order->load('user', 'items.product');
                Mail::to($order->user->email)->send(new OrderStatusUpdated($order, $oldStatus));
            }

        } catch (\Exception $e) {
            Log::error('Midtrans notification error: ' . $e->getMessage());
            return response('error', 500);
        }

        return response('ok', 200);
    }
}
