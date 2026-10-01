<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
    'nama' => ['required', 'string', 'max:255'],
    'username' => ['required', 'string', 'max:255', 'unique:users'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
    'no_hp' => ['required'],
    'alamat' => ['required'], ],

    ['username.unique' => 'username already used.',
     'email.unique' => 'email already used',
]);

        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer'
        ]);

        Customer::create([
        'id_user' => $user->id,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat
    ]);

        event(new Registered($user));

        Auth::login($user);

        $role = Auth::user()?->role;

        return match($role)
        {
            'admin' => redirect()->intended('/admin/dashboard')->with('success', 'Register Success'),
            'kasir' => redirect()->intended('/admin/dashboard')->with('success', 'Register Success'),
            'customer' => redirect()->intended('/user/dashboard')->with('success', 'Register Success'),
            default => redirect()->intended('/user/dashboard')->with('success', 'Register Success')
        };
    }
}
