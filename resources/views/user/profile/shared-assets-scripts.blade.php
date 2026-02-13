<!-- jQuery (Required for Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Flatpickr JS -->
{{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/flowbite-datepicker@1.3.0/dist/js/datepicker.min.js"></script>

<script>
// Initialize Select2 (unchanged)
function initializeSelect2() {
    $('select').not('.no-select2').each(function() {
        if (!$(this).hasClass('select2-hidden-accessible')) {
            $(this).select2({
                width: '100%',
                minimumResultsForSearch: 10,
                allowClear: !$(this).prop('required'),
                placeholder: $(this).find('option:first').text() || 'Select...'
            });
        }
    });
}

// Initialize Flowbite Datepicker
function initializeDatepicker() {
    document.querySelectorAll('input[type="date"]').forEach(input => {
        if (input.dataset.datepickerInitialized) return;

        const minDateAttr = input.getAttribute('min');
        const maxDateAttr = input.getAttribute('max');

        const minDate = minDateAttr ? new Date(minDateAttr) : null;
        const maxDate = maxDateAttr ? new Date(maxDateAttr) : null;

        // Convert to text so Flowbite controls UI
        input.type = 'text';

        const picker = new Datepicker(input, {
            format: 'yyyy-mm-dd',
            autohide: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true
        });

        // Prevent manual input outside range
        input.addEventListener('changeDate', function(e) {
            const selectedDate = e.detail.date;

            if (minDate && selectedDate < minDate) {
                picker.setDate(minDate);
            }

            if (maxDate && selectedDate > maxDate) {
                picker.setDate(maxDate);
            }
        });

        input.dataset.datepickerInitialized = 'true';
    });
}

// Re-initialize for dynamic elements
function reinitializePlugins(container) {
    if (!container) return;

    // Select2
    $(container).find('select').not('.no-select2').each(function() {
        if (!$(this).hasClass('select2-hidden-accessible')) {
            $(this).select2({
                width: '100%',
                minimumResultsForSearch: 10,
                allowClear: !$(this).prop('required')
            });
        }
    });

    // Datepicker
    container.querySelectorAll('input[type="date"], input[data-datepicker]').forEach(input => {
        if (!input.dataset.datepickerInitialized) {
            input.type = 'text';

            new Datepicker(input, {
                format: 'yyyy-mm-dd',
                autohide: true
            });

            input.dataset.datepickerInitialized = 'true';
        }
    });
}

// On page load
document.addEventListener('DOMContentLoaded', function () {
    initializeSelect2();
    initializeDatepicker();
});
</script>
