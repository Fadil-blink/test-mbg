<?php $page_title = 'Beranda'; include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Ringkasan Operasional</h1>
    <p>Selamat datang kembali, CV. Tani Sejahtera. Berikut performa hari ini.</p>
  </div>
  <button class="btn"><i class="fa-solid fa-plus"></i> Tambah Produk</button>
</div>

<div class="stat-grid">
  <div class="stat-card">
    <div class="label">Pesanan Hari Ini <i class="fa-regular fa-calendar"></i></div>
    <div class="value">12</div>
  </div>
  <div class="stat-card">
    <div class="label">Pendapatan Bulan Ini <i class="fa-solid fa-money-check-alt"></i></div>
    <div class="value">Rp 45,8 Juta</div>
    <div class="delta"><i class="fa-solid fa-arrow-trend-up"></i> +15% dari bln lalu</div>
  </div>
  <div class="stat-card">
    <div class="label">Produk Aktif <i class="fa-solid fa-box-archive"></i></div>
    <div class="value">24</div>
  </div>
  <div class="stat-card">
    <div class="label">SPPG Dilayani <i class="fa-solid fa-diagram-project"></i></div>
    <div class="value">5 Unit</div>
  </div>
  <div class="stat-card warn">
    <div class="label">Butuh Konfirmasi <i class="fa-solid fa-triangle-exclamation"></i></div>
    <div class="value">3</div>
  </div>
</div>

<div class="grid-3">
  <div class="panel">
    <div class="panel-head">
      <h3>Tren Pendapatan</h3>
      <span class="select-fake">7 Hari Terakhir <i class="fa-solid fa-chevron-down"></i></span>
    </div>
    <div class="chart-box"><canvas id="chartTren"></canvas></div>
  </div>
  <div class="panel">
    <div class="panel-head">
      <h3>Volume Pesanan</h3>
      <i class="fa-regular fa-circle-question"></i>
    </div>
    <div class="chart-box"><canvas id="chartVolume"></canvas></div>
    <p style="text-align:center;color:var(--text-muted);font-size:13.5px;margin-top:8px;">Total: 428 pesanan terselesaikan</p>
  </div>
  <div class="panel">
    <div class="panel-head">
      <h3>Notifikasi Terbaru</h3>
      <a href="notifikasi.php" class="link">Lihat Semua</a>
    </div>
    <?php
    $notifs = [
      ['fa-cart-shopping','blue','Pesanan baru dari SPPG Surabaya','2 menit yang lalu'],
      ['fa-circle-check','green','Pembayaran diterima #ORD-8921','45 menit yang lalu'],
      ['fa-triangle-exclamation','red','Stok Beras Medium menipis','2 jam yang lalu'],
      ['fa-truck','navy','Kurir telah mengambil pesanan','3 jam yang lalu'],
    ];
    foreach ($notifs as $n):
    ?>
    <div style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);">
      <div class="notif-icon" style="background:#eef2f7;color:var(--navy);"><i class="fa-solid <?= $n[0] ?>"></i></div>
      <div>
        <div style="font-size:13.5px;font-weight:600;color:var(--navy);"><?= $n[2] ?></div>
        <div style="font-size:12.5px;color:var(--text-muted);"><?= $n[3] ?></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="table-wrap">
  <div class="panel-head" style="padding:20px 22px 0 22px;">
    <h3>Pesanan Terbaru</h3>
    <div style="display:flex;gap:10px;">
      <button class="btn outline small"><i class="fa-solid fa-download"></i> Unduh Laporan (CSV)</button>
      <button class="btn small">Lihat Semua</button>
    </div>
  </div>
  <table>
    <thead>
      <tr><th>ID Pesanan</th><th>Nama SPPG</th><th>Komoditas</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php
      $orders = [
        ['#ORD-9021','SPPG Surabaya Barat','Beras Medium (500kg)','Rp 6.250.000','Menunggu','red'],
        ['#ORD-9018','SPPG Sidoarjo Utara','Jagung Pipil (1000kg)','Rp 4.500.000','Diproses','blue'],
        ['#ORD-9015','SPPG Gresik Kota','Kedelai Impor (200kg)','Rp 2.800.000','Dikirim','amber'],
        ['#ORD-8992','SPPG Malang Raya','Pupuk NPK (50 sak)','Rp 12.000.000','Selesai','green'],
      ];
      foreach ($orders as $o):
      ?>
      <tr>
        <td class="link"><?= $o[0] ?></td>
        <td><?= $o[1] ?></td>
        <td><?= $o[2] ?></td>
        <td><b><?= $o[3] ?></b></td>
        <td><span class="badge <?= $o[5] ?>"><?= $o[4] ?></span></td>
        <td class="link">Detail</td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
new Chart(document.getElementById('chartTren'), {
  type: 'bar',
  data: {
    labels: ['Sen','Sel','Rab','Kam','Jum','Sab','Min'],
    datasets: [{ data: [35,42,38,48,45,58,52], backgroundColor: '#0f2a4a', borderRadius: 6, barThickness: 26 }]
  },
  options: { plugins:{legend:{display:false}}, scales:{y:{display:false,beginAtZero:true},x:{grid:{display:false}}} }
});
new Chart(document.getElementById('chartVolume'), {
  type: 'line',
  data: {
    labels: ['1','2','3','4','5','6','7'],
    datasets: [{ data: [30,55,40,35,50,70,90], borderColor:'#2563eb', backgroundColor:'rgba(37,99,235,0.08)', fill:true, tension:0.4, pointRadius:0 }]
  },
  options: { plugins:{legend:{display:false}}, scales:{y:{display:false},x:{display:false}} }
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
