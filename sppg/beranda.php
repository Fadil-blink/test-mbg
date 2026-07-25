<?php
$pageTitle = 'Beranda';
$active = 'beranda';
include 'includes/header.php';

$stats = [
  ['icon'=>'blue',  'svg'=>'wallet',  'pct'=>'+2.4%', 'pctType'=>'up',      'label'=>'Anggaran Bulan Ini', 'value'=>'Rp 4.2M'],
  ['icon'=>'amber', 'svg'=>'gauge',   'pct'=>'65% used','pctType'=>'neutral','label'=>'Anggaran Terpakai', 'value'=>'Rp 2.7M'],
  ['icon'=>'teal',  'svg'=>'pig',     'pct'=>'-1.2%', 'pctType'=>'down',    'label'=>'Sisa Anggaran', 'value'=>'Rp 1.5M'],
  ['icon'=>'gray',  'svg'=>'cart2',   'pct'=>'',      'pctType'=>'',        'label'=>'Pesanan Aktif', 'value'=>'42'],
  ['icon'=>'blue',  'svg'=>'check',   'pct'=>'',      'pctType'=>'',        'label'=>'Pesanan Selesai', 'value'=>'156'],
  ['icon'=>'amber', 'svg'=>'box',     'pct'=>'',      'pctType'=>'',        'label'=>'Supplier Aktif', 'value'=>'18'],
];

$quickActions = [
  ['primary'=>true, 'icon'=>'cart2', 'title'=>'Belanja Sekarang', 'sub'=>'Pesan komoditas baru', 'href'=>'belanja-komoditas.php'],
  ['primary'=>false,'icon'=>'search','title'=>'Cari Supplier', 'sub'=>'Direktori mitra SPPG', 'href'=>'supplier.php'],
  ['primary'=>false,'icon'=>'file',  'title'=>'Lihat Pesanan', 'sub'=>'Status logistik terkini', 'href'=>'pesanan-saya.php'],
  ['primary'=>false,'icon'=>'truck', 'title'=>'Terima Barang', 'sub'=>'Konfirmasi kedatangan', 'href'=>'penerimaan-barang.php'],
];

$chart = [
  ['label'=>'MEI','h'=>60,'cls'=>''],
  ['label'=>'JUN','h'=>55,'cls'=>''],
  ['label'=>'JUL','h'=>38,'cls'=>''],
  ['label'=>'AGU','h'=>90,'cls'=>''],
  ['label'=>'SEP','h'=>80,'cls'=>''],
  ['label'=>'OKT','h'=>100,'cls'=>'highlight'],
];

$notifs = [
  ['type'=>'red','icon'=>'alert','title'=>'Stok Beras Menipis','desc'=>'Persediaan beras di gudang sisa 250kg. Segera buat pesanan baru.','time'=>'5 menit yang lalu'],
  ['type'=>'blue','icon'=>'truck','title'=>'Pengiriman Sedang Jalan','desc'=>'Pesanan #ORD-9821 sedang dalam perjalanan oleh Supplier Sembako Jaya.','time'=>'1 jam yang lalu'],
  ['type'=>'green','icon'=>'check','title'=>'Budget Disetujui','desc'=>'Penambahan anggaran operasional minggu ke-3 telah disetujui pusat.','time'=>'3 jam yang lalu'],
];

$activities = [
  ['dot'=>'','title'=>'Pesanan Dibuat','desc'=>'Budi Santoso membuat pesanan baru #ORD-9825','time'=>'Hari ini, 09:12'],
  ['dot'=>'blue','title'=>'Invoice Dibayar','desc'=>'Pembayaran lunas untuk INV/2023/10/012','time'=>'Hari ini, 07:45'],
  ['dot'=>'brown','title'=>'Supplier Ditambahkan','desc'=>'Verifikasi CV Maju Bersama selesai','time'=>'Kemarin, 16:20'],
  ['dot'=>'gray','title'=>'Laporan Bulanan','desc'=>'Laporan periode September telah diarsipkan','time'=>'11 Okt, 14:00'],
];

$orders = [
  ['id'=>'#ORD-9825','supplier'=>'CV Sembako Jaya','komoditas'=>'Beras, Telur','total'=>'Rp 12.500.000','status'=>'Diproses'],
  ['id'=>'#ORD-9824','supplier'=>'PT Telur Nasional','komoditas'=>'Telur Ayam (50kg)','total'=>'Rp 1.450.000','status'=>'Dikirim'],
  ['id'=>'#ORD-9822','supplier'=>'UD Sayur Mayur','komoditas'=>'Sayuran Hijau','total'=>'Rp 3.200.000','status'=>'Selesai'],
  ['id'=>'#ORD-9819','supplier'=>'Farm Fresh Milk','komoditas'=>'Susu UHT (200L)','total'=>'Rp 4.100.000','status'=>'Kendala'],
];

function status_class($s){
  $map = ['Diproses'=>'diproses','Dikirim'=>'dikirim','Selesai'=>'selesai','Kendala'=>'kendala','Menunggu'=>'menunggu','Lunas'=>'lunas'];
  return $map[$s] ?? '';
}

