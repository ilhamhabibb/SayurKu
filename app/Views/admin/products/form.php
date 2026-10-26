<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<?php
helper('form');
$product = $product ?? null;
$old = $old ?? null;
$errors = $errors ?? [];

$value = static function (string $field, $fallback = '') use ($old, $product) {
    if ($old !== null) {
        return $old[$field] ?? $fallback;
    }
    if ($product !== null) {
        return $product[$field] ?? $fallback;
    }

    return $fallback;
};

$currentImage = $old['image_url'] ?? $product['image_url'] ?? null;
$hasUploadedFile = $currentImage !== null && $currentImage !== '' && ! str_starts_with((string) $currentImage, 'http');
$urlFieldValue = $hasUploadedFile ? '' : (string) ($currentImage ?? '');
$selectedCategory = (int) $value('category_id', 0);
?>

<div class="mb-6">
    <a href="/admin/products" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-emerald-600">
        <i class="ph ph-arrow-left"></i> Kembali ke daftar produk
    </a>
    <h2 class="font-display mt-3 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl"><?= esc($title) ?></h2>
    <p class="mt-2 text-sm text-slate-500">Lengkapi informasi produk agar tampil rapi di halaman toko.</p>
</div>

<?php if ($errors !== []): ?>
<div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700">
    <div class="flex items-start gap-3">
        <i class="ph-fill ph-warning-circle mt-0.5 text-lg text-red-500"></i>
        <div>
            <p class="font-bold">Data belum disimpan</p>
            <ul class="mt-1 list-inside list-disc space-y-1 text-red-600">
                <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>
<?php endif ?>

