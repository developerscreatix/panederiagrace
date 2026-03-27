<?php

namespace App\Http\Controllers;

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
        $categories = Category::with(['products.productIngredients.ingredient'])->get();
        return view('home', compact('categories'));
    }

    // Admin: list products
    public function adminIndex()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    // Admin: show create form
    public function create()
    {
        $categories   = Category::all();
        $ingredients  = Ingredient::all();
        return view('admin.products.create', compact('categories', 'ingredients'));
    }

    // Admin: store new product
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'discount'    => 'nullable|integer|min:0|max:100',
            'image'       => 'nullable|image|max:2048',
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'exists:ingredients,id',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $data['discount'] = $data['discount'] ?? 0;

        $product = Product::create($data);

        if (!empty($data['ingredients'])) {
            foreach ($data['ingredients'] as $ingredientId) {
                ProductIngredient::create([
                    'product_id'    => $product->id,
                    'ingredient_id' => $ingredientId,
                ]);
            }
        }

        return redirect()->route('admin.products')->with('success', 'Producto creado correctamente.');
    }

    // Admin: delete product
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Producto eliminado.');
    }
}
