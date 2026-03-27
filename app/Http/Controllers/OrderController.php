<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class OrderController extends Controller
{
    // Show cart (session-based)
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // Add product to cart via session
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        $pid = $product->id;
        if (isset($cart[$pid])) {
            $cart[$pid]['quantity'] += $request->quantity;
        } else {
            $cart[$pid] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'discount' => $product->discount,
                'quantity' => $request->quantity,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('home')->with('success', 'Producto agregado al carrito.');
    }

    // Remove item from cart
    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart');
    }

    // Place order
    public function store(Request $request)
    {
        $request->validate([
            'client_name'    => 'required|string|max:255',
            'phone_number'   => 'required|string|max:30',
            'payment_method' => 'required|in:transferencia,efectivo',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'El carrito está vacío.');
        }

        // Calculate subtotal
        $subtotal = 0;
        foreach ($cart as $item) {
            $effectivePrice = $item['price'] * (1 - ($item['discount'] / 100));
            $subtotal += $effectivePrice * $item['quantity'];
        }

        // Find applicable fee
        $fee = Fee::where('minFee', '<=', $subtotal)
               ->where('maxFee', '>=', $subtotal)
                   ->first();

        $total = $fee ? $subtotal * (1 + $fee->percentage / 100) : $subtotal;

        $order = Order::create([
            'fee_id'         => $fee?->id,
            'client_name'    => $request->client_name,
            'phone_number'   => $request->phone_number,
            'payment_method' => $request->payment_method,
            'total'          => round($total, 2),
            'is_recieved'    => false,
        ]);

        $hasQuantityColumn = Schema::hasColumn('order_products', 'quantity');

        foreach ($cart as $item) {
            $orderProductData = [
                'order_id'   => $order->id,
                'product_id' => $item['id'],
            ];

            if ($hasQuantityColumn) {
                $orderProductData['quantity'] = $item['quantity'];
            }

            OrderProduct::create($orderProductData);
        }

        session()->forget('cart');

        return redirect()->route('confirmation', $order->id);
    }

    // Confirmation page
    public function confirmation(Order $order)
    {
        $order->load('orderProducts.product');
        return view('confirmation', compact('order'));
    }

    // Admin: pending orders
    public function dashboard()
    {
        $orders = Order::with('orderProducts.product')
                        ->where('is_recieved', false)
                        ->orderBy('created_at', 'asc')
                        ->get();
        return view('dashboard', compact('orders'));
    }

    // Admin: toggle order received status
    public function toggleStatus(Order $order)
    {
        $order->update(['is_recieved' => !$order->is_recieved]);
        return redirect()->back()->with('success', 'Estado actualizado.');
    }

    // Admin: completed orders (history)
    public function history()
    {
        $orders = Order::with('orderProducts.product')
                        ->where('is_recieved', true)
                        ->orderBy('updated_at', 'desc')
                        ->get();
        return view('history', compact('orders'));
    }

    // Admin: wallet (today's summary)
    public function wallet()
    {
        $today = today();
        $orders = Order::with('orderProducts.product')
                        ->where('is_recieved', true)
                        ->whereDate('created_at', $today)
                        ->get();

        $total = $orders->sum('total');

        return view('wallet', compact('orders', 'total'));
    }
}
