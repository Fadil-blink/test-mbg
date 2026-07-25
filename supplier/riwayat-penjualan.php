<?php $page_title = 'Riwayat Penjualan'; include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Riwayat Penjualan</h1>
    <p>Pantau dan kelola seluruh catatan transaksi penjualan Anda dalam ekosistem MBG secara real-time.</p>
  </div>
</div>

<div class="stat-grid" style="grid-template-columns:repeat(3,1fr);">
  <div class="stat-card">
    <div class="label">Total Penjualan <span class="badge green">+12%</span></div>
    <div class="value">Rp 145.820.000</div>
    <div class="delta">dibanding bulan lalu</div>
  </div>
  <div class="stat-card">
    <div class="label">Pesanan Selesai</div>
    <div class="value">842 Transaksi</div>
    <div class="delta">98.2% efisiensi pengiriman</div>
  </div>
  <div class="stat-card">
    <div class="label">Rata-rata Transaksi</div>
    <div class="value">Rp 173.182</div>
    <div class="delta" style="color:var(--text-muted);">Per SPPG / Kelompok Tani</div>
  </div>
</div>

<div class="tabs">
  <a href="#" class="active">Semua</a>
  <a href="#">Selesai</a>
  <a href="#">Dibatalkan</a>
  <a href="#">Retur</a>
</div>

<div class="toolbar">
  <div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari ID Transaksi atau Nama SPPG..."></div>
  <span class="date-fake"><i class="fa-regular fa-calendar"></i> Pilih Tanggal</span>
  <button class="btn"><i class="fa-solid fa-download"></i> Unduh Laporan</button>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>ID Transaksi</th><th>Tanggal</th><th>SPPG Tujuan</th><th>Komoditas</th><th>Jumlah</th><th>Total Nominal</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php
      $rows = [
        ['#MBG-240901','12 Okt 2023','SPPG Tunas Harapan','Beras IR64','500 Kg','Rp 7.500.000','Selesai','green'],
        ['#MBG-240902','13 Okt 2023','Gapoktan Makmur Jaya','Cabai Rawit','120 Kg','Rp 4.200.000','Dikirim','blue'],
        ['#MBG-240903','13 Okt 2023','SPPG Bumi Lestari','Jagung Manis','1.000 Kg','Rp 5.100.000','Retur','amber'],
        ['#MBG-240904','14 Okt 2023','Koperasi Berkah','Bawang Merah','250 Kg','Rp 8.750.000','Dibatalkan','red'],
        ['#MBG-240905','15 Okt 2023','SPPG Sejahtera Mandiri','Kedelai','400 Kg','Rp 6.400.000','Selesai','green'],
      ];
      foreach ($rows as $r):
      ?>
      <tr>
        <td class="link"><?= $r[0] ?></td>
        <td><?= $r[1] ?></td>
        <td><?= $r[2] ?></td>
        <td><?= $r[3] ?></td>
        <td><?= $r[4] ?></td>
        <td><b><?= $r[5] ?></b></td>
        <td><span class="badge <?= $r[7] ?>"><?= strtoupper($r[6]) ?></span></td>
        <td><i class="fa-regular fa-eye" style="color:var(--blue);cursor:pointer;"></i></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="pagination">
    <div>Menampilkan 1-5 dari 842 Transaksi</div>
    <div class="pages">
      <a href="#"><i class="fa-solid fa-chevron-left"></i></a>
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <span>...</span>
      <a href="#">168</a>
      <a href="#"><i class="fa-solid fa-chevron-right"></i></a>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
