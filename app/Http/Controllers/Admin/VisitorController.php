<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteVisitor;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = SiteVisitor::latest()->paginate(50);
        return view('admin.visitors', compact('visitors'));
    }
}
