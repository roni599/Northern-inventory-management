$('#procurementproduct').change(function () {
    var selectedValue = $('#procurementproduct').val();
    // var userId = $(this).val();
    console.log(selectedValue);
    $.ajax({
        url: '/admin/search/procurement_report',
        method: 'GET',
        data: {
            selectedValue: selectedValue,
        },
        dataType: 'html',
        success: function (response) {
            console.log(response);
            $('#daysTable').html(response);

        },
        error: function (xhr, status, error) {
            $('#daysTable').load(location.href + ' #daysTable');
        }
    });
});

$('#procurementdays').change(function () {
    var selectedValue = $('#procurementdays').val();
    var today = new Date();
    var startDate;
    var endDate = new Date();

    switch (selectedValue) {
        case '0':
            startDate = new Date(today);
            startDate.setDate(today.getDate() + 1);
            break;
        case '1':
            startDate = new Date(today);
            startDate.setDate(today.getDate() + 1);
            break;
        case '2':
            startDate = new Date(today);
            startDate.setDate(today.getDate() - 6);
            break;
        case '3':
            startDate = new Date(today);
            startDate.setDate(today.getDate() - 29);
            break;
        default:
            startDate = null;
    }

    if (startDate) {
        var formattedStartDate = startDate.toISOString().substr(0, 10);
        var formattedEndDate = endDate.toISOString().substr(0, 10);
        $.ajax({
            url: '/admin/search/procurement_daysreport',
            method: 'GET',
            data: {
                start_date: formattedStartDate,
                end_date: formattedEndDate,
                selected_value: selectedValue,
            },
            success: function (response) {
                console.log(response);
                // Update the product table with the filtered data
                $('#daysTable').html(response);
            },
            error: function (xhr, status, error) {
                $('#daysTable').load(location.href + ' #daysTable');
            }
        });
    }
});
