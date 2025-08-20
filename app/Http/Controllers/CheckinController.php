<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CheckinController extends Controller
{
     public function dashboard()
    {
        $user = Auth::user();
        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Dashboard', [
            'user' => $user,
            'attendances' => $attendances,
        ]);
    }


    public function checkin()
    {
        $user = Auth::user();

        Attendance::create([
            'user_id' => $user->id,
            'check_in' => now(),
        ]);

        return back()->with('success', 'Checked in successfully!');
    }

    public function checkout()
    {
        $user = Auth::user();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereNull('check_out')
            ->latest()
            ->first();

        if ($attendance) {
            $attendance->update(['check_out' => now()]);
        }

        return back()->with('success', 'Checked out successfully!');
    }
}
