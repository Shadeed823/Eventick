<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Constants\RoleType;
use App\Rules\PhoneKSA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user();
            if ($user->role_id == 2) {
                return redirect()->route('seller.dashboard');
            }
            if ($user->role_id == 3) {
                return redirect()->route('buyer.dashboard');
            }
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials provided.',])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => ['required', new PhoneKSA()],
            'password' => 'required|string|min:6|confirmed',
            'role_id'  => 'required|in:2,3', // 2=Seller, 3=Buyer
        ]);

        $user = User::create([
            'role_id' => $request->role_id,
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'password'=> Hash::make($request->password),
            'status'  => 'Active',
        ]);

        Auth::login($user);
        if ($user->role_id == 2) {
            return redirect()->route('seller.dashboard');
        }
        return redirect()->route('home')->with('success', 'Account created successfully!');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    public function showProfile()
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'phone'    => ['required', new PhoneKSA()],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }





}
