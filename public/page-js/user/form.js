$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    

    $("#userForm").submit(function (e) {
        e.preventDefault();

        $("#message").empty();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text:
                            response.message ||
                            "Operation completed successfully.",
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
                        const parts = key.split(".");
                        const field = parts[0];
                        const index = parts[1];

                        let inputSelector;

                        if (index !== undefined) {
                            // For array fields like label[], name[]
                            inputSelector = `input[name="${field}[]"]`;
                            const $input = $(inputSelector).eq(index);
                            if ($input.length) {
                                $input.after(
                                    `<span class="text-danger error-text text-sm">${message}</span>`
                                );
                            }
                        } else {
                            // For single fields like title, description
                            const $input = $(`[name="${field}"]`);
                            if ($input.length) {
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
                        text:
                            "Form submission failed" ||
                            "Unexpected server response.",
                    });
                }
            },
        });
    });
});


