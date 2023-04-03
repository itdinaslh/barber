$(document).on('shown.bs.modal', '.modal', function() {
    $(this).find('[autofocus]').focus();
});
$('#product').dataTable({
    responsive: true,
    lengthMenu:[5,10,15,20],
    autoWidth:false
});
