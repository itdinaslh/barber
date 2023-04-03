$('#sid').on('change', function() {
    $('#pid').focus();
});

$(document).on('shown.bs.modal', '.modal', function() {
    $(this).find('[autofocus]').focus();
});
$('#barberman').DataTable({
    responsive:true,
    autoWidth:false,
    lengthMenu:[5,10,15,20],
    order:[[0,'asc']]
});
$('.sDetail').on('click', function() {
    $('#formService').trigger('reset');
    var id = $(this).attr('data-value');
    var kode = $('#bb-'+id).attr('data-kode');
    var nama = $('#nama-'+id).attr('data-nama');


    $('#detailDiv').show();
    $('#inputbid').val(id);
    $('#DetailTitle').html('List Service "' + kode + ' - ' + nama + '"');
    $('#sid').focus();
    loadService(id);

});
function loadService(bid) {
  $('#service').DataTable().destroy();
  $('#service').DataTable({
      processing:true,
      serverSide:true,
      responsive:true,
      autoWidth:false,
      searchable:false,
      paginate:false,
      ajax: '/barberman/serviceajax-'+bid,
      columns: [
          {data: 'Kode', name:'Kode'},
          {data: 'Nama', name:'Nama'},
          {data: 'ServiceName', name:'ServiceName'},
          {data: 'Harga', name:'Harga'},
          {data: 'Fee', name:'Fee'},
          {data: 'action', name:'action', searchable:false}
      ]
  });
}

$('#formService').on('submit', function(e) {
    e.preventDefault();
    var getId = $('#inputbid').val();
    $.ajax({
        type: 'POST',
        url: '/barberman/addservice',
        data: $(this).serialize(),
        success: function(result) {
          if(result.success) {
              swal(
                'Sukses!',
                'Data telah ditambahkan',
                'success'
              ).then(function() {
                  loadService(getId);
                  $('#formService').find("input[type=text]").val("");
                  $('#sid').focus();
              });
          } else {
              alert(result);
          }
        }
    });
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
            url:'/barberman/delserv-'+getId,
            success: function(result) {
              if(result.success) {
                  swal(
                    'Sukses!',
                    'Data telah terhapus.',
                    'success'
                  ).then(function() {
                      loadService(bbid);
                  });
              }
            }
        });
    });
});
