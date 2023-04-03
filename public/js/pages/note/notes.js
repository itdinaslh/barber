$(document).on('shown.bs.modal', '.modal', function() {
    $(".textarea").wysihtml5();
});
$('#notes').DataTable({
    responsive: true,
    lengthMenu: [5,10,15,20],
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: '/notes/ajaxdata',
    columns: [
        {data:'Title', name:'Title'},
        {data:'Content', name:'Content'},
        {data:'Active', name:'Active'},
        {data:'action', name:'action'}
    ],
    order:[2, 'desc']
});

$(document).on('click', '.activateMe', function() {
    var id = $(this).attr('data-id');
    $.ajax({
        type:'GET',
        url: '/notes/activate/' + id,
        success: function(result) {
            if(result.success) {
                swal(
                  'Sukses', 'Note telah aktif', 'success'
                ).then(function() {
                    location.reload();
                });                
            }
        }
    });
});
