<?php

namespace App\Http\Controllers;

use App\Models\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{
    public function dashboard()
    {
        // BAC controller
        $controller = Controller::find(1);
        return view('admin.dashboard', compact('controller'));
    }

public function toggleController(Request $request, Controller $controller)
{
    $request->validate([
        'status' => 'required|in:active,disabled'
    ]);

    // Update controller status
    $controller->status = $request->status;
    $controller->save();

    // Determine the new controller_id for attendances
    $newControllerId = $request->status === 'active' ? 1 : 2;

    // Update attendances for BAC unit
    Attendance::where('unit', 'bac')
        ->update(['controller_id' => $newControllerId]);

    return response()->json([
        'success' => true,
        'controller_id' => $newControllerId,
        'status' => $request->status
    ]);
}

    // FEB 4 2026
public function attendeesRealtime()
{
    $today = Carbon::now()->format('Y-m-d');

    $attendees = DB::table('attendees')
        ->where('attendance_date', $today)
        ->orderBy('attendance_time', 'desc')
        ->get();

    return response()->json([
        'attendees' => $attendees
    ]);
}

}
