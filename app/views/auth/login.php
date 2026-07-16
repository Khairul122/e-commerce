<?php $pageTitle = 'Masuk'; include APP_PATH . '/views/layouts/header.php'; ?>

<!-- Glowing Blobs for Auth Background -->
<div class="absolute top-[20%] left-1/2 -translate-x-[150%] w-80 h-80 bg-primary/10 rounded-full blur-3xl pointer-events-none -z-10 animate-float-slow"></div>
<div class="absolute bottom-[20%] left-1/2 translate-x-[50%] w-80 h-80 bg-secondary/15 rounded-full blur-3xl pointer-events-none -z-10 animate-float-medium"></div>

<section class="min-h-[75vh] flex items-center justify-center px-4 py-16 relative overflow-hidden">
  <div class="max-w-md w-full bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-white/60 p-8 md:p-10 relative z-10" data-aos="fade-up">
    <!-- Header Logo / Icon -->
    <div class="text-center mb-8">
      <div class="w-16 h-16 bg-white border border-gray-100 rounded-2xl flex items-center justify-center mx-auto shadow-md mb-4 rotate-6 hover:rotate-12 transition duration-300">
        <img src="<?= BASE_URL ?>/assets/images/logo.svg" alt="UKM ARC Logo" class="w-12 h-12">
      </div>
      <h1 class="text-2xl font-extrabold text-primary font-outfit tracking-wide">Selamat Datang Kembali</h1>
      <p class="text-xs text-gray-400 mt-1 font-light">Masuk untuk mengelola pesanan lezat Anda di UKM ARC</p>
    </div>

    <!-- Error Messages -->
    <?php if (!empty($errors)): ?>
      <div class="bg-red-50 border border-red-100 text-red-600 text-xs rounded-2xl p-4 mb-6 shadow-sm">
        <div class="flex items-center gap-2 mb-1.5 font-bold">
          <i class="fa-solid fa-circle-exclamation text-sm"></i> Periksa Kesalahan:
        </div>
        <ul class="list-disc pl-5 font-medium space-y-1">
          <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Success Flash Messages -->
    <?php if (!empty($flash['success'])): ?>
      <div class="bg-green-50 border border-green-100 text-green-700 text-xs rounded-2xl p-4 mb-6 shadow-sm flex items-center gap-2 font-bold">
        <i class="fa-solid fa-circle-check text-sm text-green-500"></i>
        <span><?= e($flash['success']) ?></span>
      </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="POST" action="<?= BASE_URL ?>/login" class="space-y-5">
      <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
      
      <!-- Email Field -->
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider pl-1">Alamat Email</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
            <i class="fa-solid fa-envelope"></i>
          </span>
          <input type="email" name="email" required value="<?= e($old['email'] ?? '') ?>" placeholder="nama@email.com"
            class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200/80 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300 text-sm text-gray-700 placeholder-gray-300 shadow-sm">
        </div>
      </div>
      
      <!-- Password Field -->
      <div class="space-y-1.5">
        <div class="flex justify-between items-center pl-1">
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Password</label>
        </div>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
            <i class="fa-solid fa-lock"></i>
          </span>
          <input type="password" name="password" required placeholder="••••••••"
            class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200/80 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300 text-sm text-gray-700 placeholder-gray-300 shadow-sm">
        </div>
      </div>
      
      <!-- Submit Button -->
      <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white font-bold py-3.5 rounded-2xl hover:brightness-105 active:scale-98 shadow-lg shadow-primary/10 transition-all duration-300 transform mt-2 flex items-center justify-center gap-2">
        Masuk Sekarang <i class="fa-solid fa-right-to-bracket text-xs"></i>
      </button>
    </form>

    <!-- Navigation links -->
    <div class="mt-8 pt-6 border-t border-gray-100/80 text-center space-y-3">
      <p class="text-sm text-gray-500 font-light">
        Belum punya akun? <a href="<?= BASE_URL ?>/register" class="text-secondary font-bold hover:underline">Daftar sekarang</a>
      </p>
      <p class="text-[11px] text-gray-400 leading-relaxed font-light">
        <i class="fa-solid fa-circle-info mr-1 text-primary/45"></i> Lupa password? Silakan hubungi admin via WhatsApp untuk mereset kata sandi Anda.
      </p>
    </div>
  </div>
</section>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
