<?php
use App\Models\Setting;
$__settings = (new Setting())->get();
$__user = $_SESSION['user'] ?? null;
$__cartCount = 0;
if ($__user) {
    $__db = \App\Core\Database::getInstance();
    $__stmt = $__db->prepare("SELECT COALESCE(SUM(ci.quantity),0) as total FROM cart_items ci JOIN carts c ON c.id = ci.cart_id WHERE c.user_id = ?");
    $__stmt->execute([$__user['id']]);
    $__cartCount = (int) $__stmt->fetch()['total'];
}
$__pageTitle = $pageTitle ?? $__settings['site_name'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($__pageTitle) ?> - <?= e($__settings['site_name']) ?></title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,500&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: '#7A2E1D',
          'primary-dark': '#5E2415',
          secondary: '#D98324',
          cream: '#FBF3EA',
          dark: '#1E1B1A',
        },
        fontFamily: {
          sans: ['Poppins', 'Inter', 'sans-serif'],
          outfit: ['Outfit', 'sans-serif'],
          display: ['Fraunces', 'serif'],
        },
      },
    },
  };
</script>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<style>
  body { font-family: 'Poppins', 'Inter', sans-serif; background-color: #FBF3EA; scroll-behavior: smooth; }
  ::-webkit-scrollbar { width: 8px; }
  ::-webkit-scrollbar-track { background: #FBF3EA; }
  ::-webkit-scrollbar-thumb { background: #D98324; border-radius: 8px; }
  ::-webkit-scrollbar-thumb:hover { background: #7A2E1D; }
  
  .skeleton { background: linear-gradient(90deg,#eee 25%,#f5f5f5 50%,#eee 75%); background-size: 200% 100%; animation: skeleton-loading 1.4s infinite; }
  @keyframes skeleton-loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

  /* Premium Micro-animations */
  @keyframes float-slow {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-10px) rotate(1deg); }
  }
  .animate-float-slow { animation: float-slow 6s ease-in-out infinite; }

  @keyframes float-medium {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-8px) rotate(-1.5deg); }
  }
  .animate-float-medium { animation: float-medium 5s ease-in-out infinite; }

  @keyframes spin-slow {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  .animate-spin-slow { animation: spin-slow 20s linear infinite; }

  @keyframes pulse-glow {
    0%, 100% { box-shadow: 0 0 10px rgba(217, 131, 36, 0.2); }
    50% { box-shadow: 0 0 25px rgba(217, 131, 36, 0.5); }
  }
  .glow-active { animation: pulse-glow 3s infinite; }

  /* Nav Links Underline Effect */
  .nav-link {
    position: relative;
    padding-bottom: 2px;
  }
  .nav-link::after {
    content: '';
    position: absolute;
    width: 100%;
    transform: scaleX(0);
    height: 2px;
    bottom: -2px;
    left: 0;
    background-color: #D98324;
    transform-origin: bottom right;
    transition: transform 0.3s cubic-bezier(0.86, 0, 0.07, 1);
  }
  .nav-link:hover::after {
    transform: scaleX(1);
    transform-origin: bottom left;
  }

  /* Marquee ticker */
  @keyframes marquee-scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
  }
  .marquee-track { animation: marquee-scroll 22s linear infinite; }

  /* Grain texture overlay */
  .grain-overlay {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
    mix-blend-mode: overlay;
  }

  /* Glassmorphism Styles */
  .glass-card {
    background: rgba(255, 255, 255, 0.45);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.25);
  }
  .glass-card-dark {
    background: rgba(30, 27, 26, 0.85);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.1);
  }
</style>
</head>
<body class="text-gray-800 antialiased">

<nav id="mainNavbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 bg-white/20 backdrop-blur-sm border-b border-white/10 py-4">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-14">
      <a href="<?= BASE_URL ?>/" class="flex items-center gap-2.5 text-xl font-extrabold text-primary font-outfit tracking-wide group hover:scale-102 transition-all duration-300">
        <img src="<?= BASE_URL ?>/assets/images/logo.svg" alt="UKM ARC Logo" class="w-10 h-10 group-hover:rotate-12 transition-transform duration-300">
        <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent group-hover:brightness-110 transition">UKM ARC</span>
      </a>

      <div class="hidden md:flex items-center gap-8 font-semibold text-sm tracking-wide">
        <a href="<?= BASE_URL ?>/" class="nav-link text-primary hover:text-secondary transition duration-300">Beranda</a>
        <a href="<?= BASE_URL ?>/produk" class="nav-link text-primary hover:text-secondary transition duration-300">Katalog</a>
        <?php if ($__user): ?>
          <a href="<?= BASE_URL ?>/pesanan" class="nav-link text-primary hover:text-secondary transition duration-300">Pesanan Saya</a>
        <?php endif; ?>
      </div>

      <div class="flex items-center gap-5">
        <a href="<?= BASE_URL ?>/cart" class="relative group p-2 rounded-full hover:bg-cream/50 transition duration-300">
          <i class="fa-solid fa-cart-shopping text-xl text-primary group-hover:text-secondary transition-colors duration-300"></i>
          <?php if ($__cartCount > 0): ?>
            <span class="absolute -top-1 -right-1 bg-secondary text-white text-[10px] font-extrabold w-5 h-5 flex items-center justify-center rounded-full animate-bounce"><?= $__cartCount ?></span>
          <?php endif; ?>
        </a>
        <?php if ($__user): ?>
          <div class="relative group">
            <button class="flex items-center gap-2 text-sm font-semibold text-primary py-1 px-3 rounded-full hover:bg-cream/50 transition duration-300">
              <span class="w-7 h-7 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                <?= strtoupper(substr(e($__user['name']), 0, 1)) ?>
              </span>
              <span class="hidden sm:inline"><?= e($__user['name']) ?></span>
              <i class="fa-solid fa-chevron-down text-xs opacity-60"></i>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right group-hover:translate-y-0 translate-y-1">
              <a href="<?= BASE_URL ?>/profile" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-cream hover:text-primary transition">
                <i class="fa-solid fa-user-circle mr-2 opacity-70"></i>Profil Saya
              </a>
              <a href="<?= BASE_URL ?>/pesanan" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-cream hover:text-primary transition">
                <i class="fa-solid fa-bag-shopping mr-2 opacity-70"></i>Pesanan Saya
              </a>
              <?php if ($__user['role'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>/admin/dashboard" class="block px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-cream hover:text-primary transition">
                  <i class="fa-solid fa-gauge mr-2 opacity-70"></i>Panel Admin
                </a>
              <?php endif; ?>
              <hr class="my-1 border-gray-100">
              <a href="<?= BASE_URL ?>/logout" class="block px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 transition">
                <i class="fa-solid fa-right-from-bracket mr-2 opacity-80"></i>Keluar
              </a>
            </div>
          </div>
        <?php else: ?>
          <a href="<?= BASE_URL ?>/login" class="px-6 py-2.5 rounded-full bg-gradient-to-r from-primary to-secondary text-white text-sm font-bold shadow-md hover:brightness-105 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300">
            <i class="fa-solid fa-right-to-bracket mr-1.5"></i>Masuk
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<div class="h-20"></div>
