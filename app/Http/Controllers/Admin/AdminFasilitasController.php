<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminFasilitasController extends Controller
{
	public function index(): View
	{
		return view('admin.fasilitas.index');
	}

	public function create(): View
	{
		return view('admin.fasilitas.create');
	}

	public function store(Request $request): RedirectResponse
	{
		return redirect()->route('admin.fasilitas.index');
	}

	public function edit(string $id): View
	{
		return view('admin.fasilitas.edit');
	}

	public function update(Request $request, string $id): RedirectResponse
	{
		return redirect()->route('admin.fasilitas.index');
	}

	public function destroy(string $id): RedirectResponse
	{
		return redirect()->route('admin.fasilitas.index');
	}
}
