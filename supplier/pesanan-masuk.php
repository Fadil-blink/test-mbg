<?php $page_title = 'Pesanan Masuk'; include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Pesanan Masuk</h1>
    <p>Kelola dan proses pesanan komoditas dari SPPG.</p>
  </div>
</div>

<div class="tabs">
  <a href="#" class="active">Semua</a>
  <a href="#">Menunggu Konfirmasi</a>
  <a href="#">Diproses</a>
  <a href="#">Sedang Dikirim</a>
  <a href="#">Selesai</a>
</div>

<div class="toolbar">
  <div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari ID Pesanan atau nama SPPG..."></div>
  <span class="date-fake"><i class="fa-regular fa-calendar"></i> Pilih Tanggal</span>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>ID Pesanan</th><th>Nama SPPG</th><th>Tanggal</th><th>Total Pembayaran</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <tr>
        <td class="link">#ORD-2024-001</td>
        <td>SPPG Surabaya Barat</td>
        <td>12 Okt 2024</td>
        <td><b>Rp 15.500.000</b></td>
        <td><span class="badge blue">Menunggu Konfirmasi</span></td>
        <td><button class="btn small">Terima</button> <button class="btn small outline">Tolak</button></td>
      </tr>
      <tr>
        <td class="link">#ORD-2024-002</td>
        <td>SPPG Surabaya Timur</td>
        <td>11 Okt 2024</td>
        <td><b>Rp 8.200.000</b></td>
        <td><span class="badge green">Diproses</span></td>
        <td><a href="#" class="cell-link">Detail</a></td>
      </tr>
      <tr>
        <td class="link">#ORD-2024-003</td>
        <td>SPPG Sidoarjo</td>
        <td>10 Okt 2024</td>
        <td><b>Rp 12.000.000</b></td>
        <td><span class="badge gray">Sedang Dikirim</span></td>
        <td><a href="#" class="cell-link">Lacak</a></td>
      </tr>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
