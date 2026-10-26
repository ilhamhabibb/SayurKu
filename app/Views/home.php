<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>SayurSegar - Kebutuhan Dapur Harian</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/@phosphor-icons/web"></script>
<style>body{font-family:'Inter',sans-serif;scroll-behavior:smooth;}</style>
</head>
<body class="bg-gray-50 text-gray-800">

<nav class="bg-white shadow-sm fixed w-full top-0 z-50">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex justify-between items-center h-16">
<a href="/" class="flex items-center"><i class="ph-fill ph-leaf text-green-600 text-3xl mr-2"></i><span class="font-bold text-xl text-green-700">SayurSegar</span></a>
<div class="hidden md:flex space-x-8"><a href="#produk" class="text-gray-600 hover:text-green-600 font-medium">Produk</a><a href="#checkout" class="text-gray-600 hover:text-green-600 font-medium">Checkout</a></div>
<div class="flex items-center"><button onclick="document.getElementById('cart-panel').classList.toggle('hidden')" class="relative p-2 text-gray-600 hover:text-green-600" aria-label="Keranjang"><i class="ph ph-shopping-cart text-2xl"></i><span id="cart-badge" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full scale-0 transition-transform">0</span></button></div>
</div></div>
</nav>

<section class="relative pt-24 pb-12 lg:pt-32 lg:pb-24 bg-green-50 overflow-hidden">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center max-w-3xl mx-auto">
<h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">Bahan Masak Segar, <br><span class="text-green-600">Langsung ke Dapur Anda</span></h1>
<p class="text-lg text-gray-600 mb-8">Penuhi kebutuhan nutrisi keluarga dengan sayuran organik dan bumbu pilihan yang dipanen hari ini.</p>
<a href="#produk" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white bg-green-600 rounded-full hover:bg-green-700 shadow-lg transition">Belanja Sekarang <i class="ph-bold ph-arrow-right ml-2"></i></a>
</div>
</section>

<section id="produk" class="py-16 bg-white">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="text-center mb-12"><h2 class="text-3xl font-bold text-gray-900">Produk Segar Kami</h2><div class="w-24 h-1 bg-green-500 mx-auto mt-4 rounded-full"></div></div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
<?php foreach ($products as $p): ?>
<div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition border border-gray-100 overflow-hidden group">
<div class="relative overflow-hidden"><img src="<?= esc(product_image_url($p['image_url'] ?? null)) ?>" alt="<?= esc($p['name']) ?>" loading="lazy" onerror="this.onerror=null;this.src='<?= esc(base_url('uploads/placeholder.svg')) ?>'" class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500"></div>
<div class="p-5">
<h3 class="text-lg font-bold text-gray-900 mb-1"><?= esc($p['name']) ?></h3>
<p class="text-sm text-gray-500 mb-1"><?= esc($p['unit']) ?></p>
<div class="flex items-center justify-between mt-4">
<span class="text-xl font-bold text-green-600">Rp <?= number_format($p['price'],0,',','.') ?></span>
<button onclick="addToCart('<?= esc($p['name']) ?>',<?= $p['price'] ?>)" class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition" aria-label="Tambah"><i class="ph-bold ph-plus"></i></button>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<section id="checkout" class="py-16 bg-gray-50">
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 bg-white rounded-3xl shadow-lg p-8">
<h2 class="text-2xl font-bold text-gray-900 mb-6">Checkout</h2>
<form action="/checkout" method="post">
<div class="grid md:grid-cols-2 gap-4 mb-4">
<input type="text" name="name" placeholder="Nama Lengkap" required class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" />
<input type="text" name="address" placeholder="Alamat" required class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500" />
</div>
<textarea name="items" id="checkout-items" placeholder="Barang yang dipesan" required class="w-full border border-gray-300 rounded-xl px-4 py-3 mb-4 focus:outline-none focus:ring-2 focus:ring-green-500" rows="3"></textarea>
<div class="flex justify-between items-center mb-6"><span class="text-gray-600">Total:</span><span id="checkout-total" class="text-2xl font-bold text-green-600">Rp 0</span></div>
<input type="hidden" name="total" id="checkout-total-hidden" value="0" />
<button type="submit" class="w-full bg-green-600 text-white font-semibold py-4 rounded-xl hover:bg-green-700 transition">Kirim ke WhatsApp</button>
</form>
</div>
</section>

