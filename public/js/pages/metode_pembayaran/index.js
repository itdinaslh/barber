
$('#metode_pembayaran').DataTable({
    responsive: true,
    lengthMenu: [5,10,15,20],
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: '/metode_pembayaran/ajaxdata',
    columns: [
        {data:'Name', name:'Name'},
        {data:'action', name:'action'}
    ],
});
$(document).on('click', '.btnDel', function() {
    var getId = $(this).attr('data-val');
    var bbid = $(this).attr('data-bbid');
    swal({
      title: 'Yakin Hapus?',
      text: "Data tidak dapat dikembalikan!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then(function () {
        $.ajax({
            type:'GET',
            url:'/metode_pembayaran/delserv/'+getId,
            success: function(result) {
              if(result.success) {
                  swal(
                    'Sukses!',
                    'Data telah terhapus.',
                    'success'
                  ).then(function() {
                    location.reload();
                  });
              }
            }
        });
    });
});

