$(document).ready(function() {
    $('#barberman').prop('selectedIndex', -1);
    $('#bbman').prop('selectedIndex', -1);
});

$('.tgl').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
});

$('#formlapbbman').on('submit', function(e) {
    e.preventDefault();

    var tglawal = $('#TglAwal').val();
    var tglakhir = $('#TglAkhir').val();
    var id = $('#barberman').val();

    lapprint(tglawal, tglakhir, id);
});

$('#formlapmanager').on('submit', function(e) {
    e.preventDefault();

    var tglawal = $('#tAwal').val();
    var tglakhir = $('#tAkhir').val();
    var id = $('#bbman').val();

    lapprintmanager(tglawal, tglakhir, id);
});

$('#CashierDaily').on('submit', function(e) {
    e.preventDefault();

    var tgl = $('#Tanggal').val();

    var id = $('#barberman').val();

    cashierbbdailyprint(tgl, tgl, id);
});

$('#formlaprecap').on('submit', function(e) {
    e.preventDefault();

    var tglawal = $('#TglAwal').val();
    var tglakhir = $('#TglAkhir').val();

    laprecap(tglawal, tglakhir);
});

function lapprint(tglawal, tglakhir, id) {
    var win = window.open('/reports/lapbbman/' + tglawal + '/' + tglakhir + '/' + id, '_blank');

    if (win) {
        win.focus();
        location.reload();
    } else {
        alert('Please allow popup for this application');
    }
}

function lapprintmanager(tglawal, tglakhir, id) {
    var win = window.open('/reports/lapbbmanager/' + tglawal + '/' + tglakhir + '/' + id, '_blank');

    if (win) {
        win.focus();
        location.reload();
    } else {
        alert('Please allow popup for this application');
    }
}

function cashierbbdailyprint(tglawal, tglakhir, id) {
    var win = window.open('/reports/cashier/lapbbman/' + tglawal + '/' + tglakhir + '/' + id, '_blank');

    if (win) {
        win.focus();
        location.reload();
    } else {
        alert('Please allow popup for this application');
    }
}

function laprecap(tglawal, tglakhir) {
  var win = window.open('/reports/laprecap/' + tglawal + '/' + tglakhir, '_blank');

  if (win) {
      win.focus();
      location.reload();
  } else {
      alert('Please allow popup for this application');
  }
}
