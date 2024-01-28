<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAdminRequest;
use App\Http\Requests\RegisterAdminRequest;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function getLogin() {
        return Inertia::render('Admin/Login');
    }

    public function getRegister() {
        return Inertia::render('Admin/Register');
    }

    public function login(LoginAdminRequest $request) 
    {
        // Authenticate admin
        $request->authenticate();

        // Regenerate session
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));

    }

    public function register(RegisterAdminRequest $request) {
        // Get data from request
        $data = $request->only(['name', 'email', 'password', 'role_type']);

        // Register admin
        // Hash password and register
        $data['password'] = Hash::make($data['password']);
        $admin = User::create($data);

        // Login
        Auth::login($admin);

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function dashboard() {
        // All user and listing
        $users = User::all();
        $listings = Listing::with('user')->get();

        return Inertia::render('Admin/Dashboard', [
            'users' => $users,
            'listings' => $listings,
        ]);
    }
}
