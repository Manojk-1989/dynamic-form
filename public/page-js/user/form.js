$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    
$("#userForm").submit(function (e) {
    e.preventDefault();

    $("#message").empty();
    $(".error-text").remove(); // Clear any old errors

    $.ajax({
        url: $(this).attr("action"),
        method: $(this).attr("method"),
        data: $(this).serialize(),
        success: function (response) {
            if (response.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: response.message || "Operation completed successfully.",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "Something went wrong!",
                    text: response.message || "Unexpected server response.",
                });
            }
        },
        error: function (xhr) {
            $(".error-text").remove(); // Remove previous errors

            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;

                $.each(errors, function (key, messages) {
                    const message = messages[0];

                    // Try to find input by name or name[]
                    let $input = $(`[name="${key}"]`);
                    if (!$input.length) {
                        $input = $(`[name="${key}[]"]`);
                    }

                    // Append error message accordingly
                    if ($input.length) {
                        if ($input.attr("type") === "checkbox") {
                            // Append error after the checkbox group container
                            $input.last().closest('div').append(
                                `<span class="text-danger error-text text-sm block mt-1">${message}</span>`
                            );
                        } else {
                            $input.after(
                                `<span class="text-danger error-text text-sm">${message}</span>`
                            );
                        }
                    }
                });
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "Something went wrong!",
                    text: "Form submission failed or unexpected server response.",
                });
            }
        },
    });
});

});


