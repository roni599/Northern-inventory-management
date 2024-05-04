
$(document).ready(function () {
    $('#organization').change(function () {
        var userId = $(this).val();
        $.ajax({
            url: '/admin/search/users',
            method: 'GET',
            data: {
                userId: userId,
            },
            dataType: 'html',
            success: function (response) {
                console.log(response);
                $('#reportTable').html(response);

            },
            error: function (xhr, status, error) {
                $('#reportTable').load(location.href + ' #reportTable');
            }
        });
    });

    $('#product').change(function () {
        var userId = $(this).val();
        $.ajax({
            url: '/admin/search/product',
            method: 'GET',
            data: {
                userId: userId,
            },
            dataType: 'html',
            success: function (response) {
                $('#reportTable').html(response);

            },
            error: function (xhr, status, error) {
                $('#reportTable').load(location.href + ' #reportTable');
            }
        });
    });

    $('#category').change(function () {
        var userId = $(this).val();
        $.ajax({
            url: '/admin/search/category',
            method: 'GET',
            data: {
                userId: userId,
            },
            dataType: 'html',
            success: function (response) {
                console.log(response);
                $('#reportTable').html(response);

            },
            error: function (xhr, status, error) {
                $('#reportTable').load(location.href + ' #reportTable');
            }
        });
    });

    $('#designation').change(function () {
        var userId = $(this).val();
        $.ajax({
            url: '/admin/search/designation',
            method: 'GET',
            data: {
                userId: userId,
            },
            dataType: 'html',
            success: function (response) {
                console.log(response);
                $('#reportTable').html(response);

            },
            error: function (xhr, status, error) {
                $('#reportTable').load(location.href + ' #reportTable');
            }
        });
    });

    $('#orderStatus').change(function () {
        var userId = $(this).val();
        $.ajax({
            url: '/admin/search/status',
            method: 'GET',
            data: {
                userId: userId,
            },
            dataType: 'html',
            success: function (response) {
                console.log(response);
                $('#reportTable').html(response);

            },
            error: function (xhr, status, error) {
                $('#reportTable').load(location.href + ' #reportTable');
            }
        });
    });
});

