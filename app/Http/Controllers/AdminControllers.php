<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        $attendances = Attendance::with('user')->orderBy('created_at', 'desc')->get();

        return Inertia::render('Dashboard/AdminDashboard', [
            'employees' => $attendances
        ]);
    }
}
