$(document).ready(function (e) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    $('#fileForm').submit(function (e) {
        e.preventDefault();

        $('.responseInfo').empty();

        let formData = new FormData(this);
        $.ajax({
            url: "{{ url('upload-file') }}",
            type: "POST",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data)
                $('.responseInfo').append('<div class="alert alert-success" role="alert">\n' +
                    data.message + '</div>');

                $('.btn-upload-file').prop('disabled', true);

                setTimeout(() => {
                    $('#fileForm').trigger("reset");
                    $('.responseInfo').empty();
                    $('#uploadFile').modal('hide');
                }, 1200);
            },
            error: function (data) {
                const errors = data.responseJSON.errors.csv_file;
                console.log(errors)

                errors.forEach(function (element) {
                    $('.responseInfo').append('<div class="alert alert-danger" role="alert">\n' +
                        element + '</div>');
                });
            }
        });
    });
});
