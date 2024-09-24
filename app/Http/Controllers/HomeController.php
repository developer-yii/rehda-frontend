<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Room;
use App\Models\Template;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $rules = [
            'qr_code' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return view('home');
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }
        $qrCode = $request->qr_code;

        $room = $this->checkRoomQR($qrCode);
        // if (empty($room)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Room Not found!'
        //     ], 404);
        // }
        return view('home', compact('room'));
    }

    public function checkRoomQR($qrCode)
    {
        return Room::where('unique_uuid', $qrCode)->first();
    }

    public function deskLog(Request $request)
    {
        // Parse JSON data from the request body
        $jsonBody = json_decode($request->getContent(), true);

        $logData = [
            'method' => $request->method(),
            'url' => $request->url(),
            'params' => $request->all(),
            'POST' => $_POST,
            'GET' => $_GET,
            'requestJSON' => $jsonBody,
            'headers' => $request->header(),
        ];

         // Create a unique log file name based on the current timestamp
         $logFileName = storage_path('logs/desk-webhook.log');

         // Log the separator line
         Log::build([
             'driver' => 'single',
             'path' => $logFileName,
         ])->info('--------------------------New request-----------------------------------');

         // Log the data into the file
         Log::build([
             'driver' => 'single',
             'path' => $logFileName,
         ])->info(json_encode($logData, JSON_PRETTY_PRINT));

        return true;
    }
}
