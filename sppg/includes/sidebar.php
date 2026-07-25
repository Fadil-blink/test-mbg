<?php
// $active harus di-set di halaman pemanggil sebelum include ini
if (!isset($active)) $active = '';

$menu = [
  'beranda'            => ['label' => 'Beranda', 'href' => 'beranda.php', 'icon' => 'grid'],
  'belanja'            => ['label' => 'Belanja Komoditas', 'href' => 'belanja-komoditas.php', 'icon' => 'cart'],
  'supplier'           => ['label' => 'Supplier', 'href' => 'supplier.php', 'icon' => 'store'],
  'pesanan'            => ['label' => 'Pesanan Saya', 'href' => 'pesanan-saya.php', 'icon' => 'file'],
  'penerimaan'         => ['label' => 'Penerimaan Barang', 'href' => 'penerimaan-barang.php', 'icon' => 'truck'],
  'anggaran'           => ['label' => 'Anggaran', 'href' => 'anggaran.php', 'icon' => 'wallet'],
  'invoice'            => ['label' => 'Invoice Digital', 'href' => 'invoice-digital.php', 'icon' => 'doc'],
  'riwayat'            => ['label' => 'Riwayat Pembelian', 'href' => 'riwayat-pembelian.php', 'icon' => 'history'],
  'notifikasi'         => ['label' => 'Notifikasi', 'href' => 'notifikasi.php', 'icon' => 'bell'],
];

function sppg_icon($name) {
  $icons = [
    'grid' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>',
    'cart' => '<circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h7.2a2 2 0 0 0 2-1.6L21 8H6"/>',
    'store' => '<path d="M3 9l1.5-5h15L21 9"/><path d="M3 9v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/><path d="M9 20v-6h6v6"/>',
    'file' => '<path d="M6 3h9l5 5v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M9 12h6M9 16h6"/>',
    'truck' => '<rect x="1" y="6" width="14" height="11" rx="1"/><path d="M15 10h4l3 3v4h-7z"/><circle cx="6" cy="19" r="2"/><circle cx="17.5" cy="19" r="2"/>',
    'wallet' => '<rect x="2" y="6" width="20" height="14" rx="2"/><path d="M2 10h20"/><circle cx="17" cy="15" r="1.3"/>',
    'doc' => '<path d="M7 3h7l5 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M9 12h6M9 16h4"/>',
    'history' => '<path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 4v5h5"/><path d="M12 7v5l4 2"/>',
    'bell' => '<path d="M6 8a6 6 0 0 1 12 0c0 5 2 6 2 6H4s2-1 2-6z"/><path d="M10 20a2 2 0 0 0 4 0"/>',
    'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"/>',
    'bank' => '<path d="M3 21h18"/><path d="M4 21V10l8-6 8 6v11"/><path d="M9 21v-7h6v7"/>',
  ];
  return $icons[$name] ?? '';
}
?>
<aside class="sidebar">
  <div class="sidebar-brand">
    <div class="logo"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo sppg_icon('bank'); ?></svg></div>
    <div class="brand-text">
      <div class="title">SPPG</div>
      <div class="subtitle">Satuan Pelayanan Gizi</div>
    </div>
  </div>
  <nav class="sidebar-nav">
    <ul>
      <?php foreach ($menu as $key => $item): ?>
      <li>
        <a href="<?php echo $item['href']; ?>" class="<?php echo $active === $key ? 'active' : ''; ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo sppg_icon($item['icon']); ?></svg>
          <span><?php echo $item['label']; ?></span>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <div class="sidebar-footer <?php echo $active === 'profil' ? 'active-profile' : ''; ?>">
    <a href="profil-sppg.php" class="profile-link">
      <div class="avatar-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo sppg_icon('user'); ?></svg>
      </div>
      <div>
        <div class="profile-name">Profil SPPG</div>
        <div class="profile-sub">PENGATURAN AKUN</div>
      </div>
    </a>
  </div>
</aside>
