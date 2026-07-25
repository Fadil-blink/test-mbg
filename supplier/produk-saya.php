<?php $page_title = 'Produk Saya'; include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Produk Saya</h1>
    <p>Kelola daftar komoditas dan produk agrikultur Anda.</p>
  </div>
  <button class="btn"><i class="fa-solid fa-plus"></i> Tambah Produk</button>
</div>

<div class="stat-grid">
  <div class="stat-card"><div class="label">Total Produk <i class="fa-solid fa-box-archive"></i></div><div class="value">24</div></div>
  <div class="stat-card"><div class="label">Produk Aktif <i class="fa-solid fa-circle-check" style="color:var(--green)"></i></div><div class="value" style="color:var(--green)">20</div></div>
  <div class="stat-card"><div class="label">Produk Non-Aktif <i class="fa-solid fa-circle-xmark" style="color:var(--red)"></i></div><div class="value" style="color:var(--red)">4</div></div>
  <div class="stat-card"><div class="label">Kategori Produk <i class="fa-solid fa-sitemap"></i></div><div class="value">5</div></div>
</div>

<div class="toolbar">
  <div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari nama produk atau SKU..."></div>
  <span class="select-fake">Semua Kategori <i class="fa-solid fa-chevron-down"></i></span>
  <span class="select-fake">Semua Status <i class="fa-solid fa-chevron-down"></i></span>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>Produk</th><th>Kategori</th><th>Harga Satuan</th><th>Stok</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php
      $products = [
        ['Beras Medium Cianjur','BR-MED-001','Serealia','Rp 12.500/kg','500 kg','Aktif','green'],
        ['Jagung Pipil Kering','JG-PI-002','Serealia','Rp 8.000/kg','45 kg','Aktif','green'],
        ['Kedelai Impor Grade A','KD-IMP-003','Lauk Pauk','Rp 14.200/kg','0 kg','Non-Aktif','red'],
      ];
      foreach ($products as $p):
      ?>
      <tr>
        <td>
          <div class="product-cell">
            <img src="https://placehold.co/44x44/e6ebf1/6b7c93?text=%20" alt="">
            <div><div class="p-name"><?= $p[0] ?></div><div class="p-sku">SKU: <?= $p[1] ?></div></div>
          </div>
        </td>
        <td><?= $p[2] ?></td>
        <td><b><?= $p[3] ?></b></td>
        <td><?= $p[4] ?></td>
        <td><span class="badge <?= $p[6] ?>"><?= $p[5] ?></span></td>
        <td><a href="#" class="cell-link">Edit</a> &nbsp; <a href="#" class="cell-link">Detail</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
