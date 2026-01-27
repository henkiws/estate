<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rental Reference Form - Plyform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .btn-group button {
            flex: 1;
        }
        .btn-group button.active {
            background-color: #E5E7EB;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-2xl mx-auto py-8 px-4">
        
        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Plyform" class="h-12 mx-auto">
        </div>

        @if($alreadySubmitted)
            <!-- Already Submitted Message -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <div class="mb-6">
                    <svg class="w-16 h-16 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Reference Already Submitted</h2>
                <p class="text-gray-600">This reference has already been submitted. Thank you for your contribution!</p>
            </div>
        @else
            <!-- Form -->
            <form id="reference-form" method="POST" action="{{ route('address-reference.submit', $address->reference_token) }}" enctype="multipart/form-data">
                @csrf

                <!-- Display validation errors -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h3 class="text-sm font-semibold text-red-800 mb-2">Please correct the following errors:</h3>
                                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Header -->
                <div class="bg-red-600 text-white p-6 rounded-t-lg">
                    <h1 class="text-2xl font-bold">Rental Reference Form</h1>
                </div>

                <div class="bg-white shadow-sm rounded-b-lg p-6 space-y-6">
                    
                    <!-- Intro -->
                    <div>
                        <p class="text-gray-800">
                            You are completing a reference for <strong>{{ $address->user->profile->first_name }} {{ $address->user->profile->last_name }}</strong> at <strong>{{ $address->address }}</strong>
                        </p>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
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

                    <!-- Upload tenant ledger -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Upload tenant ledger</h3>
                        <p class="text-sm text-gray-600 mb-3">Property managers want to confirm that potential renters are able to pay rent</p>
                        
                        <input type="file" name="ref_tenant_ledger" id="ledger_file" accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                        <button type="button" onclick="document.getElementById('ledger_file').click()" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">
                            Add file
                        </button>
                        <div id="ledger_preview" class="mt-2 text-sm text-gray-600"></div>
                    </div>

                    <!-- Questions Title -->
                    <div>
                        <h3 class="font-semibold text-gray-900 text-lg">Questions</h3>
                    </div>

                    <!-- Question 1: Is leaseholder -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">Is this tenant a leaseholder or an approved occupant at the property mentioned above?</label>
                        <div class="btn-group flex border border-gray-300 rounded overflow-hidden">
                            <button type="button" onclick="selectOption('ref_is_leaseholder', 'yes')" data-field="ref_is_leaseholder" data-value="yes" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">Yes</button>
                            <button type="button" onclick="selectOption('ref_is_leaseholder', 'no')" data-field="ref_is_leaseholder" data-value="no" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">No</button>
                            <button type="button" onclick="selectOption('ref_is_leaseholder', 'n/a')" data-field="ref_is_leaseholder" data-value="n/a" class="py-2 px-4 hover:bg-gray-50">N/A</button>
                        </div>
                        <input type="hidden" name="ref_is_leaseholder" id="ref_is_leaseholder" value="{{ old('ref_is_leaseholder', $address->ref_is_leaseholder) }}">
                        <button type="button" onclick="toggleComment('comment_is_leaseholder')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_is_leaseholder_comment" id="comment_is_leaseholder" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_is_leaseholder_comment', $address->ref_is_leaseholder_comment) }}</textarea>
                    </div>

                    <!-- Question 2: Would rent again -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">Would you rent to this tenant again?</label>
                        <div class="btn-group flex border border-gray-300 rounded overflow-hidden">
                            <button type="button" onclick="selectOption('ref_would_rent_again', 'yes')" data-field="ref_would_rent_again" data-value="yes" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">Yes</button>
                            <button type="button" onclick="selectOption('ref_would_rent_again', 'no')" data-field="ref_would_rent_again" data-value="no" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">No</button>
                            <button type="button" onclick="selectOption('ref_would_rent_again', 'n/a')" data-field="ref_would_rent_again" data-value="n/a" class="py-2 px-4 hover:bg-gray-50">N/A</button>
                        </div>
                        <input type="hidden" name="ref_would_rent_again" id="ref_would_rent_again" value="{{ old('ref_would_rent_again', $address->ref_would_rent_again) }}">
                        <button type="button" onclick="toggleComment('comment_would_rent_again')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_would_rent_again_comment" id="comment_would_rent_again" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_would_rent_again_comment', $address->ref_would_rent_again_comment) }}</textarea>
                    </div>

                    <!-- Question 3: Lived at address -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">Did the tenant live at the above address from {{ \Carbon\Carbon::parse($address->user->profile->date_of_birth)->format('M Y') }} until {{ \Carbon\Carbon::now()->format('M Y') }}?</label>
                        <div class="btn-group flex border border-gray-300 rounded overflow-hidden">
                            <button type="button" onclick="selectOption('ref_lived_at_address', 'yes')" data-field="ref_lived_at_address" data-value="yes" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">Yes</button>
                            <button type="button" onclick="selectOption('ref_lived_at_address', 'no')" data-field="ref_lived_at_address" data-value="no" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">No</button>
                            <button type="button" onclick="selectOption('ref_lived_at_address', 'n/a')" data-field="ref_lived_at_address" data-value="n/a" class="py-2 px-4 hover:bg-gray-50">N/A</button>
                        </div>
                        <input type="hidden" name="ref_lived_at_address" id="ref_lived_at_address" value="{{ old('ref_lived_at_address', $address->ref_lived_at_address) }}">
                        <button type="button" onclick="toggleComment('comment_lived_at_address')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_lived_at_address_comment" id="comment_lived_at_address" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_lived_at_address_comment', $address->ref_lived_at_address_comment) }}</textarea>
                    </div>

                    <!-- Question 4: Rent paid on time -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">Was the rent always paid on time?</label>
                        <div class="btn-group flex border border-gray-300 rounded overflow-hidden">
                            <button type="button" onclick="selectOption('ref_rent_paid_on_time', 'yes')" data-field="ref_rent_paid_on_time" data-value="yes" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">Yes</button>
                            <button type="button" onclick="selectOption('ref_rent_paid_on_time', 'no')" data-field="ref_rent_paid_on_time" data-value="no" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">No</button>
                            <button type="button" onclick="selectOption('ref_rent_paid_on_time', 'n/a')" data-field="ref_rent_paid_on_time" data-value="n/a" class="py-2 px-4 hover:bg-gray-50">N/A</button>
                        </div>
                        <input type="hidden" name="ref_rent_paid_on_time" id="ref_rent_paid_on_time" value="{{ old('ref_rent_paid_on_time', $address->ref_rent_paid_on_time) }}">
                        <button type="button" onclick="toggleComment('comment_rent_paid_on_time')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_rent_paid_on_time_comment" id="comment_rent_paid_on_time" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_rent_paid_on_time_comment', $address->ref_rent_paid_on_time_comment) }}</textarea>
                    </div>

                    <!-- Question 5: Last inspection -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">When was the last routine inspection?</label>
                        <div class="grid grid-cols-2 gap-4">
                            <select name="ref_last_inspection_month" class="border border-gray-300 rounded px-3 py-2">
                                <option value="">Month</option>
                                @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                    <option value="{{ $month }}" {{ old('ref_last_inspection_month', $address->ref_last_inspection_month) == $month ? 'selected' : '' }}>{{ $month }}</option>
                                @endforeach
                            </select>
                            <select name="ref_last_inspection_year" class="border border-gray-300 rounded px-3 py-2">
                                <option value="">Year</option>
                                @for($year = now()->year; $year >= now()->year - 10; $year--)
                                    <option value="{{ $year }}" {{ old('ref_last_inspection_year', $address->ref_last_inspection_year) == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="button" onclick="toggleComment('comment_last_inspection')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_last_inspection_comment" id="comment_last_inspection" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_last_inspection_comment', $address->ref_last_inspection_comment) }}</textarea>
                    </div>

                    <!-- Question 6: Rent per week -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">What was the rent per week?</label>
                        <input type="number" name="ref_rent_per_week" step="0.01" min="0" value="{{ old('ref_rent_per_week', $address->ref_rent_per_week) }}" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Enter amount">
                        <button type="button" onclick="toggleComment('comment_rent_per_week')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_rent_per_week_comment" id="comment_rent_per_week" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_rent_per_week_comment', $address->ref_rent_per_week_comment) }}</textarea>
                    </div>

                    <!-- Question 7: Bond refund -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">Did they/will they receive a full bond refund?</label>
                        <div class="btn-group flex border border-gray-300 rounded overflow-hidden">
                            <button type="button" onclick="selectOption('ref_full_bond_refund', 'yes')" data-field="ref_full_bond_refund" data-value="yes" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">Yes</button>
                            <button type="button" onclick="selectOption('ref_full_bond_refund', 'no')" data-field="ref_full_bond_refund" data-value="no" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">No</button>
                            <button type="button" onclick="selectOption('ref_full_bond_refund', 'n/a')" data-field="ref_full_bond_refund" data-value="n/a" class="py-2 px-4 hover:bg-gray-50">N/A</button>
                        </div>
                        <input type="hidden" name="ref_full_bond_refund" id="ref_full_bond_refund" value="{{ old('ref_full_bond_refund', $address->ref_full_bond_refund) }}">
                        <button type="button" onclick="toggleComment('comment_full_bond_refund')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_full_bond_refund_comment" id="comment_full_bond_refund" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_full_bond_refund_comment', $address->ref_full_bond_refund_comment) }}</textarea>
                    </div>

                    <!-- Question 8: Breach free -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">Was the tenancy free of breach notices?</label>
                        <div class="btn-group flex border border-gray-300 rounded overflow-hidden">
                            <button type="button" onclick="selectOption('ref_breach_free', 'yes')" data-field="ref_breach_free" data-value="yes" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">Yes</button>
                            <button type="button" onclick="selectOption('ref_breach_free', 'no')" data-field="ref_breach_free" data-value="no" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">No</button>
                            <button type="button" onclick="selectOption('ref_breach_free', 'n/a')" data-field="ref_breach_free" data-value="n/a" class="py-2 px-4 hover:bg-gray-50">N/A</button>
                        </div>
                        <input type="hidden" name="ref_breach_free" id="ref_breach_free" value="{{ old('ref_breach_free', $address->ref_breach_free) }}">
                        <button type="button" onclick="toggleComment('comment_breach_free')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_breach_free_comment" id="comment_breach_free" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_breach_free_comment', $address->ref_breach_free_comment) }}</textarea>
                    </div>

                    <!-- Question 9: Property clean -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">Was the property found to be clean, undamaged and well maintained?</label>
                        <div class="btn-group flex border border-gray-300 rounded overflow-hidden">
                            <button type="button" onclick="selectOption('ref_property_clean', 'yes')" data-field="ref_property_clean" data-value="yes" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">Yes</button>
                            <button type="button" onclick="selectOption('ref_property_clean', 'no')" data-field="ref_property_clean" data-value="no" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">No</button>
                            <button type="button" onclick="selectOption('ref_property_clean', 'n/a')" data-field="ref_property_clean" data-value="n/a" class="py-2 px-4 hover:bg-gray-50">N/A</button>
                        </div>
                        <input type="hidden" name="ref_property_clean" id="ref_property_clean" value="{{ old('ref_property_clean', $address->ref_property_clean) }}">
                        <button type="button" onclick="toggleComment('comment_property_clean')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_property_clean_comment" id="comment_property_clean" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_property_clean_comment', $address->ref_property_clean_comment) }}</textarea>
                    </div>

                    <!-- Question 10: Had pet -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">Did the tenant have a pet during the tenancy?</label>
                        <div class="btn-group flex border border-gray-300 rounded overflow-hidden">
                            <button type="button" onclick="selectOption('ref_had_pet', 'yes')" data-field="ref_had_pet" data-value="yes" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">Yes</button>
                            <button type="button" onclick="selectOption('ref_had_pet', 'no')" data-field="ref_had_pet" data-value="no" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">No</button>
                            <button type="button" onclick="selectOption('ref_had_pet', 'n/a')" data-field="ref_had_pet" data-value="n/a" class="py-2 px-4 hover:bg-gray-50">N/A</button>
                        </div>
                        <input type="hidden" name="ref_had_pet" id="ref_had_pet" value="{{ old('ref_had_pet', $address->ref_had_pet) }}">
                        <button type="button" onclick="toggleComment('comment_had_pet')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_had_pet_comment" id="comment_had_pet" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_had_pet_comment', $address->ref_had_pet_comment) }}</textarea>
                    </div>

                    <!-- Question 11: Pet policy compliance -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">Did the tenant comply with the pet policy of the rental?</label>
                        <div class="btn-group flex border border-gray-300 rounded overflow-hidden">
                            <button type="button" onclick="selectOption('ref_pet_policy_complied', 'yes')" data-field="ref_pet_policy_complied" data-value="yes" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">Yes</button>
                            <button type="button" onclick="selectOption('ref_pet_policy_complied', 'no')" data-field="ref_pet_policy_complied" data-value="no" class="py-2 px-4 border-r border-gray-300 hover:bg-gray-50">No</button>
                            <button type="button" onclick="selectOption('ref_pet_policy_complied', 'n/a')" data-field="ref_pet_policy_complied" data-value="n/a" class="py-2 px-4 hover:bg-gray-50">N/A</button>
                        </div>
                        <input type="hidden" name="ref_pet_policy_complied" id="ref_pet_policy_complied" value="{{ old('ref_pet_policy_complied', $address->ref_pet_policy_complied) }}">
                        <button type="button" onclick="toggleComment('comment_pet_policy_complied')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_pet_policy_complied_comment" id="comment_pet_policy_complied" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_pet_policy_complied_comment', $address->ref_pet_policy_complied_comment) }}</textarea>
                    </div>

                    <!-- Question 12: Cooperative rating -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">How co-operative and pleasant was/is the tenant to deal with?</label>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Poor</span>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="selectCooperativeRating({{ $i }})" data-coop-rating="{{ $i }}" class="coop-rating-btn w-12 h-12 border border-gray-300 rounded hover:bg-gray-100 {{ old('ref_cooperative_rating', $address->ref_cooperative_rating) == $i ? 'bg-gray-200 font-bold' : '' }}">{{ $i }}</button>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">Excellent</span>
                        </div>
                        <input type="hidden" name="ref_cooperative_rating" id="ref_cooperative_rating" value="{{ old('ref_cooperative_rating', $address->ref_cooperative_rating) }}">
                        <button type="button" onclick="toggleComment('comment_cooperative_rating')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_cooperative_rating_comment" id="comment_cooperative_rating" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_cooperative_rating_comment', $address->ref_cooperative_rating_comment) }}</textarea>
                    </div>

                    <!-- Question 13: Property condition rating -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">What was the condition of the property when the tenant left?</label>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Poor</span>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="selectConditionRating({{ $i }})" data-condition-rating="{{ $i }}" class="condition-rating-btn w-12 h-12 border border-gray-300 rounded hover:bg-gray-100 {{ old('ref_property_condition_rating', $address->ref_property_condition_rating) == $i ? 'bg-gray-200 font-bold' : '' }}">{{ $i }}</button>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">Excellent</span>
                        </div>
                        <input type="hidden" name="ref_property_condition_rating" id="ref_property_condition_rating" value="{{ old('ref_property_condition_rating', $address->ref_property_condition_rating) }}">
                        <button type="button" onclick="toggleComment('comment_property_condition_rating')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_property_condition_rating_comment" id="comment_property_condition_rating" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_property_condition_rating_comment', $address->ref_property_condition_rating_comment) }}</textarea>
                    </div>

                    <!-- Question 14: Overall rating -->
                    <div class="space-y-2">
                        <label class="block text-sm text-gray-700">How would you rate your overall experience with the tenant?</label>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Poor</span>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="selectRating({{ $i }})" data-rating="{{ $i }}" class="rating-btn w-12 h-12 border border-gray-300 rounded hover:bg-gray-100 {{ old('ref_overall_rating', $address->ref_overall_rating) == $i ? 'bg-gray-200 font-bold' : '' }}">{{ $i }}</button>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">Excellent</span>
                        </div>
                        <input type="hidden" name="ref_overall_rating" id="ref_overall_rating" value="{{ old('ref_overall_rating', $address->ref_overall_rating) }}">
                        <button type="button" onclick="toggleComment('comment_overall_rating')" class="text-blue-600 text-sm hover:underline">Add comment</button>
                        <textarea name="ref_overall_rating_comment" id="comment_overall_rating" rows="2" class="hidden w-full border border-gray-300 rounded px-3 py-2 text-sm mt-2" placeholder="Add your comment...">{{ old('ref_overall_rating_comment', $address->ref_overall_rating_comment) }}</textarea>
                    </div>

                    <!-- Signature -->
                    <div class="border-t pt-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Signature</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="ref_signature_name" required class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Enter your full name" value="{{ old('ref_signature_name', $address->ref_signature_name) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Privacy Statement -->
                    <div class="border-t pt-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Rental Application Personal Information Privacy Statement</h3>
                        <div class="bg-gray-50 p-4 rounded text-xs text-gray-600 max-h-48 overflow-y-auto">
                            <p class="mb-2"><strong>Name:</strong> {{ $address->reference_full_name }}</p>
                            <p class="mb-4">{{ $address->user->profile->first_name }} {{ $address->user->profile->last_name }} (the 'Applicant') has submitted a Rental Application through the online tenancy application system operated by plyform.com. By submitting their Rental Application {{ $address->user->profile->first_name }} {{ $address->user->profile->last_name }} accepts the conditions set out in plyform's Rental Application Terms and Conditions...</p>
                            <p class="text-xs text-gray-500">Full terms and conditions apply.</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-6">
                        <button type="button" onclick="saveDraft()" class="flex-1 bg-gray-800 text-white py-3 rounded hover:bg-gray-900 transition font-semibold">
                            Save as draft
                        </button>
                        <button type="submit" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded hover:bg-gray-400 transition font-semibold">
                            Submit reference
                        </button>
                    </div>

                    <p class="text-xs text-center text-gray-500 mt-4">By submitting this reference, you agree to the terms and conditions above.</p>
                </div>
            </form>
        @endif
    </div>

    <script>
        // Select option for Yes/No/N/A buttons
        function selectOption(field, value) {
            // Update hidden input
            document.getElementById(field).value = value;
            
            // Remove error styling
            const buttonGroup = document.querySelector(`[data-field="${field}"]`)?.closest('.btn-group');
            if (buttonGroup) {
                buttonGroup.classList.remove('border-red-500');
                const errorMsg = buttonGroup.parentElement.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();
            }
            
            // Update button styles
            const buttons = document.querySelectorAll(`[data-field="${field}"]`);
            buttons.forEach(btn => {
                if (btn.dataset.value === value) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        }

        // Select rating
        function selectRating(rating) {
            document.getElementById('ref_overall_rating').value = rating;
            
            // Remove error styling
            const ratingContainer = document.querySelector('.rating-btn')?.closest('.space-y-2');
            if (ratingContainer) {
                const errorMsg = ratingContainer.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();
            }
            
            const buttons = document.querySelectorAll('.rating-btn');
            buttons.forEach(btn => {
                if (parseInt(btn.dataset.rating) === rating) {
                    btn.classList.add('bg-gray-200', 'font-bold');
                } else {
                    btn.classList.remove('bg-gray-200', 'font-bold');
                }
            });
        }

        // Select cooperative rating
        function selectCooperativeRating(rating) {
            document.getElementById('ref_cooperative_rating').value = rating;
            
            // Remove error styling
            const ratingContainer = document.querySelector('.coop-rating-btn')?.closest('.space-y-2');
            if (ratingContainer) {
                const errorMsg = ratingContainer.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();
            }
            
            const buttons = document.querySelectorAll('.coop-rating-btn');
            buttons.forEach(btn => {
                if (parseInt(btn.dataset.coopRating) === rating) {
                    btn.classList.add('bg-gray-200', 'font-bold');
                } else {
                    btn.classList.remove('bg-gray-200', 'font-bold');
                }
            });
        }

        // Select condition rating
        function selectConditionRating(rating) {
            document.getElementById('ref_property_condition_rating').value = rating;
            
            // Remove error styling
            const ratingContainer = document.querySelector('.condition-rating-btn')?.closest('.space-y-2');
            if (ratingContainer) {
                const errorMsg = ratingContainer.querySelector('.error-message');
                if (errorMsg) errorMsg.remove();
            }
            
            const buttons = document.querySelectorAll('.condition-rating-btn');
            buttons.forEach(btn => {
                if (parseInt(btn.dataset.conditionRating) === rating) {
                    btn.classList.add('bg-gray-200', 'font-bold');
                } else {
                    btn.classList.remove('bg-gray-200', 'font-bold');
                }
            });
        }

        // Toggle comment field
        function toggleComment(id) {
            const textarea = document.getElementById(id);
            textarea.classList.toggle('hidden');
            if (!textarea.classList.contains('hidden')) {
                textarea.focus();
            }
        }

        // File preview
        document.getElementById('ledger_file')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                document.getElementById('ledger_preview').textContent = `Selected: ${file.name}`;
            }
        });

        // Save as draft
        function saveDraft() {
            const formData = new FormData(document.getElementById('reference-form'));
            
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
                    alert(data.message);
                } else {
                    alert('Failed to save draft');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to save draft');
            });
        }

        // Show error message under field
        function showError(element, message) {
            // Remove existing error message
            const existingError = element.querySelector('.error-message');
            if (existingError) existingError.remove();
            
            // Create error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-red-600 text-sm mt-1 font-medium';
            errorDiv.textContent = message;
            element.appendChild(errorDiv);
            
            // Add red border
            const buttonGroup = element.querySelector('.btn-group');
            if (buttonGroup) {
                buttonGroup.classList.add('border-red-500');
            }
            
            const input = element.querySelector('input[type="text"], input[type="number"]');
            if (input) {
                input.classList.add('border-red-500');
            }
        }

        // Validate form before submission
        document.getElementById('reference-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear all previous errors
            document.querySelectorAll('.error-message').forEach(err => err.remove());
            document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
            
            let firstError = null;
            let hasErrors = false;
            
            // Validation rules
            const validations = [
                {
                    field: 'ref_is_leaseholder',
                    message: 'Please answer: Is this tenant a leaseholder or an approved occupant?',
                    selector: '[name="ref_is_leaseholder"]'
                },
                {
                    field: 'ref_would_rent_again',
                    message: 'Please answer: Would you rent to this tenant again?',
                    selector: '[name="ref_would_rent_again"]'
                },
                {
                    field: 'ref_lived_at_address',
                    message: 'Please answer: Did the tenant live at the above address?',
                    selector: '[name="ref_lived_at_address"]'
                },
                {
                    field: 'ref_rent_paid_on_time',
                    message: 'Please answer: Was the rent always paid on time?',
                    selector: '[name="ref_rent_paid_on_time"]'
                },
                {
                    field: 'ref_full_bond_refund',
                    message: 'Please answer: Did they receive a full bond refund?',
                    selector: '[name="ref_full_bond_refund"]'
                },
                {
                    field: 'ref_breach_free',
                    message: 'Please answer: Was the tenancy free of breach notices?',
                    selector: '[name="ref_breach_free"]'
                },
                {
                    field: 'ref_property_clean',
                    message: 'Please answer: Was the property found to be clean and well maintained?',
                    selector: '[name="ref_property_clean"]'
                },
                {
                    field: 'ref_had_pet',
                    message: 'Please answer: Did the tenant have a pet during the tenancy?',
                    selector: '[name="ref_had_pet"]'
                },
                {
                    field: 'ref_pet_policy_complied',
                    message: 'Please answer: Did the tenant comply with the pet policy?',
                    selector: '[name="ref_pet_policy_complied"]'
                },
                {
                    field: 'ref_cooperative_rating',
                    message: 'Please rate: How co-operative and pleasant was the tenant?',
                    selector: '[name="ref_cooperative_rating"]'
                },
                {
                    field: 'ref_property_condition_rating',
                    message: 'Please rate: What was the condition of the property when the tenant left?',
                    selector: '[name="ref_property_condition_rating"]'
                },
                {
                    field: 'ref_overall_rating',
                    message: 'Please rate: Your overall experience with the tenant',
                    selector: '[name="ref_overall_rating"]'
                },
                {
                    field: 'ref_signature_name',
                    message: 'Please enter your full name',
                    selector: '[name="ref_signature_name"]',
                    type: 'input'
                }
            ];
            
            // Check each validation
            validations.forEach(validation => {
                const input = document.getElementById(validation.field);
                const value = input ? input.value.trim() : '';
                
                if (!value) {
                    hasErrors = true;
                    
                    // Find the container
                    let container = input ? input.closest('.space-y-2') : null;
                    if (!container && validation.selector) {
                        const element = document.querySelector(validation.selector);
                        container = element ? element.closest('.space-y-2') : null;
                    }
                    
                    if (container) {
                        showError(container, validation.message);
                        
                        // Set first error for scrolling
                        if (!firstError) {
                            firstError = container;
                        }
                    }
                }
            });
            
            // If there are errors
            if (hasErrors) {
                // Scroll to first error
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                // Show error summary
                alert('Please fill in all required fields before submitting the reference.');
                return false;
            }
            
            // If no errors, submit the form
            this.submit();
        });

        // Initialize active buttons on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set active states for Yes/No/N/A buttons
            @foreach(['ref_is_leaseholder', 'ref_would_rent_again', 'ref_lived_at_address', 'ref_rent_paid_on_time', 'ref_full_bond_refund', 'ref_breach_free', 'ref_property_clean', 'ref_had_pet', 'ref_pet_policy_complied'] as $field)
                const {{ $field }}_value = document.getElementById('{{ $field }}').value;
                if ({{ $field }}_value) {
                    selectOption('{{ $field }}', {{ $field }}_value);
                }
            @endforeach

            // Set active ratings
            const rating = document.getElementById('ref_overall_rating').value;
            if (rating) {
                selectRating(parseInt(rating));
            }

            const coopRating = document.getElementById('ref_cooperative_rating').value;
            if (coopRating) {
                selectCooperativeRating(parseInt(coopRating));
            }

            const conditionRating = document.getElementById('ref_property_condition_rating').value;
            if (conditionRating) {
                selectConditionRating(parseInt(conditionRating));
            }

            // Show comments if they have content
            @foreach(['is_leaseholder', 'would_rent_again', 'lived_at_address', 'rent_paid_on_time', 'last_inspection', 'rent_per_week', 'full_bond_refund', 'breach_free', 'property_clean', 'had_pet', 'pet_policy_complied', 'cooperative_rating', 'property_condition_rating', 'overall_rating'] as $field)
                const comment_{{ $field }} = document.getElementById('comment_{{ $field }}');
                if (comment_{{ $field }} && comment_{{ $field }}.value.trim() !== '') {
                    comment_{{ $field }}.classList.remove('hidden');
                }
            @endforeach
        });
    </script>
</body>
</html>