// $(document).ready(function () {
//     // Event handler for Approve button
//     $(document).on('click', '.approveBtn', function (e) {
//         e.preventDefault();
//         var $form = $(this).closest('form'); // Find the closest form to the clicked button
//         var formData = $form.serialize(); // Serialize form data
//         var actionUrl = "/admin/order_approve"; // Get the form action URL
//         sendDataToDatabase(formData, actionUrl, $form);
//     });

//     // Event handler for Reject button
//     $(document).on('click', '.rejectBtn', function (e) {
//         e.preventDefault();
//         var $form = $(this).closest('form'); // Find the closest form to the clicked button
//         var formData = $form.serialize(); // Serialize form data
//         var actionUrl = "/admin/order_reject"; // Get the form action URL
//         sendDataToDatabase(formData, actionUrl, $form);
//     });

//     // Function to send data to the database using AJAX
//     function sendDataToDatabase(formData, actionUrl, $form) {
//         var csrfToken = $('meta[name="csrf-token"]').attr('content');
//         $.ajax({
//             url: actionUrl,
//             type: 'POST',
//             data: formData,
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken
//             },
//             success: function (response) {
//                 if (response.message === 'Stock out') {
//                     alert('Stock is out!');
//                 } else if (response.message === 'Success') {
//                     console.log('Order approved successfully');
//                     $form.closest('tr').find('.status').text('Approved');
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error(xhr.responseText);
//                 // Handle error response, if needed
//             }
//         });
//     }
// });

// $(document).ready(function () {
//     // Event handler for Approve button
//     $(document).on('click', '.approveBtn', function (e) {
//         e.preventDefault();
//         var $form = $(this).closest('form'); // Find the closest form to the clicked button
//         var formData = $form.serialize(); // Serialize form data
//         var actionUrl = "/admin/order_approve"; // Get the form action URL
//         sendDataToDatabase(formData, actionUrl, $form);
//     });

//     // Event handler for Reject button
//     $(document).on('click', '.rejectBtn', function (e) {
//         e.preventDefault();
//         var $form = $(this).closest('form'); // Find the closest form to the clicked button
//         var formData = $form.serialize(); // Serialize form data
//         var actionUrl = "/admin/order_reject"; // Get the form action URL
//         sendDataToDatabase(formData, actionUrl, $form);
//     });

//     // Function to send data to the database using AJAX
//     function sendDataToDatabase(formData, actionUrl, $form) {
//         var csrfToken = $('meta[name="csrf-token"]').attr('content');
//         $.ajax({
//             url: actionUrl,
//             type: 'POST',
//             data: formData,
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken
//             },
//             success: function (response) {
//                 console.log(response);
//                 if (response.message === 'Stock out') {
//                     alert('Stock is out!');
//                 } else if (response.message === 'Success') {
//                     console.log('Order approved successfully');
//                     // Update status in UI
//                     $form.closest('tr').find('.status').text('Approved');
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error(xhr.responseText);
//                 // Handle error response, if needed
//             }
//         });
//     }
// });
$(document).ready(function () {
    // Event handler for Approve button
    $(document).on('click', '.approveBtn', function (e) {
        e.preventDefault();
        var $form = $(this).closest('form'); // Find the closest form to the clicked button
        var formData = $form.serialize(); // Serialize form data
        var actionUrl = "/admin/order_approve"; // Get the form action URL
        sendDataToDatabase(formData, actionUrl, $form);
    });

    // Event handler for Reject button
    $(document).on('click', '.rejectBtn', function (e) {
        e.preventDefault();
        var $form = $(this).closest('form'); // Find the closest form to the clicked button
        var formData = $form.serialize(); // Serialize form data
        var actionUrl = "/admin/order_reject"; // Get the form action URL
        sendDataToDatabase(formData, actionUrl, $form);
    });

    // Function to send data to the database using AJAX
    function sendDataToDatabase(formData, actionUrl, $form) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function (response) {
                console.log(response);
                if (response.message === 'Stock out') {
                    alert('Stock is out!');
                } else if (response.message === 'Success') {
                    console.log('Order approved successfully');
                    // Update status in UI
                    $form.closest('tr').find('.status').text('Approved');
                    // Reload the page
                    location.reload();
                    // window.location.href = '/admin/dashboard';
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error response, if needed
            }
        });
    }

    $(document).ready(function () {
        $('#credentials').change(function (e) {
            e.preventDefault();
            var selectedOption = $(this).val();

            // Send AJAX request to server
            $.ajax({
                url: '/admin/crendial_search', // Adjust the URL based on your server route
                type: 'GET',
                data: { status: selectedOption },
                success: function (response) {
                    console.log(response);
                    // Update UI with filtered results
                    $('#orderlistTable').html(response);
                },
                error: function (xhr, status, error) {
                    $('#orderlistTable').load(location.href + ' #orderlistTable');
                }
            });
        });
    });


    $(document).ready(function () {
        var searchForm = $('#searchForm');
        var searchInput = $('#searchInput');

        function submitForm() {
            var searchInputValue = searchInput.val().trim();
            if (searchInputValue === '') {
                $('#orderlistTable').load(location.href + ' #orderlistTable');
                return;
            }
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/admin/initial_orderlist',
                type: 'GET',
                data: {
                    '_token': csrfToken,
                    'query': searchInputValue,
                },
                dataType: 'html',
                success: function (response) {
                    console.log(response);
                    $('#orderlistTable').html(response);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching search results:', error);
                    $('#orderlistTable').load(location.href + ' #orderlistTable');
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
