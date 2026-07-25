<?php
$pageTitle = 'Belanja Komoditas';
$active = 'belanja';
include 'includes/header.php';

$products = [
  ['name'=>'Beras Premium','price'=>'Rp 14.500','unit'=>'/kg','rating'=>'4.9','supplier'=>'PT Pangan Nusantara','tag'=>'PT','loc'=>'Jakarta Timur','stock'=>'2.500 kg','img'=>'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400&h=300&fit=crop'],
  ['name'=>'Telur Ayam','price'=>'Rp 28.000','unit'=>'/kg','rating'=>'4.8','supplier'=>'CV Tani Makmur','tag'=>'KOPERASI','loc'=>'Bogor','stock'=>'500 kg','img'=>'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?w=400&h=300&fit=crop'],
  ['name'=>'Daging Ayam','price'=>'Rp 35.000','unit'=>'/kg','rating'=>'4.7','supplier'=>'Prima Unggas','tag'=>'PT','loc'=>'Bandung','stock'=>'1.200 kg','img'=>'https://images.unsplash.com/photo-1604503468506-a8da13d82791?w=400&h=300&fit=crop'],
  ['name'=>'Bayam','price'=>'Rp 5.000','unit'=>'/ikat','rating'=>'4.9','supplier'=>'Kelompok Tani Hijau','tag'=>'UMKM','loc'=>'Sleman','stock'=>'300 ikat','img'=>'https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=400&h=300&fit=crop'],
  ['name'=>'Wortel','price'=>'Rp 12.000','unit'=>'/kg','rating'=>'4.6','supplier'=>'Sayur Fresh Mandiri','tag'=>'UMKM','loc'=>'Bandung','stock'=>'850 kg','img'=>'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=400&h=300&fit=crop'],
  ['name'=>'Pisang','price'=>'Rp 15.000','unit'=>'/sisir','rating'=>'4.8','supplier'=>'Koperasi Buah Jaya','tag'=>'KOPERASI','loc'=>'Jakarta','stock'=>'150 sisir','img'=>'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=400&h=300&fit=crop'],
  ['name'=>'Susu UHT','price'=>'Rp 95.000','unit'=>'/karton','rating'=>'5.0','supplier'=>'IndoDairy Pratama','tag'=>'PT','loc'=>'Bekasi','stock'=>'420 karton','img'=>'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=400&h=300&fit=crop'],
];
?>
<div class="page-header-row">
  <div>
    <div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Belanja Komoditas</b></div>
    <h1 class="page-title">Belanja Komoditas</h1>
    <p class="page-sub">SPPG dapat membeli bahan pangan hanya dari supplier yang telah terverifikasi untuk menjamin kualitas program Makan Bergizi Gratis.</p>
  </div>
  <a href="#" class="btn btn-blue">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h7.2a2 2 0 0 0 2-1.6L21 8H6"/></svg>
    Keranjang (<span class="cart-count">3</span>)
  </a>
</div>

<div class="filter-bar">
  <div class="filter-item">
    <label>Kategori</label>
    <select><option>Semua Kategori</option><option>Karbohidrat</option><option>Protein</option><option>Sayur</option><option>Buah</option></select>
  </div>
  <div class="filter-item">
    <label>Jenis Supplier</label>
    <select><option>Semua Jenis</option><option>PT</option><option>Koperasi</option><option>UMKM</option></select>
  </div>
  <div class="filter-item">
    <label>Kabupaten/Kota</label>
    <select><option>Semua Lokasi</option><option>Jakarta Timur</option><option>Bogor</option><option>Bandung</option></select>
  </div>
  <div class="filter-item">
    <label>Rentang Harga</label>
    <input type="text" placeholder="Rp Max">
  </div>
  <div class="filter-item">
    <label>Status Stok</label>
    <select><option>Tersedia</option><option>Semua</option></select>
  </div>
</div>

<div class="commodity-grid">
  <?php foreach ($products as $p): ?>
  <div class="commodity-card">
    <div class="thumb">
      <img src="<?php echo $p['img']; ?>" alt="<?php echo $p['name']; ?>">
      <div class="rating"><svg viewBox="0 0 24 24"><polygon points="12 2 15 9 22 9 16.5 13.5 18.5 21 12 17 5.5 21 7.5 13.5 2 9 9 9"/></svg> <?php echo $p['rating']; ?></div>
      <div class="verified-badge">TERVERIFIKASI</div>
    </div>
    <div class="body">
      <div class="name-price">
        <span class="name"><?php echo $p['name']; ?></span>
        <span class="price"><?php echo $p['price']; ?> <small><?php echo $p['unit']; ?></small></span>
      </div>
      <div class="supplier-row">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l1.5-5h15L21 9"/><path d="M3 9v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/></svg>
        <?php echo $p['supplier']; ?>
      </div>
      <div class="tag-row"><span class="tag"><?php echo $p['tag']; ?></span> <?php echo $p['loc']; ?></div>
      <div class="stock-row"><span>Sisa Stok:</span> <b><?php echo $p['stock']; ?></b></div>
      <button class="add-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h7.2a2 2 0 0 0 2-1.6L21 8H6"/></svg>
        Tambah ke Keranjang
      </button>
    </div>
  </div>
  <?php endforeach; ?>

  <div class="ajukan-card">
    <div class="circle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M2 12h20"/></svg></div>
    <b>Ajukan Komoditas Baru</b>
    <p>Ingin produk lain dari supplier terverifikasi?</p>
  </div>
</div>

<div class="table-footer" style="padding:0;">
  <span>Menampilkan 1-7 dari 24 Komoditas</span>
  <div class="pagination">
    <a href="#">&lsaquo;</a>
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <span class="dots">…</span>
    <a href="#">6</a>
    <a href="#">&rsaquo;</a>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
