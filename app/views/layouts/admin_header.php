<?php
$__pageTitle = $pageTitle ?? 'Admin';
$__user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($__pageTitle) ?> - Admin UKM ARC</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: { primary: '#7A2E1D', 'primary-dark': '#5E2415', secondary: '#D98324', cream: '#FBF3EA' },
        fontFamily: { sans: ['Poppins', 'Inter', 'sans-serif'] },
      },
    },
  };
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
  body { font-family: 'Poppins', 'Inter', sans-serif; background-color: #FBF3EA; }
  @media (max-width: 767px) { #adminSidebar { transform: translateX(-100%); } #adminSidebar.open { transform: translateX(0); } }
</style>
</head>
<body class="text-gray-800">

<?php include APP_PATH . '/views/admin/layout/sidebar.php'; ?>

<div class="md:ml-64 min-h-screen">
  <header class="bg-white shadow-sm sticky top-0 z-30 px-4 md:px-8 py-4 flex items-center justify-between">
    <button id="sidebarToggle" class="md:hidden text-xl text-primary"><i class="fa-solid fa-bars"></i></button>
    <h1 class="text-lg font-bold text-primary"><?= e($__pageTitle) ?></h1>
    <div class="flex items-center gap-2 text-sm">
      <i class="fa-solid fa-circle-user text-lg text-primary"></i>
      <span class="hidden sm:inline font-medium"><?= e($__user['name'] ?? '') ?></span>
    </div>
  </header>

  <main class="p-4 md:p-8">
