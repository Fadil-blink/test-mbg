<?php
$pageTitle = 'Profil SPPG';
$active = 'profil';
include 'includes/header.php';
?>
<div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Profil SPPG</b></div>
<h1 class="page-title">Profil SPPG</h1>
<p class="page-sub">Kelola informasi profil dan data operasional unit Satuan Pelayanan Gizi.</p>

<div class="profile-head">
  <div class="left">
    <div class="icon-box">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M4 21V10l8-6 8 6v11"/><path d="M9 21v-7h6v7"/></svg>
    </div>
    <div>
      <h2>SPPG Surabaya Barat <span class="badge-verified">TERVERIFIKASI</span></h2>
      <div class="id-unit">ID Unit: MBG-SPPG-SUB-001</div>
    </div>
  </div>
  <a href="#" class="btn btn-outline">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg>
    Edit Profil
  </a>
</div>

<div class="info-grid">
  <div class="panel">
    <h3 style="margin:0 0 20px 0;font-size:16.5px;color:var(--navy);">Informasi Umum</h3>
    <div class="info-list">
      <div><div class="lbl">Alamat</div><div class="val">Jl. Mayjen HR. Muhammad No. 12, Surabaya</div></div>
      <div><div class="lbl">Wilayah</div><div class="val">Jawa Timur</div></div>
      <div><div class="lbl">Penanggung Jawab</div><div class="val">Dr. Andi Wijaya</div></div>
      <div><div class="lbl">Email</div><div class="val">sppg.subarat@mbg.go.id</div></div>
      <div><div class="lbl">Nomor Telepon</div><div class="val">031-5550123</div></div>
    </div>
  </div>
  <div class="panel">
    <h3 style="margin:0 0 20px 0;font-size:16.5px;color:var(--navy);">Statistik Operasional</h3>
    <div class="stat-list">
      <div class="stat-row">
        <div class="circle-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l1.5-5h15L21 9"/><path d="M3 9v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/></svg></div>
        <div><div class="lbl">Jumlah Supplier</div><div class="val">24</div></div>
      </div>
      <div class="stat-row">
        <div class="circle-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h7.2a2 2 0 0 0 2-1.6L21 8H6"/></svg></div>
        <div><div class="lbl">Jumlah Pembelian</div><div class="val">1.240</div></div>
      </div>
      <div class="stat-row">
        <div class="circle-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg></div>
        <div><div class="lbl">Anggaran Tahunan</div><div class="val">Rp 5,4 Miliar</div></div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
