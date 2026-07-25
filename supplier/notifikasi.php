<?php $page_title = 'Notifikasi'; include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Pusat Notifikasi</h1>
    <p>Pantau semua aktivitas dan pemberitahuan penting terkait operasional Anda.</p>
  </div>
</div>

<div class="grid-2" style="grid-template-columns:3fr 1fr;">
  <div class="status-banner">
    <div class="check"><i class="fa-solid fa-check"></i></div>
    <h3>Status Sistem Operasional</h3>
    <p>Semua layanan logistik dan pembayaran berfungsi dengan normal hari ini.</p>
  </div>
  <div class="unread-count">
    <div class="lbl">Belum Dibaca</div>
    <div class="num">03</div>
  </div>
</div>

<div class="tabs" style="justify-content:space-between;display:flex;">
  <div style="display:flex;">
    <a href="#" class="active">Semua</a>
    <a href="#">Belum Dibaca</a>
    <a href="#">Sudah Dibaca</a>
  </div>
</div>

<div class="notif-card unread">
  <div class="n-dot"></div>
  <div class="n-head">
    <div class="notif-icon"><i class="fa-solid fa-cart-shopping"></i></div>
    <div class="notif-body">
      <div class="n-title">Pesanan Baru Masuk <span class="id">#MBG-240906</span></div>
      <div class="n-text">Pesanan baru telah diterima dari SPPG Surabaya Barat. Segera lakukan konfirmasi stok dan atur jadwal pengiriman.</div>
    </div>
    <div class="n-time">2 menit yang lalu</div>
  </div>
  <div class="n-actions">
    <button class="btn small">Detail Pesanan</button>
    <button class="btn small outline">Tandai Dibaca</button>
  </div>
</div>

<div class="notif-card">
  <div class="n-head">
    <div class="notif-icon"><i class="fa-solid fa-truck"></i></div>
    <div class="notif-body">
      <div class="n-title">Barang Telah Diterima</div>
      <div class="n-text">Pesanan #MBG-240901 telah sampai di tujuan dan diterima oleh petugas gudang pusat. Status pengiriman: Selesai.</div>
    </div>
    <div class="n-time">1 jam yang lalu</div>
  </div>
</div>

<div class="notif-card alert">
  <div class="n-dot red"></div>
  <div class="n-head">
    <div class="notif-icon red"><i class="fa-solid fa-triangle-exclamation"></i></div>
    <div class="notif-body">
      <div class="n-title">Stok Hampir Habis</div>
      <div class="n-text">Peringatan: Beras Premium SLY tersisa <b style="color:var(--red)">50kg</b> di gudang utama. Segera lakukan pengisian stok untuk menghindari pembatalan pesanan otomatis.</div>
    </div>
    <div class="n-time">3 jam yang lalu</div>
  </div>
  <div class="n-actions"><button class="btn small" style="background:var(--red);">Update Stok</button></div>
</div>

<div class="notif-card">
  <div class="n-head">
    <div class="notif-icon"><i class="fa-solid fa-money-check-alt"></i></div>
    <div class="notif-body">
      <div class="n-title">Pembayaran Berhasil</div>
      <div class="n-text">Dana untuk Invoice #INV-2024-001 telah berhasil ditransfer ke rekening terdaftar. Silakan periksa saldo pendapatan Anda.</div>
    </div>
    <div class="n-time">Kemarin, 14:20</div>
  </div>
</div>

<div class="notif-card">
  <div class="n-head">
    <div class="notif-icon"><i class="fa-solid fa-circle-info"></i></div>
    <div class="notif-body">
      <div class="n-title">Pembaruan Kebijakan Supplier</div>
      <div class="n-text">Terdapat pembaruan pada syarat dan ketentuan pengadaan pangan nasional periode Q4 2024. Harap tinjau kembali dokumen kontrak Anda.</div>
    </div>
    <div class="n-time">2 hari yang lalu</div>
  </div>
</div>

<div class="pagination" style="background:#fff;border:1px solid var(--border);border-radius:var(--radius);">
  <div>Menampilkan 5 dari 24 notifikasi</div>
  <div class="pages">
    <a href="#"><i class="fa-solid fa-chevron-left"></i></a>
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#"><i class="fa-solid fa-chevron-right"></i></a>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
