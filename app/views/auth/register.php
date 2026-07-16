<?php $pageTitle = 'Daftar Akun'; include APP_PATH . '/views/layouts/header.php'; ?>

<!-- Glowing Blobs for Auth Background -->
<div class="absolute top-[20%] left-1/2 -translate-x-[150%] w-80 h-80 bg-primary/10 rounded-full blur-3xl pointer-events-none -z-10 animate-float-slow"></div>
<div class="absolute bottom-[20%] left-1/2 translate-x-[50%] w-80 h-80 bg-secondary/15 rounded-full blur-3xl pointer-events-none -z-10 animate-float-medium"></div>

<section class="min-h-[85vh] flex items-center justify-center px-4 py-16 relative overflow-hidden">
  <div class="max-w-md w-full bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-white/60 p-8 md:p-10 relative z-10" data-aos="fade-up">
    <!-- Header Logo / Icon -->
    <div class="text-center mb-8">
      <div class="w-16 h-16 bg-white border border-gray-100 rounded-2xl flex items-center justify-center mx-auto shadow-md mb-4 -rotate-6 hover:rotate-0 transition duration-300">
        <img src="<?= BASE_URL ?>/assets/images/logo.svg" alt="UKM ARC Logo" class="w-12 h-12">
      </div>
      <h1 class="text-2xl font-extrabold text-primary font-outfit tracking-wide">Buat Akun Baru</h1>
      <p class="text-xs text-gray-400 mt-1 font-light">Daftar untuk mulai menikmati kemudahan belanja di UKM ARC</p>
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

    <!-- Form -->
    <form method="POST" action="<?= BASE_URL ?>/register" class="space-y-4">
      <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
      
      <!-- Name Field -->
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider pl-1">Nama Lengkap</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
            <i class="fa-solid fa-user"></i>
          </span>
          <input type="text" name="name" required value="<?= e($old['name'] ?? '') ?>" placeholder="Nama Lengkap Anda"
            class="w-full pl-11 pr-4 py-2.5 bg-white border border-gray-200/80 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300 text-sm text-gray-700 placeholder-gray-300 shadow-sm">
        </div>
      </div>

      <!-- Email Field -->
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider pl-1">Alamat Email</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
            <i class="fa-solid fa-envelope"></i>
          </span>
          <input type="email" name="email" required value="<?= e($old['email'] ?? '') ?>" placeholder="nama@email.com"
            class="w-full pl-11 pr-4 py-2.5 bg-white border border-gray-200/80 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300 text-sm text-gray-700 placeholder-gray-300 shadow-sm">
        </div>
      </div>

      <!-- Phone Field -->
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider pl-1">Nomor HP / WhatsApp</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
            <i class="fa-solid fa-phone"></i>
          </span>
          <input type="text" name="phone" value="<?= e($old['phone'] ?? '') ?>" placeholder="08xxxxxxxxxx"
            class="w-full pl-11 pr-4 py-2.5 bg-white border border-gray-200/80 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300 text-sm text-gray-700 placeholder-gray-300 shadow-sm">
        </div>
      </div>
      
      <!-- Password Field -->
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider pl-1">Password</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
            <i class="fa-solid fa-lock"></i>
          </span>
          <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter"
            class="w-full pl-11 pr-4 py-2.5 bg-white border border-gray-200/80 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300 text-sm text-gray-700 placeholder-gray-300 shadow-sm">
        </div>
      </div>

      <!-- Confirm Password Field -->
      <div class="space-y-1.5">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider pl-1">Konfirmasi Password</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
            <i class="fa-solid fa-check-double"></i>
          </span>
          <input type="password" name="confirm_password" required minlength="6" placeholder="Ulangi password"
            class="w-full pl-11 pr-4 py-2.5 bg-white border border-gray-200/80 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300 text-sm text-gray-700 placeholder-gray-300 shadow-sm">
        </div>
      </div>
      
      <!-- Submit Button -->
      <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white font-bold py-3.5 rounded-2xl hover:brightness-105 active:scale-98 shadow-lg shadow-primary/10 transition-all duration-300 transform mt-4 flex items-center justify-center gap-2">
        Daftar Sekarang <i class="fa-solid fa-user-plus text-xs"></i>
      </button>
    </form>

    <!-- Navigation links -->
    <div class="mt-6 pt-5 border-t border-gray-100/80 text-center">
      <p class="text-sm text-gray-500 font-light">
        Sudah punya akun? <a href="<?= BASE_URL ?>/login" class="text-secondary font-bold hover:underline">Masuk di sini</a>
      </p>
    </div>
  </div>
</section>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
