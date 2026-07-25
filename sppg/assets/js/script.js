// SPPG Dashboard - basic front-end interactivity
document.addEventListener('DOMContentLoaded', function () {

  // Tabs (Pesanan Saya, Notifikasi)
  document.querySelectorAll('.tabs, .notif-tabs').forEach(function (tabGroup) {
    tabGroup.querySelectorAll('a').forEach(function (tab) {
      tab.addEventListener('click', function (e) {
        e.preventDefault();
        tabGroup.querySelectorAll('a').forEach(function (t) { t.classList.remove('active'); });
        tab.classList.add('active');
      });
    });
  });

  // "Tambah ke Keranjang" buttons -> simple feedback
  document.querySelectorAll('.add-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var original = btn.innerHTML;
      btn.innerHTML = '<span>✓ Ditambahkan</span>';
      btn.style.background = '#16a34a';
      setTimeout(function () {
        btn.innerHTML = original;
        btn.style.background = '';
      }, 1200);
    });
  });

  // Cart counter (client-side demo only)
  var cartCountEl = document.querySelector('.cart-count');
  var cartCount = 3;
  document.querySelectorAll('.add-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      cartCount++;
      if (cartCountEl) cartCountEl.textContent = cartCount;
    });
  });

  // "Tandai Semua Telah Dibaca" -> visually mark unread dots as read
  var markAllBtn = document.querySelector('.mark-all-read');
  if (markAllBtn) {
    markAllBtn.addEventListener('click', function () {
      document.querySelectorAll('.notif-page-item .unread-dot').forEach(function (d) {
        d.style.display = 'none';
      });
    });
  }

  // Confirm buttons on Penerimaan Barang (demo confirmation)
  document.querySelectorAll('.confirm-receive').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      alert('Barang telah dikonfirmasi diterima.');
    });
  });
  document.querySelectorAll('.report-issue').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      alert('Silakan lengkapi formulir laporan masalah (fitur demo).');
    });
  });

});
