$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let currentOptionsInput = null;
    let currentOptionsSummary = null;

    function createOptionRow(value = "", description = "") {
        return `
            <tr>
                <td class="border border-gray-300 p-1">
                    <input type="text" class="option-value w-full border rounded px-2 py-1" value="${value}" required>
                </td>
                <td class="border border-gray-300 p-1">
                    <input type="text" class="option-description w-full border rounded px-2 py-1" value="${description}">
                </td>
                <td class="border border-gray-300 p-1 text-center">
                    <button type="button" class="deleteOptionRow text-red-600">Delete</button>
                </td>
            </tr>
        `;
    }

    $("body").on("click", ".btn-options-modal", function (e) {
        e.preventDefault();
        currentOptionsInput = $(this).next("input.options-hidden-input");
        currentOptionsSummary = currentOptionsInput.next(".options-summary");

        $("#optionsTableBody").empty();

        let optionsData = [];
        let raw = currentOptionsInput.val();
        try {
            optionsData = raw && raw !== "null" ? JSON.parse(raw) : [];
        } catch (err) {
            optionsData = [];
        }

        if (optionsData.length === 0) {
            $("#optionsTableBody").append(createOptionRow());
        } else {
            optionsData.forEach((opt) => {
                $("#optionsTableBody").append(
                    createOptionRow(opt.value, opt.description)
                );
            });
        }

        // Show modal
        $("#optionsModal").removeClass("hidden");
    });

    // Add new empty option row
    $("#addOptionRow").on("click", function () {
        $("#optionsTableBody").append(createOptionRow());
    });

    // Delete option row
    $("body").on("click", ".deleteOptionRow", function () {
        $(this).closest("tr").remove();
    });

    // Close modal
    $("#closeOptionsModal").on("click", function () {
        $("#optionsModal").addClass("hidden");
    });

    // Save options from modal
    $("#saveOptionsModal").on("click", function () {
        let optionsData = [];

        let valid = true;

        $("#optionsTableBody tr").each(function () {
            const value = $(this).find(".option-value").val().trim();
            const description = $(this)
                .find(".option-description")
                .val()
                .trim();

            if (value === "") {
                alert("Option value cannot be empty!");
                valid = false;
                return false; // break out of each loop
            }

            optionsData.push({ value, description });
        });

        if (!valid) return;

        // Save as JSON string in hidden input
        currentOptionsInput.val(JSON.stringify(optionsData));

        // Update summary (show only values, comma separated)
        const summaryText = optionsData.map((opt) => opt.value).join(", ");
        currentOptionsSummary.text(summaryText || "(No options)");

        // Close modal
        $("#optionsModal").addClass("hidden");
    });

    $("body").on("change", ".field-type", function () {
        const $row = $(this).closest("tr");
        const $btn = $row.find(".btn-options-modal");
        const $hiddenInput = $row.find(".options-hidden-input");
        const $summary = $row.find(".options-summary");

        if (["select", "radio", "checkbox"].includes($(this).val())) {
            $btn.prop("disabled", false).show();
            $hiddenInput.prop("disabled", false);
            $summary.show();
        } else {
            $btn.prop("disabled", true).hide();
            $hiddenInput.prop("disabled", false);
            $hiddenInput.val("null");
            $summary.hide().text("");
        }
    });

    let fieldIndex = $("#fieldsTable tbody tr").length;

    $("#addFieldBtn").click(function () {
        var template = $("#templateRow").html();
        var newRowHtml = template.replace(/__INDEX__/g, fieldIndex);
        $("#fieldsTable tbody").append(newRowHtml);
        fieldIndex++;
    });

    $("#fieldsTable").on("click", ".removeRowBtn", function () {
        const formFieldId = $(this).data("id");
        const formFieldDeleteUrl = $(this).data("url");
        if (formFieldId == undefined && formFieldDeleteUrl == undefined) {
            $(this).closest("tr").remove();
        } else {
            deleteFormElement(formFieldId, formFieldDeleteUrl);
        }
    });

    $("#createForm").submit(function (e) {
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
                $(".error-text").remove();
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, messages) {
                        const message = messages[0];
                        const parts = key.split(".");
                        const field = parts[0];
                        const index = parts[1];

                        let inputSelector;

                        if (index !== undefined) {
                            inputSelector = `input[name="${field}[]"]`;
                            const $input = $(inputSelector).eq(index);
                            if ($input.length) {
                                $input.after(
                                    `<span class="text-danger error-text text-sm">${message}</span>`
                                );
                            }
                        } else {
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
                            "Updation failed" || "Unexpected server response.",
                    });
                }
            },
        });
    });
});

function deleteFormElement(formFieldId, formFieldDeleteUrl) {
    $.ajax({
        url: formFieldDeleteUrl,
        type: "DELETE",

        success: function (response) {
            Swal.fire({
                icon: "success",
                title: "Deleted!",
                text: response.message || "Form deleted successfully.",
                showConfirmButton: false,
                timer: 1500,
            }).then(() => {
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    location.reload();
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
}
