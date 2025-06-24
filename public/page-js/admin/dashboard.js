$(document).ready(function() {
    alert('Script dashboard');

    $('#addFieldBtn').click(function() {
        var template = $('#templateRow').html();
        $('#fieldsTable tbody').append(template);
    });

    $('#fieldsTable').on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
    });
});