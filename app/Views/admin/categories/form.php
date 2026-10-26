<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<?php
helper('form');
$category = $category ?? null;
$old = $old ?? null;
$errors = $errors ?? [];

$value = static function (string $field, $fallback = '') use ($old, $category) {
    if ($old !== null) {
        return $old[$field] ?? $fallback;
    }
    if ($category !== null) {
        return $category[$field] ?? $fallback;
    }

    return $fallback;
};
?>

<div class="mb-6">
    <a href="/admin/categories" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-emerald-600">
        <i class="ph ph-arrow-left"></i> Kembali ke daftar kategori
    </a>
    <h2 class="font-display mt-3 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl"><?= esc($title) ?></h2>
    <p class="mt-2 text-sm text-slate-500">Kategori membantu pembeli menjelajah produk dengan lebih cepat.</p>
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

<form action="<?= esc($action) ?>" method="post" class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    <?= csrf_field() ?>

    <div class="space-y-6 xl:col-span-2">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-5 flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"><i class="ph ph-tag text-xl"></i></span>
                <div>
                    <h3 class="font-display text-base font-bold text-slate-900">Informasi Kategori</h3>
                    <p class="text-xs text-slate-400">Nama dan slug akan tampil di halaman toko.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" required maxlength="100" value="<?= esc($value('name')) ?>" placeholder="Contoh: Sayuran"
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                </div>

                <div>
                    <label for="slug" class="mb-1.5 block text-sm font-semibold text-slate-700">Slug</label>
                    <input type="text" id="slug" name="slug" maxlength="120" value="<?= esc($value('slug')) ?>" placeholder="otomatis-dari-nama"
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    <p class="mt-2 text-xs text-slate-400">Dipakai untuk filter URL. Kosongkan untuk dibuat otomatis.</p>
                </div>

                <div>
                    <label for="sort_order" class="mb-1.5 block text-sm font-semibold text-slate-700">Urutan Tampil</label>
                    <input type="number" id="sort_order" name="sort_order" min="0" step="1" value="<?= esc($value('sort_order', 0)) ?>"
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    <p class="mt-2 text-xs text-slate-400">Angka kecil tampil lebih dulu.</p>
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="mb-1.5 block text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" placeholder="Deskripsi singkat kategori..."
                              class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"><?= esc($value('description')) ?></textarea>
                </div>

                <div class="sm:col-span-2">
                    <label for="image_url" class="mb-1.5 block text-sm font-semibold text-slate-700">URL Gambar (opsional)</label>
                    <input type="url" id="image_url" name="image_url" maxlength="500" value="<?= esc($value('image_url')) ?>" placeholder="https://contoh.com/kategori.jpg"
                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                </div>
            </div>
        </section>
    </div>

    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h3 class="font-display text-base font-bold text-slate-900">Pratinjau</h3>
            <div class="mt-4 rounded-xl border border-dashed border-slate-200 bg-slate-50 p-4">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm"><i class="ph ph-tag text-xl"></i></span>
                <p id="preview-name" class="font-display mt-3 text-base font-bold text-slate-900"><?= esc($value('name', 'Nama Kategori')) ?: 'Nama Kategori' ?></p>
                <p id="preview-slug" class="mt-0.5 text-xs font-medium text-slate-400">/<?= esc($value('slug', 'slug-kategori')) ?: 'slug-kategori' ?></p>
                <p class="mt-3 line-clamp-2 text-xs leading-relaxed text-slate-500"><?= esc($value('description', 'Deskripsi kategori akan tampil di sini.')) ?: 'Deskripsi kategori akan tampil di sini.' ?></p>
            </div>

            <div class="mt-6 space-y-2 border-t border-slate-100 pt-5">
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700">
                    <i class="ph ph-floppy-disk"></i> <?= esc($submitLabel) ?>
                </button>
                <a href="/admin/categories" class="flex w-full items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-500 transition hover:border-slate-300 hover:text-slate-700">Batal</a>
            </div>
        </section>

        <?php if ($category !== null): ?>
        <section class="rounded-2xl border border-red-100 bg-white p-5 shadow-sm">
            <h3 class="font-display text-base font-bold text-slate-900">Hapus Kategori</h3>
            <p class="mt-1 text-xs leading-relaxed text-slate-500">Kategori hanya bisa dihapus jika tidak dipakai produk.</p>
            <form action="/admin/categories/<?= (int) $category['id'] ?>/delete" method="post" data-confirm="Hapus kategori ini?" class="mt-4">
                <?= csrf_field() ?>
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-bold text-red-600 transition hover:bg-red-100">
                    <i class="ph ph-trash"></i> Hapus Kategori
                </button>
            </form>
        </section>
        <?php endif ?>
    </div>
</form>

<script>
const nameInput = document.getElementById('name');
const slugInput = document.getElementById('slug');
const previewName = document.getElementById('preview-name');
const previewSlug = document.getElementById('preview-slug');

function slugify(value) {
    return value.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
}

nameInput.addEventListener('input', function () {
    previewName.textContent = this.value || 'Nama Kategori';
    if (slugInput.value === '') {
        previewSlug.textContent = '/' + (slugify(this.value) || 'slug-kategori');
    }
});

slugInput.addEventListener('input', function () {
    previewSlug.textContent = '/' + (this.value || slugify(nameInput.value) || 'slug-kategori');
});

document.getElementById('description').addEventListener('input', function () {
    document.querySelector('#preview-name').parentElement.querySelector('.line-clamp-2').textContent = this.value || 'Deskripsi kategori akan tampil di sini.';
});
</script>
<?= $this->endSection() ?>
