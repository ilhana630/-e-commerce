<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,done,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        if ($oldStatus !== $request->status) {
            Cache::forget('dashboard.stats');
            $order->load('user', 'items.product');
            Mail::to($order->user->email)->send(new OrderStatusUpdated($order, $oldStatus));
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
