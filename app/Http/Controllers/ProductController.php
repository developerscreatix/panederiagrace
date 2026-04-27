<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductIngredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Public catalog (home page)
    public function index()
    {
        $categories = Category::with(['products' => function ($query) {
            $query->where('is_enabled', true)
                ->with('productIngredients.ingredient');
        }])->get();

        $categories = $categories->filter(fn ($category) => $category->products->isNotEmpty());

        $advertisements = Advertisement::orderBy('created_at', 'asc')->get();

        return view('home', compact('categories', 'advertisements'));
    }

    // Admin: list products
    public function adminIndex()
    {
        $products = Product::with('category')->orderByDesc('is_enabled')->orderBy('name')->get();
        return view('admin.products.index', compact('products'));
    }

    // Admin: show create form
    public function create()
    {
        $categories = Category::all();
        $regularIngredients = Ingredient::where('is_special', false)->orderBy('name')->get();
        $specialIngredients = Ingredient::where('is_special', true)->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'regularIngredients', 'specialIngredients'));
    }

    // Admin: store new product
    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $data['discount'] = $data['discount'] ?? 0;
        $data['is_enabled'] = true;

        $product = Product::create($data);

        $this->syncIngredients($product, $data['ingredients'] ?? []);

        return redirect()->route('admin.products')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
    {
        $product->load('productIngredients');
        $categories = Category::all();
        $regularIngredients = Ingredient::where('is_special', false)->orderBy('name')->get();
        $specialIngredients = Ingredient::where('is_special', true)->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'regularIngredients', 'specialIngredients'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request, $product);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['discount'] = $data['discount'] ?? 0;
        $product->update($data);
        $this->syncIngredients($product, $data['ingredients'] ?? []);

        return redirect()->route('admin.products')->with('success', 'Producto actualizado correctamente.');
    }

    public function toggleEnabled(Product $product)
    {
        $product->update([
            'is_enabled' => !$product->is_enabled,
        ]);

        $message = $product->is_enabled
            ? 'Producto habilitado correctamente.'
            : 'Producto deshabilitado correctamente.';

        return redirect()->route('admin.products')->with('success', $message);
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'image' => 'nullable|image|max:2048',
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'exists:ingredients,id',
        ]);
    }

    private function syncIngredients(Product $product, array $ingredientIds): void
    {
        $product->productIngredients()->delete();

        foreach ($ingredientIds as $ingredientId) {
            ProductIngredient::create([
                'product_id' => $product->id,
                'ingredient_id' => $ingredientId,
            ]);
        }
    }
}
