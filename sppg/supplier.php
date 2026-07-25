<?php
$pageTitle = 'Supplier';
$active = 'supplier';
include 'includes/header.php';

$suppliers = [
  ['name'=>'Tani Maju Bersama','type'=>'Koperasi Pertanian','loc'=>'Malang, Jawa Timur','rating'=>'4.9','produk'=>'24 Item','kapasitas'=>'50 Ton/bln','img'=>'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=500&h=300&fit=crop','emoji'=>'🌾'],
  ['name'=>'Pusat Unggas Segar','type'=>'Distributor Nasional','loc'=>'Bogor, Jawa Barat','rating'=>'4.7','produk'=>'12 Item','kapasitas'=>'120 Ton/bln','img'=>'https://images.unsplash.com/photo-1580554530778-ca36943938b2?w=500&h=300&fit=crop','emoji'=>'🐔'],
  ['name'=>'Lumbung Padi Mandiri','type'=>'UMKM Unggulan','loc'=>'Cianjur, Jawa Barat','rating'=>'4.8','produk'=>'8 Item','kapasitas'=>'30 Ton/bln','img'=>'https://images.unsplash.com/photo-1595855759920-86582396756c?w=500&h=300&fit=crop','emoji'=>'🌾'],
];
?>
<div class="page-header-row">
  <div>
    <div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Supplier</b></div>
    <h1 class="page-title">Daftar Supplier Terverifikasi</h1>
    <p class="page-sub">Kelola dan temukan mitra supplier berkualitas untuk pemenuhan gizi nasional.</p>
  </div>
  <a href="#" class="btn btn-navy">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
    Daftarkan Supplier Baru
  </a>
</div>

<div class="filter-bar">
  <div class="filter-item">
    <label>Kabupaten/Kota</label>
    <select><option>Seluruh Indonesia</option><option>Jawa Timur</option><option>Jawa Barat</option></select>
  </div>
  <div class="filter-item grow">
    <label>Jenis Komoditas</label>
    <select><option>Semua</option><option>Protein</option><option>Karbohidrat</option></select>
  </div>
  <div class="filter-item">
    <label>Rating Minimum</label>
    <select><option>★★★★☆ 4.0+</option><option>★★★☆☆ 3.0+</option></select>
  </div>
  <div class="filter-item" style="flex:0.6;justify-content:flex-end;">
    <label>&nbsp;</label>
    <button class="btn btn-outline" style="justify-content:center;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M6 12h12M10 18h4"/></svg>
      Semua Filter
    </button>
  </div>
</div>

<div class="supplier-grid">
  <?php foreach ($suppliers as $s): ?>
  <div class="supplier-card">
    <div class="thumb">
      <img src="<?php echo $s['img']; ?>" alt="<?php echo $s['name']; ?>">
      <div class="verified"><svg viewBox="0 0 24 24"><path d="M12 2l2.4 2.5 3.4-.6.9 3.3 3.3.9-.6 3.4L24 14l-2.6 2.4.6 3.4-3.3.9-.9 3.3-3.4-.6L12 26l-2.4-2.6-3.4.6-.9-3.3-3.3-.9.6-3.4L0 14l2.6-2.5-.6-3.4 3.3-.9.9-3.3 3.4.6z" fill="#2563eb"/></svg> Terverifikasi</div>
      <div class="logo-badge"><?php echo $s['emoji']; ?></div>
    </div>
    <div class="body">
      <div class="s-name"><?php echo $s['name']; ?></div>
      <div class="s-type"><?php echo $s['type']; ?></div>
      <div class="s-loc">
        <span>📍 <?php echo $s['loc']; ?></span>
        <span class="stars"><svg viewBox="0 0 24 24"><polygon points="12 2 15 9 22 9 16.5 13.5 18.5 21 12 17 5.5 21 7.5 13.5 2 9 9 9"/></svg> <?php echo $s['rating']; ?></span>
      </div>
      <div class="s-stats">
        <div><div class="stat-label">Produk</div><div class="stat-val"><?php echo $s['produk']; ?></div></div>
        <div><div class="stat-label">Kapasitas</div><div class="stat-val"><?php echo $s['kapasitas']; ?></div></div>
      </div>
      <a href="belanja-komoditas.php" class="view-btn">Lihat Produk
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="table-footer" style="padding:0;">
  <span>Menampilkan 3 dari 128 supplier terverifikasi</span>
  <div class="pagination">
    <a href="#">&lsaquo;</a>
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">&rsaquo;</a>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
