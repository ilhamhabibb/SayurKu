<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Produk</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-8">
<div class="max-w-5xl mx-auto">

  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Produk</h1>
    <a href="/admin/add" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">+ Tambah</a>
  </div>

  <div class="overflow-x-auto">
  <table class="w-full min-w-[640px] bg-white shadow rounded-xl overflow-hidden">
    <thead class="bg-green-600 text-white">
      <tr>
        <th class="px-4 py-3 text-left">Nama</th>
        <th class="px-4 py-3 text-left">Kategori</th>
        <th class="px-4 py-3">Harga</th>
        <th class="px-4 py-3 text-right">Aksi</th>
      </tr>
    </thead>
    <tbody>
    <?php if ($items === []): ?>
      <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada produk. Klik "+ Tambah" untuk menambahkan.</td></tr>
    <?php endif ?>
    <?php foreach ($items as $i): ?>
      <tr class="border-b">
        <td class="px-4 py-3">
          <div class="flex items-center gap-3">
            <img src="<?= esc(product_image_url($i['image_url'] ?? null)) ?>" alt="<?= esc($i['name']) ?>" loading="lazy"
                 class="w-12 h-12 object-cover rounded-lg border border-gray-200 bg-gray-50 shrink-0">
            <span class="font-medium text-gray-900"><?= esc($i['name']) ?></span>
          </div>
        </td>
        <td class="px-4 py-3 text-gray-600"><?= esc($i['category']) ?></td>
        <td class="px-4 py-3">Rp <?= number_format($i['price'], 0, ',', '.') ?></td>
        <td class="px-4 py-3 text-right whitespace-nowrap">
          <a href="/admin/edit/<?= (int) $i['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
          <a href="/admin/delete/<?= (int) $i['id'] ?>" onclick="return confirm('Hapus produk ini?')" class="text-red-600 hover:underline ml-3">Hapus</a>
        </td>
      </tr>
    <?php endforeach ?>
    </tbody>
  </table>
  </div>

  <a href="/admin/logout" class="text-red-600 mt-4 inline-block">Logout</a>
</div>
</body>
</html>