function mini_icon($name){
  $icons = [
    'wallet'=>'<rect x="2" y="6" width="20" height="14" rx="2"/><path d="M2 10h20"/><circle cx="17" cy="15" r="1.3"/>',
    'gauge'=>'<path d="M12 20a8 8 0 1 0-8-8"/><path d="M12 12l4-4"/>',
    'pig'=>'<path d="M19 6.5V5a2 2 0 0 0-2-2h-2l-2 2H9L7 3H5a2 2 0 0 0-2 2v1.5"/><path d="M3 10a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v3a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4z"/><circle cx="16" cy="12" r="1"/>',
    'cart2'=>'<circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h7.2a2 2 0 0 0 2-1.6L21 8H6"/>',
    'check'=>'<path d="M20 6L9 17l-5-5"/>',
    'box'=>'<path d="M21 8l-9-5-9 5 9 5 9-5z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>',
    'search'=>'<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>',
    'file'=>'<path d="M6 3h9l5 5v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M9 12h6M9 16h6"/>',
    'truck'=>'<rect x="1" y="6" width="14" height="11" rx="1"/><path d="M15 10h4l3 3v4h-7z"/><circle cx="6" cy="19" r="2"/><circle cx="17.5" cy="19" r="2"/>',
    'alert'=>'<path d="M12 9v4"/><path d="M12 17h.01"/><path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/>',
    'chev'=>'<path d="M9 18l6-6-6-6"/>',
  ];
  return $icons[$name] ?? '';
}
?>
<div class="page-header-row">
  <div>
    <h1 class="page-title">Selamat Pagi, Pak Budi</h1>
    <p class="page-sub">Berikut ringkasan operasional Satuan Pelayanan Gizi hari ini. &nbsp;•&nbsp; Pembaruan Terakhir: <?php echo date('d M Y, H:i'); ?></p>
  </div>
  <a href="riwayat-pembelian.php" class="btn btn-navy">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
    Laporan Cepat
  </a>
</div>

<div class="stat-grid cols-6">
  <?php foreach ($stats as $s): ?>
  <div class="stat-card">
    <div class="top-row">
      <div class="icon <?php echo $s['icon']; ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo mini_icon($s['svg']); ?></svg></div>
      <?php if ($s['pct']): ?><span class="badge-pct <?php echo $s['pctType']; ?>"><?php echo $s['pct']; ?></span><?php endif; ?>
    </div>
    <div class="label"><?php echo $s['label']; ?></div>
    <div class="value small"><?php echo $s['value']; ?></div>
  </div>
  <?php endforeach; ?>
</div>

<h3 style="margin:0 0 4px 0;color:var(--navy);font-size:16.5px;">Aksi Cepat</h3>
<div class="quick-actions">
  <?php foreach ($quickActions as $qa): ?>
  <a href="<?php echo $qa['href']; ?>" class="qa-card <?php echo $qa['primary'] ? 'primary' : ''; ?>" style="text-decoration:none;">
    <div class="qa-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo mini_icon($qa['icon']); ?></svg></div>
    <div>
      <b><?php echo $qa['title']; ?></b>
      <p><?php echo $qa['sub']; ?></p>
    </div>
    <div class="chev"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo mini_icon('chev'); ?></svg></div>
  </a>
  <?php endforeach; ?>
</div>

<div class="two-col">
  <div class="panel">
    <div class="panel-head">
      <h3>Grafik Pengeluaran Bulanan</h3>
      <select><option>Tahun 2023</option><option>Tahun 2024</option></select>
    </div>
    <div class="panel-sub">Trend belanja komoditas 6 bulan terakhir</div>
    <div class="bar-chart">
      <?php foreach ($chart as $c): ?>
      <div class="bar-col">
        <div class="bar <?php echo $c['cls']; ?>" style="height:<?php echo $c['h']; ?>%;"></div>
        <div class="bar-label"><?php echo $c['label']; ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="panel">
    <div class="panel-head">
      <h3>Notifikasi Terbaru</h3>
      <a href="notifikasi.php" class="seeall">Semua</a>
    </div>
    <div class="notif-list">
      <?php foreach ($notifs as $n): ?>
      <div class="notif-item">
        <div class="n-icon <?php echo $n['type']; ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo mini_icon($n['icon']); ?></svg></div>
        <div>
          <b><?php echo $n['title']; ?></b>
          <p><?php echo $n['desc']; ?></p>
          <div class="time"><?php echo $n['time']; ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<div class="two-col" style="grid-template-columns: 1fr 2fr;">
  <div class="panel">
    <h3 style="margin:0 0 18px 0;font-size:16.5px;color:var(--navy);">Riwayat Aktivitas</h3>
    <div class="activity-list">
      <?php foreach ($activities as $a): ?>
      <div class="activity-item">
        <div class="dot <?php echo $a['dot']; ?>"></div>
        <div>
          <b><?php echo $a['title']; ?></b>
          <p><?php echo $a['desc']; ?></p>
          <div class="time"><?php echo $a['time']; ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="panel">
    <div class="panel-head">
      <h3>Daftar Pesanan Terbaru</h3>
      <a href="pesanan-saya.php" class="btn btn-outline btn-sm">Lihat Semua</a>
    </div>
    <div class="panel-sub">Monitoring transaksi pengadaan aktif</div>
    <div class="table-wrap" style="box-shadow:none;border:1px solid var(--border);">
      <table class="data-table">
        <thead>
          <tr><th>ID Pesanan</th><th>Supplier</th><th>Komoditas</th><th>Total Tagihan</th><th>Status</th></tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $o): ?>
          <tr>
            <td class="cell-link"><?php echo $o['id']; ?></td>
            <td><?php echo $o['supplier']; ?></td>
            <td><?php echo $o['komoditas']; ?></td>
            <td class="cell-strong"><?php echo $o['total']; ?></td>
            <td><span class="status-pill <?php echo status_class($o['status']); ?>"><?php echo $o['status']; ?></span></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
