<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagePaymentController extends Controller
{
    //

    public function ManagePayment(){

        return view('admin.manage_payment');
    }
}
