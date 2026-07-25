<?php $page_title = 'Analitik Penjualan'; include __DIR__ . '/includes/header.php'; ?>

<div class="page-header">
  <div>
    <h1>Analitik Penjualan</h1>
    <p>Analisis mendalam performa penjualan dan tren produk Anda.</p>
  </div>
</div>

<div class="stat-grid">
  <div class="stat-card">
    <div class="label">Total Pendapatan</div>
    <div class="value">Rp 145.820.000</div>
    <div class="delta">+8.4% vs bln lalu</div>
  </div>
  <div class="stat-card">
    <div class="label">Produk Terlaris</div>
    <div class="value" style="font-size:19px;">Beras Premium SLY</div>
    <div class="delta" style="color:var(--text-muted);">Volume: 4.200 Kg</div>
  </div>
  <div class="stat-card">
    <div class="label">Total Produk Terjual</div>
    <div class="value">12.450 unit</div>
    <div class="delta" style="color:var(--text-muted);">Target 92% tercapai</div>
  </div>
  <div class="stat-card">
    <div class="label">Pertumbuhan Penjualan</div>
    <div class="value">+15.2%</div>
    <div class="delta">Signifikan</div>
  </div>
</div>

<div class="grid-2">
  <div class="panel">
    <div class="panel-head"><h3>Grafik Penjualan Bulanan</h3></div>
    <div class="chart-box"><canvas id="chartBulanan"></canvas></div>
  </div>
  <div class="panel">
    <div class="panel-head"><h3>Distribusi Komoditas</h3></div>
    <div class="chart-box"><canvas id="chartDonut"></canvas></div>
  </div>
</div>

<div class="table-wrap">
  <div class="panel-head" style="padding:20px 22px 0 22px;"><h3>Top 5 Produk Berdasarkan Volume</h3></div>
  <table>
    <thead><tr><th>Nama Produk</th><th>Kategori</th><th>Jumlah Terjual</th><th>Total Nominal</th><th>Tren</th></tr></thead>
    <tbody>
      <?php
      $top = [
        ['Beras Premium SLY (5kg)','Beras','4.200 Unit','Rp 63.000.000','Trend Up','trend-up'],
        ['Telur Ayam Negeri (1kg)','Telur','2.850 Unit','Rp 34.200.000','Trend Up','trend-up'],
        ['Daging Sapi Lokal (500g)','Daging','1.200 Unit','Rp 21.600.000','Trend Flat','trend-flat'],
        ['Cabai Merah Keriting (250g)','Sayuran','1.050 Unit','Rp 12.600.000','Trend Up','trend-up'],
        ['Minyak Goreng Kita (1L)','Lainnya','980 Unit','Rp 14.420.000','Trend Down','trend-down'],
      ];
      foreach ($top as $t):
      ?>
      <tr>
        <td class="link"><?= $t[0] ?></td>
        <td><?= $t[1] ?></td>
        <td><?= $t[2] ?></td>
        <td><b><?= $t[3] ?></b></td>
        <td><span class="<?= $t[5] ?>"><?= $t[4] ?></span></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
new Chart(document.getElementById('chartBulanan'), {
  type: 'bar',
  data: {
    labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
    datasets: [{ data: [18,22,19,26,24,30], backgroundColor:'#0f2a4a', borderRadius:6 }]
  },
  options: { plugins:{legend:{display:false}}, scales:{y:{display:false},x:{grid:{display:false}}} }
});
new Chart(document.getElementById('chartDonut'), {
  type: 'doughnut',
  data: {
    labels: ['Beras 45%','Telur 25%','Daging 20%','Sayur 10%'],
    datasets: [{ data:[45,25,20,10], backgroundColor:['#0f2a4a','#2563eb','#60a5fa','#bfdbfe'] }]
  },
  options: { plugins:{legend:{position:'bottom'}} }
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
