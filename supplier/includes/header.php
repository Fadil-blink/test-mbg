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
require_once __DIR__ . '/../../includes/db.php';

function supplier_lookup_by_session(mysqli $mysqli) {
  $supplierId = $_SESSION['supplier_id'] ?? null;
  if (!$supplierId && !empty($_SESSION['organization_id']) && is_numeric($_SESSION['organization_id'])) {
    $supplierId = (int)$_SESSION['organization_id'];
  }

  if (!$supplierId) {
    $stmt = $mysqli->prepare('SELECT id FROM suppliers WHERE email = ? OR name = ? LIMIT 1');
    if ($stmt) {
      $email = $_SESSION['email'] ?? '';
      $name = $_SESSION['full_name'] ?? '';
      $stmt->bind_param('ss', $email, $name);
      $stmt->execute();
      $stmt->bind_result($foundId);
      if ($stmt->fetch()) {
        $supplierId = (int)$foundId;
      }
      $stmt->close();
    }
  }

  if (!$supplierId) {
    $result = $mysqli->query('SELECT id FROM suppliers WHERE status = "aktif" ORDER BY rating DESC LIMIT 1');
    if ($result && ($row = $result->fetch_assoc())) {
      $supplierId = (int)$row['id'];
    }
  }

  if (!$supplierId) {
    return null;
  }

  $_SESSION['supplier_id'] = $supplierId;

  $stmt = $mysqli->prepare('SELECT id, code, name, type, city, province, email, phone, rating, total_sales, total_transactions, status FROM suppliers WHERE id = ? LIMIT 1');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $result = $stmt->get_result();
    $supplier = $result->fetch_assoc();
    $stmt->close();
    return $supplier ?: null;
  }
  return null;
}

$supplier = supplier_lookup_by_session($mysqli);
$supplierId = $supplier['id'] ?? null;
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
