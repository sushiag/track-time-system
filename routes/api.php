<?php
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Attendance;
use App\Http\Controllers\EmployeeController;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
});

Route::get('/dashboard-data', function () {
    $totalUsers = User::count();
    $totalCheckIns = Attendance::whereNotNull('check_in')->count();
    $totalCheckOuts = Attendance::whereNotNull('check_out')->count();
    $activeToday = Attendance::whereDate('check_in', today())->count();

    $trends = Attendance::selectRaw('DATE(created_at) as date, COUNT(CASE WHEN check_in IS NOT NULL THEN 1 END) as check_ins, COUNT(CASE WHEN check_out IS NOT NULL THEN 1 END) as check_outs')
        ->where('created_at', '>=', now()->subDays(6))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

    $labels = $trends->pluck('date')->toArray();
    $checkIns = $trends->pluck('check_ins')->toArray();
    $checkOuts = $trends->pluck('check_outs')->toArray();

    return response()->json([
        'stats' => [
            'totalUsers' => $totalUsers,
            'totalCheckIns' => $totalCheckIns,
            'totalCheckOuts' => $totalCheckOuts,
            'activeToday' => $activeToday,
        ],
        'attendanceTrends' => [
            'labels' => $labels,
            'checkIns' => $checkIns,
            'checkOuts' => $checkOuts,
        ],
        'attendances' => Attendance::with('user')->latest()->limit(10)->get(),
    ]);
});
