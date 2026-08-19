<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    public function logSecurityEvent(Request $request)
    {
        $request->validate([
            'event_type' => 'required',
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'event_type' => $request->event_type,
            'description' => $request->description,
            'ip_address' => $request->ip(),
            'browser' => $request->header('User-Agent'),
        ]);

        return response()->json(['message' => 'Event logged']);
    }
}
