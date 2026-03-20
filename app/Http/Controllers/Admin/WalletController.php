<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet; // Model for wallets table

class WalletController extends Controller
{
    public function chooseWallet(Request $request)
    {
        // Validate based on selected wallet method
        $rules = [
            'method' => 'required|in:usdt,btc,eth,xrp',
        ];

        switch ($request->method) {
            case 'usdt':
                $rules['usdt_address'] = 'required|string|max:255';
                break;
            case 'btc':
                $rules['btc_address'] = 'required|string|max:255';
                break;
            case 'eth':
                $rules['eth_address'] = 'required|string|max:255';
                break;
            case 'xrp':
                $rules['xrp_address'] = 'required|string|max:255';
                $rules['xrp_destination_tag'] = 'nullable|string|max:255';
                break;
        }

        $validated = $request->validate($rules);

        // Save or update wallet
        $wallet = Wallet::updateOrCreate(
            ['method' => $validated['method']], // search by wallet type
            [
                'address' => $validated[$validated['method'].'_address'],
                'destination_tag' => $validated['xrp_destination_tag'] ?? null
            ]
        );

        return redirect()->back()->with('success', 'Wallet information updated successfully!');
    }
}
