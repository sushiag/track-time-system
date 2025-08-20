<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class AdminController extends Controller
{
    // Show employees list
    public function index()
    {
        $employees = User::where('role', 'employee')->get();
        return Inertia::render('Admin/Employees', [
            'employees' => $employees
        ]);
    }

    // Create new employee
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'employee',
        ]);

        return redirect()->route('admin.employees')->with('success', 'Employee created successfully!');
    }
}