<footer id="tentang" class="bg-gray-900 text-white pt-16 pb-8">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid md:grid-cols-3 gap-12 mb-12">
<div><div class="flex items-center mb-4"><i class="ph-fill ph-leaf text-green-500 text-3xl mr-2"></i><span class="font-bold text-2xl">SayurSegar</span></div><p class="text-gray-400 text-sm">Kami berkomitmen menyediakan bahan masakan segar langsung dari petani lokal.</p></div>
<div><h4 class="text-lg font-bold mb-4">Tautan</h4><ul class="space-y-2 text-sm text-gray-400"><li><a href="#" class="hover:text-green-500">Beranda</a></li><li><a href="#produk" class="hover:text-green-500">Produk</a></li></ul></div>
<div><h4 class="text-lg font-bold mb-4">Kontak</h4><ul class="space-y-2 text-sm text-gray-400"><li><i class="ph ph-whatsapp-logo mr-2 text-green-500"></i><?= esc(env('WA_DISPLAY', '+62 812 3456 7890')) ?></li></ul></div>
</div>
<div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-500">© <?= date('Y') ?> SayurSegar</div>
</div>
</footer>

<div id="cart-panel" class="hidden fixed inset-0 bg-black/50 z-50 flex justify-end">
<div class="w-full max-w-md bg-white h-full shadow-2xl p-6 overflow-y-auto">
<button onclick="document.getElementById('cart-panel').classList.add('hidden')" class="text-gray-500 hover:text-red-600 mb-4">Tutup</button>
<h2 class="text-xl font-bold mb-4">Keranjang</h2>
<ul id="cart-list" class="space-y-2 mb-4"></ul>
<div class="border-t pt-4 flex justify-between font-bold"><span>Total:</span><span id="cart-total">Rp 0</span></div>
</div>
</div>

<div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>

<script>
let cart={};
function addToCart(name,price){cart[name]=(cart[name]||0)+1;updateCart();showToast(name);}
function updateCart(){let count=Object.values(cart).reduce((a,b)=>a+b,0);document.getElementById('cart-badge').textContent=count;document.getElementById('cart-badge').classList.remove('scale-0');document.getElementById('cart-badge').classList.add('scale-100');let list=document.getElementById('cart-list'),items="",total=0;for(let n in cart){let p=0;<?php foreach($products as $p){echo "if('".esc($p['name'])."'==n)p=".$p['price'].";";}?>items+=`<li class="flex justify-between"><span>${n} x${cart[n]}</span><span>Rp ${cart[n]*p}</span></li>`;total+=cart[n]*p;}list.innerHTML=items||'<li class="text-gray-400">Kosong</li>';document.getElementById('cart-total').textContent='Rp '+total.toLocaleString('id-ID');document.getElementById('checkout-items').value=Object.keys(cart).map(n=>`${n} x${cart[n]}`).join(', ');document.getElementById('checkout-total').textContent='Rp '+total.toLocaleString('id-ID');document.getElementById('checkout-total-hidden').value=total;}
function showToast(name){const t=document.createElement('div');t.className='bg-white border-l-4 border-green-500 shadow-lg rounded-r p-4 min-w-[250px]';t.innerHTML=`<p class="font-bold text-sm">Ditambahkan!</p><p class="text-xs text-gray-500">${name}</p>`;document.getElementById('toast-container').appendChild(t);setTimeout(()=>t.remove(),3000);}
</script>
</body>
</html>
