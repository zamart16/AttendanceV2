<?php

namespace App\Http\Controllers;

use App\Models\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

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

}
