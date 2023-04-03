$('.tgl').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
});

function loadTable(tglawal, tglakhir) {
    $('#trans').DataTable().destroy();

    $('#trans').DataTable({
        responsive:true,
        serverSide:true,
        processing:true,
        autoWidth:false,
        lengthMenu:[5,10,15],
        ajax: '/reports/cafe/ajaxcafe/' + tglawal + '/' + tglakhir,
        columns: [
            {data:'fTgl', name:'fTgl', orderable:false, searchable: false},
            {data:'id', name:'id'},
            {data:'payment', name:'payment'},
            {data:'fTotalTrx', name:'fTotalTrx', orderable:false, searchable:false},
            {data:'fDiscount', name:'fDiscount', orderable:false, searchable:false},
            {data:'fGrand', name:'fGrand', orderable:false, searchable:false}
        ]
    });
}

function GetSum(tglawal, tglakhir) {
    $.ajax({
        type:'GET',
        url:'/reports/cafe/getsum/' + tglawal + '/' + tglakhir,
        success: function(result) {
            $('#SumTotalTrx').html('Rp. ' + result.SumTrx);
            $('#SumDiscount').html('Rp ' + result.SumDiscount);
            $('#GrandTotal').html('Rp ' + result.GrandTotal);
        }
    });
}

function pivotShow(tglawal, tglakhir) {
    var derivers = $.pivotUtilities.derivers;

    $.getJSON("/reports/cafe/cafepivottrans/" + tglawal + '/' + tglakhir, function(data) {
        $("#pivot").pivotUI(data, {
            rows: ["Tanggal"],
            vals: ["Total"],
            aggregatorName: "Sum",
            rendererName : "Heatmap"
        });
    });
}

$(document).on('submit', '#formreports', function(e) {
    e.preventDefault();
    var first = $('#TglAwal').val();
    var end = $('#TglAkhir').val();

    $('.transhid').show();
    loadTable(first, end);
    GetSum(first, end);
    pivotShow(first, end);
});

$(document).on('submit', '#formexcel', function(e) {
    e.preventDefault();

    var first = $('#TglAwal').val();
    var end = $('#TglAkhir').val();

    downloadExcel(first, end);
});

$(document).on('submit', '#formpdf', function(e) {
    e.preventDefault();

    var first = $('#TglAwal').val();
    var end = $('#TglAkhir').val();

    downloadPdf(first, end);
});

$(document).on('submit', '#formprint', function(e) {
    e.preventDefault();

    var first = $('#TglAwal').val();
    var end = $('#TglAkhir').val();

    printLapTrans(first, end);
});

function printLapTrans(tglawal, tglakhir) {
    var win = window.open('/reports/cafe/printlaptrans/' + tglawal + '/' + tglakhir, '_blank');

    if (win) {
        win.focus();
    } else {
        alert('Please allow popup for this application');
    }
}

function downloadExcel(tglawal, tglakhir) {
    var win = window.open('/reports/cafe/exportexcel/' + tglawal + '/' + tglakhir, '_blank');

    if (win) {
        win.focus();
    } else {
        alert('Please allow popup for this application');
    }
}

function downloadPdf(tglawal, tglakhir) {
    var win = window.open('/reports/cafe/exportpdf/' + tglawal + '/' + tglakhir, '_blank');

    if (win) {
        win.focus();
    } else {
        alert('Please allow popup for this application');
    }
}
