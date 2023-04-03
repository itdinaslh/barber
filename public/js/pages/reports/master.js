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
        ajax: '/reports/ajaxmaster/' + tglawal + '/' + tglakhir,
        columns: [
            {data:'fTgl', name:'fTgl', orderable:false, searchable: false},
            {data:'TrxID', name:'TrxID'},
            {data:'fTotalTrx', name:'fTotalTrx', orderable:false, searchable:false},
            {data:'DiscountID', name:'DiscountID'},
            {data:'fDiscount', name:'fDiscount', orderable:false, searchable:false},
            {data:'VoucherID', name:'VoucherID'},
            {data:'fVoucherVal', name:'fVoucherVal', orderable:false, searchable:false},
            {data:'PayMethod', name:'PayMethod'},
            {data:'fTotalPaid', name:'fTotalPaid', orderable:false, searchable:false}
        ]
    });
}

function GetSum(tglawal, tglakhir) {
    $.ajax({
        type:'GET',
        url:'/reports/getsum/' + tglawal + '/' + tglakhir,
        success: function(result) {
            $('#SumTotalTrx').html('Rp. ' + result.SumTrx);
            $('#SumDiscount').html('Rp. ' + result.SumDiscount);
            $('#SumVoucher').html('Rp. ' + result.SumVoucher);
            $('#SumTotalPaid').html('Rp. ' + result.SumTotal);
        }
    });
}

function pivotShow(tglawal, tglakhir) {
    var derivers = $.pivotUtilities.derivers;

    $.getJSON("/reports/ajaxpivottrans/" + tglawal + '/' + tglakhir, function(data) {
        $("#pivot").pivotUI(data, {
            rows: ["Tanggal"],
            cols: ["Service"],
            vals: ["TpS"],
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

    awal = $('#TglAwal').val();
    akhir = $('#TglAkhir').val();

    downloadExcelBbs(awal, akhir);
});

$(document).on('submit', '#formpdf', function(e) {
    e.preventDefault();

    awal = $('#TglAwal').val();
    akhir = $('#TglAkhir').val();

    downloadPdfBbs(awal, akhir);
});

$(document).on('submit', '#formprint', function(e) {
    e.preventDefault();

    awal = $('#TglAwal').val();
    akhir = $('#TglAkhir').val();

    printLapTrans(awal, akhir);
});

function printLapTrans(tglawal, tglakhir) {
    var win = window.open('/reports/printlaptrans/' + tglawal + '/' + tglakhir, '_blank');

    if (win) {
        win.focus();
    } else {
        alert('Please allow popup for this application');
    }
}

function downloadExcelBbs(tglawal, tglakhir) {
    var win = window.open('/reports/bbsexcel/' + tglawal + '/' + tglakhir, '_blank');

    if (win) {
        win.focus();
    } else {
        alert('Please allow popup for this application');
    }
}

function downloadPdfBbs(tglawal, tglakhir) {
    var win = window.open('/reports/bbspdf/' + tglawal + '/' + tglakhir, '_blank');

    if (win) {
        win.focus();
    } else {
        alert('Please allow popup for this application');
    }
}
