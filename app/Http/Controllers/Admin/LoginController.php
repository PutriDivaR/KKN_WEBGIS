<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
	public function showLoginForm(): View
	{
		return view('admin.login');
	}

	public function login(Request $request): RedirectResponse
	{
		$credentials = $request->validate([
			'email' => ['required', 'email'],
			'password' => ['required'],
		]);

		if ($credentials['email'] !== 'admin@kampungadat.id' || $credentials['password'] !== 'admin123') {
			return back()->withErrors([
				'email' => 'Email atau password admin sementara salah.',
			])->onlyInput('email');
		}

		$request->session()->regenerate();
		$request->session()->put('admin_authenticated', true);
		$request->session()->put('admin_name', 'Admin Kampung Adat');
		$request->session()->put('admin_email', 'admin@kampungadat.id');

		return redirect()->intended(route('admin.dashboard'));
	}

	public function logout(Request $request): RedirectResponse
	{
		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect()->route('home');
	}
}
