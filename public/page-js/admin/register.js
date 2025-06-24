$(document).ready(function () {
    alert();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#registerForm").submit(function (e) {
        e.preventDefault();

        $("#message").empty();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === 'success' && response.redirect) {
                    $("#message").html('<div class="success">Registration successful! Redirecting to login...</div>');
                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 1500);
                } else {
                    $("#message").html('<div class="error">Unexpected server response.</div>');
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorHtml = '<div class="error"><ul>';
                $.each(errors, function (key, value) {
                    errorHtml += "<li>" + value[0] + "</li>";
                });
                errorHtml += "</ul></div>";
                $("#message").html(errorHtml);
            },
        });
    });
});
