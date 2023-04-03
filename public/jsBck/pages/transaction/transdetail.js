$(document).on('shown.bs.modal', '.modal', function() {
    $(this).find('[autofocus]').focus();
});

$(document).ready(function() {
    $('#trx').DataTable({
      responsive:true,
      autoWidth:false,
      lengthMenu:[5,10,15,20],
      processing:true,
      serverSide:true,
      ajax: '/transaction/ajaxdata',
      columns: [
          {data: 'id', name:'t.id'},
          {data: 'Nama', name:'c.Nama'},
          {data: 'action', name:'action', searchable:false}
      ],
      order:[[0, 'desc']]
    });
});

$(document).on('click', '.ngehek', function() {
  var getTrxID = $(this).attr('data-trx');
  var getName = $(this).attr('data-name');
  $('#TrxID').val(getTrxID);
  $('#TrxProduct').val(getTrxID);
  $('#detailDiv').show();
  $('#DetailTitle').html('Detail Transaksi "' + getTrxID + ' - ' + getName + '"');
  loadDetails(getTrxID);
  loadProducts(getTrxID);
  TotalTrx(getTrxID);
  $('#btnCheckout').attr('data-href', '/transaction/getcheckout-'+getTrxID);
});

$(document).on('click', '.btnDelDetail', function() {
    var id = $(this).attr('data-id');
    var trx = $(this).attr('data-trx');
    $.ajax({
        type: 'GET',
        url: '/transaction/deltransdetail-'+id,
        success: function(result) {
            if(result.success) {
                swal(
                    'Sukses',
                    'Detail dihapus',
                    'success'
                ).then(function() {
                    loadDetails(trx);
                    TotalTrx(trx);
                });
            }
        }
    })
});

$(document).on('click', '.btnDelProduct', function() {
    var id = $(this).attr('data-id');
    var trx = $(this).attr('data-trx');
    $.ajax({
        type: 'GET',
        url: '/transaction/deltransproduct-'+id,
        success: function(result) {
            if(result.success) {
                swal(
                    'Sukses',
                    'Produk dihapus',
                    'success'
                ).then(function() {
                    loadProducts(trx);
                    TotalTrx(trx);
                });
            }
        }
    })
});

function loadDetails(trxid) {
    var id = trxid;
    $('#trxDetail').DataTable().destroy();
    $('#trxDetail').DataTable({
      paginate: false,
      searching: false,
      autoWidth: false,
      responsive: true,
      info: false,
      ajax: '/transaction/ajaxtransbbdetail-'+id,
      columns: [
        {data: 'TrxID', name:'TrxID'},
        {data: 'ServName', name:'ServName'},
        {data: 'BbName', name:'BbName'},
        {data: 'Price', name:'Price'},
        {data: 'Qty', name:'Qty'},
        {data: 'Total', name:'Total'},
        {data: 'action', name:'action'}
      ]
    });
}

function loadProducts(trxid) {
    var id = trxid;
    $('#trxProduct').DataTable().destroy();
    $('#trxProduct').DataTable({
      paginate: false,
      searching: false,
      autoWidth: false,
      responsive: true,
      info: false,
      ajax: '/transaction/ajaxtransbbproduct-'+id,
      columns: [
        {data: 'TrxID', name:'TrxID'},
        {data: 'ServName', name:'ServName'},
        {data: 'BbName', name:'BbName'},
        {data: 'Price', name:'Price'},
        {data: 'Qty', name:'Qty'},
        {data: 'Total', name:'Total'},
        {data: 'action', name:'action'}
      ]
    });
}

function TotalTrx(TrxId) {
    $.ajax({
      type: 'GET',
      url: '/transaction/gettotal-' + TrxId,
      success: function(data) {
          $('#TotalTrx').html('Total : Rp. ' + data +',-');
      }
    });
}

$('#formService').on('submit', function(e) {
  e.preventDefault();
  var id = $('#TrxID').val();
  $.ajax({
      type: 'POST',
      url: '/transaction/addtransbbdetail',
      data: $(this).serialize(),
      success: function(result) {
          if(result.success) {
              swal(
                'Sukses!',
                'Detail ditambahkan',
                'success'
              ).then(function() {
                loadDetails(id);
                TotalTrx(id);
              });
          }
      }
  });
});

$('#formProduct').on('submit', function(e) {
  e.preventDefault();
  var id = $('#TrxProduct').val();
  $.ajax({
      type: 'POST',
      url: '/transaction/addtransbbproduct',
      data: $(this).serialize(),
      success: function(result) {
          if(result.success) {
              swal(
                'Sukses!',
                'Product ditambahkan',
                'success'
              ).then(function() {
                loadProducts(id);
                TotalTrx(id);
              });
          }
      }
  });
});

$('body').on('change', '#payment', function() {
    $('#PayVal').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    var payid = $('#payment').val();
    var total = $('#TotalTrans').val();
    if(payid == 1) {
        $('#CardView').hide();
        $('#PayVal').prop('disabled', false);
        $('#PayVal').val(0);
        $('#ChangeView').show();
    } else {
        $('#CardView').show();
        $('#PayVal').autoNumeric('set', $('#rTotal').val());
        $('#PayVal').prop('disabled', true);
        $('#ChangeView').hide();
        $('#rPayVal').val($('#rTotal').val());
    }
});

$(document).on('keyup', '#Discount', function() {
    $(this).autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    var total = $('#totalhid').val();
    var disc = $(this).autoNumeric('get');

    var pmethod = $('#Payment').val();

    $('#rDisc').val(disc);
    var now = total - disc;

    $('#rTotal').val(now);
    $('#SubtotalTrx').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    $('#SubtotalTrx').autoNumeric('set', now);

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
