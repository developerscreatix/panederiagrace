<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile()
    {
        $users = Auth::id() === 1 ? User::where('id', '!=', 1)->get() : collect();
        return view('profile', compact('users'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($data);

        return redirect()->route('profile')->with('success', 'Perfil actualizado.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('profile')->with('success', 'Contraseña actualizada.');
    }

    public function storeUser(Request $request)
    {
        abort_unless(Auth::id() === 1, 403);

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('profile')->with('success', 'Cuenta creada correctamente.');
    }

    public function destroyUser(User $user)
    {
        abort_unless(Auth::id() === 1, 403);
        abort_if($user->id === 1, 403);

        $user->delete();

        return redirect()->route('profile')->with('success', 'Cuenta eliminada.');
    }
}
