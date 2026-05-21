<?php

namespace App\Http\Controllers;

use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $allProducts = Product::where('active', true)->get();

        $bayelsaProducts = $allProducts
            ->filter(fn($p) => in_array($p->location, ['bayelsa', 'both']))
            ->map(fn($p) => $p->toJsArray())
            ->values();

        $beninProducts = $allProducts
            ->filter(fn($p) => in_array($p->location, ['benin', 'both']))
            ->map(fn($p) => $p->toJsArray())
            ->values();

        $flashSale = FlashSale::getActive();

        return view('pages.home', compact('bayelsaProducts', 'beninProducts', 'flashSale'));
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

    public function howToOrder()
    {
        return view('pages.how-to-order');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function qrCode()
    {
        return view('pages.qr-code');
    }

    public function product($id)
    {
        $product = Product::where('active', true)->findOrFail($id);
        $related = Product::where('active', true)
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->limit(3)
            ->get()
            ->map(fn($p) => $p->toJsArray())
            ->values();

        return view('pages.product', compact('product', 'related'));
    }
}
