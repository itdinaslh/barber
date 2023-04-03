$(document).ready(function () {
    $.ajaxSetup({ cache: false });

    $(".showMe").on("click", function () {
      $('#myModalContent').load($(this).attr('data-href'), function () {

        $('#myModal').modal();

        bindForm(this);
      });

      return false;
    });

    function bindForm(dialog) {
      $('#formCheckout', dialog).submit(function (e) {
        e.preventDefault();
        var total = $('#rTotal').val();
        var i = $('#PayVal').autoNumeric('get');
        var paid = parseInt(i);

        if(paid < total) {
            swal('Warning', 'Uang bayar lebih kecil dari total transaksi..!!!', 'warning');
            $('#PayVal').focus();
            return false;
        }

        var id = $('#TrxID').val();
        $.ajax({
          url: this.action,
          type: this.method,
          data: $(this).serialize(),
          success: function (result) {
            if (result.success) {
              $('#myModal').modal('hide');
              Checkout(id);
            } else if (result.limit) {
              swal('Warning', 'Stok Kurang...!', 'warning');
              return false;
            } else if (result.discountinvalid) {
                swal('Warning', 'Kode discount sdh tidak berlaku / kadaluarsa', 'warning');
                return false;
            } else if (result.voucherinvalid) {
                swal('Warning', 'Kode voucher sdh tidak berlaku/ kadaluarsa', 'warning');
                return false;
            } else {
              $('#myModalContent').html(result);
              bindForm();
            }
          }
        });
        return false;
      });
  }

  function Checkout(id) {
    swal("Sukses!", "Transaksi Berhasil", "success").then(function() {
        var win = window.open('/transaction/printpreview-'+id, '_blank');

        if (win) {
            win.focus();
            location.reload();
        } else {
            alert('Please allow popup for this application');
        }
    });
  }
});
