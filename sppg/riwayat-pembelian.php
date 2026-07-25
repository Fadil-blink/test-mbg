<?php
$pageTitle = 'Riwayat Pembelian';
$active = 'riwayat';
include 'includes/header.php';

$transactions = [
  ['id'=>'#TRX-88210','tanggal'=>'24 Okt 2024','supplier'=>'PT. Pangan Nusantara Abadi','komoditas'=>'Beras Premium','jumlah'=>'5.000 Kg','total'=>'Rp 124.500.000'],
  ['id'=>'#TRX-88209','tanggal'=>'23 Okt 2024','supplier'=>'UD. Berkah Tani Jaya','komoditas'=>'Telur Ayam','jumlah'=>'2.000 Kg','total'=>'Rp 45.200.000'],
  ['id'=>'#TRX-88208','tanggal'=>'22 Okt 2024','supplier'=>'CV. Mitra Gizi Sejahtera','komoditas'=>'Daging Ayam','jumlah'=>'1.500 Kg','total'=>'Rp 89.750.000'],
  ['id'=>'#TRX-88207','tanggal'=>'21 Okt 2024','supplier'=>'Koperasi Tani Makmur','komoditas'=>'Sayuran Segar','jumlah'=>'3.000 Kg','total'=>'Rp 210.300.000'],
];
?>
<div class="page-header-row">
  <div>
    <div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Riwayat Pembelian</b></div>
    <h1 class="page-title">Riwayat Pembelian</h1>
    <p class="page-sub">Pantau dan kelola seluruh riwayat transaksi pengadaan komoditas gizi.</p>
  </div>
</div>

<div class="kpi-grid cols-4">
  <div class="kpi-card">
    <div class="kpi-label">Total Pembelian Bulan Ini</div>
    <div class="kpi-value">Rp 458,2M</div>
    <div class="kpi-note up">+12%</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Total Transaksi</div>
    <div class="kpi-value">1.240</div>
    <div class="kpi-note">transaksi berhasil</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Komoditas Utama</div>
    <div class="kpi-value" style="font-size:20px;">Beras Premium</div>
    <div class="kpi-note">60% dari total volume</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Rata-rata Transaksi</div>
    <div class="kpi-value">Rp 369,5jt</div>
    <div class="kpi-note">per invoice</div>
  </div>
</div>

<div class="toolbar">
  <div class="search-input">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
    <input type="text" placeholder="Cari transaksi atau supplier...">
  </div>
  <select><option>Semua Status</option></select>
  <select><option>Semua Komoditas</option></select>
  <select><option>Rentang Tanggal</option></select>
  <a href="#" class="btn btn-outline">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
    Ekspor Laporan (CSV)
  </a>
</div>

<div class="table-wrap">
  <table class="data-table">
    <thead>
      <tr><th>ID Transaksi</th><th>Tanggal</th><th>Supplier</th><th>Komoditas</th><th>Jumlah</th><th>Total Pembelian</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php foreach ($transactions as $t): ?>
      <tr>
        <td class="cell-strong"><?php echo $t['id']; ?></td>
        <td class="cell-muted"><?php echo $t['tanggal']; ?></td>
        <td><?php echo $t['supplier']; ?></td>
        <td><?php echo $t['komoditas']; ?></td>
        <td class="cell-muted"><?php echo $t['jumlah']; ?></td>
        <td class="cell-strong"><?php echo $t['total']; ?></td>
        <td><span class="status-pill selesai">Selesai</span></td>
        <td><a href="#" class="cell-link">👁</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="table-footer">
    <span>Menampilkan 1-4 dari 1.240 transaksi</span>
    <div class="pagination">
      <a href="#">&lsaquo;</a>
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">&rsaquo;</a>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
