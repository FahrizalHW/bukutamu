(function ($) {
  'use strict';

  const tableElement = document.getElementById('visitor-table');
  if (!tableElement || !$.fn.DataTable) {
    return;
  }

  const filters = {
    month: document.getElementById('bulan'),
    start: document.getElementById('tanggal_mulai'),
    end: document.getElementById('tanggal_selesai')
  };

  const table = $(tableElement).DataTable({
    processing: true,
    serverSide: true,
    pageLength: 25,
    lengthMenu: [10, 25, 50, 100],
    order: [[1, 'desc']],
    ajax: {
      url: tableElement.dataset.source,
      data: function (data) {
        data.bulan = filters.month.value;
        data.tanggal_mulai = filters.start.value;
        data.tanggal_selesai = filters.end.value;
      }
    },
    columns: [
      { data: 'pengunjung', name: 'nama_tamu' },
      { data: 'tanggal', name: 'tanggal' },
      { data: 'asal', name: 'asal' },
      { data: 'tujuan', name: 'tujuan' },
      { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
    ],
    language: {
      processing: 'Memuat data...',
      search: 'Cari:',
      lengthMenu: 'Tampilkan _MENU_ data',
      info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
      infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
      infoFiltered: '(disaring dari _MAX_ data)',
      zeroRecords: 'Data kunjungan tidak ditemukan',
      emptyTable: 'Belum ada data kunjungan',
      paginate: {
        first: 'Pertama',
        previous: 'Sebelumnya',
        next: 'Berikutnya',
        last: 'Terakhir'
      }
    },
    drawCallback: updateExportLinks
  });

  function activeParams() {
    const params = new URLSearchParams();
    const search = table.search();

    if (filters.month.value) {
      params.set('bulan', filters.month.value);
    } else {
      if (filters.start.value) params.set('tanggal_mulai', filters.start.value);
      if (filters.end.value) params.set('tanggal_selesai', filters.end.value);
    }

    if (search) params.set('search', search);
    return params;
  }

  function updateExportLinks() {
    const params = activeParams().toString();
    ['excel', 'pdf'].forEach(function (format) {
      const link = document.getElementById('export-' + format);
      link.href = link.dataset.baseUrl || link.href.split('?')[0];
      link.dataset.baseUrl = link.href;
      if (params) link.href += '?' + params;
    });
  }

  filters.month.addEventListener('change', function () {
    if (this.value) {
      filters.start.value = '';
      filters.end.value = '';
    }
  });

  [filters.start, filters.end].forEach(function (input) {
    input.addEventListener('change', function () {
      if (this.value) filters.month.value = '';
    });
  });

  document.getElementById('rekap-filters').addEventListener('submit', function (event) {
    event.preventDefault();
    table.ajax.reload();
  });

  document.getElementById('reset-filters').addEventListener('click', function () {
    filters.month.value = '';
    filters.start.value = '';
    filters.end.value = '';
    table.search('').ajax.reload();
  });

  $(tableElement).on('search.dt', updateExportLinks);

  $(tableElement).on('submit', '.delete-visit-form', function (event) {
    const name = this.dataset.name || 'ini';
    if (!window.confirm('Hapus data kunjungan ' + name + '?')) {
      event.preventDefault();
    }
  });
})(jQuery);