document.addEventListener('DOMContentLoaded', function () {
  // Tab click toggling (visual only – content is static demo data)
  document.querySelectorAll('.tabs a').forEach(function (tab) {
    tab.addEventListener('click', function (e) {
      e.preventDefault();
      var siblings = tab.parentElement.querySelectorAll('a');
      siblings.forEach(function (s) { s.classList.remove('active'); });
      tab.classList.add('active');
    });
  });

  // Simple client-side table filter for any .toolbar .search-input input
  document.querySelectorAll('.toolbar .search-input input, .search-box input').forEach(function (input) {
    input.addEventListener('keyup', function () {
      var term = input.value.toLowerCase();
      var table = document.querySelector('.table-wrap table');
      if (!table) return;
      table.querySelectorAll('tbody tr').forEach(function (row) {
        row.style.display = row.textContent.toLowerCase().indexOf(term) > -1 ? '' : 'none';
      });
    });
  });
});
