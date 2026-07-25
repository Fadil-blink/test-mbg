<?php $page_title = 'Pendapatan'; include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Dashboard Pendapatan</h1>
    <p>Pantau performa keuangan dan rincian transaksi penjualan Anda.</p>
  </div>
</div>

<div class="stat-grid">
  <div class="stat-card"><div class="label">Total Pendapatan</div><div class="value">Rp 125.500.000</div></div>
  <div class="stat-card"><div class="label">Pendapatan Bulan Ini <span class="badge green">+12%</span></div><div class="value">Rp 42.200.000</div></div>
  <div class="stat-card"><div class="label">Pesanan Selesai</div><div class="value">148 Pesanan</div></div>
  <div class="stat-card dark">
    <div class="label">Saldo Tersedia <span class="btn small" style="background:rgba(255,255,255,.15);">Tarik Dana</span></div>
    <div class="value">Rp 15.800.000</div>
  </div>
</div>

<div class="grid-2">
  <div class="panel">
    <div class="panel-head">
      <h3>Grafik Pendapatan 7 Hari Terakhir</h3>
      <span class="select-fake">Minggu Ini <i class="fa-solid fa-chevron-down"></i></span>
    </div>
    <div class="chart-box"><canvas id="chartPendapatan"></canvas></div>
  </div>
  <div class="panel">
    <div class="panel-head"><h3>Ringkasan Penjualan</h3></div>
    <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border);"><span>Sayuran</span><b>Rp 18.500.000</b></div>
    <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border);"><span>Buah-buahan</span><b>Rp 12.200.000</b></div>
    <div style="display:flex;justify-content:space-between;padding:12px 0;"><span>Lainnya</span><b>Rp 11.500.000</b></div>
  </div>
</div>

<div class="table-wrap">
  <div class="panel-head" style="padding:20px 22px 0 22px;">
    <h3>Transaksi Terakhir</h3>
    <a href="#" class="link">Lihat Semua</a>
  </div>
  <table>
    <thead><tr><th>ID Transaksi</th><th>Tanggal</th><th>SPPG Tujuan</th><th>Nominal</th><th>Status</th></tr></thead>
    <tbody>
      <tr><td class="link">#TRX-99281</td><td>14 Okt 2024</td><td>SPPG Surabaya Barat</td><td><b>Rp 4.250.000</b></td><td><span class="badge green">Berhasil</span></td></tr>
      <tr><td class="link">#TRX-99280</td><td>14 Okt 2024</td><td>SPPG Sidoarjo</td><td><b>Rp 2.100.000</b></td><td><span class="badge blue">Diproses</span></td></tr>
      <tr><td class="link">#TRX-99279</td><td>13 Okt 2024</td><td>SPPG Surabaya Timur</td><td><b>Rp 8.400.000</b></td><td><span class="badge green">Berhasil</span></td></tr>
    </tbody>
  </table>
</div>

<script>
new Chart(document.getElementById('chartPendapatan'), {
  type: 'line',
  data: {
    labels: ['Sen','Sel','Rab','Kam','Jum','Sab','Min'],
    datasets: [{ data: [4.2,5.1,3.8,6.2,7.0,8.5,6.9], borderColor:'#0f2a4a', backgroundColor:'rgba(15,42,74,0.08)', fill:true, tension:0.4, pointRadius:3 }]
  },
  options: { plugins:{legend:{display:false}}, scales:{y:{ticks:{callback:v=>'Rp '+v+'jt'}},x:{grid:{display:false}}} }
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
