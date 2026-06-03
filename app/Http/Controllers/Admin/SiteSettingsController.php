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

        $accountDetails = [
            'bank_name'      => SiteSetting::get('bayelsa_bank_name', ''),
            'account_number' => SiteSetting::get('bayelsa_account_number', ''),
            'account_name'   => SiteSetting::get('bayelsa_account_name', ''),
            'note'           => SiteSetting::get('bayelsa_account_note', ''),
        ];

        return view('admin.site_settings', compact('currentPasscode', 'accountDetails'));
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

    public function updateAccountDetails(Request $request)
    {
        $request->validate([
            'bank_name'      => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:20',
            'account_name'   => 'nullable|string|max:100',
            'note'           => 'nullable|string|max:300',
        ]);

        SiteSetting::set('bayelsa_bank_name',      $request->bank_name ?? '');
        SiteSetting::set('bayelsa_account_number', $request->account_number ?? '');
        SiteSetting::set('bayelsa_account_name',   $request->account_name ?? '');
        SiteSetting::set('bayelsa_account_note',   $request->note ?? '');

        return back()->with('account_success', 'Bayelsa account details updated successfully.');
    }
}
