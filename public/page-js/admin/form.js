$(document).ready(function() {
let currentOptionsInput = null;
    let currentOptionsSummary = null;

    function createOptionRow(value = '', description = '') {
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

    // Open modal on button click
    $('body').on('click', '.btn-options-modal', function (e) {
        e.preventDefault();
        currentOptionsInput = $(this).next('input.options-hidden-input');
        currentOptionsSummary = currentOptionsInput.next('.options-summary');

        // Clear current rows
        $('#optionsTableBody').empty();

        // Load existing options from hidden input (JSON string)
        let optionsData = [];
        try {
            optionsData = JSON.parse(currentOptionsInput.val() || '[]');
        } catch (err) {
            // fallback if not valid JSON, treat as empty
            optionsData = [];
        }

        if (optionsData.length === 0) {
            $('#optionsTableBody').append(createOptionRow());
        } else {
            optionsData.forEach(opt => {
                $('#optionsTableBody').append(createOptionRow(opt.value, opt.description));
            });
        }

        // Show modal
        $('#optionsModal').removeClass('hidden');
    });

    // Add new empty option row
    $('#addOptionRow').on('click', function () {
        $('#optionsTableBody').append(createOptionRow());
    });

    // Delete option row
    $('body').on('click', '.deleteOptionRow', function () {
        $(this).closest('tr').remove();
    });

    // Close modal
    $('#closeOptionsModal').on('click', function () {
        $('#optionsModal').addClass('hidden');
    });

    // Save options from modal
    $('#saveOptionsModal').on('click', function () {
        let optionsData = [];

        let valid = true;

        $('#optionsTableBody tr').each(function () {
            const value = $(this).find('.option-value').val().trim();
            const description = $(this).find('.option-description').val().trim();

            if (value === '') {
                alert('Option value cannot be empty!');
                valid = false;
                return false; // break out of each loop
            }

            optionsData.push({ value, description });
        });

        if (!valid) return;

        // Save as JSON string in hidden input
        currentOptionsInput.val(JSON.stringify(optionsData));

        // Update summary (show only values, comma separated)
        const summaryText = optionsData.map(opt => opt.value).join(', ');
        currentOptionsSummary.text(summaryText || '(No options)');

        // Close modal
        $('#optionsModal').addClass('hidden');
    });

// ------------------------
    // let currentOptionsInput = null;
    // let currentOptionsSummary = null;

    // // Open modal on button click
    // $('body').on('click', '.btn-options-modal', function (e) {
    //     e.preventDefault();
    //     currentOptionsInput = $(this).next('input.options-hidden-input');
    //     currentOptionsSummary = currentOptionsInput.next('.options-summary');

    //     // Load current options into textarea (one per line)
    //     const options = currentOptionsInput.val() ? currentOptionsInput.val().split(',') : [];
    //     $('#optionsTextarea').val(options.map(o => o.trim()).join('\n'));

    //     // Show modal
    //     $('#optionsModal').removeClass('hidden');
    // });

    // // Close modal
    // $('#closeOptionsModal').on('click', function () {
    //     $('#optionsModal').addClass('hidden');
    // });

    // // Save options from modal
    // $('#saveOptionsModal').on('click', function () {
    //     const textarea = $('#optionsTextarea');
    //     const options = textarea.val()
    //         .split('\n')
    //         .map(opt => opt.trim())
    //         .filter(opt => opt.length > 0);

    //     // Save to hidden input as comma-separated string
    //     currentOptionsInput.val(options.join(','));

    //     // Update summary text below the button
    //     currentOptionsSummary.text(options.length ? options.join(', ') : '(No options)');

    //     // Close modal
    //     $('#optionsModal').addClass('hidden');
    // });

    // // Show/hide options button based on selected field type
    $('body').on('change', '.field-type', function () {
        const $row = $(this).closest('tr');
        const $btn = $row.find('.btn-options-modal');
        const $hiddenInput = $row.find('.options-hidden-input');
        const $summary = $row.find('.options-summary');

        if (['select', 'radio', 'checkbox'].includes($(this).val())) {
            $btn.prop('disabled', false).show();
            $hiddenInput.prop('disabled', false);
            $summary.show();
        } else {
            $btn.prop('disabled', true).hide();
            $hiddenInput.prop('disabled', true);
            $hiddenInput.val('');
            $summary.hide().text('');
        }
    });

    // // Trigger change on page load to set button visibility correctly for existing rows
    // $('.field-type').each(function () {
    //     $(this).trigger('change');
    // });

    alert('Script form');

    $('#addFieldBtn').click(function() {
        var template = $('#templateRow').html();
        $('#fieldsTable tbody').append(template);
    });

    $('#fieldsTable').on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
    });

    $("#createForm").submit(function (e) {
        e.preventDefault();
alert($(this).attr("action"));
        $("#message").empty();

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === 'success' && response.redirect) {
                    $("#message").html(
                        '<div class="success">Login successful! Redirecting...</div>'
                    );
                    setTimeout(function () {
                        window.location.href = response.redirect; // Redirect dynamically based on server response
                    }, 1500);
                } else {
                    $("#message").html('<div class="error">Unexpected response from server.</div>');
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