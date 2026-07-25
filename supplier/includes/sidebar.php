<?php
$menu = [
  'index.php'               => ['fa-th-large', 'Beranda'],
  'produk-saya.php'         => ['fa-box', 'Produk Saya'],
  'manajemen-stok.php'      => ['fa-clipboard-list', 'Manajemen Stok'],
  'pesanan-masuk.php'       => ['fa-shopping-cart', 'Pesanan Masuk'],
  'pengiriman.php'          => ['fa-truck', 'Pengiriman'],
  'pendapatan.php'          => ['fa-money-check-alt', 'Pendapatan'],
  'riwayat-penjualan.php'   => ['fa-history', 'Riwayat Penjualan'],
  'invoice-digital.php'     => ['fa-file-invoice', 'Invoice Digital'],
  'analitik-penjualan.php'  => ['fa-chart-bar', 'Analitik Penjualan'],
  'notifikasi.php'          => ['fa-bell', 'Notifikasi'],
];
$current = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar">
  <div class="brand">
    <div class="brand-icon"><i class="fa-solid fa-tractor"></i></div>
    <div class="brand-text">
      <div class="name">Supplier MBG</div>
      <div class="sub">Ekosistem Agrikultur</div>
    </div>
  </div>
  <nav class="nav">
    <?php foreach ($menu as $file => $item): ?>
      <a href="<?= $file ?>" class="<?= $current === $file ? 'active' : '' ?>">
        <i class="fa-solid <?= $item[0] ?>"></i><?= $item[1] ?>
      </a>
    <?php endforeach; ?>
  </nav>
  <div class="nav-bottom">
    <a href="#" class="logout"><i class="fa-solid fa-right-from-bracket"></i>Keluar</a>
  </div>
</aside>
