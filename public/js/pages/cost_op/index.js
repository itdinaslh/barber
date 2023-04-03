$('.tgl').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
});
$(document).on('submit', '#formreports', function(e) {
    e.preventDefault();
    var first = $('#TglAwal').val();
    var end = $('#TglAkhir').val();

    $('.transhid').show();
    loadTable(first, end);
    GetSum(first, end);
});
$(document).on('shown.bs.modal', '.modal', function() {
    $('.tgl').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    $(this).find('[autofocus]').focus();
    $('#Price').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    $('#PriceBulk').autoNumeric('init', { currencySymbol:'', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
});

$('#cost_op').dataTable({
    responsive: true,
    lengthMenu:[5,10,15,20],
    autoWidth:false,
    serverSide:true,
    processing:true,
    ajax: '/cost_op/ajaxdata',
    columns: [
        {data:'id', name:'c.id'},
        {data:'Tanggal', name:'c.Tanggal'},
        {data:'NamaOp', name:'o.NamaOp'},
        {data:'fPrice', name:'fPrice'},
        {data:'Qty', name:'c.Qty'},
        {data:'fTotal', name:'fTotal'},
        {data:'Ket', name:'c.Ket'},
        {data:'action', name:'action', searchable:false, orderable: false}
    ]
});
$(document).on('keyup', '#Price', function() {
    $(this).autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    var price = $(this).autoNumeric('get');

    $('#rPrice').val(price);
});
$(document).on('keyup', '#PriceBulk', function() {
    $(this).autoNumeric('init', { currencySymbol:'', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    var price = $(this).autoNumeric('get');

    $('#rPriceBulk').val(price);
});

function loadTable(tglawal, tglakhir) {
    $('#trans').DataTable().destroy();

    $('#trans').DataTable({
        responsive:true,
        serverSide:true,
        processing:true,
        autoWidth:false,
        lengthMenu:[5,10,15],
        ajax: '/reports/ajaxpengeluaran/' + tglawal + '/' + tglakhir,
        columns: [
            {data:'Tanggal', name:'c.Tanggal'},
            {data:'NamaOp', name:'o.NamaOp'},
            {data:'fPrice', name:'fPrice'},
            {data:'Qty', name:'c.Qty'},
            {data:'fTotal', name:'fTotal'},
            {data:'Ket', name:'c.Ket'},
        ]
    });
}

function GetSum(tglawal, tglakhir) {
    $.ajax({
        type:'GET',
        url:'/reports/getsumcost/' + tglawal + '/' + tglakhir,
        success: function(result) {
            $('#SumTotalTrx').html('Rp. ' + result.SumTrx);
            $('#SumTotalPaid').html('Rp. ' + result.SumTotal);
            $('#result').html('Rp. ' + result.result);
        }
    });
}


