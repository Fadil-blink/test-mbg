<?php
require __DIR__ . '/config.php';
$pageTitle = "Deteksi Kecurangan";
$topbarTitle = "Monitoring Anggaran";
require __DIR__ . '/includes/header.php';
?>

<div class="page-head">
  <div>
    <h1>Deteksi Kecurangan AI</h1>
    <p>Analisis Integritas Transaksi Nasional Berbasis Kecerdasan Buatan</p>
  </div>
  <div class="page-head-actions">
    <button class="btn btn-outline"><i data-lucide="sliders-horizontal"></i>Filter Data</button>
    <button class="btn btn-primary"><i data-lucide="download"></i>Ekspor Rekapitulasi</button>
  </div>
</div>

<div class="grid grid-2 mb-24">
  <div class="card score-ring-wrap">
    <div class="card-title" style="letter-spacing:.5px;font-size:13px;color:var(--text-500);margin-bottom:14px;">SKOR RISIKO NASIONAL</div>
    <div class="donut-wrap" style="height:180px;width:180px;">
      <canvas id="skorRisikoChart"></canvas>
      <div class="donut-center"><b>68</b><span>/ 100</span></div>
    </div>
    <div style="margin-top:14px;"><span class="chip chip-red" style="font-size:13px;padding:6px 14px;">Risiko Menengah-Tinggi</span></div>
    <p style="font-size:12.5px;color:var(--text-500);margin-top:12px;max-width:260px;">Terdeteksi anomali pada 4 provinsi dalam 24 jam terakhir.</p>
  </div>

  <div class="card" style="border-top:3px solid var(--blue-500);">
    <div class="card-title" style="display:flex;align-items:center;gap:8px;margin-bottom:18px;">
      <i data-lucide="sparkles" style="width:17px;height:17px;color:var(--blue-500);"></i>Rekomendasi Tindakan AI
    </div>
    <div style="display:flex;gap:14px;align-items:flex-start;padding:14px;border:1px solid var(--border);border-radius:12px;margin-bottom:12px;">
      <div class="verify-icon"><i data-lucide="map-pin"></i></div>
      <div style="flex:1;">
        <h4 style="font-size:13.5px;font-weight:700;margin-bottom:4px;">Audit Lapangan Segera</h4>
        <p style="font-size:12.5px;color:var(--text-500);">Lakukan audit fisik pada SPPG X di Jakarta Timur karena selisih volume bahan baku mencapai 42%.</p>
      </div>
      <span class="link-btn" style="white-space:nowrap;">Detail</span>
    </div>
    <div style="display:flex;gap:14px;align-items:flex-start;padding:14px;border:1px solid var(--border);border-radius:12px;">
      <div class="verify-icon" style="background:var(--red-bg);color:var(--red-solid);"><i data-lucide="ban"></i></div>
      <div style="flex:1;">
        <h4 style="font-size:13.5px;font-weight:700;margin-bottom:4px;">Pembekuan Akun</h4>
        <p style="font-size:12.5px;color:var(--text-500);">Bekukan sementara akun Supplier PT IndoPangan atas dugaan manipulasi harga (Markup) masif.</p>
      </div>
      <span class="link-btn" style="white-space:nowrap;color:var(--red-solid);font-weight:800;">Eksekusi</span>
    </div>
  </div>
</div>

<div class="grid grid-5 mb-24">
  <div class="stat-card">
    <div class="stat-label" style="margin-bottom:10px;">Harga Melebihi Acuan</div>
    <div class="stat-value" style="margin-bottom:8px;">124</div>
    <span class="chip chip-red">Sangat Tinggi</span>
  </div>
  <div class="stat-card">
    <div class="stat-label" style="margin-bottom:10px;">Transaksi Ganda</div>
    <div class="stat-value" style="margin-bottom:8px;">42</div>
    <span class="chip chip-red">Tinggi</span>
  </div>
  <div class="stat-card">
    <div class="stat-label" style="margin-bottom:10px;">Supplier Mencurigakan</div>
    <div class="stat-value" style="margin-bottom:8px;">15</div>
    <span class="chip chip-red">Kritis</span>
  </div>
  <div class="stat-card" style="border-color:var(--blue-500);border-width:1.5px;">
    <div class="stat-label" style="margin-bottom:10px;">Pembelian Tidak Wajar</div>
    <div class="stat-value" style="margin-bottom:8px;">289</div>
    <span class="chip chip-blue">Sedang</span>
  </div>
  <div class="stat-card">
    <div class="stat-label" style="margin-bottom:10px;">Anggaran Melebihi Batas</div>
    <div class="stat-value" style="margin-bottom:8px;">8</div>
    <span class="chip chip-red">Kritis</span>
  </div>
</div>

<div class="card" style="padding:0;">
  <div class="card-head-row" style="padding:22px 22px 0;">
    <div class="card-title">Transaksi Mencurigakan Terbaru</div>
    <div style="display:flex;gap:8px;">
      <span class="page-btn"><i data-lucide="refresh-cw"></i></span>
      <span class="page-btn"><i data-lucide="more-vertical"></i></span>
    </div>
  </div>
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr><th>ID Transaksi</th><th>Unit SPPG</th><th>Supplier</th><th>Jenis Kecurangan</th><th>Tingkat Risiko</th><th>Status</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <tr>
          <td class="cell-strong">#TRX-9821-JKT</td>
          <td>SPPG Menteng Jaya</td>
          <td>PT Surya Boga Utama</td>
          <td><span class="chip chip-red">Harga Melebihi Acuan</span></td>
          <td><?php echo badge('92%','danger'); ?></td>
          <td><?php echo badge('Menunggu Review','neutral'); ?></td>
          <td><button class="btn btn-primary btn-sm">Audit</button></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div style="height:6px;"></div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
