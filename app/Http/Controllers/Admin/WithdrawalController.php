<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    //

     
      public function approve($id)
{
    $escrow = Withdrawal::findOrFail($id);
    $escrow->status = 1;
    $escrow->save();

    return redirect()->back()->with('success', 'Withdrawal approved.');
}

public function decline($id)
{
    $escrow = Withdrawal::findOrFail($id);
    $escrow->status = 2;
    $escrow->save();

    return redirect()->back()->with('error', 'Withdrawal declined.');
}


}
