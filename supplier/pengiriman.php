<?php $page_title = 'Pengiriman'; include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Manajemen Pengiriman</h1>
    <p>Pantau dan kelola status pengiriman komoditas ke SPPG.</p>
  </div>
</div>

<div class="tabs">
  <a href="#" class="active">Semua</a>
  <a href="#">Sedang Dikemas</a>
  <a href="#">Dalam Perjalanan</a>
  <a href="#">Tiba di Lokasi</a>
  <a href="#">Selesai</a>
</div>

<div class="toolbar">
  <div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari ID Pengiriman atau nama SPPG..."></div>
  <span class="date-fake"><i class="fa-regular fa-calendar"></i> Pilih Tanggal</span>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>ID Pengiriman</th><th>ID Pesanan</th><th>Tujuan</th><th>Metode</th><th>Estimasi Tiba</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <tr>
        <td class="link">#DEL-2024-001</td><td>#ORD-2024-001</td><td>SPPG Surabaya Barat</td><td>Kurir Internal</td><td>13 Okt 2024</td>
        <td><span class="badge blue">Dikirim</span></td><td><a href="#" class="cell-link">Lacak</a></td>
      </tr>
      <tr>
        <td class="link">#DEL-2024-002</td><td>#ORD-2024-002</td><td>SPPG Surabaya Timur</td><td>Ekspedisi J&amp;T</td><td>12 Okt 2024</td>
        <td><span class="badge green">Tiba</span></td><td><a href="#" class="cell-link">Detail</a></td>
      </tr>
      <tr>
        <td class="link">#DEL-2024-003</td><td>#ORD-2024-003</td><td>SPPG Sidoarjo</td><td>Kurir Internal</td><td>11 Okt 2024</td>
        <td><span class="badge gray">Dikemas</span></td><td><a href="#" class="cell-link">Lacak</a></td>
      </tr>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
