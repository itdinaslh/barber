$(document).ready(function () {
    $.ajaxSetup({ cache: false });

    $("#btnCheckOut").on("click", function () {
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
            alert('Uang bayar lebih kecil dari total transaksi!');
            $('#PayVal').focus();
            return false;
        }

        $.ajax({
          url: this.action,
          type: this.method,
          data: $(this).serialize(),
          success: function (result) {
            if (result.success) {
              $('#myModal').modal('hide');
              Checkout();
            } else {
              $('#myModalContent').html(result);
              bindForm();
            }
          }
        });
        return false;
      });
  }

  function Checkout() {
    swal("Sukses!", "Transaksi Berhasil", "success").then(function() {
        var win = window.open('/transaction/cafe/print', '_blank');

        if (win) {
            win.focus();
            location.reload();
        } else {
            alert('Please allow popup for this application');
        }
    });
  }
});