<form action="<?= esc($action) ?>" method="post" enctype="multipart/form-data" class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    <?= csrf_field() ?>

    <div class="space-y-6 xl:col-span-2">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-5 flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"><i class="ph ph-info text-xl"></i></span>
                <div>
                    <h3 class="font-display text-base font-bold text-slate-900">Informasi Produk</h3>
                    <p class="text-xs text-slate-400">Data utama yang dilihat pembeli.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" required maxlength="255" value="<?= esc($value('name')) ?>" placeholder="Contoh: Bayam Hijau Organik"
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                </div>

                <div>
                    <label for="category_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Kategori <span class="text-red-500">*</span></label>
                    <select id="category_id" name="category_id" required
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        <option value="">Pilih kategori</option>
                        <?php foreach ($categories as $id => $name): ?>
                        <option value="<?= (int) $id ?>" <?= $selectedCategory === (int) $id ? 'selected' : '' ?>><?= esc($name) ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php if ($categories === []): ?>
                    <p class="mt-2 text-xs text-amber-600">Belum ada kategori. <a href="/admin/categories/new" class="font-semibold underline">Buat kategori dulu</a> sebelum menambah produk.</p>
                    <?php endif ?>
                </div>

                <div>
                    <label for="unit" class="mb-1.5 block text-sm font-semibold text-slate-700">Satuan</label>
                    <input type="text" id="unit" name="unit" maxlength="50" value="<?= esc($value('unit')) ?>" placeholder="Contoh: 500 gram / ikatan"
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                </div>

                <div>
                    <label for="price" class="mb-1.5 block text-sm font-semibold text-slate-700">Harga (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-400">Rp</span>
                        <input type="number" id="price" name="price" required min="1" step="1" value="<?= esc($value('price') ?: '') ?>" placeholder="0"
                               class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="mb-1.5 block text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" placeholder="Jelaskan keunggulan produk secara singkat..."
                              class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"><?= esc($value('description')) ?></textarea>
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-5 flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600"><i class="ph ph-image text-xl"></i></span>
                <div>
                    <h3 class="font-display text-base font-bold text-slate-900">Foto Produk</h3>
                    <p class="text-xs text-slate-400">JPG, PNG, atau WEBP maksimal 2MB.</p>
                </div>
            </div>

            <div class="flex flex-col gap-5 sm:flex-row sm:items-start">
                <div class="shrink-0">
                    <img id="photo-preview" src="<?= esc(product_image_url($currentImage)) ?>" alt="Pratinjau foto produk"
                         class="h-32 w-32 rounded-2xl border border-slate-200 bg-slate-50 object-cover">
                </div>
                <div class="min-w-0 flex-1">
                    <label for="photo" class="mb-1.5 block text-sm font-semibold text-slate-700">Unggah Foto</label>
                    <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp"
                           class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-600 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-emerald-700">
                    <p class="mt-2 text-xs text-slate-400">Kalau diisi, foto ini dipakai dan URL di bawah diabaikan.</p>

                    <label for="image_url" class="mt-5 mb-1.5 block text-sm font-semibold text-slate-700">Atau URL Foto</label>
                    <input type="url" id="image_url" name="image_url" maxlength="500" value="<?= esc($urlFieldValue) ?>" placeholder="https://contoh.com/foto.jpg"
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    <?php if ($hasUploadedFile): ?>
                    <p class="mt-2 text-xs text-slate-400">Produk ini memakai foto yang tersimpan di server. Unggah file baru untuk menggantinya.</p>
                    <?php endif ?>
                </div>
            </div>
        </section>
    </div>

    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h3 class="font-display text-base font-bold text-slate-900">Ringkasan</h3>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex items-center justify-between gap-3">
                    <dt class="text-slate-500">Status</dt>
                    <dd class="font-semibold text-emerald-600">Tampil di toko</dd>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <dt class="text-slate-500">Kategori</dt>
                    <dd id="summary-category" class="max-w-[60%] truncate text-right font-semibold text-slate-700">
                        <?php
                        $selectedName = '';
                        foreach ($categories as $id => $name) {
                            if ((int) $id === $selectedCategory) {
                                $selectedName = $name;
                                break;
                            }
                        }
                        echo esc($selectedName !== '' ? $selectedName : 'Belum dipilih');
                        ?>
                    </dd>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <dt class="text-slate-500">Harga</dt>
                    <dd id="summary-price" class="font-semibold text-slate-700">Rp <?= number_format((int) $value('price', 0), 0, ',', '.') ?></dd>
                </div>
            </dl>

            <div class="mt-6 space-y-2 border-t border-slate-100 pt-5">
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700">
                    <i class="ph ph-floppy-disk"></i> <?= esc($submitLabel) ?>
                </button>
                <a href="/admin/products" class="flex w-full items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-500 transition hover:border-slate-300 hover:text-slate-700">Batal</a>
            </div>
        </section>

        <?php if ($product !== null): ?>
        <section class="rounded-2xl border border-red-100 bg-white p-5 shadow-sm">
            <h3 class="font-display text-base font-bold text-slate-900">Hapus Produk</h3>
            <p class="mt-1 text-xs leading-relaxed text-slate-500">Produk akan dihapus permanen dari katalog.</p>
            <form action="/admin/products/<?= (int) $product['id'] ?>/delete" method="post" data-confirm="Hapus produk ini secara permanen?" class="mt-4">
                <?= csrf_field() ?>
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-bold text-red-600 transition hover:bg-red-100">
                    <i class="ph ph-trash"></i> Hapus Produk
                </button>
            </form>
        </section>
        <?php endif ?>
    </div>
</form>

<script>
document.getElementById('photo').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (!file) return;
    document.getElementById('photo-preview').src = URL.createObjectURL(file);
});

const categorySelect = document.getElementById('category_id');
const categorySummary = document.getElementById('summary-category');
const priceInput = document.getElementById('price');
const priceSummary = document.getElementById('summary-price');

categorySelect.addEventListener('change', function () {
    categorySummary.textContent = this.options[this.selectedIndex].text || 'Belum dipilih';
});

priceInput.addEventListener('input', function () {
    const value = Number(this.value || 0);
    priceSummary.textContent = 'Rp ' + value.toLocaleString('id-ID');
});
</script>
<?= $this->endSection() ?>
