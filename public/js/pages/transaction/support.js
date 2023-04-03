$(document).on('shown.bs.modal', '.modal', function() {
    $(this).find('[autofocus]').focus();
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    $("[data-mask]").inputmask();
});
$('#customer').DataTable({
    responsive:true,
    autoWidth:false,
    lengthMenu:[5,10,15,25],
    processing:true,
    serverSide: true,
    ajax: '/customer/getajaxindex',
    columns: [
        {data: 'id', name: 'id'},
        {data: 'Nama', name: 'Nama'},
        {data: 'Phone', name: 'Phone'},
        {data: 'IdNum', name: 'IdNum'},
        {data: 'BirthDate', name: "BirthDate"},
        {data: 'Email', name: 'Email'},
        {data: 'action', name: 'action', searchable:false, orderable: false}
    ],
    order:[[0,'desc']]
});




//
