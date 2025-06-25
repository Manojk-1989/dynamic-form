$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#addFieldBtn").click(function () {
        var template = $("#templateRow").html();
        $("#fieldsTable tbody").append(template);
    });

    $("#fieldsTable").on("click", ".removeRowBtn", function () {
        $(this).closest("tr").remove();
    });

    $(".delete-form-btn").on("click", function () {
        alert();
        if (!confirm("Are you sure you want to delete this form?")) return;

        const formId = $(this).data("id");
        const url = $(this).data("url");

        $.ajax({
            url: url,
            type: "DELETE",
            success: function (response) {
                alert(response.message || "Form deleted successfully");
                location.reload();
            },
            error: function (xhr, status, error) {
                alert("Error deleting form");
                console.error(error);
            },
        });
    });
});
