<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function uploadToCloudinary(\Illuminate\Http\UploadedFile $file): array
    {
        $result = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::getFacadeRoot()
            ->uploadApi()
            ->upload($file->getRealPath(), ['folder' => 'seu_products']);

        return [
            'url'       => $result['secure_url'],
            'public_id' => $result['public_id'],
        ];
    }

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
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $uploaded = $this->uploadToCloudinary($request->file('image'));
            $data['image']                = $uploaded['url'];
            $data['cloudinary_public_id'] = $uploaded['public_id'];
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
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($product->cloudinary_public_id) {
                \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::getFacadeRoot()
                    ->uploadApi()->destroy($product->cloudinary_public_id);
            }
            $uploaded = $this->uploadToCloudinary($request->file('image'));
            $data['image']                = $uploaded['url'];
            $data['cloudinary_public_id'] = $uploaded['public_id'];
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
        if ($product->cloudinary_public_id) {
            \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::getFacadeRoot()
                ->uploadApi()->destroy($product->cloudinary_public_id);
        }
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }
}
