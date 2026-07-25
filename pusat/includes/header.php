<?php if (!isset($topbarTitle)) { $topbarTitle = "PAN MBG Dashboard"; } ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . " - " : ""; ?>PAN MBG | Pusat Audit Nasional</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
</head>
<body>
<div class="app">
  <?php require __DIR__ . '/sidebar.php'; ?>
  <div class="main">
    <header class="topbar">
      <div class="topbar-title"><?php echo htmlspecialchars($topbarTitle); ?></div>
      <div class="searchbox">
        <i data-lucide="search"></i>
        <input type="text" placeholder="Cari SPPG, Supplier, atau Transaksi...">
      </div>
      <div class="topbar-right">
        <div class="icon-btn"><i data-lucide="bell"></i><span class="icon-dot"></span></div>
        <div class="icon-btn"><i data-lucide="calendar"></i></div>
        <div class="topbar-divider"></div>
        <div class="profile-tag">
          <span>Profil Pengguna</span>
          <span class="avatar-sm">A</span>
        </div>
      </div>
    </header>
    <main class="content">
