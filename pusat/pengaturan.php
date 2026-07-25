<?php
require __DIR__ . '/config.php';
$pageTitle = "Pengaturan";
$topbarTitle = "Manajemen Pengguna";
require __DIR__ . '/includes/header.php';
?>

<div class="breadcrumb">Beranda &rsaquo; <b>Pengaturan</b></div>
<div class="page-head">
  <div>
    <h1>Pengaturan Sistem</h1>
    <p>Konfigurasi parameter operasional dan keamanan sistem audit nasional.</p>
  </div>
</div>

<div class="grid grid-2 mb-24">
  <div class="card">
    <div class="card-title" style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
      <i data-lucide="landmark" style="width:17px;height:17px;"></i>Profil Instansi
    </div>
    <div class="grid" style="grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
      <div class="field"><label>Nama Instansi</label><input class="input" value="Pusat Audit Nasional MBG"></div>
      <div class="field"><label>Kontak Utama</label><input class="input" value="admin@panmbg.go.id"></div>
    </div>
    <div class="field mb-20">
      <label>Alamat Kantor Pusat</label>
      <textarea class="textarea">Jl. Merdeka No. 10, Jakarta Pusat, DKI Jakarta</textarea>
    </div>
    <div class="field">
      <label>Logo Instansi</label>
      <div class="upload-box">
        <div class="upload-icon"><i data-lucide="image"></i></div>
        <div style="flex:1;">
          <div style="font-weight:600;font-size:13.5px;">PNG atau JPG max. 5MB (Rekomendasi 512&times;512px)</div>
        </div>
        <button class="btn btn-outline btn-sm">Pilih File</button>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-title" style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
      <i data-lucide="palette" style="width:17px;height:17px;"></i>Tema
    </div>
    <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:18px;">
      <div class="radio-row selected">
        <span class="radio-swatch" style="background:var(--navy-900);"></span>
        <span style="flex:1;font-weight:600;">Default Blue (Aktif)</span>
        <span class="check-circle"><i data-lucide="check"></i></span>
      </div>
      <div class="radio-row">
        <span class="radio-swatch" style="background:#1a1a1a;"></span>
        <span style="flex:1;font-weight:600;">Dark Mode</span>
        <span class="radio-dot"></span>
      </div>
      <div class="radio-row">
        <span class="radio-swatch" style="background:#f4c20d;"></span>
        <span style="flex:1;font-weight:600;">High Contrast</span>
        <span class="radio-dot"></span>
      </div>
    </div>
    <div style="background:var(--blue-50);border-radius:10px;padding:14px;font-size:12.5px;color:#3a5a8a;font-style:italic;">
      "Tema sistem akan diterapkan secara global untuk seluruh pengguna dalam instansi Anda."
    </div>
  </div>
</div>

<div style="display:flex;justify-content:flex-end;gap:12px;margin-bottom:24px;">
  <button class="btn btn-outline">Batalkan Perubahan</button>
  <button class="btn btn-primary">Simpan Konfigurasi</button>
</div>

<div class="grid grid-2">
  <div class="card">
    <div class="card-title" style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
      <i data-lucide="settings" style="width:17px;height:17px;"></i>Pengaturan Umum
    </div>
    <div class="field mb-20">
      <label>Zona Waktu (Timezone)</label>
      <div class="dropdown" style="justify-content:space-between;">(GMT+07:00) Jakarta, Bangkok<i data-lucide="chevron-down"></i></div>
    </div>
    <div class="field mb-20">
      <label>Format Tanggal</label>
      <div style="display:flex;gap:20px;">
        <label style="display:flex;align-items:center;gap:8px;font-weight:500;"><span class="radio-dot on"></span>DD/MM/YYYY</label>
        <label style="display:flex;align-items:center;gap:8px;font-weight:500;"><span class="radio-dot"></span>YYYY-MM-DD</label>
      </div>
    </div>
    <div class="field">
      <label>Bahasa Utama</label>
      <div class="dropdown" style="justify-content:space-between;">Bahasa Indonesia<i data-lucide="chevron-down"></i></div>
    </div>
  </div>

  <div class="card">
    <div class="card-title" style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
      <i data-lucide="shield" style="width:17px;height:17px;"></i>Keamanan &amp; Akses
    </div>
    <div style="display:flex;justify-content:space-between;align-items:center;padding:14px;border:1px solid var(--border);border-radius:10px;margin-bottom:14px;">
      <div>
        <div style="font-weight:700;font-size:13.5px;">Two-Factor Authentication (2FA)</div>
        <div class="cell-sub">Wajibkan verifikasi tambahan saat login.</div>
      </div>
      <div class="toggle"></div>
    </div>
    <div style="display:flex;justify-content:space-between;align-items:center;padding:14px;border:1px solid var(--border);border-radius:10px;margin-bottom:18px;">
      <div>
        <div style="font-weight:700;font-size:13.5px;">Session Timeout</div>
        <div class="cell-sub">Otomatis logout setelah tidak aktif.</div>
      </div>
      <div class="dropdown">15 Menit<i data-lucide="chevron-down"></i></div>
    </div>
    <button class="btn btn-danger-outline" style="width:100%;justify-content:center;"><i data-lucide="rotate-ccw"></i>Paksa Reset Semua Password</button>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
