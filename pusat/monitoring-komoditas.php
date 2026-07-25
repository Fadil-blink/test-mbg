<?php
require __DIR__ . '/config.php';
$pageTitle = "Monitoring Komoditas";
$topbarTitle = "Monitoring Anggaran";
require __DIR__ . '/includes/header.php';
?>

<div class="page-head">
  <div>
    <h1>Monitoring Komoditas</h1>
    <p>Analisis Distribusi dan Performa Bahan Pangan Nasional</p>
  </div>
</div>

<div class="grid grid-4 mb-24">
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon"><i data-lucide="share-2"></i></div>
      <span class="stat-tag stat-tag-up" style="background:var(--green-bg);padding:3px 8px;border-radius:20px;">+2 Bulan ini</span>
    </div>
    <div class="stat-label-plain">Total Komoditas</div>
    <div class="stat-value" style="margin-bottom:4px;">12 Kategori</div>
    <div class="cell-sub" style="font-style:italic;">Beras, Telur, Daging, dsb</div>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon"><i data-lucide="trending-up"></i></div>
      <span class="stat-tag" style="background:var(--blue-badge-bg);color:var(--blue-badge-text);padding:3px 8px;border-radius:20px;">Terpopuler</span>
    </div>
    <div class="stat-label-plain">Komoditas Terlaris</div>
    <div class="stat-value" style="margin-bottom:4px;font-size:19px;">Beras Premium</div>
    <div class="cell-sub" style="color:var(--blue-600);font-weight:700;">35% Total Volume</div>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:#fbeedd;color:#b9791b;"><i data-lucide="wallet"></i></div>
      <span class="stat-tag" style="background:var(--gray-badge-bg);color:var(--gray-badge-text);padding:3px 8px;border-radius:20px;">YTD</span>
    </div>
    <div class="stat-label-plain">Nilai Pembelian</div>
    <div class="stat-value" style="margin-bottom:4px;">Rp 4.2 T</div>
    <div class="cell-sub">Update: 2 Jam lalu</div>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon"><i data-lucide="building-2"></i></div>
      <span class="stat-tag" style="background:var(--gray-badge-bg);color:var(--gray-badge-text);padding:3px 8px;border-radius:20px;">Nasional</span>
    </div>
    <div class="stat-label-plain">Jumlah Supplier</div>
    <div class="stat-value" style="margin-bottom:4px;">4.892 Entitas</div>
    <div class="cell-sub">Terverifikasi LHKPN</div>
  </div>
</div>

<div class="grid grid-2 mb-24">
  <div class="card">
    <div class="card-head-row">
      <div>
        <div class="card-title">Top 10 Komoditas</div>
        <div class="card-sub">Berdasarkan Volume Pengadaan Terbesar</div>
      </div>
      <button class="btn btn-outline btn-sm">Lihat Detail</button>
    </div>
    <div class="bar-list-item">
      <div class="bar-list-top"><b>Beras Premium</b><span>1.500 Ton</span></div>
      <?php echo progress_bar(100,'dark'); ?>
    </div>
    <div class="bar-list-item">
      <div class="bar-list-top"><b>Telur Ayam</b><span>980 Ton</span></div>
      <?php echo progress_bar(65,'dark'); ?>
    </div>
    <div class="bar-list-item">
      <div class="bar-list-top"><b>Daging Sapi</b><span>450 Ton</span></div>
      <?php echo progress_bar(30,'dark'); ?>
    </div>
  </div>
  <div class="card">
    <div class="card-title">Distribusi Komoditas</div>
    <div class="card-sub mb-20">Proporsi berdasarkan kategori pangan</div>
    <div class="donut-wrap" style="height:190px;">
      <canvas id="distribusiKomoditasChart"></canvas>
      <div class="donut-center"><b>100%</b><span>TOTAL DATA</span></div>
    </div>
  </div>
</div>

<div class="card" style="padding:0;">
  <div class="card-head-row" style="padding:22px 22px 0;">
    <div class="card-title">Daftar Detail Komoditas</div>
    <div style="display:flex;gap:10px;">
      <button class="btn btn-outline btn-sm"><i data-lucide="sliders-horizontal"></i>Filter</button>
      <button class="btn btn-outline btn-sm"><i data-lucide="download"></i>Export</button>
    </div>
  </div>
  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Komoditas</th><th>Jumlah Pembelian</th><th>Nilai Pembelian</th><th>Supplier</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        <tr>
          <td class="cell-strong">Beras Premium</td>
          <td>1.500 Ton</td>
          <td class="cell-money">Rp 1.2 T</td>
          <td>45</td>
          <td><?php echo badge('Pasokan Aman','success'); ?></td>
          <td><span class="link-btn">Detail</span></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div style="height:6px;"></div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
