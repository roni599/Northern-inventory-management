$(document).ready(function () {
    $('#addOrganization').click(function (e) {
        e.preventDefault();
        var organizationName = $('#nameWithTitle').val();
        var url = $('#createOrganization').data('route');
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                _token: $('input[name="_token"]').val(),
                nameWithTitle: organizationName
            },
            success: function (response) {
                if (response.status == 'success') {
                    $('#modalCenter').modal('hide');
                    $('#addOrganization').trigger('reset');
                    $('.modal-backdrop').remove();
                    $('#organizationTable').load(location.href + ' #organizationTable')
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

    $(document).on('click', '#organizationTableDiv .pagination a', function (event) {
        event.preventDefault();
        var baseUrl = window.location.href.split('?')[0];
        var url = $(this).attr('href');
        $.ajax({
            url: baseUrl,
            data: { page: url.split('=')[1] },
            success: function (data) {
                $('#organizationTableDiv').html($(data).find('#organizationTableDiv').html());
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    $(document).on('click', '.updateOrganizationButton', function () {
        var organizationId = $(this).data('organization_id');
        var organizationName = $(this).data('organization_name');
        $('#organization_id').val(organizationId);
        $('#organizationNameUpdate').val(organizationName);
    });
    

    $(document).on('submit', '#updateOrganization', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).data('route'),
            method: 'PUT',
            data: formData,
            success: function (response) {
                if (response.status == 'success') {
                    $('#organizationUpdate').modal('hide');
                    $('#updateOrganization').trigger('reset');
                    $('.modal-backdrop').remove();
                    $('#organizationTable').load(location.href + ' #organizationTable')
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

    $(document).on('submit', '#organizationDelete', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            method: 'DELETE',
            data: formData,
            success: function (response) {
                $('#organizationTable').load(location.href + ' #organizationTable');
            },
            error: function (xhr, status, error) {
                console.error('Error occurred:', error);
            }
        });
    });
});