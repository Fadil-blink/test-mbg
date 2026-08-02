<?php
$pageTitle = 'Pusat Notifikasi';
$active = 'notifikasi';
include 'includes/header.php';

$userId = $_SESSION['user_id'];
$notifs = [];
$stmt = $mysqli->prepare('SELECT title, message, status, DATE_FORMAT(created_at, "%d %b %Y %H:%i") AS created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 20');
if ($stmt) {
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $notifs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
}

function notif_icon($name){
  $icons = [
    'cart'=>'<circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h7.2a2 2 0 0 0 2-1.6L21 8H6"/>',
    'invoice'=>'<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 8h8M8 12h8M8 16h5"/>',
    'alert'=>'<path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/>',
  ];
  return $icons[$name] ?? '<circle cx="12" cy="12" r="10"/>';
}
?>
<div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Pusat Notifikasi</b></div>
<h1 class="page-title">Pusat Notifikasi</h1>
<p class="page-sub">Pantau semua aktivitas dan pembaruan sistem dalam satu tempat.</p>

<div class="table-wrap">
  <div class="notif-page-toolbar"><div class="notif-tabs" style="padding:0;"><a href="#" class="active">Semua</a><a href="#">Belum Dibaca</a><a href="#">Sudah Dibaca</a></div><button class="btn btn-outline btn-sm mark-all-read"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M20 6L9 17l-5-5"/></svg> Tandai Semua Telah Dibaca</button></div>
  <div class="notif-page-list" style="margin-top:18px;">
    <?php if (empty($notifs)): ?>
      <div style="padding:28px;text-align:center;color:var(--text-500);">Belum ada notifikasi untuk akun Anda.</div>
    <?php endif; ?>
    <?php foreach ($notifs as $n): ?>
    <div class="notif-page-item">
      <div class="n-icon blue"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo notif_icon('cart'); ?></svg></div>
      <div class="n-body">
        <div class="n-top"><b><?php echo htmlspecialchars($n['title']); ?></b><span class="time"><?php echo htmlspecialchars($n['created_at']); ?></span></div>
        <p><?php echo htmlspecialchars($n['message']); ?></p>
        <a href="#" class="action">Lihat Detail</a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="table-footer"><span>Menampilkan <?php echo count($notifs); ?> notifikasi</span><div class="pagination"><a href="#">&lsaquo;</a><a href="#" class="active">1</a><a href="#">2</a><a href="#">&rsaquo;</a></div></div>
</div>

<?php include 'includes/footer.php'; ?>
