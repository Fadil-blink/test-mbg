<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pendaftaran Supplier - MBG Nasional</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="reg-topbar">
  <div class="logo-mini"><span class="box"><i class="fa-solid fa-chart-line"></i></span> Sistem MBG Nasional</div>
  <div class="reg-nav">
    <a href="#">Beranda</a>
    <a href="#">Panduan</a>
    <a href="#">Layanan</a>
    <a href="#">Pusat Bantuan</a>
  </div>
  <div class="reg-topbar-icons">
    <i class="fa-regular fa-bell"></i>
    <i class="fa-regular fa-circle-question"></i>
    <a href="login.php" class="btn-nav">Daftar Sekarang</a>
  </div>
</div>

<div class="reg-body">

  <aside class="reg-sidebar">
    <h2>Registrasi Supplier</h2>
    <p class="sub">MBG Program Nasional</p>

    <a href="#data-usaha"><i class="fa-solid fa-building"></i> Data Usaha</a>
    <a href="#alamat"><i class="fa-solid fa-location-dot"></i> Alamat</a>
    <a href="#kontak"><i class="fa-solid fa-address-card"></i> Kontak</a>
    <a href="#bank"><i class="fa-solid fa-building-columns"></i> Bank</a>
    <a href="#komoditas"><i class="fa-solid fa-box"></i> Komoditas</a>
    <a href="#upload"><i class="fa-solid fa-file-arrow-up"></i> Upload</a>
    <a href="#account" class="active"><i class="fa-solid fa-user"></i> Account</a>

    <div class="reg-note">
      <i class="fa-solid fa-circle-info"></i>
      <span>Setelah pendaftaran berhasil, data akan diverifikasi oleh Auditor Pusat sebelum akun dapat digunakan.</span>
    </div>
  </aside>

  <main class="reg-content">
    <div class="reg-header">
      <div>
        <h1>Formulir Pendaftaran</h1>
        <p>Lengkapi data di bawah ini untuk bergabung sebagai mitra pengadaan nasional.</p>
      </div>
      <span class="status-pill">Status: Draft Registrasi</span>
    </div>

    <form action="#" method="post">

      <section class="form-section" id="data-usaha">
        <h3><i class="fa-solid fa-building"></i> Data Usaha</h3>
        <div class="form-grid">
          <div class="field">
            <label>Nama Usaha</label>
            <div class="input-wrap no-icon"><input type="text" placeholder="Masukkan nama usaha/kelompok"></div>
          </div>
          <div class="field">
            <label>Jenis Supplier</label>
            <div class="input-wrap no-icon">
              <select>
                <option>Pilih Jenis Supplier</option>
                <option>Kelompok Tani</option>
                <option>Koperasi</option>
                <option>UMKM</option>
                <option>Perusahaan</option>
              </select>
            </div>
          </div>
          <div class="field">
            <label>Nama Pemilik</label>
            <div class="input-wrap no-icon"><input type="text" placeholder="Nama sesuai KTP"></div>
          </div>
          <div class="field">
            <label>NIK</label>
            <div class="input-wrap no-icon"><input type="text" maxlength="16" placeholder="16 Digit Nomor Induk Kependudukan"></div>
          </div>
          <div class="field">
            <label>NIB</label>
            <div class="input-wrap no-icon"><input type="text" placeholder="Nomor Induk Berusaha"></div>
          </div>
          <div class="field">
            <label>NPWP (Opsional)</label>
            <div class="input-wrap no-icon"><input type="text" placeholder="Nomor Pokok Wajib Pajak"></div>
          </div>
        </div>
      </section>

      <section class="form-section" id="alamat">
        <h3><i class="fa-solid fa-location-dot"></i> Alamat</h3>
        <div class="form-grid">
          <div class="field">
            <label>Provinsi</label>
            <div class="input-wrap no-icon">
              <select><option>Pilih Provinsi</option><option>Jawa Timur</option><option>Jawa Barat</option><option>Jawa Tengah</option></select>
            </div>
          </div>
          <div class="field">
            <label>Kabupaten/Kota</label>
            <div class="input-wrap no-icon">
              <select><option>Pilih Kabupaten/Kota</option><option>Surabaya</option><option>Sidoarjo</option></select>
            </div>
          </div>
          <div class="field">
            <label>Kecamatan</label>
            <div class="input-wrap no-icon"><input type="text" placeholder="Masukkan nama kecamatan"></div>
          </div>
          <div class="field">
            <label>Desa/Kelurahan</label>
            <div class="input-wrap no-icon"><input type="text" placeholder="Masukkan nama desa"></div>
          </div>
        </div>
        <div class="field" style="margin-top:4px;">
          <label>Alamat Lengkap</label>
          <div class="input-wrap no-icon"><textarea rows="3" placeholder="Nama jalan, RT/RW, dan detail alamat lainnya"></textarea></div>
        </div>
      </section>

      <section class="form-section" id="kontak">
        <h3><i class="fa-solid fa-address-card"></i> Kontak</h3>
        <div class="form-grid">
          <div class="field">
            <label>Nomor Telepon</label>
            <div class="input-wrap no-icon"><input type="text" placeholder="+62 812 3456 7890"></div>
          </div>
          <div class="field">
            <label>Email</label>
            <div class="input-wrap no-icon"><input type="email" placeholder="nama@email.com"></div>
          </div>
        </div>
      </section>

      <section class="form-section" id="bank">
        <h3><i class="fa-solid fa-building-columns"></i> Informasi Bank</h3>
        <div class="form-grid" style="grid-template-columns:1fr 1fr 1fr;">
          <div class="field">
            <label>Nama Bank</label>
            <div class="input-wrap no-icon">
              <select><option>Pilih Bank</option><option>BRI</option><option>BNI</option><option>Mandiri</option><option>BCA</option></select>
            </div>
          </div>
          <div class="field">
            <label>Nomor Rekening</label>
            <div class="input-wrap no-icon"><input type="text" placeholder="Nomor rekening aktif"></div>
          </div>
          <div class="field">
            <label>Nama Pemilik Rekening</label>
            <div class="input-wrap no-icon"><input type="text" placeholder="Harus sesuai buku tabungan"></div>
          </div>
        </div>
      </section>

      <section class="form-section" id="komoditas">
        <h3><i class="fa-solid fa-box"></i> Komoditas</h3>
        <p style="font-size:13.5px;color:var(--text-muted);margin:-6px 0 16px 0;">Pilih komoditas yang Anda sediakan (Bisa pilih lebih dari satu):</p>
        <div class="chip-group">
          <div class="chip-option" data-chip><i class="fa-solid fa-wheat-awn"></i> Beras</div>
          <div class="chip-option" data-chip><i class="fa-solid fa-egg"></i> Telur</div>
          <div class="chip-option" data-chip><i class="fa-solid fa-drumstick-bite"></i> Ayam</div>
          <div class="chip-option" data-chip><i class="fa-solid fa-carrot"></i> Sayur</div>
          <div class="chip-option" data-chip><i class="fa-solid fa-apple-whole"></i> Buah</div>
          <div class="chip-option" data-chip><i class="fa-solid fa-glass-water"></i> Susu</div>
          <div class="chip-option" data-chip><i class="fa-solid fa-fish"></i> Ikan</div>
          <div class="chip-option" data-chip><i class="fa-solid fa-ellipsis"></i> Lainnya</div>
        </div>
      </section>

      <section class="form-section" id="upload">
        <h3><i class="fa-solid fa-file-arrow-up"></i> Upload Dokumen</h3>
        <div class="upload-grid">
          <label class="upload-box">
            <i class="fa-regular fa-image"></i>
            <div class="u-title">Upload Foto KTP</div>
            <div class="u-sub">Maksimal 2MB (JPG, PNG)</div>
            <input type="file" hidden>
          </label>
          <label class="upload-box">
            <i class="fa-solid fa-paperclip"></i>
            <div class="u-title">Upload Dokumen NIB</div>
            <div class="u-sub">Maksimal 5MB (PDF)</div>
            <input type="file" hidden>
          </label>
          <label class="upload-box">
            <i class="fa-solid fa-shop"></i>
            <div class="u-title">Upload Foto Usaha/Lahan</div>
            <div class="u-sub">Maksimal 5MB (JPG, PNG)</div>
            <input type="file" hidden>
          </label>
          <label class="upload-box">
            <i class="fa-regular fa-file-lines"></i>
            <div class="u-title">Dokumen Pendukung Lainnya</div>
            <div class="u-sub">Opsional (PDF, ZIP)</div>
            <input type="file" hidden>
          </label>
        </div>
      </section>

      <section class="form-section" id="account">
        <h3><i class="fa-solid fa-user"></i> Account Access</h3>
        <div class="form-grid">
          <div class="field">
            <label>Email Login</label>
            <div class="input-wrap no-icon"><input type="email" placeholder="Digunakan untuk login ke sistem"></div>
          </div>
        </div>
        <div class="form-grid" style="margin-top:4px;">
          <div class="field">
            <label>Kata Sandi</label>
            <div class="input-wrap no-icon"><input type="password" placeholder="Minimal 8 Karakter"></div>
          </div>
          <div class="field">
            <label>Konfirmasi Kata Sandi</label>
            <div class="input-wrap no-icon"><input type="password" placeholder="Ulangi kata sandi"></div>
          </div>
        </div>
      </section>

      <div class="agreement-box">
        <input type="checkbox" id="agree">
        <label for="agree">Saya menyatakan seluruh data yang diberikan benar dan bersedia mengikuti prosedur verifikasi yang ditetapkan oleh Badan Gizi Nasional - Republik Indonesia.</label>
      </div>

      <div class="reg-actions">
        <button type="submit" class="btn-submit">Daftar Supplier</button>
        <a href="login.php" class="btn-cancel" style="display:flex;align-items:center;justify-content:center;">Kembali ke Login</a>
      </div>

    </form>
  </main>
