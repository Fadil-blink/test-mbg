<?php
require __DIR__ . '/config.php';
$pageTitle = "Laporan";
$topbarTitle = "Monitoring Anggaran";
require __DIR__ . '/includes/header.php';
?>

<div class="page-head">
  <div>
    <h1>Laporan &amp; Rekapitulasi</h1>
    <p>Penyusunan dan pengunduhan laporan audit berkala nasional.</p>
  </div>
  <div class="page-head-actions">
    <button class="btn btn-outline"><i data-lucide="file-output"></i>Ekspor PDF</button>
    <button class="btn btn-outline"><i data-lucide="file-spreadsheet"></i>Ekspor Excel</button>
    <button class="btn btn-primary"><i data-lucide="download"></i>Unduh CSV</button>
  </div>
</div>

<div class="card mb-24">
  <div class="card-title" style="letter-spacing:.4px;font-size:13px;color:var(--text-500);margin-bottom:16px;">FILTER LAPORAN</div>
  <div class="grid grid-6" style="gap:14px;margin-bottom:18px;">
    <div class="field"><label>Rentang Tanggal</label><input type="text" class="input" placeholder="mm/dd/yyyy"></div>
    <div class="field"><label>Provinsi</label><div class="dropdown">Semua Provinsi<i data-lucide="chevron-down"></i></div></div>
    <div class="field"><label>Kabupaten/Kota</label><div class="dropdown">Semua Kota<i data-lucide="chevron-down"></i></div></div>
    <div class="field"><label>Unit SPPG</label><div class="dropdown">Semua Unit<i data-lucide="chevron-down"></i></div></div>
    <div class="field"><label>Supplier</label><div class="dropdown">Semua Supplier<i data-lucide="chevron-down"></i></div></div>
    <div class="field"><label>Komoditas</label><div class="dropdown">Semua Komoditas<i data-lucide="chevron-down"></i></div></div>
  </div>
  <button class="btn btn-primary" style="background:var(--blue-600);">Terapkan Filter</button>
</div>

<div class="card" style="padding:0;">
  <div class="card-head-row" style="padding:22px 22px 0;">
    <div class="card-title">Pratinjau Laporan Terbaru</div>
    <span class="page-btn"><i data-lucide="refresh-cw"></i></span>
  </div>
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr><th>ID Laporan</th><th>Judul Laporan</th><th>Tipe</th><th>Tanggal</th><th>Dibuat Oleh</th><th>Status</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <tr>
          <td class="cell-strong">#REP-2026-07-01</td>
          <td>Rekapitulasi Bulanan Nasional - Juli</td>
          <td>Bulanan</td>
          <td>24 Jul 2026</td>
          <td>Sistem AI</td>
          <td><?php echo badge('Selesai','info'); ?></td>
          <td><span class="link-btn">Lihat</span></td>
        </tr>
        <tr>
          <td class="cell-strong">#REP-2026-07-02</td>
          <td>Audit Khusus SPPG Jakarta Timur</td>
          <td>Insidental</td>
          <td>23 Jul 2026</td>
          <td>Auditor Utama</td>
          <td><?php echo badge('Draft','neutral'); ?></td>
          <td><span class="link-btn">Edit</span></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div style="height:6px;"></div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
