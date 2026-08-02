<?php $page_title = 'Notifikasi'; include __DIR__ . '/includes/header.php'; ?>

<?php
$userId = $_SESSION['user_id'] ?? null;
$notifications = [];
$unreadCount = 0;

function notif_icon($type) {
  return match ($type) {
    'shipment' => 'fa-truck',
    'payment' => 'fa-money-check-alt',
    'alert' => 'fa-triangle-exclamation',
    default => 'fa-circle-info',
  };
}

if ($userId) {
  $tableExists = $mysqli->query("SHOW TABLES LIKE 'notifications'");
  if ($tableExists && $tableExists->num_rows > 0) {
    $stmt = $mysqli->prepare('SELECT title, message, type, is_read, DATE_FORMAT(created_at, "%d %b %Y %H:%i") AS created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 20');
    if ($stmt) {
      $stmt->bind_param('i', $userId);
      $stmt->execute();
      $res = $stmt->get_result();
      while ($row = $res->fetch_assoc()) {
        $notifications[] = $row;
        if (!$row['is_read']) {
          $unreadCount++;
        }
      }
      $stmt->close();
    }
  }
}
?>

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
    <div class="num"><?= $unreadCount ?></div>
  </div>
</div>

<div class="tabs" style="justify-content:space-between;display:flex;">
  <div style="display:flex;">
    <a href="#" class="active">Semua</a>
    <a href="#">Belum Dibaca</a>
    <a href="#">Sudah Dibaca</a>
  </div>
</div>

<?php if (empty($notifications)): ?>
  <div class="notif-card" style="padding:24px;text-align:center;color:var(--text-muted);">Belum ada notifikasi untuk Anda.</div>
<?php else: ?>
  <?php foreach ($notifications as $note): ?>
    <?php $isUnread = !$note['is_read']; ?>
    <div class="notif-card <?= $isUnread ? 'unread' : '' ?> <?= $note['type'] === 'alert' ? 'alert' : '' ?>">
      <?php if ($isUnread): ?><div class="n-dot"></div><?php endif; ?>
      <div class="n-head">
        <div class="notif-icon <?= $note['type'] === 'alert' ? 'red' : '' ?>"><i class="fa-solid <?= notif_icon($note['type']) ?>"></i></div>
        <div class="notif-body">
          <div class="n-title"><?= htmlspecialchars($note['title']) ?></div>
          <div class="n-text"><?= htmlspecialchars($note['message']) ?></div>
        </div>
        <div class="n-time"><?= htmlspecialchars($note['created_at']) ?></div>
      </div>
      <?php if ($isUnread): ?>
        <div class="n-actions"><button class="btn small outline">Tandai Dibaca</button></div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<div class="pagination" style="background:#fff;border:1px solid var(--border);border-radius:var(--radius);">
  <div>Menampilkan <?= count($notifications) ?> notifikasi</div>
  <div class="pages">
    <a href="#"><i class="fa-solid fa-chevron-left"></i></a>
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#"><i class="fa-solid fa-chevron-right"></i></a>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
