<?php

namespace App\Http\Controllers;

use App\Models\SiteVisitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function show()
    {
        return view('visitor-email');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        SiteVisitor::create([
            'email' => $request->email,
            'ip'    => $request->ip(),
        ]);

        $request->session()->put('visitor_email_submitted', true);

        return redirect('/');
    }
}
