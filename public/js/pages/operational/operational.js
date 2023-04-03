$(document).on('shown.bs.modal', '.modal', function() {
    $(this).find('[autofocus]').focus();
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    $("[data-mask]").inputmask();
    $('#Price').autoNumeric('init', { currencySymbol:'', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    $('#PriceBulk').autoNumeric('init', { currencySymbol:'', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
});
$('#operational').dataTable({
    responsive: true,
    lengthMenu:[5,10,15,20],
    autoWidth:false,
    serverSide:true,
    processing:true,
    ajax: '/operational/ajaxdata',
    columns: [
        {data:'id', name:'id'},
        {data:'NamaOp', name:'NamaOp'},
        {data:'action', name:'action', searchable:false, orderable: false}
    ]
});
$(document).on('keyup', '#Price', function() {
    $(this).autoNumeric('init', { currencySymbol:'', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    var price = $(this).autoNumeric('get');

    $('#rPrice').val(price);
});
$(document).on('keyup', '#PriceBulk', function() {
    $(this).autoNumeric('init', { currencySymbol:'', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    var price = $(this).autoNumeric('get');

    $('#rPriceBulk').val(price);
});
