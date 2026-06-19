<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promos = PromoCode::latest()->paginate(15);
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('admin.promos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'         => 'required|string|max:50|unique:promo_codes,code',
            'type'         => 'required|in:percentage,fixed',
            'value'        => 'required|numeric|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_uses'     => 'nullable|integer|min:1',
            'expires_at'   => 'nullable|date|after:today',
            'is_active'    => 'boolean',
        ]);

        $data['code']         = strtoupper($data['code']);
        $data['min_purchase'] = $data['min_purchase'] ?? 0;
        $data['is_active']    = $request->boolean('is_active', true);

        PromoCode::create($data);

        return redirect()->route('admin.promos.index')->with('success', 'Kode promo berhasil dibuat.');
    }

    public function edit(PromoCode $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    public function update(Request $request, PromoCode $promo)
    {
        $data = $request->validate([
            'code'         => 'required|string|max:50|unique:promo_codes,code,' . $promo->id,
            'type'         => 'required|in:percentage,fixed',
            'value'        => 'required|numeric|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_uses'     => 'nullable|integer|min:1',
            'expires_at'   => 'nullable|date',
            'is_active'    => 'boolean',
        ]);

        $data['code']         = strtoupper($data['code']);
        $data['min_purchase'] = $data['min_purchase'] ?? 0;
        $data['is_active']    = $request->boolean('is_active', true);

        $promo->update($data);

        return redirect()->route('admin.promos.index')->with('success', 'Kode promo berhasil diperbarui.');
    }

    public function destroy(PromoCode $promo)
    {
        $promo->delete();
        return back()->with('success', 'Kode promo berhasil dihapus.');
    }
}
