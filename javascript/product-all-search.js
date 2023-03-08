$(document).ready(function () {
    $('#search').keyup(function () {
        var query = $(this).val();
        if (query.length >= 0) {
            $.ajax({
                url: '../../process/product-search-process.php',
                type: 'POST',
                data: {
                    query: query
                },
                success: function (data) {
                    $('#results').html(data);
                }
            });
        }
    });
});