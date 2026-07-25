<?php
$pageTitle = 'Penerimaan Barang';
$active = 'penerimaan';
include 'includes/header.php';

$deliveries = [
  ['supplier'=>'Tani Maju Bersama','po'=>'#PO-2024-0089','status'=>'Dalam Perjalanan','komoditas'=>'Beras Premium','jumlah'=>'2.500 kg','eta'=>'25 Okt 2024'],
  ['supplier'=>'Pusat Unggas Segar','po'=>'#PO-2024-0088','status'=>'Dalam Perjalanan','komoditas'=>'Telur Ayam','jumlah'=>'500 kg','eta'=>'26 Okt 2024'],
];
?>
<div class="page-header-row">
  <div>
    <div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Penerimaan Barang</b></div>
    <h1 class="page-title">Penerimaan Barang</h1>
    <p class="page-sub">Kelola dan verifikasi kedatangan komoditas dari supplier secara real-time.</p>
  </div>
  <a href="#" class="btn btn-navy">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 4v5h5"/></svg>
    Riwayat Penerimaan
  </a>
</div>

<div class="toolbar">
  <div class="search-input">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
    <input type="text" placeholder="Cari ID Pesanan atau Supplier...">
  </div>
  <select><option>Filter Status</option></select>
</div>

<div class="receive-grid">
  <?php foreach ($deliveries as $d): ?>
  <div class="receive-card">
    <div class="rc-top">
      <div>
        <div class="rc-name"><?php echo $d['supplier']; ?></div>
        <div class="rc-id"><?php echo $d['po']; ?></div>
      </div>
      <span class="status-pill dalam-perjalanan"><?php echo $d['status']; ?></span>
    </div>
    <div class="rc-grid">
      <div>
        <div class="lbl">Komoditas</div>
        <div class="val"><?php echo $d['komoditas']; ?></div>
      </div>
      <div>
        <div class="lbl">Jumlah</div>
        <div class="val"><?php echo $d['jumlah']; ?></div>
      </div>
      <div>
        <div class="lbl">Estimasi Kedatangan</div>
        <div class="val"><?php echo $d['eta']; ?></div>
      </div>
    </div>
    <div class="rc-actions">
      <a href="#" class="btn btn-navy confirm-receive">Konfirmasi Penerimaan</a>
      <a href="#" class="btn btn-outline report-issue">Laporkan Masalah</a>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
