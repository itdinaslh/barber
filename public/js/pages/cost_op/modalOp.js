function bindForm(dialog) {
    $('form', dialog).submit(function () {
        $.ajax({
            url: this.action,
            type: this.method,
            data: $(this).serialize(),
            success: function (result) {
                if (result.success) {
                    $('#myModal').modal('hide');
                    showSuccessMessage();
                } else if(result.used) {
                    swal('Warning', 'Kode Operational Telah Digunakan', 'warning');
                    $('#OperationalID').focus();
                    return false;
                } else if (result.invalid) {
                    swal('Warning', 'Kode Operational Dalam Range Telah Digunakan', 'warning');
                    return false;
                }
            }
        });
        return false;
    });
}

function showSuccessMessage() {
    swal("Sukses!", "Data berhasil disimpan!", "success").then(function() {
      location.reload();
    });
}

$(document).ready(function () {
    $.ajaxSetup({ cache: false });

    $(".dataTable").on("click", '.showMe', function () {
        $('#myModalContent').load($(this).attr('data-href'), function () {

            $('#myModal').modal();

            bindForm(this);
        });

        return false;
    });
});

$(document).on('click', '.showMe', function() {
    $('#myModalContent').load($(this).attr('data-href'), function () {

        $('#myModal').modal();

        bindForm(this);
    });

    return false;
});
