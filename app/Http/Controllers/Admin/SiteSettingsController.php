<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SiteSettingsController extends Controller
{
    public function showPasscode()
    {
        $encrypted = SiteSetting::get('passcode');
        $currentPasscode = null;

        if (!empty($encrypted)) {
            try {
                $currentPasscode = Crypt::decryptString($encrypted);
            } catch (\Exception $e) {
                $currentPasscode = null;
            }
        }

        return view('admin.site_settings', compact('currentPasscode'));
    }

    public function updatePasscode(Request $request)
    {
        $request->validate([
            'passcode' => 'nullable|string|min:4|max:50',
        ]);

        if (empty($request->passcode)) {
            SiteSetting::where('key', 'passcode')->delete();
            return back()->with('success', 'Passcode removed. Site is now open to everyone.');
        }

        SiteSetting::set('passcode', Crypt::encryptString($request->passcode));
        return back()->with('success', 'Passcode updated successfully.');
    }
}
