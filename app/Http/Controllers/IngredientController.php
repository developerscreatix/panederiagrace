<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::orderByDesc('is_special')->orderBy('name')->get();
        return view('admin.ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('admin.ingredients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name',
            'is_special' => 'nullable|boolean',
        ]);

        $data['is_special'] = $request->boolean('is_special');

        Ingredient::create($data);

        return redirect()->route('admin.ingredients')->with('success', 'Ingrediente creado.');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('admin.ingredients')->with('success', 'Ingrediente eliminado.');
    }
}
