<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user_id'])) {
  header('Location: ../auth/login.php');
  exit;
}
$roleName = strtolower($_SESSION['role_name'] ?? '');
$roleId = (int)($_SESSION['role_id'] ?? 0);
if (!in_array($roleName, ['supplier', 'admin_supplier']) && !in_array($roleId, [6,7])) {
  header('Location: ../auth/login.php');
  exit;
}
$page_title = $page_title ?? 'Supplier MBG';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title) ?> - Supplier MBG</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="app">
<?php include __DIR__ . '/sidebar.php'; ?>
<div class="main">
  <div class="topbar">
    <div class="search-box">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" placeholder="Cari data pesanan atau produk...">
    </div>
    <div class="topbar-icons">
      <i class="fa-regular fa-bell"></i>
      <i class="fa-solid fa-gear"></i>
      <div class="divider-v"></div>
      <a href="../auth/logout.php" class="icon-btn" title="Logout" style="color:inherit;text-decoration:none;display:inline-flex;align-items:center;">
        <i class="fa-solid fa-right-from-bracket"></i>
      </a>
      <img class="avatar" src="https://i.pravatar.cc/80?img=13" alt="avatar">
    </div>
  </div>
  <div class="content">
