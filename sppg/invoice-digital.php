<?php
$pageTitle = 'Invoice Digital';
$active = 'invoice';
include 'includes/header.php';

$invoices = [
  ['no'=>'INV/MBG/2024/0821','tanggal'=>'24 Okt 2024','supplier'=>'PT. Pangan Nusantara Abadi','total'=>'Rp 124.500.000','status'=>'Lunas'],
  ['no'=>'INV/MBG/2024/0822','tanggal'=>'23 Okt 2024','supplier'=>'UD. Berkah Tani Jaya','total'=>'Rp 45.200.000','status'=>'Menunggu Pembayaran'],
  ['no'=>'INV/MBG/2024/0823','tanggal'=>'22 Okt 2024','supplier'=>'CV. Mitra Gizi Sejahtera','total'=>'Rp 89.750.000','status'=>'Lunas'],
  ['no'=>'INV/MBG/2024/0824','tanggal'=>'21 Okt 2024','supplier'=>'Koperasi Tani Makmur','total'=>'Rp 210.300.000','status'=>'Menunggu Pembayaran'],
  ['no'=>'INV/MBG/2024/0825','tanggal'=>'20 Okt 2024','supplier'=>'UD. Segar Selalu','total'=>'Rp 12.800.000','status'=>'Lunas'],
];
function status_class($s){
  $map = ['Lunas'=>'lunas','Menunggu Pembayaran'=>'menunggu'];
  return $map[$s] ?? '';
}
?>
<div class="page-header-row">
  <div>
    <div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Invoice Digital</b></div>
    <h1 class="page-title">Invoice Digital</h1>
    <p class="page-sub">Kelola dan unduh dokumen tagihan resmi dari transaksi pengadaan komoditas untuk program Makan Bergizi Gratis.</p>
  </div>
</div>

<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-label">Total Tagihan Bulan Ini</div>
    <div class="kpi-value">Rp 458,2M</div>
    <div class="kpi-note up">+12.4%</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Tagihan Belum Dibayar</div>
    <div class="kpi-value">Rp 82,4M</div>
    <div class="kpi-note">12 invoice jatuh tempo minggu ini</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Tagihan Lunas</div>
    <div class="kpi-value">Rp 375,8M</div>
    <div class="kpi-note">Tingkat kepatuhan pembayaran 94%</div>
  </div>
</div>

<div class="toolbar">
  <div class="search-input">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
    <input type="text" placeholder="Cari nomor invoice atau supplier...">
  </div>
  <select><option>Semua Status</option><option>Lunas</option><option>Menunggu Pembayaran</option></select>
  <select><option>Bulan Ini</option></select>
  <a href="#" class="btn btn-outline">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
    Ekspor Semua (CSV)
  </a>
</div>

<div class="table-wrap">
  <table class="data-table">
    <thead>
      <tr><th>Nomor Invoice</th><th>Tanggal</th><th>Supplier</th><th>Total Pembayaran</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php foreach ($invoices as $i): ?>
      <tr>
        <td class="cell-strong"><?php echo $i['no']; ?></td>
        <td class="cell-muted"><?php echo $i['tanggal']; ?></td>
        <td><?php echo $i['supplier']; ?></td>
        <td class="cell-strong"><?php echo $i['total']; ?></td>
        <td><span class="status-pill <?php echo status_class($i['status']); ?>"><?php echo $i['status']; ?></span></td>
        <td><a href="#" class="cell-link">Detail</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="alert-banner red">
  <div class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg></div>
  <div>
    <b>Peringatan Audit Fraud</b>
    <p>Ditemukan 3 invoice dengan nilai tagihan di atas rata-rata pasar untuk komoditas Beras Premium. Silakan tinjau ulang detail transaksi sebelum melakukan persetujuan pembayaran.</p>
    <a href="#" class="link">Tinjau Sekarang</a>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
