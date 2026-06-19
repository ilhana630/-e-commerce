<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Kode Promo <span class="text-danger">*</span></label>
        <input type="text" name="code" class="form-control text-uppercase @error('code') is-invalid @enderror"
               value="{{ old('code', $promo->code ?? '') }}" placeholder="contoh: DISKON10" required>
        <div class="form-text">Kode akan otomatis diubah ke huruf kapital.</div>
        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Tipe Diskon <span class="text-danger">*</span></label>
        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
            <option value="percentage" {{ old('type', $promo->type ?? '') === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
            <option value="fixed"      {{ old('type', $promo->type ?? '') === 'fixed'      ? 'selected' : '' }}>Nominal (Rp)</option>
        </select>
        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Nilai Diskon <span class="text-danger">*</span></label>
        <input type="number" name="value" class="form-control @error('value') is-invalid @enderror"
               value="{{ old('value', $promo->value ?? '') }}" min="1" required>
        <div class="form-text">Isi angka % atau nominal Rp sesuai tipe.</div>
        @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Minimum Pembelian (Rp)</label>
        <input type="number" name="min_purchase" class="form-control @error('min_purchase') is-invalid @enderror"
               value="{{ old('min_purchase', $promo->min_purchase ?? 0) }}" min="0">
        @error('min_purchase')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Maks. Penggunaan</label>
        <input type="number" name="max_uses" class="form-control @error('max_uses') is-invalid @enderror"
               value="{{ old('max_uses', $promo->max_uses ?? '') }}" min="1" placeholder="Kosongkan = tidak terbatas">
        @error('max_uses')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Tanggal Kadaluarsa</label>
        <input type="date" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror"
               value="{{ old('expires_at', isset($promo) && $promo->expires_at ? $promo->expires_at->format('Y-m-d') : '') }}">
        <div class="form-text">Kosongkan jika tidak ada batas waktu.</div>
        @error('expires_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive"
                {{ old('is_active', $promo->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="isActive">Promo Aktif</label>
        </div>
    </div>
</div>
