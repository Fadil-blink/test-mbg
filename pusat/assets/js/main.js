// ==========================================================================
// PAN MBG - main.js
// Inisialisasi ikon (Lucide) & grafik (Chart.js) untuk seluruh halaman
// ==========================================================================

document.addEventListener('DOMContentLoaded', function () {
  if (window.lucide) { lucide.createIcons(); }

  Chart.defaults.font.family = "Inter, sans-serif";
  Chart.defaults.color = "#64748b";

  var navy = "#0f1f3d";
  var blue = "#3b82f6";
  var lightBlue = "#bcd4fb";

  // ---------- Dashboard: Tren Transaksi Harian ----------
  var elTren = document.getElementById('trenTransaksiChart');
  if (elTren) {
    new Chart(elTren, {
      type: 'line',
      data: {
        labels: ['18 Jul', '19 Jul', '20 Jul', '21 Jul', '22 Jul', '23 Jul', '24 Jul'],
        datasets: [{
          data: [420, 610, 520, 380, 470, 980, 760],
          borderColor: blue,
          backgroundColor: 'rgba(59,130,246,0.08)',
          fill: true,
          tension: 0.45,
          borderWidth: 3,
          pointRadius: 0,
          pointHoverRadius: 5,
        }]
      },
      options: {
        plugins: { legend: { display: false } },
        scales: {
          x: { grid: { display: false } },
          y: { display: false }
        }
      }
    });
  }

  // ---------- Dashboard: Volume Komoditas Utama (donut) ----------
  var elVol = document.getElementById('volumeKomoditasChart');
  if (elVol) {
    new Chart(elVol, {
      type: 'doughnut',
      data: {
        labels: ['Beras', 'Telur', 'Ayam', 'Susu', 'Sayuran'],
        datasets: [{
          data: [35, 25, 20, 12, 8],
          backgroundColor: [navy, blue, '#7fb0f5', '#f5b95c', '#cbd5e1'],
          borderWidth: 0,
        }]
      },
      options: {
        cutout: '72%',
        plugins: { legend: { display: false } }
      }
    });
  }

  // ---------- Monitoring Komoditas: Distribusi Komoditas (donut) ----------
  var elDist = document.getElementById('distribusiKomoditasChart');
  if (elDist) {
    new Chart(elDist, {
      type: 'doughnut',
      data: {
        labels: ['Beras', 'Telur', 'Daging', 'Lainnya'],
        datasets: [{
          data: [42, 27, 13, 18],
          backgroundColor: [navy, blue, '#7fb0f5', '#dbe4ee'],
          borderWidth: 0,
        }]
      },
      options: {
        cutout: '72%',
        plugins: { legend: { display: false } }
      }
    });
  }

  // ---------- Monitoring Nasional: Tren Pengadaan Nasional ----------
  var elTrenNasional = document.getElementById('trenPengadaanChart');
  if (elTrenNasional) {
    new Chart(elTrenNasional, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
        datasets: [
          {
            label: 'Volume',
            data: [62, 74, 58, 50, 92, 88],
            borderColor: navy,
            backgroundColor: 'transparent',
            tension: 0.4,
            borderWidth: 3,
            pointRadius: 0,
          },
          {
            label: 'Target',
            data: [68, 68, 70, 70, 72, 74],
            borderColor: lightBlue,
            borderDash: [6, 5],
            backgroundColor: 'transparent',
            tension: 0.3,
            borderWidth: 2,
            pointRadius: 0,
          }
        ]
      },
      options: {
        plugins: { legend: { display: false } },
        scales: { x: { grid: { display: false } }, y: { display: false } }
      }
    });
  }

  // ---------- Monitoring Nasional: Nilai Pengadaan per Provinsi ----------
  var elProvinsi = document.getElementById('nilaiProvinsiChart');
  if (elProvinsi) {
    new Chart(elProvinsi, {
      type: 'bar',
      data: {
        labels: ['Jabar', 'Jatim', 'Jateng', 'Sumut', 'Susel', 'Banten', 'Lainnya'],
        datasets: [{
          data: [420, 385, 310, 245, 190, 150, 210],
          backgroundColor: blue,
          borderRadius: 6,
          maxBarThickness: 26,
        }]
      },
      options: {
        plugins: { legend: { display: false } },
        scales: { x: { grid: { display: false } }, y: { display: false } }
      }
    });
  }

  // ---------- Skor Risiko Nasional (ring statis via canvas) ----------
  var elSkor = document.getElementById('skorRisikoChart');
  if (elSkor) {
    new Chart(elSkor, {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [68, 32],
          backgroundColor: ['#d0342c', '#f6e2e2'],
          borderWidth: 0,
        }]
      },
      options: {
        cutout: '78%',
        rotation: -90,
        circumference: 360,
        plugins: { legend: { display: false }, tooltip: { enabled: false } }
      }
    });
  }
});
