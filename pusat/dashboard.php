<?php
require __DIR__ . '/config.php';
$pageTitle = "Dashboard";
$topbarTitle = "PAN MBG Dashboard";
require __DIR__ . '/includes/header.php';
?>

<!-- Stat cards -->
<div class="grid grid-6 mb-24" style="grid-template-columns:repeat(4,1fr) 1.1fr 1fr 1fr;">
  <div class="stat-card">
    <div class="stat-label-plain">Total SPPG Aktif</div>
    <div class="stat-value">1.248</div>
    <div class="stat-tag stat-tag-up">&#8593;12%</div>
  </div>
  <div class="stat-card">
    <div class="stat-label-plain">Total Supplier</div>
    <div class="stat-value">4.892</div>
    <div class="stat-tag stat-tag-up">&#8593;8%</div>
  </div>
  <div class="stat-card">
    <div class="stat-label-plain">Transaksi Hari Ini</div>
    <div class="stat-value">12.040 <small>Target 95%</small></div>
  </div>
  <div class="stat-card">
    <div class="stat-label-plain">Nilai Transaksi (Rp)</div>
    <div class="stat-value">1.28B <small>Real-time</small></div>
  </div>
  <div class="stat-card">
    <div class="stat-label-plain">Anggaran Digunakan</div>
    <div class="stat-value">Rp 45.2T <small>YTD</small></div>
  </div>
  <div class="stat-card">
    <div class="stat-label-plain">Sisa Anggaran</div>
    <div class="stat-value">Rp 26.8T <small>37.2%</small></div>
  </div>
  <div class="stat-card danger">
    <div class="stat-label-plain" style="color:var(--red-text);">Indikasi Kecurangan</div>
    <div class="stat-value">24 <i data-lucide="alert-triangle" style="width:18px;height:18px;"></i></div>
  </div>
</div>

<!-- Chart row -->
<div class="grid grid-2 mb-24">
  <div class="card">
    <div class="card-head-row">
      <div class="card-title">Tren Transaksi Harian</div>
      <div class="dropdown"><span>7 Hari Terakhir</span><i data-lucide="chevron-down"></i></div>
    </div>
    <div style="height:260px;"><canvas id="trenTransaksiChart"></canvas></div>
  </div>
  <div class="card">
    <div class="card-title mb-20">Pengeluaran Teratas (Provinsi)</div>
    <div class="bar-list-item">
      <div class="bar-list-top"><b>Jawa Barat</b><span>Rp 420M</span></div>
      <?php echo progress_bar(88, 'dark'); ?>
    </div>
    <div class="bar-list-item">
      <div class="bar-list-top"><b>Jawa Timur</b><span>Rp 385M</span></div>
      <?php echo progress_bar(80, 'dark'); ?>
    </div>
    <div class="bar-list-item">
      <div class="bar-list-top"><b>Jawa Tengah</b><span>Rp 310M</span></div>
      <?php echo progress_bar(65, 'dark'); ?>
    </div>
    <div class="bar-list-item">
      <div class="bar-list-top"><b>Sumatera Utara</b><span>Rp 245M</span></div>
      <?php echo progress_bar(51, 'dark'); ?>
    </div>
    <div class="bar-list-item">
      <div class="bar-list-top"><b>Sulawesi Selatan</b><span>Rp 190M</span></div>
      <?php echo progress_bar(40, 'dark'); ?>
    </div>
  </div>
</div>

<!-- Map + donut row -->
<div class="grid grid-2 mb-24">
  <div class="card" style="padding:0;overflow:hidden;">
    <div style="padding:22px 22px 0;">
      <div class="card-head-row" style="margin-bottom:12px;">
        <div class="card-title">Sebaran Nasional &amp; Intensitas Audit</div>
        <div class="map-legend" style="position:static;background:transparent;padding:0;">
          <span><i style="background:#bcd4fb"></i>Rendah</span>
          <span><i style="background:var(--navy-900)"></i>Tinggi</span>
        </div>
      </div>
    </div>
    <div class="map-box" style="border-radius:0;min-height:340px;">
      <div class="map-caption">
        <strong>Peta Intensitas Audit Nasional - Indonesia</strong>
        <span>Dashboard Pusat Audit Nasional MBG</span>
      </div>
      <img src="assets/img/map-placeholder.svg" alt="Peta Indonesia">
      <div class="map-legend-bottom">
        <span>Intensitas Audit</span>
        <span><i class="dot" style="background:#bcd4fb"></i>Low &nbsp; <i class="dot" style="background:var(--navy-900)"></i>High</span>
      </div>
    </div>
  </div>
  <div class="card" style="display:flex;flex-direction:column;">
    <div class="card-title mb-20">Volume Komoditas Utama</div>
    <div class="donut-wrap" style="height:210px;">
      <canvas id="volumeKomoditasChart"></canvas>
      <div class="donut-center"><b>850K</b><span>TON TOTAL</span></div>
    </div>
    <div class="legend-grid">
      <div class="legend-grid-item"><i style="background:var(--navy-900)"></i>Beras (35%)</div>
      <div class="legend-grid-item"><i style="background:var(--blue-500)"></i>Telur (25%)</div>
      <div class="legend-grid-item"><i style="background:#7fb0f5"></i>Ayam (20%)</div>
      <div class="legend-grid-item"><i style="background:#f5b95c"></i>Susu (12%)</div>
      <div class="legend-grid-item"><i style="background:#cbd5e1"></i>Sayuran (8%)</div>
    </div>
  </div>