</div>

<div class="reg-footer">
  <div>
    <div class="f-brand">Badan Gizi Nasional</div>
    <div>© 2024 Badan Gizi Nasional - Republik Indonesia. Seluruh Hak Cipta Dilindungi.</div>
  </div>
  <div class="f-links">
    <a href="#">Kebijakan Privasi</a>
    <a href="#">Syarat &amp; Ketentuan</a>
    <a href="#">Kontak Kami</a>
    <a href="#">Aksesibilitas</a>
  </div>
</div>

<script>
document.querySelectorAll('[data-chip]').forEach(function(chip){
  chip.addEventListener('click', function(){ chip.classList.toggle('selected'); });
});
document.querySelectorAll('.upload-box input[type=file]').forEach(function(inp){
  inp.addEventListener('change', function(){
    if (inp.files.length){
      const box = inp.closest('.upload-box');
      box.querySelector('.u-sub').textContent = inp.files[0].name;
      box.style.borderColor = '#1d5fd6';
    }
  });
});
document.querySelectorAll('.reg-sidebar a').forEach(function(link){
  link.addEventListener('click', function(){
    document.querySelectorAll('.reg-sidebar a').forEach(function(a){ a.classList.remove('active'); });
    link.classList.add('active');
  });
});
</script>
</body>
</html>
