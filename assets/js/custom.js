$(document).ready(function() {
    $('#searchGroup').on('input', function() {
        var search = $(this).val();
        $.ajax({
            url: '/loco/includes/search_groups.php',
            method: 'GET',
            data: { search: search },
            success: function(data) {
                $('#groupTree').html(data);
            }
        });
    });
});