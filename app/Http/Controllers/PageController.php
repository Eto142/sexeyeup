<?php

namespace App\Http\Controllers;

use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $products  = Product::where('active', true)
            ->get()
            ->map(fn($p) => $p->toJsArray());

        $flashSale = FlashSale::getActive();

        return view('pages.home', compact('products', 'flashSale'));
    }

    public function shop(Request $request)
    {
        $products = Product::where('active', true)
            ->get()
            ->map(fn($p) => $p->toJsArray());

        return view('pages.shop', compact('products'));
    }

    public function deals()
    {
        $products = Product::where('active', true)
            ->get()
            ->map(fn($p) => $p->toJsArray());

        return view('pages.deals', compact('products'));
    }

    public function about()
    {
        return view('pages.about');
    }
}
