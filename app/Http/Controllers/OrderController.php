<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

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
            'quantity' => 'required|integer|min:1',
            'special_ingredient_id' => 'nullable|integer',
        ]);

        $product = Product::where('is_enabled', true)
            ->with('productIngredients.ingredient')
            ->findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        $specialIngredient = $this->resolveSpecialIngredient($product, $request->input('special_ingredient_id'));

        $cartKey = $this->buildCartItemKey($product->id, $specialIngredient?->id);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = [
                'key' => $cartKey,
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'discount' => $product->discount,
                'quantity' => $request->quantity,
                'special_ingredient_id' => $specialIngredient?->id,
                'special_ingredient_name' => $specialIngredient?->name,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('home')->with('success', 'Producto agregado al carrito.');
    }

    // Remove item from cart
    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $cartKey = $request->input('cart_key', $request->input('product_id'));

        if ($cartKey !== null && isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart');
    }

    // Place order
    public function store(Request $request)
    {

        $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:30'],
            'pickup_time' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:500'],
            'payment_method' => ['required', 'in:transferencia,sucursal'],
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'El carrito está vacío.');
        }

        $products = Product::with('productIngredients.ingredient')
            ->whereIn('id', collect($cart)->pluck('id')->all())
            ->where('is_enabled', true)
            ->get()
            ->keyBy('id');

        // Calculate subtotal
        $subtotal = 0;
        foreach ($cart as $item) {
            $itemKey = $item['key'] ?? $this->buildCartItemKey($item['id'], $item['special_ingredient_id'] ?? null);
            $product = $products->get($item['id']);

            if (!$product) {
                throw ValidationException::withMessages([
                    'cart' => 'Uno de los productos del carrito ya no está disponible.',
                ]);
            }

            $selectedSpecialIngredient = $this->resolveSpecialIngredient($product, $item['special_ingredient_id'] ?? null);
            $effectivePrice = $product->price * (1 - ($product->discount / 100));
            $subtotal += $effectivePrice * $item['quantity'];

            $cart[$itemKey]['key'] = $itemKey;
            $cart[$itemKey]['price'] = $product->price;
            $cart[$itemKey]['discount'] = $product->discount;
            $cart[$itemKey]['special_ingredient_id'] = $selectedSpecialIngredient?->id;
            $cart[$itemKey]['special_ingredient_name'] = $selectedSpecialIngredient?->name;
        }

        session()->put('cart', $cart);

        // Find applicable fee
        $fee = Fee::where('minFee', '<=', $subtotal)
               ->where('maxFee', '>=', $subtotal)
                   ->first();

        $total = $fee ? $subtotal * (1 + $fee->percentage / 100) : $subtotal;

        $order = Order::create([
            'fee_id'         => $fee?->id,
            'client_name' => $request->client_name,
            'phone_number' => $request->phone_number,
            'payment_method' => $request->payment_method,
            'pickup_time' => $request->pickup_time,
            'notes' => $request->notes,
            'is_recieved'    => false,
            'total' => $total,
        ]);

        $hasQuantityColumn = Schema::hasColumn('order_products', 'quantity');
        $hasSpecialIngredientColumn = Schema::hasColumn('order_products', 'special_ingredient_id');

        foreach ($cart as $item) {
            $orderProductData = [
                'order_id' => $order->id,
                'product_id' => $item['id'],
            ];

            if ($hasSpecialIngredientColumn) {
                $orderProductData['special_ingredient_id'] = $item['special_ingredient_id'] ?? null;
            }

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
        $order->load('orderProducts.product', 'orderProducts.specialIngredient');
        return view('confirmation', compact('order'));
    }

    // Admin: pending orders
    public function dashboard()
    {
        $orders = Order::with('orderProducts.product', 'orderProducts.specialIngredient')
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
        $orders = Order::with('orderProducts.product', 'orderProducts.specialIngredient')
                        ->where('is_recieved', true)
                        ->orderBy('updated_at', 'desc')
                        ->get();
        return view('history', compact('orders'));
    }

    // Admin: wallet (today's summary)
    public function wallet()
    {
        $today = today();
        $orders = Order::with('orderProducts.product', 'orderProducts.specialIngredient')
                        ->where('is_recieved', true)
                        ->whereDate('created_at', $today)
                        ->get();

        $total = $orders->sum('total');

        return view('wallet', compact('orders', 'total'));
    }

    private function resolveSpecialIngredient(Product $product, $specialIngredientId): ?Ingredient
    {
        $specialIngredients = $product->productIngredients
            ->map->ingredient
            ->filter(fn ($ingredient) => $ingredient && $ingredient->is_special)
            ->values();

        if ($specialIngredients->isEmpty()) {
            return null;
        }

        if (!$specialIngredientId) {
            throw ValidationException::withMessages([
                'special_ingredient_id' => 'Selecciona una opción especial para este producto.',
            ]);
        }

        $selectedIngredient = $specialIngredients->firstWhere('id', (int) $specialIngredientId);

        if (!$selectedIngredient) {
            throw ValidationException::withMessages([
                'special_ingredient_id' => 'La opción especial seleccionada no pertenece a este producto.',
            ]);
        }

        return $selectedIngredient;
    }

    private function buildCartItemKey(int $productId, ?int $specialIngredientId): string
    {
        return $productId . ':' . ($specialIngredientId ?? 'base');
    }


    public function update(Request $request)
    {
        $request->validate([
            'cart_key' => ['required'],
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = session()->get('cart', []);
        $cartKey = $request->cart_key;

        foreach ($cart as $index => $item) {
            $currentKey = $item['key'] ?? $item['id'];

            if ((string) $currentKey === (string) $cartKey) {
                $cart[$index]['quantity'] = (int) $request->quantity;
                break;
            }
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Cantidad actualizada.');
    }
}
