<?php
$pageTitle = 'Pusat Notifikasi';
$active = 'notifikasi';
include 'includes/header.php';

$notifs = [
  ['icon'=>'cart','type'=>'blue','title'=>'Pesanan Dikonfirmasi','desc'=>'Pesanan #TRX-88210 untuk Beras Premium telah dikonfirmasi oleh supplier PT. Pangan Nusantara Abadi.','time'=>'2 jam yang lalu','action'=>'Lihat Detail'],
  ['icon'=>'invoice','type'=>'gray','title'=>'Tagihan Baru Tersedia','desc'=>'Invoice digital untuk pengadaan Telur Ayam periode Oktober telah diterbitkan dan siap untuk diproses.','time'=>'5 jam yang lalu','action'=>'Lihat Invoice'],
  ['icon'=>'alert','type'=>'red','title'=>'Peringatan Stok Rendah','desc'=>'Stok Daging Ayam di gudang pusat saat ini di bawah ambang batas minimum (500 Kg).','time'=>'Kemarin','action'=>'Cek Inventaris'],
];

function notif_icon($name){
  $icons = [
    'cart'=>'<circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h7.2a2 2 0 0 0 2-1.6L21 8H6"/>',
    'invoice'=>'<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 8h8M8 12h8M8 16h5"/>',
    'alert'=>'<path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/>',
  ];
  return $icons[$name] ?? '';
}
?>
<div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Pusat Notifikasi</b></div>
<h1 class="page-title">Pusat Notifikasi</h1>
<p class="page-sub">Pantau semua aktivitas dan pembaruan sistem dalam satu tempat.</p>

<div class="table-wrap">
  <div class="notif-page-toolbar">
    <div class="notif-tabs" style="padding:0;">
      <a href="#" class="active">Semua</a>
      <a href="#">Belum Dibaca</a>
      <a href="#">Sudah Dibaca</a>
    </div>
    <button class="btn btn-outline btn-sm mark-all-read">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M20 6L9 17l-5-5"/></svg>
      Tandai Semua Telah Dibaca
    </button>
  </div>

  <div class="notif-page-list" style="margin-top:18px;">
    <?php foreach ($notifs as $n): ?>
    <div class="notif-page-item">
      <div class="n-icon <?php echo $n['type']; ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo notif_icon($n['icon']); ?></svg></div>
      <div class="n-body">
        <div class="n-top">
          <b><?php echo $n['title']; ?></b>
          <span class="time"><?php echo $n['time']; ?></span>
        </div>
        <p><?php echo $n['desc']; ?></p>
        <a href="#" class="action"><?php echo $n['action']; ?> <span class="unread-dot" style="color:var(--blue);">●</span></a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="table-footer">
    <span>Menampilkan 1-3 dari 24 notifikasi</span>
    <div class="pagination">
      <a href="#">&lsaquo;</a>
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#">&rsaquo;</a>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
