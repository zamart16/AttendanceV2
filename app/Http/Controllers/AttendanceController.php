<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{

public function qr()
    {
        return view('attendance.qr');
    }
    
public function bac()
{
    // Get the BAC attendance row
    $attendance = \App\Models\Attendance::where('unit', 'bac')->first();

    // Only allow access if controller_id = 1 (active)
    if (!$attendance || $attendance->controller_id != 1) {
        return response()->view('attendance.disabled', [], 403);
    }

    return view('attendance.bac');
}



    public function store(Request $request)
    {
        try {
            $request->validate([
                'fullName' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'type_attendee' => 'required|string|max:255',
                'phone_number' => 'required|string|max:50',
                'purpose' => 'nullable|string|max:255',
                'company' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'photo' => 'required|string',
                'attendance_date' => 'required|date',
                'attendance_time' => 'required|string',
            ]);

            // Validate base64 image
            if (!preg_match('/^data:image\/\w+;base64,/', $request->photo)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid image format'
                ], 422);
            }

            $image = base64_decode(
                preg_replace('/^data:image\/\w+;base64,/', '', $request->photo)
            );

            if ($image === false) {
                return response()->json([
                    'success' => false,
                    'error' => 'Image decoding failed'
                ], 422);
            }

            // Upload to Supabase Storage
            $fileName = 'attendance/' . Str::uuid() . '.jpg';
/** @var \Illuminate\Http\Client\Response $response */
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_KEY'),
                'apikey' => env('SUPABASE_SERVICE_KEY'),
                'Content-Type' => 'image/jpeg',
            ])->withBody($image, 'image/jpeg')
              ->post(
                  env('SUPABASE_URL') .
                  '/storage/v1/object/' .
                  env('SUPABASE_BUCKET') .
                  '/' . $fileName
              );

            // ✅ FIXED STATUS CHECK
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                return response()->json([
                    'success' => false,
                    'error' => 'Supabase upload failed'
                ], 500);
            }

            $photoUrl =
                env('SUPABASE_URL') .
                '/storage/v1/object/public/' .
                env('SUPABASE_BUCKET') .
                '/' . $fileName;

            $attendee = Attendee::create([
                'fullName' => $request->fullName,
                'position' => $request->position,
                'type_attendee' => $request->type_attendee,
                'phone_number' => $request->phone_number,
                'purpose' => $request->purpose,
                'company' => $request->company,
                'address' => $request->address,
                'photo' => $photoUrl,
                'attendance_date' => $request->attendance_date,
                'attendance_time' => $request->attendance_time,
            ]);

            return response()->json([
                'success' => true,
                'attendee' => $attendee
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function todayCount(): JsonResponse
{
    $today = Carbon::now()->format('Y-m-d');

    $count = DB::table('attendees')
        ->where('attendance_date', $today)
        ->count();

    return response()->json(
        ['count' => $count],
        200,
        [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache'
        ]
    );
}
}
