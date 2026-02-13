<!-- Profile Cards - Shared Assets -->
<!-- Include this in the <head> section of your layout or at the top of overview.blade.php -->

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Flatpickr CSS -->
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> --}}

<!-- intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/css/intlTelInput.css">

<!-- Select2 Custom Styling for Tailwind -->
<style>
    /* Select2 Tailwind Integration */
    .select2-container--default .select2-selection--single {
        height: 48px !important;
        padding: 8px 16px !important;
        border: 1px solid #d1d5db !important;
        border-radius: 0.5rem !important;
        font-size: 0.875rem !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 32px !important;
        color: #374151 !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
        right: 8px !important;
    }
    
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #14b8a6 !important;
        box-shadow: 0 0 0 2px rgba(20, 184, 166, 0.2) !important;
    }
    
    .select2-dropdown {
        border: 1px solid #d1d5db !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
    }
    
    .select2-results__option--highlighted {
        background-color: #14b8a6 !important;
    }
    
    .select2-search--dropdown .select2-search__field {
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        padding: 8px 12px !important;
    }
    
    /* Flatpickr Custom Styling */
    /* .flatpickr-calendar {
        border-radius: 0.5rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
    }
    
    .flatpickr-day.selected {
        background: #14b8a6 !important;
        border-color: #14b8a6 !important;
    }
    
    .flatpickr-day:hover {
        background: #f0fdfa !important;
        border-color: #99f6e4 !important;
    } */
     .datepicker-cell.disabled {
        color: #d1d5db !important;
        /* background-color: #f3f4f6 !important; */
        cursor: not-allowed !important;
        pointer-events: none !important;
    }

    .dark .datepicker-cell.disabled {
        color: #6b7280 !important;
        /* background-color: #374151 !important; */
    }
</style>