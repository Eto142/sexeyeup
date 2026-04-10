<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PasscodeController extends Controller
{
    public function show()
    {
        return view('passcode');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'passcode' => 'required|string',
        ]);

        $encrypted = SiteSetting::get('passcode');

        if ($encrypted) {
            try {
                $stored = Crypt::decryptString($encrypted);
                if ($request->passcode === $stored) {
                    $request->session()->put('passcode_unlocked', true);
                    return redirect()->route('visitor.email.show');
                }
            } catch (\Exception $e) {
                // tampered / invalid — treat as wrong
            }
        }

        return back()->withErrors(['passcode' => 'Incorrect passcode. Please try again.']);
    }
}
