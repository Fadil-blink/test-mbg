<?php
$current = basename($_SERVER['PHP_SELF']);

// Struktur menu sidebar: key => [label, icon (lucide), file]
require_once __DIR__ . '/../includes/db.php';

$menu = [
    ['label' => 'Dashboard',            'icon' => 'layout-dashboard', 'file' => 'dashboard.php'],
    ['label' => 'Monitoring Nasional',  'icon' => 'bar-chart-3',      'file' => 'monitoring-nasional.php'],
    ['label' => 'Data SPPG',            'icon' => 'file-text',        'file' => 'data-sppg.php'],
    ['label' => 'Data Supplier',        'icon' => 'archive',          'file' => 'data-supplier.php'],
    ['label' => 'Transaksi Pembelian',  'icon' => 'shopping-cart',    'file' => 'transaksi-pembelian.php'],
    ['label' => 'Monitoring Anggaran',  'icon' => 'credit-card',      'file' => 'monitoring-anggaran.php'],
    ['label' => 'Monitoring Komoditas', 'icon' => 'share-2',          'file' => 'monitoring-komoditas.php'],
    ['label' => 'Deteksi Kecurangan',   'icon' => 'shield',           'file' => 'deteksi-kecurangan.php'],
    ['label' => 'Laporan',              'icon' => 'file-output',      'file' => 'laporan.php'],
    ['label' => 'Jejak Audit',          'icon' => 'history',          'file' => 'jejak-audit.php'],
    ['label' => 'Manajemen Pengguna',   'icon' => 'users',            'file' => 'manajemen-pengguna.php'],
    ['label' => 'Pengaturan',           'icon' => 'settings',         'file' => 'pengaturan.php'],
];

/**
 * Escape string untuk output HTML.
 */
function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function bind_stmt_params(mysqli_stmt $stmt, string $types, array $params): void {
    if ($types === '' || count($params) === 0) {
        return;
    }
    $bindNames = [];
    $bindNames[] = $types;
    foreach ($params as $key => $value) {
        $bindNames[] = &$params[$key];
    }
    call_user_func_array([$stmt, 'bind_param'], $bindNames);
}

/**
 * Format angka ke Rupiah singkat, mis. 45200000000000 -> "Rp 45.2T"
 */
function fmt_rp_short($value) {
    $value = (float)$value;
    if ($value >= 1000000000000) {
        return 'Rp ' . number_format($value / 1000000000000, 1, ',', '.') . 'T';
    }
    if ($value >= 1000000000) {
        return 'Rp ' . number_format($value / 1000000000, 1, ',', '.') . 'M';
    }
    if ($value >= 1000000) {
        return 'Rp ' . number_format($value / 1000000, 1, ',', '.') . 'Jt';
    }
    return 'Rp ' . number_format($value, 0, ',', '.');
}

function formatRp($value) {
    return 'Rp ' . number_format((float)$value, 0, ',', '.');
}

/**
 * Helper untuk badge status berwarna
 * type: success | info | danger | warning | neutral
 */
function badge($text, $type = 'neutral') {
    return '<span class="badge badge-' . htmlspecialchars($type) . '">' . htmlspecialchars($text) . '</span>';
}

/**
 * Helper progress bar tipis
 */
function progress_bar($percent, $color = 'blue') {
    $percent = max(0, min(100, (float)$percent));
    return '<div class="progress-track"><div class="progress-fill progress-' . htmlspecialchars($color) . '" style="width:' . $percent . '%"></div></div>';
}
