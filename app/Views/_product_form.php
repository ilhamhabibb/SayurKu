<?php
/**
 * Form produk, dipakai oleh admin_add dan admin_edit.
 * @var string      $action
 * @var string      $submitLabel
 * @var array       $errors
 * @var array|null  $old
 * @var array|null  $item
 */
$value = static function (string $field, $fallback = '') use ($old, $item) {
    if ($old !== null) {
        return $old[$field] ?? $fallback;
    }
    if ($item !== null) {
        return $item[$field] ?? $fallback;
    }
    return $fallback;
};
$currentImage = $old['image_url'] ?? $item['image_url'] ?? null;
$hasUploadedFile = $currentImage !== null && $currentImage !== '' && ! str_starts_with($currentImage, 'http');
$urlFieldValue = $hasUploadedFile ? '' : (string) $currentImage;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($submitLabel) ?> Produk - Admin SayurSegar</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-8">
<div class="max-w-3xl mx-auto">

  <a href="/admin/products" class="inline-flex items-center text-sm text-gray-500 hover:text-green-600">&larr; Kembali ke daftar produk</a>
  <h1 class="text-2xl font-bold text-gray-900 mt-4 mb-6"><?= esc($submitLabel) ?> Produk</h1>

  <?php if (! empty($errors)): ?>
  <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6">
    <p class="font-semibold mb-1">Data belum disimpan:</p>
    <ul class="list-disc list-inside text-sm">
      <?php foreach ($errors as $error): ?>
      <li><?= esc($error) ?></li>
      <?php endforeach ?>
    </ul>
  </div>
  <?php endif ?>

  <form action="<?= esc($action) ?>" method="post" enctype="multipart/form-data" class="bg-white rounded-2xl shadow p-6 space-y-5">

    <div class="grid sm:grid-cols-2 gap-5">
      <div class="sm:col-span-2">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
        <input type="text" id="name" name="name" required maxlength="255" value="<?= esc($value('name')) ?>"
               class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
      </div>

      <div>
        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
        <input type="number" id="price" name="price" required min="1" step="1" value="<?= esc($value('price') ?: '') ?>"
               class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
      </div>

      <div>
        <label for="unit" class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
        <input type="text" id="unit" name="unit" maxlength="50" placeholder="500 gram" value="<?= esc($value('unit')) ?>"
               class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
      </div>

      <div class="sm:col-span-2">
        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
        <input type="text" id="category" name="category" maxlength="50" list="KategoriList" placeholder="Sayur / Bumbu / Buah" value="<?= esc($value('category')) ?>"
               class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
        <datalist id="KategoriList">
          <option value="Sayur"></option>
          <option value="Buah"></option>
          <option value="Bumbu"></option>
        </datalist>
      </div>

      <div class="sm:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
        <textarea id="description" name="description" rows="3"
                  class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"><?= esc($value('description')) ?></textarea>
      </div>
    </div>

    <div class="border-t border-gray-100 pt-5">
      <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
      <p class="text-xs text-gray-500 mb-3">JPG, PNG, atau WEBP maksimal 2MB. Kalau diisi, foto ini dipakai dan URL di bawah diabaikan.</p>

      <div class="flex flex-col sm:flex-row sm:items-start gap-4">
        <div class="shrink-0">
          <img id="photo-preview"
               src="<?= esc(product_image_url($currentImage)) ?>"
               alt="Foto produk saat ini"
               class="w-32 h-32 object-cover rounded-xl border border-gray-200 bg-gray-50">
        </div>
        <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp"
               class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-green-600 file:px-4 file:py-2 file:text-white file:font-medium hover:file:bg-green-700">
      </div>
    </div>

    <div class="border-t border-gray-100 pt-5">
      <label for="image_url" class="block text-sm font-medium text-gray-700 mb-1">URL Foto (opsional)</label>
      <input type="url" id="image_url" name="image_url" maxlength="500" placeholder="https://contoh.com/foto.jpg" value="<?= esc($urlFieldValue) ?>"
             class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
      <?php if ($hasUploadedFile): ?>
      <p class="text-xs text-gray-500 mt-1">Produk ini memakai foto yang tersimpan di server. Unggah file baru untuk menggantinya, atau isi URL di atas untuk memakai gambar dari internet.</p>
      <?php else: ?>
      <p class="text-xs text-gray-500 mt-1">Dipakai kalau tidak ada file yang diunggah. Kosongkan untuk memakai foto placeholder.</p>
      <?php endif ?>
    </div>

    <div class="flex items-center gap-3 pt-2">
      <button type="submit" class="bg-green-600 text-white font-medium px-6 py-2.5 rounded-xl hover:bg-green-700 transition">Simpan Produk</button>
      <a href="/admin/products" class="text-gray-500 hover:text-gray-700">Batal</a>
    </div>
  </form>
</div>

<script>
document.getElementById('photo').addEventListener('change', function (event) {
  var file = event.target.files[0];
  if (!file) return;
  document.getElementById('photo-preview').src = URL.createObjectURL(file);
});
</script>
</body>
</html>