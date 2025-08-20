<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckinController extends Controller
{
    public function checkin()
    {
        $user = Auth::user();
        // Save the check-in time to the database (for now, just returning it)
        return response()->json([
            'message' => 'Checked in successfully!',
            'user' => $user->name,
            'time' => now()->toDateTimeString(),
        ]);
    }

    public function checkout()
    {
        $user = Auth::user();
        // Save the check-out time to the database (for now, just returning it)
        return response()->json([
            'message' => 'Checked out successfully!',
            'user' => $user->name,
            'time' => now()->toDateTimeString(),
        ]);
    }
}
