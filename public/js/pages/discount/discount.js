$(document).on('shown.bs.modal', '.modal', function() {
    $(this).find('[autofocus]').focus();
    $('.tgl').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    $('#Price').autoNumeric('init', { currencySymbol:'', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    $('#PriceBulk').autoNumeric('init', { currencySymbol:'', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
});
$('#discounts').dataTable({
    responsive: true,
    lengthMenu:[5,10,15,20],
    autoWidth:false,
    serverSide:true,
    processing:true,
    ajax: '/discounts/ajaxdata',
    columns: [
        {data:'DiscountID', name:'DiscountID'},
        {data:'IsPrice', name:'IsPrice'},
        {data:'fPrice', name:'fPrice'},
        {data:'fValidUntil', name:'fValidUntil'},
        {data:'IsValid', name:'IsValid'},
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
