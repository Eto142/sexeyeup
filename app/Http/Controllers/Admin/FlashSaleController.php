<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index()
    {
        $sales = FlashSale::latest()->paginate(15);
        return view('admin.flash-sales.index', compact('sales'));
    }

    public function create()
    {
        return view('admin.flash-sales.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'badge'       => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'ends_at'     => 'required|date|after:now',
            'active'      => 'nullable|boolean',
        ]);

        // Only one active sale at a time
        if ($request->boolean('active')) {
            FlashSale::where('active', true)->update(['active' => false]);
        }

        $data['active']      = $request->boolean('active');
        $data['badge']       = $data['badge']       ?: '🔥 Flash Deal';
        $data['button_text'] = $data['button_text'] ?: 'Grab the Deal';

        FlashSale::create($data);

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'Flash sale created!');
    }

    public function edit(FlashSale $flashSale)
    {
        return view('admin.flash-sales.edit', compact('flashSale'));
    }

    public function update(Request $request, FlashSale $flashSale)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'badge'       => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'ends_at'     => 'required|date',
            'active'      => 'nullable|boolean',
        ]);

        // Only one active sale at a time
        if ($request->boolean('active') && !$flashSale->active) {
            FlashSale::where('active', true)->update(['active' => false]);
        }

        $data['active']      = $request->boolean('active');
        $data['badge']       = $data['badge']       ?: '🔥 Flash Deal';
        $data['button_text'] = $data['button_text'] ?: 'Grab the Deal';

        $flashSale->update($data);

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'Flash sale updated!');
    }

    public function destroy(FlashSale $flashSale)
    {
        $flashSale->delete();
        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'Flash sale deleted.');
    }
}
