<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rental Reference Form - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .plyform-green { color: #0d9488; }
        .bg-plyform-green { background-color: #0d9488; }
        .plyform-yellow { color: #E6FF4B; }
        .bg-plyform-yellow { background-color: #E6FF4B; }
        .plyform-purple { color: #5E17EB; }
        .bg-plyform-purple { background-color: #5E17EB; }
        .plyform-orange { color: #FF3600; }
        .bg-plyform-orange { background-color: #FF3600; }
        .plyform-dark { color: #1E1C1C; }
        .bg-plyform-dark { background-color: #1E1C1C; }
        
        /* Beautiful notification styles */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .notification {
            animation: slideIn 0.3s ease-out;
        }
        
        .notification.hiding {
            animation: slideOut 0.3s ease-in;
        }
        
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Notification Container -->
    <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Header -->
    <header class="bg-plyform-dark text-white py-6">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-2xl font-bold" style="color: #E6FF4B;">{{ config('app.name') }}</h1>
            <p class="text-gray-300 mt-1">Rental Reference Form</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-8">
        @if($alreadySubmitted)
            <!-- Already Submitted Message -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                <div class="mb-6">
                    <svg class="w-16 h-16 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Reference Already Submitted</h2>
                <p class="text-gray-600">This reference has already been submitted. Thank you for your contribution!</p>
            </div>
        @else
            <!-- Info Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Rental Reference Form</h2>
                <p class="text-gray-700 mb-4">You are completing a rental reference for <strong>{{ $address->user->profile->first_name }} {{ $address->user->profile->last_name }}</strong>.</p>
                
                <!-- Applicant Info -->
                <div class="bg-gray-50 border-l-4 border-plyform-yellow p-4 rounded mb-4">
                    <p class="text-sm text-gray-700"><strong>Name:</strong> {{ $address->user->profile->first_name }} {{ $address->user->profile->last_name }}</p>
                    <p class="text-sm text-gray-700"><strong>Address:</strong> {{ $address->address }}</p>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                    <div class="flex">
                        <svg class="h-5 w-5 text-blue-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-blue-800 text-sm">Protecting your feedback</p>
                            <p class="text-blue-700 text-sm">This information will only be shared back with the property manager.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form id="reference-form" method="POST" action="{{ route('address-reference.submit', $address->reference_token) }}" enctype="multipart/form-data">
                @csrf

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Upload Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Upload tenant ledger</h3>
                    <p class="text-sm text-gray-600 mb-4">Property managers want to confirm that potential renters are able to pay rent</p>
                    
                    <input type="file" name="ref_tenant_ledger" id="ledger_file" accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                    <button type="button" onclick="document.getElementById('ledger_file').click()" class="bg-plyform-green text-white px-6 py-2 rounded-lg hover:bg-[#036b62] transition">
                        Add file
                    </button>
                    <div id="ledger_preview" class="mt-2 text-sm text-gray-600"></div>
                </div>

                <!-- Questions Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Questions</h3>

                    <!-- Question 1: Is leaseholder -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            Is this tenant a leaseholder or an approved occupant at the property mentioned above? <span class="text-red-600">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <button type="button" onclick="selectOption('ref_is_leaseholder', 'yes', this)" 
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_is_leaseholder', $address->ref_is_leaseholder) == 'yes' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                Yes
                            </button>
                            <button type="button" onclick="selectOption('ref_is_leaseholder', 'no', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_is_leaseholder', $address->ref_is_leaseholder) == 'no' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                No
                            </button>
                            <button type="button" onclick="selectOption('ref_is_leaseholder', 'n/a', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_is_leaseholder', $address->ref_is_leaseholder) == 'n/a' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                N/A
                            </button>
                        </div>
                        <input type="hidden" name="ref_is_leaseholder" id="ref_is_leaseholder" value="{{ old('ref_is_leaseholder', $address->ref_is_leaseholder) }}">
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_is_leaseholder')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_is_leaseholder_section" class="mt-2 {{ old('ref_is_leaseholder_comment', $address->ref_is_leaseholder_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_is_leaseholder_comment" id="comment_is_leaseholder" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_is_leaseholder_comment', $address->ref_is_leaseholder_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 2: Would rent again -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            Would you rent to this tenant again? <span class="text-red-600">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <button type="button" onclick="selectOption('ref_would_rent_again', 'yes', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_would_rent_again', $address->ref_would_rent_again) == 'yes' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                Yes
                            </button>
                            <button type="button" onclick="selectOption('ref_would_rent_again', 'no', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_would_rent_again', $address->ref_would_rent_again) == 'no' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                No
                            </button>
                            <button type="button" onclick="selectOption('ref_would_rent_again', 'n/a', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_would_rent_again', $address->ref_would_rent_again) == 'n/a' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                N/A
                            </button>
                        </div>
                        <input type="hidden" name="ref_would_rent_again" id="ref_would_rent_again" value="{{ old('ref_would_rent_again', $address->ref_would_rent_again) }}">
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_would_rent_again')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_would_rent_again_section" class="mt-2 {{ old('ref_would_rent_again_comment', $address->ref_would_rent_again_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_would_rent_again_comment" id="comment_would_rent_again" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_would_rent_again_comment', $address->ref_would_rent_again_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 3: Lived at address -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            Did the tenant live at the above address from {{ \Carbon\Carbon::parse($address->user->profile->date_of_birth)->format('M Y') }} until {{ \Carbon\Carbon::now()->format('M Y') }}? <span class="text-red-600">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <button type="button" onclick="selectOption('ref_lived_at_address', 'yes', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_lived_at_address', $address->ref_lived_at_address) == 'yes' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                Yes
                            </button>
                            <button type="button" onclick="selectOption('ref_lived_at_address', 'no', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_lived_at_address', $address->ref_lived_at_address) == 'no' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                No
                            </button>
                            <button type="button" onclick="selectOption('ref_lived_at_address', 'n/a', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_lived_at_address', $address->ref_lived_at_address) == 'n/a' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                N/A
                            </button>
                        </div>
                        <input type="hidden" name="ref_lived_at_address" id="ref_lived_at_address" value="{{ old('ref_lived_at_address', $address->ref_lived_at_address) }}">
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_lived_at_address')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_lived_at_address_section" class="mt-2 {{ old('ref_lived_at_address_comment', $address->ref_lived_at_address_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_lived_at_address_comment" id="comment_lived_at_address" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_lived_at_address_comment', $address->ref_lived_at_address_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 4: Rent paid on time -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            Was the rent always paid on time? <span class="text-red-600">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <button type="button" onclick="selectOption('ref_rent_paid_on_time', 'yes', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_rent_paid_on_time', $address->ref_rent_paid_on_time) == 'yes' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                Yes
                            </button>
                            <button type="button" onclick="selectOption('ref_rent_paid_on_time', 'no', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_rent_paid_on_time', $address->ref_rent_paid_on_time) == 'no' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                No
                            </button>
                            <button type="button" onclick="selectOption('ref_rent_paid_on_time', 'n/a', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_rent_paid_on_time', $address->ref_rent_paid_on_time) == 'n/a' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                N/A
                            </button>
                        </div>
                        <input type="hidden" name="ref_rent_paid_on_time" id="ref_rent_paid_on_time" value="{{ old('ref_rent_paid_on_time', $address->ref_rent_paid_on_time) }}">
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_rent_paid_on_time')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_rent_paid_on_time_section" class="mt-2 {{ old('ref_rent_paid_on_time_comment', $address->ref_rent_paid_on_time_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_rent_paid_on_time_comment" id="comment_rent_paid_on_time" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_rent_paid_on_time_comment', $address->ref_rent_paid_on_time_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 5: Last inspection -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            When was the last routine inspection?
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <select name="ref_last_inspection_month" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green">
                                <option value="">Month</option>
                                @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                    <option value="{{ $month }}" {{ old('ref_last_inspection_month', $address->ref_last_inspection_month) == $month ? 'selected' : '' }}>{{ $month }}</option>
                                @endforeach
                            </select>
                            <select name="ref_last_inspection_year" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green">
                                <option value="">Year</option>
                                @for($year = now()->year; $year >= now()->year - 10; $year--)
                                    <option value="{{ $year }}" {{ old('ref_last_inspection_year', $address->ref_last_inspection_year) == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_last_inspection')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_last_inspection_section" class="mt-2 {{ old('ref_last_inspection_comment', $address->ref_last_inspection_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_last_inspection_comment" id="comment_last_inspection" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_last_inspection_comment', $address->ref_last_inspection_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 6: Rent per week -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            What was the rent per week?
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-500">$</span>
                            <input type="number" name="ref_rent_per_week" step="0.01" min="0" value="{{ old('ref_rent_per_week', $address->ref_rent_per_week) }}"
                                class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                placeholder="Enter amount">
                        </div>
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_rent_per_week')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_rent_per_week_section" class="mt-2 {{ old('ref_rent_per_week_comment', $address->ref_rent_per_week_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_rent_per_week_comment" id="comment_rent_per_week" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_rent_per_week_comment', $address->ref_rent_per_week_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 7: Bond refund -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            Did they/will they receive a full bond refund? <span class="text-red-600">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <button type="button" onclick="selectOption('ref_full_bond_refund', 'yes', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_full_bond_refund', $address->ref_full_bond_refund) == 'yes' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                Yes
                            </button>
                            <button type="button" onclick="selectOption('ref_full_bond_refund', 'no', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_full_bond_refund', $address->ref_full_bond_refund) == 'no' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                No
                            </button>
                            <button type="button" onclick="selectOption('ref_full_bond_refund', 'n/a', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_full_bond_refund', $address->ref_full_bond_refund) == 'n/a' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                N/A
                            </button>
                        </div>
                        <input type="hidden" name="ref_full_bond_refund" id="ref_full_bond_refund" value="{{ old('ref_full_bond_refund', $address->ref_full_bond_refund) }}">
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_full_bond_refund')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_full_bond_refund_section" class="mt-2 {{ old('ref_full_bond_refund_comment', $address->ref_full_bond_refund_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_full_bond_refund_comment" id="comment_full_bond_refund" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_full_bond_refund_comment', $address->ref_full_bond_refund_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 8: Breach free -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            Was the tenancy free of breach notices? <span class="text-red-600">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <button type="button" onclick="selectOption('ref_breach_free', 'yes', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_breach_free', $address->ref_breach_free) == 'yes' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                Yes
                            </button>
                            <button type="button" onclick="selectOption('ref_breach_free', 'no', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_breach_free', $address->ref_breach_free) == 'no' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                No
                            </button>
                            <button type="button" onclick="selectOption('ref_breach_free', 'n/a', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_breach_free', $address->ref_breach_free) == 'n/a' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                N/A
                            </button>
                        </div>
                        <input type="hidden" name="ref_breach_free" id="ref_breach_free" value="{{ old('ref_breach_free', $address->ref_breach_free) }}">
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_breach_free')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_breach_free_section" class="mt-2 {{ old('ref_breach_free_comment', $address->ref_breach_free_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_breach_free_comment" id="comment_breach_free" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_breach_free_comment', $address->ref_breach_free_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 9: Property clean -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            Was the property found to be clean, undamaged and well maintained? <span class="text-red-600">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <button type="button" onclick="selectOption('ref_property_clean', 'yes', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_property_clean', $address->ref_property_clean) == 'yes' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                Yes
                            </button>
                            <button type="button" onclick="selectOption('ref_property_clean', 'no', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_property_clean', $address->ref_property_clean) == 'no' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                No
                            </button>
                            <button type="button" onclick="selectOption('ref_property_clean', 'n/a', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_property_clean', $address->ref_property_clean) == 'n/a' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                N/A
                            </button>
                        </div>
                        <input type="hidden" name="ref_property_clean" id="ref_property_clean" value="{{ old('ref_property_clean', $address->ref_property_clean) }}">
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_property_clean')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_property_clean_section" class="mt-2 {{ old('ref_property_clean_comment', $address->ref_property_clean_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_property_clean_comment" id="comment_property_clean" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_property_clean_comment', $address->ref_property_clean_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 10: Had pet -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            Did the tenant have a pet during the tenancy? <span class="text-red-600">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <button type="button" onclick="selectOption('ref_had_pet', 'yes', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_had_pet', $address->ref_had_pet) == 'yes' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                Yes
                            </button>
                            <button type="button" onclick="selectOption('ref_had_pet', 'no', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_had_pet', $address->ref_had_pet) == 'no' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                No
                            </button>
                            <button type="button" onclick="selectOption('ref_had_pet', 'n/a', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_had_pet', $address->ref_had_pet) == 'n/a' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                N/A
                            </button>
                        </div>
                        <input type="hidden" name="ref_had_pet" id="ref_had_pet" value="{{ old('ref_had_pet', $address->ref_had_pet) }}">
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_had_pet')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_had_pet_section" class="mt-2 {{ old('ref_had_pet_comment', $address->ref_had_pet_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_had_pet_comment" id="comment_had_pet" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_had_pet_comment', $address->ref_had_pet_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 11: Pet policy compliance -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            Did the tenant comply with the pet policy of the rental? <span class="text-red-600">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <button type="button" onclick="selectOption('ref_pet_policy_complied', 'yes', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_pet_policy_complied', $address->ref_pet_policy_complied) == 'yes' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                Yes
                            </button>
                            <button type="button" onclick="selectOption('ref_pet_policy_complied', 'no', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_pet_policy_complied', $address->ref_pet_policy_complied) == 'no' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                No
                            </button>
                            <button type="button" onclick="selectOption('ref_pet_policy_complied', 'n/a', this)"
                                class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('ref_pet_policy_complied', $address->ref_pet_policy_complied) == 'n/a' ? 'border-plyform-green bg-[#bbf7d0]' : '' }}">
                                N/A
                            </button>
                        </div>
                        <input type="hidden" name="ref_pet_policy_complied" id="ref_pet_policy_complied" value="{{ old('ref_pet_policy_complied', $address->ref_pet_policy_complied) }}">
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_pet_policy_complied')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_pet_policy_complied_section" class="mt-2 {{ old('ref_pet_policy_complied_comment', $address->ref_pet_policy_complied_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_pet_policy_complied_comment" id="comment_pet_policy_complied" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_pet_policy_complied_comment', $address->ref_pet_policy_complied_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 12: Cooperative rating -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            How co-operative and pleasant was/is the tenant to deal with? <span class="text-red-600">*</span>
                        </label>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Poor</span>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="selectCooperativeRating({{ $i }})" data-coop-rating="{{ $i }}" 
                                        class="coop-rating-btn w-12 h-12 border-2 border-gray-300 rounded-lg hover:border-plyform-green transition-colors {{ old('ref_cooperative_rating', $address->ref_cooperative_rating) == $i ? 'border-plyform-green bg-[#bbf7d0] font-bold' : '' }}">
                                        {{ $i }}
                                    </button>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">Excellent</span>
                        </div>
                        <input type="hidden" name="ref_cooperative_rating" id="ref_cooperative_rating" value="{{ old('ref_cooperative_rating', $address->ref_cooperative_rating) }}">
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_cooperative_rating')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_cooperative_rating_section" class="mt-2 {{ old('ref_cooperative_rating_comment', $address->ref_cooperative_rating_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_cooperative_rating_comment" id="comment_cooperative_rating" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_cooperative_rating_comment', $address->ref_cooperative_rating_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 13: Property condition rating -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            What was the condition of the property when the tenant left? <span class="text-red-600">*</span>
                        </label>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Poor</span>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="selectConditionRating({{ $i }})" data-condition-rating="{{ $i }}" 
                                        class="condition-rating-btn w-12 h-12 border-2 border-gray-300 rounded-lg hover:border-plyform-green transition-colors {{ old('ref_property_condition_rating', $address->ref_property_condition_rating) == $i ? 'border-plyform-green bg-[#bbf7d0] font-bold' : '' }}">
                                        {{ $i }}
                                    </button>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">Excellent</span>
                        </div>
                        <input type="hidden" name="ref_property_condition_rating" id="ref_property_condition_rating" value="{{ old('ref_property_condition_rating', $address->ref_property_condition_rating) }}">
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_property_condition_rating')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_property_condition_rating_section" class="mt-2 {{ old('ref_property_condition_rating_comment', $address->ref_property_condition_rating_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_property_condition_rating_comment" id="comment_property_condition_rating" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_property_condition_rating_comment', $address->ref_property_condition_rating_comment) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Question 14: Overall rating -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-900 mb-3">
                            How would you rate your overall experience with the tenant? <span class="text-red-600">*</span>
                        </label>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Poor</span>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="selectRating({{ $i }})" data-rating="{{ $i }}" 
                                        class="rating-btn w-12 h-12 border-2 border-gray-300 rounded-lg hover:border-plyform-green transition-colors {{ old('ref_overall_rating', $address->ref_overall_rating) == $i ? 'border-plyform-green bg-[#bbf7d0] font-bold' : '' }}">
                                        {{ $i }}
                                    </button>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">Excellent</span>
                        </div>
                        <input type="hidden" name="ref_overall_rating" id="ref_overall_rating" value="{{ old('ref_overall_rating', $address->ref_overall_rating) }}">
                        
                        <div class="mt-3">
                            <button type="button" onclick="toggleComment('comment_overall_rating')" class="text-sm text-blue-600 hover:underline">
                                Add comment
                            </button>
                            <div id="comment_overall_rating_section" class="mt-2 {{ old('ref_overall_rating_comment', $address->ref_overall_rating_comment) ? '' : 'hidden' }}">
                                <textarea name="ref_overall_rating_comment" id="comment_overall_rating" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                    placeholder="Add your comment...">{{ old('ref_overall_rating_comment', $address->ref_overall_rating_comment) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signature Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Signature</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-600">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="ref_signature_name" 
                            id="ref_signature_name"
                            required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green" 
                            placeholder="Enter your full name" 
                            value="{{ old('ref_signature_name', $address->ref_signature_name) }}"
                        >
                    </div>
                </div>

                <!-- Privacy Statement -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Rental Application Personal Information Privacy Statement</h3>
                    <div class="bg-gray-50 p-4 rounded-lg text-xs text-gray-600 max-h-48 overflow-y-auto">
                        <p class="mb-2"><strong>Name:</strong> {{ $address->reference_full_name }}</p>
                        <p class="mb-4">{{ $address->user->profile->first_name }} {{ $address->user->profile->last_name }} (the 'Applicant') has submitted a Rental Application through the online tenancy application system operated by plyform.com. By submitting their Rental Application {{ $address->user->profile->first_name }} {{ $address->user->profile->last_name }} accepts the conditions set out in plyform's Rental Application Terms and Conditions...</p>
                        <p class="text-xs text-gray-500">Full terms and conditions apply.</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="button" onclick="saveDraft()" class="flex-1 bg-gray-800 text-white py-3 rounded-lg font-semibold hover:bg-gray-900 transition-colors">
                        Save as draft
                    </button>
                    <button type="submit" class="flex-1 bg-plyform-green text-white py-3 rounded-lg font-semibold hover:bg-[#036b62] transition-colors">
                        Submit reference
                    </button>
                </div>

                <p class="text-xs text-center text-gray-500 mt-4">By submitting this reference, you agree to the terms and conditions above.</p>
            </form>
        @endif

        <!-- Privacy Notice -->
        <div class="mt-6 text-center text-xs text-gray-500">
            <p>By submitting this form, you confirm that the information provided is accurate.</p>
            <p class="mt-2">
                <a href="{{ config('app.url') }}/privacy" class="text-blue-600 hover:underline">Privacy Policy</a> | 
                <a href="{{ config('app.url') }}/terms" class="text-blue-600 hover:underline">Terms of Use</a>
            </p>
        </div>
    </main>

    <script>
        // ✅ Beautiful notification system
        function showNotification(message, type = 'info') {
            const colors = {
                success: { bg: 'bg-green-50', border: 'border-green-500', text: 'text-green-800', icon: 'text-green-500' },
                error: { bg: 'bg-red-50', border: 'border-red-500', text: 'text-red-800', icon: 'text-red-500' },
                warning: { bg: 'bg-yellow-50', border: 'border-yellow-500', text: 'text-yellow-800', icon: 'text-yellow-500' },
                info: { bg: 'bg-blue-50', border: 'border-blue-500', text: 'text-blue-800', icon: 'text-blue-500' }
            };
            
            const icons = {
                success: '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>',
                error: '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>',
                warning: '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>',
                info: '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>'
            };
            
            const color = colors[type] || colors.info;
            const icon = icons[type] || icons.info;
            
            const notification = document.createElement('div');
            notification.className = `notification ${color.bg} ${color.border} border-l-4 p-4 rounded-r-lg shadow-lg max-w-md`;
            notification.innerHTML = `
                <div class="flex items-start">
                    <svg class="w-5 h-5 ${color.icon} mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        ${icon}
                    </svg>
                    <div class="flex-1">
                        <p class="${color.text} text-sm font-medium">${message}</p>
                    </div>
                    <button onclick="this.closest('.notification').remove()" class="ml-3 ${color.text} hover:opacity-70">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `;
            
            document.getElementById('notification-container').appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('hiding');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Select option for Yes/No/N/A buttons
        function selectOption(field, value, button) {
            // Update hidden input
            document.getElementById(field).value = value;
            
            // Update button styles
            const container = button.parentElement;
            container.querySelectorAll('.option-btn').forEach(btn => {
                btn.classList.remove('border-plyform-green', 'bg-[#bbf7d0]');
                btn.classList.add('border-gray-300');
            });
            button.classList.remove('border-gray-300');
            button.classList.add('border-plyform-green', 'bg-[#bbf7d0]');
        }

        // Select rating
        function selectRating(rating) {
            document.getElementById('ref_overall_rating').value = rating;
            const buttons = document.querySelectorAll('.rating-btn');
            buttons.forEach(btn => {
                btn.classList.remove('border-plyform-green', 'bg-[#bbf7d0]', 'font-bold');
                btn.classList.add('border-gray-300');
                if (parseInt(btn.dataset.rating) === rating) {
                    btn.classList.remove('border-gray-300');
                    btn.classList.add('border-plyform-green', 'bg-[#bbf7d0]', 'font-bold');
                }
            });
        }

        function selectCooperativeRating(rating) {
            document.getElementById('ref_cooperative_rating').value = rating;
            const buttons = document.querySelectorAll('.coop-rating-btn');
            buttons.forEach(btn => {
                btn.classList.remove('border-plyform-green', 'bg-[#bbf7d0]', 'font-bold');
                btn.classList.add('border-gray-300');
                if (parseInt(btn.dataset.coopRating) === rating) {
                    btn.classList.remove('border-gray-300');
                    btn.classList.add('border-plyform-green', 'bg-[#bbf7d0]', 'font-bold');
                }
            });
        }

        function selectConditionRating(rating) {
            document.getElementById('ref_property_condition_rating').value = rating;
            const buttons = document.querySelectorAll('.condition-rating-btn');
            buttons.forEach(btn => {
                btn.classList.remove('border-plyform-green', 'bg-[#bbf7d0]', 'font-bold');
                btn.classList.add('border-gray-300');
                if (parseInt(btn.dataset.conditionRating) === rating) {
                    btn.classList.remove('border-gray-300');
                    btn.classList.add('border-plyform-green', 'bg-[#bbf7d0]', 'font-bold');
                }
            });
        }

        // Toggle comment section
        function toggleComment(id) {
            const section = document.getElementById(id + '_section');
            const textarea = document.getElementById(id);
            section.classList.toggle('hidden');
            if (!section.classList.contains('hidden')) {
                textarea.focus();
            }
        }

        // File upload preview
        document.getElementById('ledger_file')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                document.getElementById('ledger_preview').textContent = `Selected: ${file.name}`;
            }
        });

        // Save draft function
        function saveDraft() {
            const formData = new FormData(document.getElementById('reference-form'));
            
            showNotification('Saving draft...', 'info');
            
            fetch('{{ route("address-reference.draft", $address->reference_token) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                } else {
                    showNotification('Failed to save draft', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to save draft. Please try again.', 'error');
            });
        }

        // Form validation on submit
        document.getElementById('reference-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let hasErrors = false;
            const required = ['ref_is_leaseholder', 'ref_would_rent_again', 'ref_lived_at_address', 'ref_rent_paid_on_time', 'ref_full_bond_refund', 'ref_breach_free', 'ref_property_clean', 'ref_had_pet', 'ref_pet_policy_complied', 'ref_cooperative_rating', 'ref_property_condition_rating', 'ref_overall_rating', 'ref_signature_name'];
            
            required.forEach(field => {
                const input = document.getElementById(field);
                if (!input || !input.value.trim()) {
                    hasErrors = true;
                }
            });
            
            if (hasErrors) {
                showNotification('Please fill in all required fields before submitting', 'error');
                return false;
            }
            
            this.submit();
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Restore selected options on page load
            @foreach(['ref_is_leaseholder', 'ref_would_rent_again', 'ref_lived_at_address', 'ref_rent_paid_on_time', 'ref_full_bond_refund', 'ref_breach_free', 'ref_property_clean', 'ref_had_pet', 'ref_pet_policy_complied'] as $field)
                const {{ $field }}_value = document.getElementById('{{ $field }}').value;
                if ({{ $field }}_value) {
                    const {{ $field }}_button = document.querySelector('[onclick="selectOption(\'{{ $field }}\', \'' + {{ $field }}_value + '\', this)"]');
                    if ({{ $field }}_button) {
                        {{ $field }}_button.classList.remove('border-gray-300');
                        {{ $field }}_button.classList.add('border-plyform-green', 'bg-[#bbf7d0]');
                    }
                }
            @endforeach

            // Restore ratings
            const rating = document.getElementById('ref_overall_rating').value;
            if (rating) selectRating(parseInt(rating));

            const coopRating = document.getElementById('ref_cooperative_rating').value;
            if (coopRating) selectCooperativeRating(parseInt(coopRating));

            const conditionRating = document.getElementById('ref_property_condition_rating').value;
            if (conditionRating) selectConditionRating(parseInt(conditionRating));

            // Show comments that have content
            @foreach(['is_leaseholder', 'would_rent_again', 'lived_at_address', 'rent_paid_on_time', 'last_inspection', 'rent_per_week', 'full_bond_refund', 'breach_free', 'property_clean', 'had_pet', 'pet_policy_complied', 'cooperative_rating', 'property_condition_rating', 'overall_rating'] as $field)
                const comment_{{ $field }} = document.getElementById('comment_{{ $field }}');
                if (comment_{{ $field }} && comment_{{ $field }}.value.trim() !== '') {
                    document.getElementById('comment_{{ $field }}_section').classList.remove('hidden');
                }
            @endforeach
        });
    </script>
</body>
</html>