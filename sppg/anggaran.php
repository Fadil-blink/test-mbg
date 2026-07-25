<?php
$pageTitle = 'Monitoring Anggaran';
$active = 'anggaran';
include 'includes/header.php';

$chart = [
  ['label'=>'Jan','h'=>32],['label'=>'Feb','h'=>38],['label'=>'Mar','h'=>46],['label'=>'Apr','h'=>42],
  ['label'=>'Mei','h'=>56],['label'=>'Jun','h'=>50],['label'=>'Jul','h'=>64],['label'=>'Agu','h'=>72],
  ['label'=>'Sep','h'=>84],['label'=>'Okt','h'=>96],
];
$alloc = [
  ['label'=>'Beras','pct'=>40],
  ['label'=>'Telur','pct'=>25],
  ['label'=>'Daging','pct'=>20],
  ['label'=>'Lainnya','pct'=>15],
];
$transactions = [
  ['tanggal'=>'24 Okt 2024','ket'=>'Pembelian Beras Premium','kategori'=>'Bahan Pangan','nominal'=>'Rp 12.500.000','status'=>'Selesai'],
  ['tanggal'=>'23 Okt 2024','ket'=>'Pengadaan Telur Ayam Ras','kategori'=>'Bahan Pangan','nominal'=>'Rp 8.200.000','status'=>'Selesai'],
  ['tanggal'=>'22 Okt 2024','ket'=>'Biaya Logistik Distribusi','kategori'=>'Operasional','nominal'=>'Rp 3.450.000','status'=>'Proses'],
];
function status_class($s){
  $map = ['Selesai'=>'selesai','Proses'=>'diproses'];
  return $map[$s] ?? '';
}
?>
<div class="page-header-row">
  <div>
    <div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Monitoring Anggaran</b></div>
    <h1 class="page-title">Monitoring Anggaran</h1>
    <p class="page-sub">Pantau alokasi, realisasi, dan sisa anggaran SPPG secara real-time.</p>
  </div>
  <a href="#" class="btn btn-outline">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
    Unduh Laporan
  </a>
</div>

<div class="stat-grid">
  <div class="stat-card">
    <div class="label" style="text-transform:uppercase;font-size:11.5px;letter-spacing:.03em;font-weight:700;">Total Anggaran</div>
    <div class="value">Rp 500.000.000</div>
  </div>
  <div class="stat-card">
    <div class="label" style="text-transform:uppercase;font-size:11.5px;letter-spacing:.03em;font-weight:700;">Anggaran Terpakai</div>
    <div class="value">Rp 325.450.000</div>
    <div class="progress-bar"><span style="width:65%;"></span></div>
    <div style="text-align:right;font-size:11.5px;color:var(--text-light);">65% Terpakai</div>
  </div>
  <div class="stat-card">
    <div class="label" style="text-transform:uppercase;font-size:11.5px;letter-spacing:.03em;font-weight:700;">Sisa Anggaran</div>
    <div class="value">Rp 174.550.000</div>
  </div>
  <div class="stat-card">
    <div class="label" style="text-transform:uppercase;font-size:11.5px;letter-spacing:.03em;font-weight:700;">Persentase</div>
    <div class="value">65.1%</div>
  </div>
</div>

<div class="two-col">
  <div class="panel">
    <h3 style="margin:0 0 20px 0;font-size:16.5px;color:var(--navy);">Tren Penggunaan Anggaran Bulanan</h3>
    <div class="bar-chart">
      <?php foreach ($chart as $c): ?>
      <div class="bar-col">
        <div class="bar" style="height:<?php echo $c['h']; ?>%;"></div>
        <div class="bar-label"><?php echo $c['label']; ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="panel">
    <h3 style="margin:0 0 20px 0;font-size:16.5px;color:var(--navy);">Alokasi per Kategori</h3>
    <?php foreach ($alloc as $a): ?>
    <div class="alloc-row">
      <div class="alloc-top"><span><?php echo $a['label']; ?></span> <b><?php echo $a['pct']; ?>%</b></div>
      <div class="progress-bar"><span style="width:<?php echo $a['pct']; ?>%;"></span></div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="panel">
  <div class="panel-head">
    <h3>Riwayat Transaksi Anggaran</h3>
    <a href="#" class="seeall">Lihat Semua</a>
  </div>
  <div class="table-wrap" style="box-shadow:none;border:1px solid var(--border);margin-top:10px;">
    <table class="data-table">
      <thead>
        <tr><th>Tanggal</th><th>Keterangan</th><th>Kategori</th><th>Nominal</th><th>Status</th></tr>
      </thead>
      <tbody>
        <?php foreach ($transactions as $t): ?>
        <tr>
          <td class="cell-muted"><?php echo $t['tanggal']; ?></td>
          <td><?php echo $t['ket']; ?></td>
          <td class="cell-muted"><?php echo $t['kategori']; ?></td>
          <td class="cell-strong"><?php echo $t['nominal']; ?></td>
          <td><span class="status-pill <?php echo status_class($t['status']); ?>"><?php echo $t['status']; ?></span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