</div>

<!-- Peringatan Deteksi Kecurangan -->
<h3 style="display:flex;align-items:center;gap:8px;font-size:16px;margin-bottom:14px;color:var(--text-900);">
  <i data-lucide="siren" style="width:18px;height:18px;color:var(--red-solid);"></i>
  Peringatan Deteksi Kecurangan (Audit AI)
</h3>
<div class="grid grid-3 mb-24">
  <div class="insight-card red">
    <div class="insight-icon"><i data-lucide="trending-up"></i></div>
    <div>
      <h4>Harga Melebihi Acuan</h4>
      <p>Telur Ayam di SPPG Bandung Utara naik 45% dalam 2 jam.</p>
      <div class="insight-tag">RESIKO TINGGI</div>
    </div>
  </div>
  <div class="insight-card amber">
    <div class="insight-icon"><i data-lucide="copy"></i></div>
    <div>
      <h4>Indikasi Transaksi Ganda</h4>
      <p>3 ID Transaksi serupa ditemukan pada Supplier Tani Makmur.</p>
      <div class="insight-tag">RESIKO MENENGAH</div>
    </div>
  </div>
  <div class="insight-card red">
    <div class="insight-icon"><i data-lucide="map-pin-off"></i></div>
    <div>
      <h4>Anomali Lokasi Pengiriman</h4>
      <p>Logistik SPPG Makassar terdeteksi di luar rute operasional.</p>
      <div class="insight-tag">INVESTIGASI SEGERA</div>
    </div>
  </div>
</div>

<!-- Transaksi Terbaru -->
<div class="card mb-24" style="padding:0;">
  <div class="card-head-row" style="padding:22px 22px 0;">
    <div class="card-title">Transaksi Terbaru</div>
    <a href="transaksi-pembelian.php" class="link-btn">Lihat Semua &rsaquo;</a>
  </div>
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>ID Transaksi</th><th>Waktu</th><th>SPPG</th><th>Supplier</th><th>Komoditas</th><th>Total Pembelian</th><th>Status</th><th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="cell-strong">MBG-772910</td><td>09:24 WIB</td><td>SPPG Surabaya Barat</td><td>UMKM Tani Makmur</td><td>Beras Premium</td>
          <td class="cell-money">Rp 12.400.000</td><td><?php echo badge('SELESAI','success'); ?></td>
          <td><span class="action-eye"><i data-lucide="eye"></i></span></td>
        </tr>
        <tr>
          <td class="cell-strong">MBG-772911</td><td>09:18 WIB</td><td>SPPG Medan Baru</td><td>Koperasi Nelayan Sejahtera</td><td>Ikan Segar</td>
          <td class="cell-money">Rp 8.750.000</td><td><?php echo badge('DIPROSES','info'); ?></td>
          <td><span class="action-eye"><i data-lucide="eye"></i></span></td>
        </tr>
        <tr>
          <td class="cell-strong">MBG-772912</td><td>08:55 WIB</td><td>SPPG Jakarta Pusat</td><td>PT. Distribusi Nasional</td><td>Susu UHT</td>
          <td class="cell-money">Rp 45.000.000</td><td><?php echo badge('DIBATALKAN','danger'); ?></td>
          <td><span class="action-eye"><i data-lucide="eye"></i></span></td>
        </tr>
        <tr>
          <td class="cell-strong">MBG-772913</td><td>08:42 WIB</td><td>SPPG Balikpapan</td><td>Agro Maju Mandiri</td><td>Telur Ayam</td>
          <td class="cell-money">Rp 15.200.000</td><td><?php echo badge('SELESAI','success'); ?></td>
          <td><span class="action-eye"><i data-lucide="eye"></i></span></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div style="height:6px;"></div>
</div>

<!-- Bottom row -->
<div class="grid grid-2">
  <div class="card">
    <div class="card-title mb-20">Supplier Menunggu Verifikasi</div>
    <div class="verify-row">
      <div class="verify-icon"><i data-lucide="landmark"></i></div>
      <div style="flex:1;">
        <div class="verify-name">CV. Berkah Tani</div>
        <div class="verify-loc">Cianjur, Jawa Barat</div>
      </div>
      <a href="data-supplier.php" class="btn btn-primary btn-sm">Verifikasi</a>
    </div>
    <div class="verify-row">
      <div class="verify-icon"><i data-lucide="landmark"></i></div>
      <div style="flex:1;">
        <div class="verify-name">UD. Jaya Lautan</div>
        <div class="verify-loc">Makassar, Sulsel</div>
      </div>
      <a href="data-supplier.php" class="btn btn-primary btn-sm">Verifikasi</a>
    </div>
  </div>
  <div class="card">
    <div class="card-title mb-20">Aktivitas Sistem Terbaru</div>
    <div class="timeline-item">
      <div class="timeline-dot" style="background:var(--navy-900);"></div>
      <div><p>10:45 WIB</p><span>Audit bulanan SPPG Wilayah Timur telah dimulai.</span></div>
    </div>
    <div class="timeline-item">
      <div class="timeline-dot" style="background:var(--red-solid);"></div>
      <div><p>10:12 WIB</p><span>Sistem AI mendeteksi lonjakan harga telur di 12 SPPG secara serentak.</span></div>
    </div>
    <div class="timeline-item">
      <div class="timeline-dot" style="background:var(--blue-500);"></div>
      <div><p>09:30 WIB</p><span>Laporan anggaran Q2 MBG Nasional telah dipublikasikan ke panel pengawas.</span></div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
