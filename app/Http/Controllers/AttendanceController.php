<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        $user = Auth::user();

        // Check if user already checked in today
        $existing = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->first();

        if ($existing && $existing->check_in) {
            return back()->withErrors(['message' => 'You have already checked in today.']);
        }

        Attendance::create([
            'user_id' => $user->id,
            'check_in' => now(),
        ]);

        return back()->with('success', 'Checked in successfully!');
    }

    public function checkOut(Request $request)
    {
        $user = Auth::user();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->first();

        if (!$attendance) {
            return back()->withErrors(['message' => 'You must check in first.']);
        }

        if ($attendance->check_out) {
            return back()->withErrors(['message' => 'You have already checked out today.']);
        }

        $attendance->update([
            'check_out' => now(),
        ]);

        return back()->with('success', 'Checked out successfully!');
    }
}
