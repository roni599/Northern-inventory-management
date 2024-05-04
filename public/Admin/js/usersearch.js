// $(document).ready(function () {
//     var searchForm = $('#searchForm');
//     var searchInput = $('#searchInput');

//     function submitForm() {
//         var searchInputValue = searchInput.val().trim();
//         if (searchInputValue === '') {
//             $('#orderTable').load(location.href + ' #orderTable');
//             return;
//         }
//         var csrfToken = '{{ csrf_token() }}';
//         $.ajax({
//             url: searchForm.data('route'),
//             type: 'GET',
//             data: {
//                 '_token': csrfToken,
//                 'designation': searchInputValue,
//             },
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken
//             },
//             dataType: 'html',
//             success: function (response) {
//                 console.log(response);
//                 $('#orderTable').html(response);
//             },
//             error: function (xhr, status, error) {
//                 console.error('Error fetching search results:', error);
//                 $('#orderTable').load(location.href + ' #orderTable');
//             }
//         });
//     }
//     searchInput.on('input', function () {
//         submitForm();
//     });

//     searchForm.submit(function (e) {
//         e.preventDefault();
//         submitForm();
//     });
// });

// $(document).ready(function () {
//     var searchForm = $('#searchForm');
//     var searchInput = $('#searchInput');

//     function submitForm() {
//         var searchInputValue = searchInput.val().trim();
//         if (searchInputValue === '') {
//             $('#orderTable').html(''); // Clear table content
//             return;
//         }
//         var csrfToken = $('meta[name="csrf-token"]').attr('content');
//         $.ajax({
//             url: searchForm.data('route'),
//             // url: '/user/search/orders',
//             type: 'GET',
//             data: {
//                 '_token': csrfToken,
//                 'designation': searchInputValue,
//             },
//             dataType: 'html',
//             success: function (response) {
//                 console.log(response);
//                 $('#orderTable').html(response);
//             },
//             error: function (xhr, status, error) {
//                 console.error('Error fetching search results:', error);
//                 $('#orderTable').html(''); // Clear table content
//             }
//         });
//     }

//     searchInput.on('input', submitForm);

//     searchForm.submit(function (e) {
//         e.preventDefault();
//         submitForm();
//     });
// });

// $(document).ready(function () {
//     var searchForm = $('#searchForm');
//     var searchInput = $('#searchInput');

//     function submitForm() {
//         var searchInputValue = searchInput.val().trim();
//         if (searchInputValue === '') {
//             $('#orderTable').html(''); // Clear table content
//             return;
//         }
//         var csrfToken = $('meta[name="csrf-token"]').attr('content');
//         $.ajax({
//             url: searchForm.data('route'),
//             type: 'GET',
//             data: {
//                 '_token': csrfToken,
//                 'designation': searchInputValue,
//             },
//             dataType: 'html',
//             success: function (response) {
//                 console.log(response);
//                 $('#orderTable').html(response);
//             },
//             error: function (xhr, status, error) {
//                 console.error('Error fetching search results:', error);
//                 // $('#orderTable').html(''); 
//                 $('#orderTable').load(location.href + ' #orderTable');
//             }
//         });
//     }

//     // Trigger form submission on input and keyup events
//     searchInput.on('input keyup', function (e) {
//         submitForm();
//     });

//     searchForm.submit(function (e) {
//         e.preventDefault();
//         submitForm();
//     });
// });

$(document).ready(function () {
    var searchForm = $('#searchForm');
    var searchInput = $('#searchInput');

    function submitForm() {
        var searchInputValue = searchInput.val().trim();
        if (searchInputValue === '') {
            $('#orderTable').load(location.href + ' #orderTable');
            return;
        }
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: searchForm.data('route'),
            type: 'GET',
            data: {
                '_token': csrfToken,
                'designation': searchInputValue,
            },
            dataType: 'html',
            success: function (response) {
                console.log(response);
                $('#orderTable').html(response);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching search results:', error);
                $('#orderTable').load(location.href + ' #orderTable');
            }
        });
    }
    searchInput.on('keyup', function () {
        submitForm();
    });

    searchForm.submit(function (e) {
        e.preventDefault();
        submitForm();
    });

    searchInput.on('input keyup', function () {
        var searchInputValue = $(this).val().trim();

        if (searchInputValue === '') {
            submitForm();
        } else {
            submitForm();
        }
    });
    searchInput.on('keyup', function (e) {
        if (e.key === 'Backspace' && $(this).val().trim() === '') {
            submitForm();
        }
    });
});

