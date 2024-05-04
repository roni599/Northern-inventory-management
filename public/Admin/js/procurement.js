$(document).ready(function () {
    $('#addProcurement').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var url = $(this).data('route');
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function (response) {
                console.log(response);
                if (response.status == 'success') {
                    $('#modalCenter').modal('hide');
                    $('#addProcurement').trigger('reset');
                    $('.modal-backdrop').remove();
                    $('#procurementTable').load(location.href + ' #procurementTable');
                }
            },
            error: function (err) {
                console.log(err);
                let error = err.responseJSON;
                $.each(error.errors, function (index, value) {
                    $('.errMsgContainer').append('<span class="text-danger">' +
                        value + '</span>' + '<br>')
                });
            }
        });
    });

    $(document).on('click', '.updateProcurement', function () {
        var productId = $(this).data('product-id');
        var Id = $(this).data('id');
        var quantity = $(this).data('quantity');
        var price = $(this).data('price');
        var unitprice = $(this).data('unitprice');
        $('#procureId').val(Id);
        $('#productName_pro').val(productId);
        $('#quantity_pro').val(quantity);
        $('#price_pro').val(price);
        $('#priceunit').val(unitprice);
    });

    $(document).on('submit', '#updateProcurement', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).data('route'),
            method: 'PUT',
            data: formData,
            success: function (response) {
                if (response.status == 'success') {
                    $('#Procurementmodal').modal('hide');
                    $('#updateProcurement').trigger('reset');
                    $('.modal-backdrop').remove();
                    $('#procurementTable').load(location.href + ' #procurementTable');
                }
            },
            error: function (xhr, status, error) {
                $.each(error.errors, function (index, value) {
                    $('.errMsgContainer').append('<span class="text-danger">' +
                        value + '</span>' + '<br>')
                })
            }
        });
    });

    $(document).on('submit', '#procurementDelete', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            method: 'DELETE',
            data: formData,
            success: function (response) {
                $('#procurementTable').load(location.href + ' #procurementTable');
            },
            error: function (xhr, status, error) {
                console.error('Error occurred:', error);
            }
        });
    });

    $(document).on('click', '#procurementDiv .pagination a', function (event) {
        event.preventDefault();
        var baseUrl = window.location.href.split('?')[0];
        var url = $(this).attr('href');
        $.ajax({
            url: baseUrl,
            data: { page: url.split('=')[1] },
            success: function (data) {
                $('#procurementDiv').html($(data).find('#procurementDiv').html());
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});