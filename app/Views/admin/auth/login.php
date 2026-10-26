<?php helper('form'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin - SayurSegar</title>
<link rel="stylesheet" href="/assets/css/app.css">
<link rel="stylesheet" href="/assets/fonts/fonts.css">
<link rel="stylesheet" href="/assets/phosphor/regular/style.css">
<link rel="stylesheet" href="/assets/phosphor/fill/style.css">
<style>
    body { font-family: 'Inter', sans-serif; }
    .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
    .produce-pattern {
        background-image: radial-gradient(rgba(255, 255, 255, 0.18) 1px, transparent 1px);
        background-size: 22px 22px;
    }
</style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">

<div class="mx-auto flex min-h-screen max-w-6xl items-center justify-center px-4 py-10 sm:px-6">
    <div class="grid w-full overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/70 lg:grid-cols-2">

        <div class="produce-pattern relative hidden flex-col justify-between bg-emerald-700 p-10 text-white lg:flex">
            <div class="flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/15">
                    <i class="ph-fill ph-leaf text-2xl"></i>
                </span>
                <div>
                    <p class="font-display text-lg font-extrabold leading-tight">SayurSegar</p>
                    <p class="text-xs font-medium uppercase tracking-widest text-emerald-200">Admin Panel</p>
                </div>
            </div>

            <div>
                <p class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-emerald-100">
                    <i class="ph ph-plant"></i> Kelola katalog toko
                </p>
                <h2 class="font-display max-w-sm text-3xl font-extrabold leading-tight">Produk segar, katalog rapi, pelanggan senang.</h2>
                <p class="mt-4 max-w-sm text-sm leading-relaxed text-emerald-100">Kelola produk dan kategori dalam satu tempat. Perubahan langsung tampil di halaman toko.</p>
            </div>

            <p class="text-xs text-emerald-200">&copy; <?= date('Y') ?> SayurSegar</p>
        </div>

        <div class="p-8 sm:p-10 lg:p-12">
            <div class="mb-8">
                <a href="/" class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-emerald-600">
                    <i class="ph ph-arrow-left"></i> Kembali ke toko
                </a>
                <h1 class="font-display text-2xl font-extrabold text-slate-900">Masuk ke Admin</h1>
                <p class="mt-2 text-sm text-slate-500">Gunakan akun administrator untuk mengelola katalog.</p>
            </div>

            <?php $error = session()->getFlashdata('error'); ?>
            <?php if ($error): ?>
            <div class="mb-5 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <i class="ph-fill ph-warning-circle mt-0.5 text-lg text-red-500"></i>
                <p class="font-medium"><?= esc($error) ?></p>
            </div>
            <?php endif ?>

            <form action="/admin/login" method="post" class="space-y-5">
                <?= csrf_field() ?>

                <div>
                    <label for="username" class="mb-1.5 block text-sm font-semibold text-slate-700">Username</label>
                    <div class="relative">
                        <i class="ph ph-user pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>
                        <input type="text" id="username" name="username" required autofocus value="<?= esc(old('username')) ?>"
                               class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Password</label>
                    <div class="relative">
                        <i class="ph ph-lock-key pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>
                        <input type="password" id="password" name="password" required
                               class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                    </div>
                </div>

                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                    Masuk
                    <i class="ph ph-arrow-right"></i>
                </button>
            </form>

            <p class="mt-8 text-xs leading-relaxed text-slate-400">Kredensial administrator dikelola melalui konfigurasi server.</p>
        </div>
    </div>
</div>

</body>
</html>
