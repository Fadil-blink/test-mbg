<?php $page_title = 'Manajemen Stok'; include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Manajemen Stok</h1>
    <p>Pantau dan kelola ketersediaan stok komoditas Anda.</p>
  </div>
  <button class="btn"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Stok</button>
</div>

<div class="stat-grid">
  <div class="stat-card"><div class="label">Total Produk <i class="fa-solid fa-box-archive"></i></div><div class="value">24</div></div>
  <div class="stat-card"><div class="label">Produk Stok Rendah <i class="fa-solid fa-triangle-exclamation" style="color:var(--red)"></i></div><div class="value" style="color:var(--red)">5</div></div>
  <div class="stat-card"><div class="label">Produk Habis <i class="fa-solid fa-circle-exclamation" style="color:var(--red)"></i></div><div class="value" style="color:var(--red)">2</div></div>
  <div class="stat-card"><div class="label">Update Terakhir <i class="fa-solid fa-rotate"></i></div><div class="value" style="font-size:18px;">Hari ini, 10:45</div></div>
</div>

<div class="toolbar">
  <div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari nama produk atau SKU..."></div>
  <span class="select-fake">Semua Kategori <i class="fa-solid fa-chevron-down"></i></span>
  <span class="select-fake">Semua Status Stok <i class="fa-solid fa-chevron-down"></i></span>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>Produk</th><th>Kategori</th><th>Stok Saat Ini</th><th>Satuan</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php
      $stocks = [
        ['Beras Medium Cianjur','BR-MED-001','Serealia','500','kg','Aman','green'],
        ['Jagung Pipil Kering','JG-PI-002','Serealia','45','kg','Menipis','red'],
        ['Kedelai Impor Grade A','KD-IMP-003','Lauk Pauk','0','kg','Habis','red'],
      ];
      foreach ($stocks as $s):
      ?>
      <tr>
        <td>
          <div class="product-cell">
            <img src="https://placehold.co/44x44/e6ebf1/6b7c93?text=%20" alt="">
            <div><div class="p-name"><?= $s[0] ?></div><div class="p-sku">SKU: <?= $s[1] ?></div></div>
          </div>
        </td>
        <td><?= $s[2] ?></td>
        <td><b><?= $s[3] ?></b></td>
        <td><?= $s[4] ?></td>
        <td><span class="badge <?= $s[6] ?>"><?= $s[5] ?></span></td>
        <td><a href="#" class="cell-link">Update Stok</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
