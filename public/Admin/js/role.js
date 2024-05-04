$(document).ready(function () {
    $('#createRoleForm').submit(function (e) {
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
                    $('#createRoleForm').trigger('reset');
                    $('.modal-backdrop').remove();
                    $('#table').load(location.href + ' #table')
                }
            },
            error: function (err) {
                let error = err.responseJSON;
                $.each(error.errors, function (index, value) {
                    $('.errMsgContainer').append('<span class="text-danger">' +
                        value + '</span>' + '<br>')
                })
            }
        });
    });

    $(document).on('click', '#rolesTable .pagination a', function (event) {
        event.preventDefault();
        var baseUrl = window.location.href.split('?')[0];
        var url = $(this).attr('href');
        $.ajax({
            url: baseUrl,
            data: { page: url.split('=')[1] },
            success: function (data) {
                $('#rolesTable').html($(data).find('#rolesTable').html());
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    $(document).on('submit', '#roleDelete', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            method: 'DELETE',
            data: formData,
            success: function (response) {
                $('#table').load(location.href + ' #table');
            },
            error: function (xhr, status, error) {
                console.error('Error occurred:', error);
            }
        });
    });

    $(document).on('click', '.updateRole', function () {
        var roleId = $(this).data('role-id');
        var roleName = $(this).data('role_name');
        var permissions = $(this).data('permissions');
        $('#role_id').val(roleId);
        $('#roleNameUpdate').val(roleName);
        $('#rlup').val(permissions);
    });

    $(document).on('submit', '#updateRoleForm', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).data('route'),
            method: 'PUT',
            data: formData,
            success: function (response) {
                if (response.status == 'success') {
                    $('#modalUpdate').modal('hide');
                    $('#updateRoleForm').trigger('reset');
                    $('.modal-backdrop').remove();
                    $('#table').load(location.href + ' #table')
                }
            },
            error: function (xhr, status, error) {
                console.error('Error occurred:', error);
            }
        });
    });
});

