<?php
require __DIR__ . '/config.php';
$pageTitle = "Transaksi Pembelian";
$topbarTitle = "Transaksi Pembelian";
require __DIR__ . '/includes/header.php';
?>

<div class="breadcrumb">Beranda &rsaquo; <b>Transaksi Pembelian</b></div>
<div class="page-head">
  <div><h1>Monitoring Transaksi Pengadaan</h1></div>
  <div class="page-head-actions">
    <button class="btn btn-primary"><i data-lucide="shopping-cart"></i>Buat Transaksi Baru</button>
  </div>
</div>

<div class="grid grid-4 mb-24">
  <div class="stat-card">
    <div class="stat-icon" style="margin-bottom:10px;"><i data-lucide="file-text"></i></div>
    <div class="stat-label-plain">Total Transaksi</div>
    <div class="stat-value">12.5k</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="margin-bottom:10px;"><i data-lucide="wallet"></i></div>
    <div class="stat-label-plain">Nilai Pembelian</div>
    <div class="stat-value" style="color:var(--blue-600);">Rp 8.4T</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#fbeedd;color:#b9791b;margin-bottom:10px;"><i data-lucide="smile"></i></div>
    <div class="stat-label-plain">Transaksi Menunggu</div>
    <div class="stat-value">145</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:var(--green-bg);color:var(--green-text);margin-bottom:10px;"><i data-lucide="check-circle-2"></i></div>
    <div class="stat-label-plain">Transaksi Berhasil</div>
    <div class="stat-value">98%</div>
  </div>
</div>

<div class="filter-toolbar">
  <span class="filter-label"><i data-lucide="sliders-horizontal" style="width:15px;height:15px;vertical-align:-2px;"></i> Filter:</span>
  <input type="text" class="input" placeholder="mm/dd/yyyy" style="max-width:150px;">
  <div class="dropdown">Semua SPPG<i data-lucide="chevron-down"></i></div>
  <div class="dropdown">Semua Supplier<i data-lucide="chevron-down"></i></div>
  <div class="dropdown">Semua Status<i data-lucide="chevron-down"></i></div>
  <span class="link-btn" style="margin-left:auto;">Reset</span>
</div>

<div class="card" style="padding:0;margin-top:20px;">
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr><th>ID Transaksi</th><th>Tanggal</th><th>SPPG</th><th>Supplier</th><th>Komoditas</th><th>Jumlah</th><th>Total Harga</th><th>Status</th></tr>
      </thead>
      <tbody>
        <tr>
          <td class="cell-strong">#TRX-99281</td>
          <td>24 Jul 2026</td>
          <td>SPPG Surabaya 01</td>
          <td>UMKM Tani Makmur</td>
          <td>Beras Premium</td>
          <td>5.000 Kg</td>
          <td class="cell-money">Rp 75.000.000</td>
          <td><span class="badge badge-success" style="width:9px;height:9px;padding:0;border-radius:50%;"></span></td>
        </tr>
        <tr>
          <td class="cell-strong">#TRX-99280</td>
          <td>24 Jul 2026</td>
          <td>SPPG Malang 02</td>
          <td>Koperasi Ternak Jaya</td>
          <td>Telur Ayam</td>
          <td>2.500 Kg</td>
          <td class="cell-money">Rp 62.500.000</td>
          <td><span class="badge badge-info" style="width:9px;height:9px;padding:0;border-radius:50%;"></span></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="pagination-row" style="padding:16px 22px;">
    <span>Menampilkan 1-10 dari 12.540 transaksi</span>
    <div class="pagination">
      <span class="page-btn"><i data-lucide="chevron-left"></i></span>
      <span class="page-btn active">1</span>
      <span class="page-btn"><i data-lucide="chevron-right"></i></span>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
