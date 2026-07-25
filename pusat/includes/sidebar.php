<aside class="sidebar">
  <div>
    <div class="sidebar-top">
      <div class="brand-title">PAN MBG</div>
      <div class="brand-sub">Pusat Audit Nasional</div>
    </div>
    <nav class="nav">
      <?php foreach ($menu as $item): ?>
        <a href="<?php echo $item['file']; ?>" class="nav-item <?php echo ($current === $item['file']) ? 'active' : ''; ?>">
          <i data-lucide="<?php echo $item['icon']; ?>"></i>
          <span><?php echo $item['label']; ?></span>
        </a>
      <?php endforeach; ?>
    </nav>
  </div>
  <div class="sidebar-bottom">
    <div class="avatar-circle">AD</div>
    <div>
      <div class="sidebar-user-name">Auditor Utama</div>
      <div class="sidebar-user-date">24 Juli 2026</div>
    </div>
  </div>
</aside>
