<?php
$pageTitle = 'Pesanan Saya';
$active = 'pesanan';
include 'includes/header.php';

function status_class($s){
  $map = ['Diproses'=>'diproses','Dikirim'=>'dikirim','Selesai'=>'selesai','Kendala'=>'kendala','Menunggu'=>'menunggu'];
  return $map[$s] ?? '';
}

$orders = [
  ['id'=>'#PO-2024-0089','supplier'=>'Tani Maju Bersama','tanggal'=>'24 Okt 2024','total'=>'Rp 12.500.000','status'=>'Menunggu'],
  ['id'=>'#PO-2024-0088','supplier'=>'Pusat Unggas Segar','tanggal'=>'22 Okt 2024','total'=>'Rp 45.200.000','status'=>'Diproses'],
  ['id'=>'#PO-2024-0087','supplier'=>'Lumbung Padi Mandiri','tanggal'=>'20 Okt 2024','total'=>'Rp 8.750.000','status'=>'Dikirim'],
  ['id'=>'#PO-2024-0086','supplier'=>'Koperasi Berkah Tani','tanggal'=>'18 Okt 2024','total'=>'Rp 15.000.000','status'=>'Selesai'],
];
?>
<div class="page-header-row">
  <div>
    <div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Pesanan Saya</b></div>
    <h1 class="page-title">Pesanan Saya</h1>
    <p class="page-sub">Pantau status pengadaan bahan pangan dan kelola pesanan SPPG Anda.</p>
  </div>
  <a href="#" class="btn btn-navy">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
    Unduh Laporan
  </a>
</div>

<div class="tabs">
  <a href="#" class="active">Semua</a>
  <a href="#">Menunggu Konfirmasi</a>
  <a href="#">Diproses</a>
  <a href="#">Sedang Dikirim</a>
  <a href="#">Selesai</a>
  <a href="#">Dibatalkan</a>
</div>

<div class="toolbar">
  <div class="search-input">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
    <input type="text" placeholder="Cari ID Pesanan atau Supplier...">
  </div>
  <select>
    <option>📅 Pilih Tanggal</option>
  </select>
</div>

<div class="table-wrap">
  <table class="data-table">
    <thead>
      <tr><th>ID Pesanan</th><th>Supplier</th><th>Tanggal</th><th>Total Pembayaran</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $o): ?>
      <tr>
        <td class="cell-strong"><?php echo $o['id']; ?></td>
        <td><?php echo $o['supplier']; ?></td>
        <td class="cell-muted"><?php echo $o['tanggal']; ?></td>
        <td class="cell-strong"><?php echo $o['total']; ?></td>
        <td><span class="status-pill <?php echo status_class($o['status']); ?>"><?php echo $o['status']; ?></span></td>
        <td><a href="#" class="cell-link">Detail</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="table-footer">
    <span>Menampilkan 4 dari 42 pesanan</span>
    <div class="pagination">
      <a href="#">&lsaquo;</a>
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">&rsaquo;</a>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
