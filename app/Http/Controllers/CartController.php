<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        abort_if($cartItem->user_id !== auth()->id(), 403);

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(CartItem $cartItem)
    {
        abort_if($cartItem->user_id !== auth()->id(), 403);

        $cartItem->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
