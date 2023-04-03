$(document).on('shown.bs.modal', '.modal', function() {
    $(this).find('[autofocus]').focus();
});


$(document).on('submit', '#FormAddSubTrans', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: '/transaction/cafe/addsubtrans',
        data: $('#FormAddSubTrans').serialize(),
        success: function(result) {
            if(result.success) {
                loadTables();
                getTotal();
            } else if (result.limit) {
                swal({
                  title:'Warning',
                  text:'Stok Barang Kurang..!!!',
                  type:'warning'
                }).then(function() {
                    return false;
                });
            }
        }
    })
});

function clearcart() {
    $.ajax({
        type: 'POST',
        url: '/transaction/cafe/clearcart',
        data: $('#FormClearCart').serialize(),
        success: function(result) {
            if(result.success) {
                loadTables();
                getTotal();
                resetForm();
            }
        }
    });
}

function getTotal() {
    $.ajax({
        type: 'GET',
        url: '/transaction/cafe/totalcart',
        success: function(data) {
            $('#TotalAll').html(data);
        }
    });
}

function resetForm() {
    $('#ProdList').prop('selectedIndex', -1);
    $('#qtyprod').val('');
    $('#ProdList').focus();
}

function delSub(rowid) {
    $.ajax({
        type: 'GET',
        url: '/transaction/cafe/delsub/' + rowid,
        success: function(result) {
            if(result.success) {
                loadTables();
                getTotal();
            }
        }
    })
}

function loadTables() {
    $('#transDetails').DataTable().destroy();
    $('#transDetails').DataTable({
      autoWidth: false,
      responsive: true,
      processing: true,
      serverSide: true,
      paginate: false,
      searching: false,
      ordering: false,
      info: false,
      ajax: '/transaction/cafe/getdata',
      columns: [
          {data: 'name', name: 'name'},
          {data: 'harga', name: 'harga'},
          {data: 'qty', name: 'qty'},
          {data: 'subtotal', name: 'subtotal'},
          {data: 'action', name: 'action'}
      ]
    });
}

$(document).ready(function() {
    loadTables();
    $('#ProdList').focus();
});

$(document).on('change', '#ProdList', function() {
    $('#qtyprod').val(1);
    $('#qtyprod').focus();
    $('#qtyprod').select();

});

$(document).ready(function() {
    $('#ProdList').prop('selectedIndex', -1);
});

$(document).on('submit', '#FormClearCart', function(e) {
    e.preventDefault();

    swal({
        title: 'Yakin Batalkan?',
        text: 'Transaksi Akan Dibatalkan',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, hapus..!'
    }).then(function() {
        clearcart()
    });
});

$(document).on('submit', '#FormNewTrans', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: '/transaction/cafe/newtrans',
        data: $("#FormNewTrans").serialize(),
        success: function(result) {
            if(result.success) {
                loadTables();
                getTotal();
                resetForm();
            }
        }
    });
});

$(document).on('click', '.btnDelSub', function() {
    var id = $(this).attr('data-row');

    delSub(id);
});

$('body').on('change', '#payment', function() {
    $('#PayVal').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    var payid = $('#payment').val();
    if(payid == 1) {
        $('#CardView').hide();
        $('#PayVal').prop('disabled', false);
        $('#PayVal').val(0);
        $('#ChangeView').show();
        $('#PayVal').focus();
    } else {
        $('#CardView').show();
        $('#PayVal').autoNumeric('set', $('#rTotal').val());
        $('#PayVal').prop('disabled', true);
        $('#ChangeView').hide();
        $('#rPayVal').val($('#rTotal').val());
        $('#CardID').focus();
    }
});

$(document).on('keyup', '#PayVal', function() {
    $(this).autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});

    var bayar = $(this).autoNumeric('get');
    $('#rPayVal').val(bayar);
    var total = $('#rTotal').val();
    var change = bayar - total;

    $('#Change').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    $('#Change').autoNumeric('set', change);
});
