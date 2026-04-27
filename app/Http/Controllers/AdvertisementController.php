<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::orderBy('created_at', 'desc')->get();
        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'required|image|max:4096',
        ]);

        $path = $request->file('image')->store('advertisements', 'public');
        $data['image'] = $path;

        Advertisement::create($data);

        return redirect()->route('admin.advertisements')->with('success', 'Publicidad agregada correctamente.');
    }

    public function destroy(Advertisement $advertisement)
    {
        Storage::disk('public')->delete($advertisement->image);
        $advertisement->delete();

        return redirect()->route('admin.advertisements')->with('success', 'Publicidad eliminada.');
    }
}
