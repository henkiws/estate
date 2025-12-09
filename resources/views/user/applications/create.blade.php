<x-user-layout title="Apply for Property">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('properties.show', $property->property_code) }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Property
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="{ currentStep: 1 }">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-200 p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Rental Application</h1>
                <p class="text-gray-600 mb-8">Complete the form below to apply for this property</p>

                <!-- Progress Steps -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <button type="button" @click="currentStep = 1" :class="currentStep >= 1 ? 'text-primary' : 'text-gray-400'" class="flex items-center gap-2">
                            <div :class="currentStep >= 1 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'" class="w-8 h-8 rounded-full flex items-center justify-center font-semibold text-sm">1</div>
                            <span class="hidden sm:inline text-sm font-medium">Personal</span>
                        </button>
                        <div :class="currentStep >= 2 ? 'bg-primary' : 'bg-gray-200'" class="flex-1 h-1 mx-2"></div>
                        
                        <button type="button" @click="currentStep = 2" :class="currentStep >= 2 ? 'text-primary' : 'text-gray-400'" class="flex items-center gap-2">
                            <div :class="currentStep >= 2 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'" class="w-8 h-8 rounded-full flex items-center justify-center font-semibold text-sm">2</div>
                            <span class="hidden sm:inline text-sm font-medium">Employment</span>
                        </button>
                        <div :class="currentStep >= 3 ? 'bg-primary' : 'bg-gray-200'" class="flex-1 h-1 mx-2"></div>
                        
                        <button type="button" @click="currentStep = 3" :class="currentStep >= 3 ? 'text-primary' : 'text-gray-400'" class="flex items-center gap-2">
                            <div :class="currentStep >= 3 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'" class="w-8 h-8 rounded-full flex items-center justify-center font-semibold text-sm">3</div>
                            <span class="hidden sm:inline text-sm font-medium">References</span>
                        </button>
                        <div :class="currentStep >= 4 ? 'bg-primary' : 'bg-gray-200'" class="flex-1 h-1 mx-2"></div>
                        
                        <button type="button" @click="currentStep = 4" :class="currentStep >= 4 ? 'text-primary' : 'text-gray-400'" class="flex items-center gap-2">
                            <div :class="currentStep >= 4 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'" class="w-8 h-8 rounded-full flex items-center justify-center font-semibold text-sm">4</div>
                            <span class="hidden sm:inline text-sm font-medium">Review</span>
                        </button>
                    </div>
                </div>

                <form action="{{ route('user.apply.store', $property->property_code) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Step 1: Personal Information -->
                    <div x-show="currentStep === 1" x-transition>
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Personal Information</h2>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', Auth::user()->name) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                                    <input type="tel" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Address *</label>
                                <textarea name="current_address" rows="2" required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('current_address') }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Move-in Date *</label>
                                    <input type="date" name="move_in_date" value="{{ old('move_in_date') }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Occupants *</label>
                                    <input type="number" name="number_of_occupants" value="{{ old('number_of_occupants', 1) }}" min="1" max="20" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Do you have pets? *</label>
                                <div class="flex gap-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="has_pets" value="0" {{ old('has_pets', '0') == '0' ? 'checked' : '' }} class="mr-2 text-primary focus:ring-primary">
                                        No
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="has_pets" value="1" {{ old('has_pets') == '1' ? 'checked' : '' }} class="mr-2 text-primary focus:ring-primary">
                                        Yes
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pet Details (if yes)</label>
                                <textarea name="pet_details" rows="2" placeholder="Describe your pets..."
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('pet_details') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="button" @click="currentStep = 2" class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                                Next Step →
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Employment -->
                    <div x-show="currentStep === 2" x-transition>
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Employment Information</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Employment Status *</label>
                                <select name="employment_status" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="">Select status</option>
                                    <option value="employed">Employed</option>
                                    <option value="self_employed">Self-Employed</option>
                                    <option value="student">Student</option>
                                    <option value="retired">Retired</option>
                                    <option value="unemployed">Unemployed</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Employer Name</label>
                                <input type="text" name="employer_name" value="{{ old('employer_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Job Title</label>
                                <input type="text" name="job_title" value="{{ old('job_title') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Annual Income *</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-600">$</span>
                                    <input type="number" name="annual_income" value="{{ old('annual_income') }}" required min="0" step="1000"
                                           class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-between">
                            <button type="button" @click="currentStep = 1" class="px-8 py-3 border border-gray-300 text-gray-700 hover:border-primary hover:text-primary font-semibold rounded-xl transition-colors">
                                ← Previous
                            </button>
                            <button type="button" @click="currentStep = 3" class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                                Next Step →
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: References -->
                    <div x-show="currentStep === 3" x-transition>
                        <h2 class="text-xl font-bold text-gray-900 mb-2">References</h2>
                        <p class="text-sm text-gray-600 mb-6">Provide at least one reference (max 3)</p>
                        
                        <div class="space-y-6">
                            <!-- Reference 1 -->
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <h3 class="font-semibold text-gray-900 mb-4">Reference 1</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                        <input type="text" name="references[0][name]" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Relationship</label>
                                        <input type="text" name="references[0][relationship]" placeholder="e.g., Landlord" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                        <input type="tel" name="references[0][phone]" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" name="references[0][email]" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                </div>
                            </div>

                            <!-- Reference 2 -->
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <h3 class="font-semibold text-gray-900 mb-4">Reference 2 (Optional)</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                        <input type="text" name="references[1][name]" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Relationship</label>
                                        <input type="text" name="references[1][relationship]" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                        <input type="tel" name="references[1][phone]" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" name="references[1][email]" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                </div>
                            </div>

                            <!-- Reference 3 -->
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <h3 class="font-semibold text-gray-900 mb-4">Reference 3 (Optional)</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                        <input type="text" name="references[2][name]" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Relationship</label>
                                        <input type="text" name="references[2][relationship]" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                        <input type="tel" name="references[2][phone]" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" name="references[2][email]" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Information</label>
                                <textarea name="additional_information" rows="4" placeholder="Any additional comments..."
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('additional_information') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Supporting Documents (Optional)</label>
                                <p class="text-sm text-gray-600 mb-2">Upload ID, payslips, etc. (PDF, JPG, PNG - Max 5MB each)</p>
                                <input type="file" name="documents[]" multiple accept=".pdf,.jpg,.jpeg,.png"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-between">
                            <button type="button" @click="currentStep = 2" class="px-8 py-3 border border-gray-300 text-gray-700 hover:border-primary hover:text-primary font-semibold rounded-xl transition-colors">
                                ← Previous
                            </button>
                            <button type="button" @click="currentStep = 4" class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                                Review →
                            </button>
                        </div>
                    </div>

                    <!-- Step 4: Review -->
                    <div x-show="currentStep === 4" x-transition>
                        <h2 class="text-xl font-bold text-gray-900 mb-2">Review & Submit</h2>
                        <p class="text-sm text-gray-600 mb-6">Please review before submitting</p>

                        <div class="space-y-4 mb-8">
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                                <p class="text-sm text-blue-800">
                                    <strong>Note:</strong> Your application will be reviewed within 48 hours. You'll receive email updates on your application status.
                                </p>
                            </div>

                            <div class="flex items-start gap-3">
                                <input type="checkbox" required id="terms" class="mt-1">
                                <label for="terms" class="text-sm text-gray-700">
                                    I confirm all information is accurate. False information may result in rejection. *
                                </label>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-between">
                            <button type="button" @click="currentStep = 3" class="px-8 py-3 border border-gray-300 text-gray-700 hover:border-primary hover:text-primary font-semibold rounded-xl transition-colors">
                                ← Previous
                            </button>
                            <button type="submit" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Submit Application
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden sticky top-6">
                <div class="relative h-48 bg-gray-100">
                    @if($property->featuredImage)
                        <img src="{{ Storage::disk('public')->url($property->featuredImage->file_path) }}" 
                             alt="{{ $property->short_address }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Applying For</h3>
                    <p class="text-2xl font-bold text-primary mb-2">{{ $property->display_price }}</p>
                    <p class="font-semibold text-gray-900 mb-1">{{ $property->full_address }}</p>
                    <p class="text-sm text-gray-600 mb-4">{{ $property->suburb }}, {{ $property->state }}</p>

                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-200 text-sm text-gray-600">
                        @if($property->bedrooms)<span>{{ $property->bedrooms }} bed</span>@endif
                        @if($property->bathrooms)<span>{{ $property->bathrooms }} bath</span>@endif
                        @if($property->parking_spaces)<span>{{ $property->parking_spaces }} car</span>@endif
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Reviewed within 48 hours
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Email notifications
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Secure & confidential
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>