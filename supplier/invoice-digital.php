<?php $page_title = 'Invoice Digital'; include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Invoice Digital</h1>
    <p>Kelola dan unduh invoice penagihan Anda untuk setiap transaksi.</p>
  </div>
</div>

<div class="stat-grid">
  <div class="stat-card"><div class="label">Total Invoice</div><div class="value">148</div></div>
  <div class="stat-card"><div class="label">Menunggu Pembayaran</div><div class="value">12</div></div>
  <div class="stat-card"><div class="label">Sudah Dibayar</div><div class="value">136</div></div>
  <div class="stat-card"><div class="label">Total Tagihan</div><div class="value">Rp 42.200.000</div></div>
</div>

<div class="toolbar">
  <div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari ID Invoice atau Nama SPPG..."></div>
  <span class="date-fake"><i class="fa-regular fa-calendar"></i> mm/dd/yyyy</span>
</div>
<div class="tabs pill">
  <a href="#" class="active">Semua</a>
  <a href="#">Belum Bayar</a>
  <a href="#">Dibayar</a>
  <a href="#">Terlambat</a>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>ID Invoice</th><th>Tanggal</th><th>SPPG Tujuan</th><th>Total Nominal</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <tr>
        <td class="link">#INV-2024-001</td><td>14 Okt 2024</td><td>SPPG Surabaya Barat</td><td><b>Rp 4.250.000</b></td>
        <td><span class="badge green">Dibayar</span></td>
        <td><i class="fa-regular fa-eye" style="color:var(--blue);margin-right:14px;"></i><i class="fa-solid fa-download" style="color:var(--blue);"></i></td>
      </tr>
      <tr>
        <td class="link">#INV-2024-002</td><td>14 Okt 2024</td><td>SPPG Sidoarjo</td><td><b>Rp 2.100.000</b></td>
        <td><span class="badge blue">Belum Bayar</span></td>
        <td><i class="fa-regular fa-eye" style="color:var(--blue);margin-right:14px;"></i><i class="fa-solid fa-download" style="color:var(--blue);"></i></td>
      </tr>
      <tr>
        <td class="link">#INV-2024-003</td><td>13 Okt 2024</td><td>SPPG Surabaya Timur</td><td><b>Rp 8.400.000</b></td>
        <td><span class="badge red">Terlambat</span></td>
        <td><i class="fa-regular fa-eye" style="color:var(--blue);margin-right:14px;"></i><i class="fa-solid fa-download" style="color:var(--blue);"></i></td>
      </tr>
    </tbody>
  </table>
  <div class="pagination">
    <div>Menampilkan 1-10 dari 148 invoice</div>
    <div class="pages">
      <a href="#"><i class="fa-solid fa-chevron-left"></i></a>
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#"><i class="fa-solid fa-chevron-right"></i></a>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
