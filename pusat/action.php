<?php
require __DIR__ . '/config.php';

$action = $_GET['action'] ?? '';
$id     = $_GET['id'] ?? '';

function sendCsv(string $filename, array $rows) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $output = fopen('php://output', 'w');
    foreach ($rows as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
}

if ($action === 'download-laporan') {
    $rows = [
        ['ID Laporan', 'Judul Laporan', 'Tipe', 'Tanggal', 'Dibuat Oleh', 'Status'],
        ['REP-2026-07-01', 'Rekapitulasi Bulanan Nasional - Juli', 'Bulanan', '24 Jul 2026', 'Sistem AI', 'Selesai'],
        ['REP-2026-07-02', 'Audit Khusus SPPG Jakarta Timur', 'Insidental', '23 Jul 2026', 'Auditor Utama', 'Draft'],
    ];
    sendCsv('laporan-nasional.csv', $rows);
    exit;
}

if ($action === 'ekspor-pengguna') {
    $rows = [
        ['Nama', 'Email', 'Role', 'Instansi', 'Status', 'Login Terakhir'],
        ['Budi Santoso', 'budi.s@audit.go.id', 'Auditor Pusat', 'Pusat Audit Nasional', 'Aktif', '24 Jul 2026, 10:15'],
        ['Siti Aminah', 'siti.a@wilayah.go.id', 'Admin Wilayah', 'Kantor Wilayah I', 'Aktif', '23 Jul 2026, 16:45'],
        ['Andi Wijaya', 'andi.w@sppg-jaya.com', 'Petugas SPPG', 'PT SPPG Jaya Makmur', 'Aktif', '24 Jul 2026, 08:30'],
    ];
    sendCsv('pengguna-mbg.csv', $rows);
    exit;
}

if ($action === 'ekspor-sppg') {
    $rows = [
        ['Nama SPPG', 'Lokasi', 'Penanggung Jawab', 'Penerima', 'Anggaran', 'Realisasi', 'Status'],
        ['SPPG Surabaya Barat', 'Jawa Timur', 'Dr. Ahmad Fauzi', '5.000', 'Rp 500jt', 'Rp 480jt', 'Aktif'],
        ['SPPG Bandung Raya', 'Jawa Barat', 'Siti Aminah', '3.500', 'Rp 350jt', 'Rp 320jt', 'Aktif'],
    ];
    sendCsv('data-sppg.csv', $rows);
    exit;
}

$actions = [
    'tambah-sppg' => ['title' => 'Tambah Unit SPPG', 'message' => 'Form penambahan unit SPPG sedang dalam pengembangan. Anda dapat menambahkan unit baru setelah modul formulir siap.', 'back' => 'data-sppg.php'],
    'tambah-supplier' => ['title' => 'Tambah Supplier Baru', 'message' => 'Form pendaftaran supplier baru sedang dalam pengembangan. Silakan kembali dan coba lagi nanti.', 'back' => 'data-supplier.php'],
    'buat-alokasi' => ['title' => 'Buat Alokasi Baru', 'message' => 'Modul pembuatan alokasi anggaran baru sedang disiapkan. Silakan kembali ke dashboard anggaran.', 'back' => 'monitoring-anggaran.php'],
    'buat-transaksi' => ['title' => 'Buat Transaksi Baru', 'message' => 'Fitur pembuatan transaksi pembelian baru akan segera hadir. Silakan kembali ke halaman transaksi.', 'back' => 'transaksi-pembelian.php'],
    'reset-anggaran' => ['title' => 'Reset Filter Anggaran', 'message' => 'Filter anggaran telah direset ke setelan default.', 'back' => 'monitoring-anggaran.php'],
    'reset-transaksi' => ['title' => 'Reset Filter Transaksi', 'message' => 'Filter transaksi telah direset ke setelan default.', 'back' => 'transaksi-pembelian.php'],
    'laporan-pdf' => ['title' => 'Ekspor Laporan PDF', 'message' => 'Ekspor PDF laporan sedang disiapkan. Saat ini, hanya unduhan CSV yang tersedia.', 'back' => 'laporan.php'],
    'laporan-excel' => ['title' => 'Ekspor Laporan Excel', 'message' => 'Ekspor Excel laporan sedang disiapkan. Saat ini, hanya unduhan CSV yang tersedia.', 'back' => 'laporan.php'],
    'ekspor-sppg' => ['title' => 'Ekspor Data SPPG', 'message' => 'Ekspor CSV data SPPG sedang diproses.', 'back' => 'data-sppg.php'],
    'ekspor-pengguna' => ['title' => 'Ekspor Data Pengguna', 'message' => 'Ekspor CSV data pengguna sedang diproses.', 'back' => 'manajemen-pengguna.php'],
    'tambah-pengguna' => ['title' => 'Tambah Pengguna', 'message' => 'Form penambahan pengguna baru sedang dalam pengembangan. Silakan kembali ke manajemen pengguna nanti.', 'back' => 'manajemen-pengguna.php'],
    'reset-supplier' => ['title' => 'Reset Filter Supplier', 'message' => 'Filter supplier telah direset ke setelan default.', 'back' => 'data-supplier.php'],
    'detail-pengguna' => ['title' => 'Detail Pengguna', 'message' => 'Halaman detail pengguna akan segera tersedia di modul manajemen pengguna.', 'back' => 'manajemen-pengguna.php'],
    'laporan-detail' => ['title' => 'Detail Laporan', 'message' => 'Detail laporan akan segera tersedia di modul laporan.', 'back' => 'laporan.php'],
    'laporan-edit' => ['title' => 'Edit Laporan', 'message' => 'Fitur edit laporan akan segera tersedia.', 'back' => 'laporan.php'],
    'kecurangan-detail' => ['title' => 'Detail Deteksi Kecurangan', 'message' => 'Detail kecurangan akan segera tersedia.', 'back' => 'deteksi-kecurangan.php'],
    'kecurangan-eksekusi' => ['title' => 'Eksekusi Tindakan', 'message' => 'Aksi eksekusi kecurangan akan segera tersedia. Silakan tinjau kembali nanti.', 'back' => 'deteksi-kecurangan.php'],
];

if (!isset($actions[$action])) {
    header('Location: dashboard.php');
    exit;
}

$page = $actions[$action];
if ($id !== '') {
    $page['message'] .= ' ID: ' . htmlspecialchars($id) . '.';
}

$pageTitle = "Aksi Pusat";
$topbarTitle = "Tindakan Pusat";
require __DIR__ . '/includes/header.php';
?>
<div class="breadcrumb">Beranda &rsaquo; <b><?php echo htmlspecialchars($page['title']); ?></b></div>
<div class="page-head">
  <div>
    <h1><?php echo htmlspecialchars($page['title']); ?></h1>
    <p><?php echo htmlspecialchars($page['message']); ?></p>
  </div>
</div>

<div class="card" style="padding:22px;max-width:760px;">
  <div class="card-title" style="margin-bottom:14px;">Status Aksi</div>
  <p style="line-height:1.7;color:var(--text-700);margin-bottom:24px;">Jika Anda ingin melanjutkan, gunakan tombol kembali di bawah ini untuk kembali ke halaman terkait atau coba lagi setelah modul tersedia.</p>
  <a href="<?php echo htmlspecialchars($page['back']); ?>" class="btn btn-primary">Kembali ke Halaman Terkait</a>
</div>

<?php require __DIR__ . '/includes/footer.php';
