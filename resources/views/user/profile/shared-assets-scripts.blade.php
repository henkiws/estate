<!-- jQuery (Required for Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
// Initialize Select2 on all selects
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

// Initialize Flatpickr on all date inputs
function initializeFlatpickr() {
    document.querySelectorAll('input[type="date"]').forEach(input => {
        if (!input._flatpickr) {
            const minDate = input.getAttribute('min') || null;
            const maxDate = input.getAttribute('max') || null;
            
            flatpickr(input, {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'F j, Y',
                minDate: minDate,
                maxDate: maxDate,
                allowInput: true,
                disableMobile: false
            });
        }
    });
}

// Re-initialize both plugins for new elements
function reinitializePlugins(container) {
    if (!container) return;
    
    // Re-initialize Select2
    $(container).find('select').not('.no-select2').each(function() {
        if (!$(this).hasClass('select2-hidden-accessible')) {
            $(this).select2({
                width: '100%',
                minimumResultsForSearch: 10,
                allowClear: !$(this).prop('required')
            });
        }
    });
    
    // Re-initialize Flatpickr
    container.querySelectorAll('input[type="date"]').forEach(input => {
        if (!input._flatpickr) {
            const minDate = input.getAttribute('min') || null;
            const maxDate = input.getAttribute('max') || null;
            
            flatpickr(input, {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'F j, Y',
                minDate: minDate,
                maxDate: maxDate,
                allowInput: true,
                disableMobile: false
            });
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeSelect2();
    initializeFlatpickr();
});
</script>