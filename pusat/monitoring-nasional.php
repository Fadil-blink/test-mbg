<?php
require __DIR__ . '/config.php';
$pageTitle = "Monitoring Nasional";
$topbarTitle = "PAN MBG Dashboard";
require __DIR__ . '/includes/header.php';
?>

<div class="breadcrumb">Beranda &rsaquo; <b>Monitoring Nasional</b></div>
<div class="page-head">
  <div><h1>Monitoring Nasional</h1></div>
  <div class="page-head-actions">
    <button class="btn btn-primary"><i data-lucide="download"></i>Download Laporan</button>
  </div>
</div>

<div class="grid grid-6 mb-24">
  <div class="stat-card">
    <div class="stat-label-plain">Total SPPG Aktif</div>
    <div class="stat-value">1,248</div>
    <div class="cell-sub" style="color:var(--green-text);margin-top:4px;">&#8593; +12 bulan ini</div>
  </div>
  <div class="stat-card">
    <div class="stat-label-plain">Total Supplier Aktif</div>
    <div class="stat-value">4,892</div>
    <div class="cell-sub" style="color:var(--green-text);margin-top:4px;">&#8593; +85 UMKM baru</div>
  </div>
  <div class="stat-card">
    <div class="stat-label-plain">Transaksi Hari Ini</div>
    <div class="stat-value">12.5k</div>
    <div class="cell-sub" style="margin-top:4px;">Update 10m lalu</div>
  </div>
  <div class="stat-card">
    <div class="stat-label-plain">Nilai Transaksi (Rp)</div>
    <div class="stat-value">8.4B</div>
    <div class="cell-sub" style="margin-top:4px;">Nasional</div>
  </div>
  <div class="stat-card">
    <div class="stat-label-plain">Anggaran Digunakan</div>
    <div class="stat-value" style="margin-bottom:6px;">Rp 4.2T</div>
    <?php echo progress_bar(34,'dark'); ?>
  </div>
  <div class="stat-card">
    <div class="stat-label-plain">Sisa Anggaran</div>
    <div class="stat-value">Rp 2.1T</div>
    <div class="cell-sub" style="margin-top:4px;">Tahun Anggaran 2024</div>
  </div>
</div>

<div class="grid grid-2 mb-24">
  <div class="card">
    <div class="card-head-row">
      <div class="card-title">Densitas SPPG Nasional</div>
      <div class="dropdown">Semua Komoditas<i data-lucide="chevron-down"></i></div>
    </div>
    <div class="map-box" style="background:linear-gradient(180deg,#e7f3ec,#d7ebe0);min-height:300px;">
      <img src="assets/img/map-placeholder.svg" alt="Densitas SPPG" style="opacity:.55;">
      <div class="map-legend-bottom" style="bottom:auto;top:16px;left:16px;right:auto;">
        <span><i class="dot" style="background:var(--navy-900)"></i>Tinggi (&gt;50 SPPG)</span>
        <span><i class="dot" style="background:var(--blue-500)"></i>Sedang (20-50)</span>
        <span><i class="dot" style="background:#cbd5e1"></i>Rendah (&lt;20)</span>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-title" style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
      <i data-lucide="alert-triangle" style="width:17px;height:17px;color:var(--red-solid);"></i>Peringatan Dini
    </div>
    <div class="warn-card">
      <div class="warn-top"><h5>Anomali Harga</h5><span class="warn-time">Baru</span></div>
      <b>Lonjakan 45% - Beras Premium</b>
      <p>SPPG Jawa Timur melaporkan harga di atas rata-rata nasional.</p>
      <div class="warn-links"><a href="#">Lihat Detail</a><a href="#">Abaikan</a></div>
    </div>
    <div class="warn-card">
      <div class="warn-top"><h5>Limit Anggaran</h5><span class="warn-time">2 jam lalu</span></div>
      <b>Realisasi &gt; 90% (Jawa Barat)</b>
      <p>Anggaran operasional triwulan ini hampir habis.</p>
    </div>
    <div class="warn-card" style="margin-bottom:14px;">
      <div class="warn-top"><h5>Integritas Data</h5><span class="warn-time">Kemarin</span></div>
      <b>Supplier Terduga Fiktif</b>
      <p>Ditemukan 3 supplier dengan alamat yang sama di Medan.</p>
    </div>
    <button class="btn btn-outline" style="width:100%;justify-content:center;">Lihat Semua Peringatan</button>
  </div>
</div>

<div class="grid grid-2">
  <div class="card">
    <div class="card-head-row">
      <div class="card-title">Tren Pengadaan Nasional</div>
      <div style="display:flex;gap:14px;font-size:12px;color:var(--text-500);">
        <span><i style="display:inline-block;width:9px;height:9px;border-radius:50%;background:var(--navy-900);margin-right:4px;"></i>Volume</span>
        <span><i style="display:inline-block;width:9px;height:9px;border-radius:50%;background:#bcd4fb;margin-right:4px;"></i>Target</span>
      </div>
    </div>
    <div style="height:230px;"><canvas id="trenPengadaanChart"></canvas></div>
  </div>
  <div class="card">
    <div class="card-head-row">
      <div class="card-title">Nilai Pengadaan per Provinsi</div>
      <span class="page-btn" style="border:none;"><i data-lucide="more-vertical"></i></span>
    </div>
    <div style="height:230px;"><canvas id="nilaiProvinsiChart"></canvas></div>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
