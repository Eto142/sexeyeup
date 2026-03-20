<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'strain'      => 'required|string|max:255',
            'category'    => 'required|in:flower,edible,concentrate,vape,preroll',
            'emoji'       => 'nullable|string|max:10',
            'thc'         => 'nullable|string|max:50',
            'price_gram'  => 'required|numeric|min:0',
            'price_ounce' => 'required|numeric|min:0',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'reviews'     => 'nullable|integer|min:0',
            'is_new'      => 'nullable|boolean',
            'featured'    => 'nullable|boolean',
            'active'      => 'nullable|boolean',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['is_new']   = $request->boolean('is_new');
        $data['featured'] = $request->boolean('featured');
        $data['active']   = $request->boolean('active', true);

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'strain'      => 'required|string|max:255',
            'category'    => 'required|in:flower,edible,concentrate,vape,preroll',
            'emoji'       => 'nullable|string|max:10',
            'thc'         => 'nullable|string|max:50',
            'price_gram'  => 'required|numeric|min:0',
            'price_ounce' => 'required|numeric|min:0',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'reviews'     => 'nullable|integer|min:0',
            'is_new'      => 'nullable|boolean',
            'featured'    => 'nullable|boolean',
            'active'      => 'nullable|boolean',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['is_new']   = $request->boolean('is_new');
        $data['featured'] = $request->boolean('featured');
        $data['active']   = $request->boolean('active', true);

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }
}
