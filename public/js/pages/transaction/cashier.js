$(document).on('shown.bs.modal', '.modal', function() {
    var userid = $('#myUid').val();
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    $("[data-mask]").inputmask();

    $('#tblCust').DataTable({
        lengthMenu: [5,10],
        autoWidth: false,
        responsive: true,
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: '/transaction/getcustomerajax/' + userid,
        columns: [
            {data: 'id', name: 'c.id'},
            {data: 'Nama', name: 'c.Nama'},
            {data: 'Phone', name: 'c.Phone'},
            {data: 'LastVisit', name: 'c.LastVisit'},
            {data: 'TotalVisit', name: 'TotalVisit', searchable: false},
            {data: 'action', name: 'action', searchable: false}
        ]
    });

    $('#btnAddCust').on('click', function() {
        $('#formAddCust').show();
        $('#myModal').data('bs.modal').handleUpdate();
        $('#txtNama').focus();
    });
});

$(document).on('submit', '.formAddTrans', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');

    $.ajax({
        type: 'POST',
        url: '/transaction/new',
        data: $('#Form-' + id).serialize(),
        success: function(result) {
            if (result.success) {
               swal({
                  title: 'Sukses!',
                  text: 'Tambah transaksi baru berhasil',
                  timer: 500
               }).then(
                  function() {},
                  function (dismiss) {
                      if (dismiss === 'timer') {
                          $('#myModal').modal('hide');
                          location.reload();
                      }
                  }
               )
            }
        }
    });
});

$(document).on('submit', '#formAddAndOrder', function(e) {
    e.preventDefault();
    $.ajax({
        url: this.action,
        type: this.method,
        data: $('#formAddAndOrder').serialize(),
        success: function(result) {
              if (result.success) {
                 swal({
                    title: 'Sukses!',
                    text: 'Tambah transaksi baru berhasil',
                    timer: 500
                 }).then(
                    function() {},
                    function (dismiss) {
                        if (dismiss === 'timer') {
                            $('#myModal').modal('hide');
                            location.reload();
                        }
                    }
                 )
              }
        }
    });
});

$('#trxdropdown').prop('selectedIndex', -1);

$(document).on('change', '#trxdropdown', function() {
    var id = $(this).val();
    var mid = $(this).attr('data-member');
    $('#TrxID').val(id);
    $('#TrxProduct').val(id);

    loadDetails(id);
    TotalTrx(id);

    $('#btnCheckOut').attr('data-href', '/transaction/getcheckout-'+id);
    $('#detailDiv').show();
});

function TotalTrx(TrxId) {
  $.ajax({
    type: 'GET',
    url: '/transaction/gettotal-' + TrxId,
    success: function(data) {
        $('#TotalTrx').html('Total : Rp. ' + data +',-');
    }
  });
}

