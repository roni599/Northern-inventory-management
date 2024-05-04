$(document).ready(function () {
    $(document).on('click', '.updateProductButton', function (event) {
        event.preventDefault();
        var productId = $(this).data('product_id');
        var productName = $(this).data('product_name');
        var expiryTime = $(this).data('expiry_time');
        var quantity = $(this).data('quantity');

        // var roleId = $(this).data('role_id');
        var category = $(this).data('categoryto');
        var organization = JSON.parse($(this).data('organization'));
        $('#productupdateid').val(productId);
        $('#firstName').val(productName);
        $('#ex_time').val(expiryTime);
        $('#quantity').val(quantity);
        $('#organization').val(organization);


        // var selectedOption = $(".assingfor option").filter(function () {
        //     return $(this).text() === roleId;
        // });

        // if (selectedOption.length === 0) {
        //     $(".assingfor").append('<option value="" selected>No Role Assigned</option>');
        // } else {
        //     selectedOption.prop('selected', true);
        // }

        var selectedCategoryOption = $(".categoryforto option").filter(function () {
            return $(this).text() === category;
        });
    
        if (selectedCategoryOption.length === 0) {
            $(".categoryforto").append('<option value="" selected>No Category Assigned</option>');
        } else {
            selectedCategoryOption.prop('selected', true);
        }

    });

    $(document).on('submit', '#updateProduct', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).data('route'),
            method: 'PUT',
            data: formData,
            success: function (response) {
                console.log(response);
                if (response.status == 'success') {
                    $('#updateProductmodal').modal('hide');
                    $('#updateProduct').trigger('reset');
                    $('.modal-backdrop').remove();
                    $('#productTable').load(location.href + ' #productTable')
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


    $(document).on('click', '#productTableDiv .pagination a', function (event) {
        event.preventDefault();
        var baseUrl = window.location.href.split('?')[0];
        var url = $(this).attr('href');
        $.ajax({
            url: baseUrl,
            data: { page: url.split('=')[1] },
            success: function (data) {
                $('#productTable').html($(data).find('#productTable').html());
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });


    $(document).on('submit', '#productDelete', function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr('action'),
            method: 'DELETE',
            data: formData,
            success: function (response) {
                $('#productTable').load(location.href + ' #productTable');
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
                $('#productTable').load(location.href + ' #productTable');
                return;
            }
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/admin/product_searchlist',
                type: 'GET',
                data: {
                    '_token': csrfToken,
                    'query': searchInputValue, // Corrected: Pass the search input value
                },
                dataType: 'html',
                success: function (response) {
                    console.log(response);
                    $('#productTable').html(response);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching search results:', error);
                    $('#productTable').load(location.href + ' #productTable');
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
    

});