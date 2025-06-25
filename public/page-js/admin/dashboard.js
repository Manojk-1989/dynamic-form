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
                Swal.fire({
                    icon: "success",
                    title: "Deleted!",
                    text: response.message || "Form deleted successfully.",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    // Redirect or reload *after* showing Swal
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        location.reload(); // reload only once
                    }
                });
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong while deleting.",
                });
            },
        });
    });
});