function loadDetails(trxid) {
    var id = trxid;
    $('#trxDetail').DataTable().destroy();
    $('#trxDetail').DataTable({
      paginate: false,
      searching: false,
      autoWidth: false,
      responsive: true,
      info: false,
      ajax: '/transaction/ajaxdetails/'+id,
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

function DiscountCheck(id) {
    $.ajax({
        type: 'GET',
        url: '/discounts/check/' + id,
        success: function(result) {
            if(result.success) {
                $('#Discount').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
                $('#rDisc').val(result.data);
                $('#Discount').autoNumeric('set', result.data);
                var total = $('#totalhid').val();
                var disc = $('#rDisc').val();

                var voucher = $('#rVoucher').val();
                var now = total - disc - voucher;
                $('#rTotal').val(now);
                $('#SubtotalTrx').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
                $('#SubtotalTrx').autoNumeric('set', now);
                $('#VoucherID').focus();
            } else if (result.used) {
                swal('Warning', 'Discount sudah terpakai..!!', 'warning');
                $('#DiscountID').val('');
                zerodiscount();
                return false;
            } else if (result.expired) {
                swal('Warning', 'Discount kadaluarsa..!!', 'warning');
                $('#DiscountID').val('');
                zerodiscount();
                return false;
            }
        }
    });
}

function VoucherCheck(id) {
    $.ajax({
        type: 'GET',
        url: '/vouchers/check/' + id,
        success: function(result) {
            if(result.success) {
                $('#VoucherVal').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
                $('#VoucherVal').autoNumeric('set', result.data);
                $('#rVoucher').val(result.data);
                var total = $('#totalhid').val();
                var disc = $('#rDisc').val();

                var voucher = $('#rVoucher').val();
                var now = total - disc - voucher;

                $('#rTotal').val(now);
                $('#SubtotalTrx').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
                $('#SubtotalTrx').autoNumeric('set', now);
                $('#payment').focus();
            } else if (result.used) {
                swal('Warning', 'Voucher sudah terpakai..!!', 'warning');
                $('#VoucherID').val('');
                zerovoucher();
                return false;
            } else if (result.expired) {
                swal('Warning', 'Voucher kadaluarsa..!!', 'warning');
                $('#VoucherID').val('');
                zerovoucher();
                return false;              
            } else {
                $('#rVoucher').val('');
                $('#VoucherVal').val(0);
            }
        }
    });
}

function DelDetail(id, trx) {
    $.ajax({
        type: 'GET',
        url: '/transaction/deltransdetail-'+id,
        success: function(result) {
            if(result.success) {
              loadDetails(trx);
              TotalTrx(trx);
            }
        }
    });
}

function DelProduct(id, trx) {
    $.ajax({
        type: 'GET',
        url: '/transaction/deltransproduct-'+id,
        success: function(result) {
            if(result.success) {
                loadDetails(trx);
                TotalTrx(trx);
            }
        }
    });
}

$(document).on('click', '.btnDelDetail', function() {
    var type = $(this).attr('data-type');
    var id = $(this).attr('data-id');
    var trx = $(this).attr('data-trx');

    if(type == 1) {
        DelDetail(id, trx);
    } else {
        DelProduct(id, trx);
    }
});

$('#formService').on('submit', function(e) {
    e.preventDefault();

    var id = $('#TrxID').val();

    $.ajax({
        type: 'POST',
        url: '/transaction/addtransbbdetail',
        data: $(this).serialize(),
        success: function(result) {
            if(result.success) {
                loadDetails(id);
                TotalTrx(id);
            }
        }
    })
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
              loadDetails(id);
              TotalTrx(id);
            } else if (result.limit) {
                swal({
                  title:'Warning',
                  text:'Stock kurang!',
                  type:'warning'
                }).then(function() {
                    return false;
                });
            }
        }
    });
});

function CustDetails(id) {
    alert(id);
}

$('body').on('change', '#payment', function() {
    $('#PayVal').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    var payid = $('#payment').val();
    var total = $('#TotalTrans').val();
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

// $(document).on('keyup', '#Discount', function() {
//     $(this).autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
//     var total = $('#totalhid').val();
//     var disc = $(this).autoNumeric('get');
//
//     var pmethod = $('#Payment').val();
//
//     $('#rDisc').val(disc);
//     var now = total - disc;
//
//     $('#rTotal').val(now);
//     $('#SubtotalTrx').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
//     $('#SubtotalTrx').autoNumeric('set', now);
//
// });

$(document).on('keyup', '#PayVal', function() {
    $(this).autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});

    var bayar = $(this).autoNumeric('get');
    $('#rPayVal').val(bayar);
    var total = $('#rTotal').val();
    var change = bayar - total;

    $('#Change').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    $('#Change').autoNumeric('set', change);
});

$(document).on('keyup', '#DiscountID', function() {
    var id = $(this).val().length;

    if(id < 9) {
        zerodiscount();
    } else {
        DiscountCheck($(this).val());
    }
});

$(document).on('keyup', '#VoucherID', function() {
    var id = $(this).val().length;

    if(id < 9) {
        zerovoucher();
    } else {
        VoucherCheck($(this).val());
    }
});

function zerodiscount() {
    $('#rDisc').val(0);
    $('#Discount').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    $('#Discount').autoNumeric('set', 0);
}

function zerovoucher() {
    $('#rVoucher').val(0);
    $('#VoucherVal').autoNumeric('init', { currencySymbol:'Rp. ', allowDecimalPadding: false, digitGroupSeparator:'.', decimalCharacter: ','});
    $('#VoucherVal').autoNumeric('set', 0);
}
