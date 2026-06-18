<div class="row g-3">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $product->name ?? '') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                      rows="4">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', $product->price ?? '') }}" min="0" step="100" required>
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock', $product->stock ?? 0) }}" min="0" required>
                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mt-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive"
                    {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="isActive">Produk Aktif</label>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Gambar Produk</label>

        @if(isset($product) && $product->image)
            <div class="mb-2">
                <img src="{{ $product->image_url }}" id="img-preview"
                     class="img-thumbnail w-100" style="max-height:200px; object-fit:cover;" alt="Gambar produk">
            </div>
        @else
            <div class="mb-2">
                <img src="" id="img-preview"
                     class="img-thumbnail w-100 d-none" style="max-height:200px; object-fit:cover;" alt="Preview">
            </div>
        @endif

        <div class="mb-2">
            <label class="form-label small text-muted">Upload File</label>
            <input type="file" name="image_file" id="image_file"
                   class="form-control @error('image_file') is-invalid @enderror" accept="image/*">
            <div class="form-text">Maks. 2MB. Format: JPG, PNG, WebP</div>
            @error('image_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="form-label small text-muted">Atau URL Gambar Eksternal</label>
            <input type="url" name="image_url" id="image_url"
                   class="form-control @error('image_url') is-invalid @enderror"
                   placeholder="https://example.com/gambar.jpg"
                   value="{{ old('image_url', (isset($product) && $product->image && str_starts_with($product->image, 'http')) ? $product->image : '') }}">
            <div class="form-text">Upload file lebih diprioritaskan jika keduanya diisi.</div>
            @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

@push('scripts')
<script>
    const preview = document.getElementById('img-preview');

    document.getElementById('image_file').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            preview.src = URL.createObjectURL(this.files[0]);
            preview.classList.remove('d-none');
        }
    });

    let urlTimer;
    document.getElementById('image_url').addEventListener('input', function () {
        clearTimeout(urlTimer);
        const url = this.value.trim();
        if (!url) return;
        urlTimer = setTimeout(() => {
            preview.src = url;
            preview.classList.remove('d-none');
            preview.onerror = () => preview.classList.add('d-none');
        }, 600);
    });
</script>
@endpush
