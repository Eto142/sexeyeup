<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function uploadToCloudinary(\Illuminate\Http\UploadedFile $file): array
    {
        $cloudName = config('filesystems.disks.cloudinary.cloud');
        $apiKey    = config('filesystems.disks.cloudinary.key');
        $apiSecret = config('filesystems.disks.cloudinary.secret');
        $timestamp = time();

        $params    = ['folder' => 'seu_products', 'timestamp' => $timestamp];
        ksort($params);
        $sigString = implode('&', array_map(
            fn ($k, $v) => "{$k}={$v}",
            array_keys($params),
            array_values($params)
        )) . $apiSecret;
        $signature = sha1($sigString);

        $response = \Illuminate\Support\Facades\Http::attach(
            'file',
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
            'api_key'   => $apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'folder'    => 'seu_products',
        ]);

        $data = $response->json();

        return [
            'url'       => $data['secure_url'],
            'public_id' => $data['public_id'],
        ];
    }

    public function index(Request $request)
    {
        $tab      = $request->query('tab', 'all');
        $query    = Product::latest();

        if ($tab === 'bayelsa') {
            $query->where('location', 'bayelsa');
        } elseif ($tab === 'benin') {
            $query->where('location', 'benin');
        } elseif ($tab === 'both') {
            $query->where('location', 'both');
        }

        $products = $query->paginate(15)->withQueryString();

        $counts = [
            'all'     => Product::count(),
            'bayelsa' => Product::where('location', 'bayelsa')->count(),
            'benin'   => Product::where('location', 'benin')->count(),
            'both'    => Product::where('location', 'both')->count(),
        ];

        return view('admin.products.index', compact('products', 'tab', 'counts'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'strain'      => 'nullable|string|max:255',
            'category'    => 'required|in:flower,edible,concentrate,vape,preroll,laughgas',
            'emoji'       => 'nullable|string|max:10',
            'thc'         => 'nullable|string|max:50',
            'price_gram'  => 'required|numeric|min:0',
            'price_ounce' => 'required|numeric|min:0',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'reviews'     => 'nullable|integer|min:0',
            'is_new'      => 'nullable|boolean',
            'featured'    => 'nullable|boolean',
            'active'      => 'nullable|boolean',
            'location'    => 'required|in:bayelsa,benin,both',
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
            'strain'      => 'nullable|string|max:255',
            'category'    => 'required|in:flower,edible,concentrate,vape,preroll,laughgas',
            'emoji'       => 'nullable|string|max:10',
            'thc'         => 'nullable|string|max:50',
            'price_gram'  => 'required|numeric|min:0',
            'price_ounce' => 'required|numeric|min:0',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'reviews'     => 'nullable|integer|min:0',
            'is_new'      => 'nullable|boolean',
            'featured'    => 'nullable|boolean',
            'active'      => 'nullable|boolean',
            'location'    => 'required|in:bayelsa,benin,both',
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
            $cloudName = config('filesystems.disks.cloudinary.cloud');
            $apiKey    = config('filesystems.disks.cloudinary.key');
            $apiSecret = config('filesystems.disks.cloudinary.secret');
            $timestamp = time();

            $params    = ['public_id' => $product->cloudinary_public_id, 'timestamp' => $timestamp];
            ksort($params);
            $sigString = implode('&', array_map(
                fn ($k, $v) => "{$k}={$v}",
                array_keys($params),
                array_values($params)
            )) . $apiSecret;
            $signature = sha1($sigString);

            \Illuminate\Support\Facades\Http::post(
                "https://api.cloudinary.com/v1_1/{$cloudName}/image/destroy",
                [
                    'public_id' => $product->cloudinary_public_id,
                    'api_key'   => $apiKey,
                    'timestamp' => $timestamp,
                    'signature' => $signature,
                ]
            );
        }
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }
}
