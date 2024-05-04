$(document).ready(function () {
    $(document).on('click', '.updateUserButton', function () {
        var userId = $(this).data('user_id');
        var fullName = $(this).data('full_name');
        var roleId = $(this).data('role_id');
        var email = $(this).data('email');
        var organizationId = $(this).data('organization_id');
        var phoneNumber = $(this).data('phone_number');
        var address = $(this).data('address');

        $('#userid').val(userId);
        $('#fullName').val(fullName);
        $('#email').val(email);
        // $('#organization').val(organizationId);
        $('#phoneNumber').val(phoneNumber);
        $('#address').val(address);
        $('#userid_change_pass').val(userId);
        // $('#organizations').val(organizationId);

        // $(".roles option").filter(function () {
        //     return $(this).text() === roleId;
        // }).attr("selected", "selected");
        // $(".roles option").filter(function () {
        //     return $(this).text() === roleId;
        // }).prop("selected", true);

        // $(".roles option").prop("selected", false); // Deselect all options initially
        // $(".roles option").filter(function () {
        //     return $(this).text() === roleId;
        // }).prop("selected", true);

        var selectedOption = $(".roles option").filter(function () {
            return $(this).text() === roleId;
        });

        if (selectedOption.length === 0) {
            // If no matching option, add "No Role Assigned" option dynamically
            $(".roles").append('<option value="" selected>No Role Assigned</option>');
        } else {
            // If there is a matching option, select it
            selectedOption.prop('selected', true);
        }

        // Set the selected option for #categoryfor
        // $(".organizations option").filter(function () {
        //     return $(this).text().trim() === organizationId;
        // }).prop("selected", true);

        var selectedOption = $(".organizations option").filter(function () {
            return $(this).text().trim() === organizationId;
        });

        if (selectedOption.length === 0) {
            // If no matching option, add a new option dynamically
            $(".organizations").append('<option value="" selected>No organization Assigned</option>');
        } else {
            // If there is a matching option, select it
            selectedOption.prop('selected', true);
        }




        var image = $(this).data('image');
        $('#imagePathDisplay').text(image);
    });



    $(document).on('click', '#userTableDiv .pagination a', function (event) {
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

    $(document).on('submit', '#userUpdate', function (event) {
        event.preventDefault();

        var formData = new FormData(this);
        var csrfToken = "{{ csrf_token() }}";

        $.ajax({
            url: $(this).data('route'),
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                if (response.status == 'success') {
                    $('#updateUsermodal').modal('hide');
                    $('#userUpdate').trigger('reset');
                    $('.modal-backdrop').remove();
                    $('#userTable').load(location.href + ' #userTable')
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    $(document).on('submit', '#userPassChange', function (event) {
        event.preventDefault(); // Prevent the default form submission

        // var formData = $(this).serialize(); // Serialize form data
        var formData = new FormData(this);
        var csrfToken = "{{ csrf_token() }}";

        $.ajax({
            url: $(this).data('route'), // Get the route from data attribute
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                if (response.status == 'success') {
                    $('#updateUsermodal').modal('hide');
                    $('#userUpdate').trigger('reset');
                    $('.modal-backdrop').remove();
                    $('#userTable').load(location.href + ' #userTable')
                }
            },
            error: function (xhr, status, error) {
               alert("Must be given Password");
            }
        });
    });
});

$(document).on('submit', '#userDelete', function (event) {
    event.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: $(this).attr('action'),
        method: 'DELETE',
        data: formData,
        success: function (response) {
            $('#userTable').load(location.href + ' #userTable');
        },
        error: function (xhr, status, error) {
            console.error('Error occurred:', error);
        }
    });
});

$(document).ready(function () {
    var searchForm = $('#searchForm');
    var searchInput = $('#searchInput');

    function submitForm() {
        var searchInputValue = searchInput.val().trim();
        if (searchInputValue === '') {
            $('#userTableDiv').load(location.href + ' #userTableDiv');
            return;
        }
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/admin/user_searchlist',
            type: 'GET',
            data: {
                '_token': csrfToken,
                'query': searchInputValue, // Corrected: Pass the search input value
            },
            dataType: 'html',
            success: function (response) {
                console.log(response);
                $('#userTableDiv').html(response);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching search results:', error);
                $('#userTableDiv').load(location.href + ' #userTableDiv');
            }
        });
    }

    searchForm.submit(function (e) {
        e.preventDefault();
        submitForm();
    });

    searchInput.on('input', function () {
        submitForm();
    });
});

