$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#loginForm").submit(function (e) {
        e.preventDefault();

        $("#message").empty();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === "success" && response.redirect) {
                    $("#message").html(
                        '<div class="success">Login successful! Redirecting...</div>'
                    );
                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 1500);
                } else {
                    $("#message").html(
                        '<div class="error">Unexpected response from server.</div>'
                    );
                }
            },
            error: function (xhr) {
                $(".error-text").text("");

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    if (errors) {
                        $.each(errors, function (key, value) {
                            $("." + key.replace(/\./g, "_") + "_error").text(
                                value[0]
                            );
                        });
                    } else if (xhr.responseJSON.message) {
                        $(".password_error").text(xhr.responseJSON.message);
                    }
                } else {
                    $(".invalid_credentials_error").text(
                        "Something went wrong. Please try again."
                    );
                }
            },
        });
    });
});
