$(document).ready(function () {
    $('#createCategory').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var url = $(this).data('route');
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function (response) {
                if (response.status == 'success') {
                    $('#modalCenter').modal('hide');
                    $('#createCategory').trigger('reset');
                    $('.modal-backdrop').remove();
                    $('#categoryTable').load(location.href + ' #categoryTable');
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

    $(document).on('click', '#categoryTableDiv .pagination a', function (event) {
        event.preventDefault();
        var baseUrl = window.location.href.split('?')[0];
        var url = $(this).attr('href');
        $.ajax({
            url: baseUrl,
            data: { page: url.split('=')[1] },
            success: function (data) {
                $('#categoryTableDiv').html($(data).find('#categoryTableDiv').html());
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    $(document).on('click', '.updateCategoryButton', function () {
        var categoryId = $(this).data('category_id');
        var categoryName = $(this).data('category_name');
        $('#category_id').val(categoryId);
        $('#category_name').val(categoryName);
    });

    $(document).on('submit', '#updateCategory', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).data('route'),
            method: 'PUT',
            data: formData,
            success: function (response) {
                if (response.status == 'success') {
                    $('#updateCategorymodal').modal('hide');
                    $('#updateCategory').trigger('reset');
                    $('.modal-backdrop').remove();
                    $('#categoryTable').load(location.href + ' #categoryTable')
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

    $(document).on('submit', '#categoryDelete', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            method: 'DELETE',
            data: formData,
            success: function (response) {
                $('#categoryTable').load(location.href + ' #categoryTable');
            },
            error: function (xhr, status, error) {
                console.error('Error occurred:', error);
            }
        });
    });

});