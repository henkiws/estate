<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $property->full_address }} - {{ $property->agency->business_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $property->agency->business_name }}</h1>
                    <p class="text-sm text-gray-600">{{ $property->agency->email }}</p>
                </div>
                <div class="text-right">
                    @if($property->listing_type == 'rent')
                        <div class="text-3xl font-bold text-blue-600">${{ number_format($property->rent_per_week, 0) }}</div>
                        <div class="text-sm text-gray-600">per week</div>
                    @else
                        <div class="text-3xl font-bold text-blue-600">${{ number_format($property->price, 0) }}</div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Image Gallery -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    @if($property->images->count() > 0)
                        <!-- Main Image -->
                        <div class="relative h-96 bg-gray-200">
                            <img id="mainImage" src="{{ Storage::url($property->images->first()->file_path) }}" alt="{{ $property->full_address }}" class="w-full h-full object-cover">
                            <div class="absolute bottom-4 right-4 px-3 py-2 bg-black bg-opacity-60 text-white text-sm rounded-lg">
                                {{ $property->images->count() }} Photos
                            </div>
                        </div>
                        <!-- Thumbnail Grid -->
                        <div class="grid grid-cols-5 gap-2 p-4 bg-gray-50">
                            @foreach($property->images->take(5) as $image)
                                <img src="{{ Storage::url($image->file_path) }}" alt="Thumbnail" 
                                     onclick="changeMainImage('{{ Storage::url($image->file_path) }}')"
                                     class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-75 transition border-2 border-transparent hover:border-blue-500">
                            @endforeach
                        </div>
                    @else
                        <div class="h-96 flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600">
                            <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Property Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $property->full_address }}</h2>
                    <p class="text-gray-600 mb-6">{{ ucfirst($property->property_type) }} for {{ ucfirst($property->listing_type) }}</p>
                    
                    <!-- Price -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        @if($property->listing_type == 'rent')
                            <div class="flex items-baseline gap-2 mb-2">
                                <span class="text-4xl font-bold text-blue-600">${{ number_format($property->rent_per_week, 0) }}</span>
                                <span class="text-xl text-gray-600">per week</span>
                            </div>
                            @if($property->bond_amount)
                                <div class="text-gray-600">
                                    Bond: <span class="font-semibold text-gray-900">${{ number_format($property->bond_amount, 0) }}</span>
                                </div>
                            @endif
                            @if($property->available_from)
                                <div class="text-gray-600 mt-1">
                                    Available from: <span class="font-semibold text-gray-900">{{ $property->available_from->format('d M Y') }}</span>
                                </div>
                            @endif
                        @else
                            <div class="text-4xl font-bold text-blue-600">${{ number_format($property->price, 0) }}</div>
                            @if($property->price_text)
                                <div class="mt-1 text-gray-600">{{ $property->price_text }}</div>
                            @endif
                        @endif
                    </div>

                    <!-- Specifications -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        @if($property->bedrooms)
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-3xl font-bold text-gray-900">{{ $property->bedrooms }}</div>
                                <div class="text-sm text-gray-600 mt-1">Bedrooms</div>
                            </div>
                        @endif
                        @if($property->bathrooms)
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-3xl font-bold text-gray-900">{{ $property->bathrooms }}</div>
                                <div class="text-sm text-gray-600 mt-1">Bathrooms</div>
                            </div>
                        @endif
                        @if($property->parking_spaces)
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-3xl font-bold text-gray-900">{{ $property->parking_spaces }}</div>
                                <div class="text-sm text-gray-600 mt-1">Parking</div>
                            </div>
                        @endif
                        @if($property->land_size)
                            <div class="text-center p-4 bg-gray-50 rounded-lg">
                                <div class="text-3xl font-bold text-gray-900">{{ number_format($property->land_size) }}</div>
                                <div class="text-sm text-gray-600 mt-1">Land (sqm)</div>
                            </div>
                        @endif
                    </div>

                    <!-- Headline -->
                    @if($property->headline)
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $property->headline }}</h3>
                    @endif

                    <!-- Description -->
                    @if($property->description)
                        <div class="prose prose-sm max-w-none text-gray-700 mb-6">
                            {!! nl2br(e($property->description)) !!}
                        </div>
                    @endif

                    <!-- Features -->
                    @if($property->features && count($property->features) > 0)
                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="font-semibold text-gray-900 mb-3">Features</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach($property->features as $feature)
                                    <div class="flex items-center gap-2 text-sm text-gray-700">
                                        <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ $feature }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Floorplan -->
                    @if($property->floorplan_path)
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h4 class="font-semibold text-gray-900 mb-3">Floorplan</h4>
                            <a href="{{ Storage::url($property->floorplan_path) }}" target="_blank" class="inline-block">
                                @if(str_ends_with($property->floorplan_path, '.pdf'))
                                    <div class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition">
                                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        <div>
                                            <div class="font-medium text-blue-900">View Floorplan PDF</div>
                                            <div class="text-sm text-blue-700">Click to open</div>
                                        </div>
                                    </div>
                                @else
                                    <img src="{{ Storage::url($property->floorplan_path) }}" alt="Floorplan" class="max-w-full h-auto rounded-lg border border-gray-200 hover:shadow-lg transition">
                                @endif
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Agent Contact -->
                @if($property->agents->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Contact Agent{{ $property->agents->count() > 1 ? 's' : '' }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($property->agents as $agent)
                                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                                        {{ substr($agent->first_name, 0, 1) }}{{ substr($agent->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $agent->first_name }} {{ $agent->last_name }}</div>
                                        <div class="text-sm text-gray-600">{{ $agent->position }}</div>
                                        @if($agent->email)
                                            <a href="mailto:{{ $agent->email }}" class="text-sm text-blue-600 hover:underline">{{ $agent->email }}</a>
                                        @endif
                                        @if($agent->phone)
                                            <div class="text-sm text-gray-700">{{ $agent->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar - Application Form -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 sticky top-4">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Apply Now</h3>
                    
                    <form id="applicationForm" class="space-y-4">
                        @csrf
                        
                        <!-- Personal Information -->
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Personal Information</h4>
                            
                            <div class="space-y-3">
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                    <input type="text" name="full_name" id="full_name" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                    <input type="email" name="email" id="email" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                                    <input type="tel" name="phone" id="phone" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Current Address -->
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Current Address</h4>
                            
                            <div class="space-y-3">
                                <div>
                                    <label for="current_address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                    <input type="text" name="current_address" id="current_address"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                        <input type="text" name="city" id="city"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    </div>
                                    <div>
                                        <label for="postcode" class="block text-sm font-medium text-gray-700 mb-1">Postcode</label>
                                        <input type="text" name="postcode" id="postcode" maxlength="4"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employment -->
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Employment</h4>
                            
                            <div class="space-y-3">
                                <div>
                                    <label for="employment_status" class="block text-sm font-medium text-gray-700 mb-1">Employment Status</label>
                                    <select name="employment_status" id="employment_status"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                        <option value="">Select...</option>
                                        <option value="employed">Employed</option>
                                        <option value="self-employed">Self-Employed</option>
                                        <option value="student">Student</option>
                                        <option value="retired">Retired</option>
                                        <option value="unemployed">Unemployed</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="annual_income" class="block text-sm font-medium text-gray-700 mb-1">Annual Income</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-2 text-gray-600 text-sm">$</span>
                                        <input type="number" name="annual_income" id="annual_income" min="0"
                                               class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Details -->
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Additional Details</h4>
                            
                            <div class="space-y-3">
                                <div>
                                    <label for="number_of_occupants" class="block text-sm font-medium text-gray-700 mb-1">Number of Occupants</label>
                                    <input type="number" name="number_of_occupants" id="number_of_occupants" min="1" value="1"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>

                                <div>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="has_pets" id="has_pets" value="1" onclick="togglePetDetails()"
                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                                        <span class="text-sm font-medium text-gray-700">I have pets</span>
                                    </label>
                                </div>

                                <div id="petDetailsDiv" class="hidden">
                                    <label for="pet_details" class="block text-sm font-medium text-gray-700 mb-1">Pet Details</label>
                                    <input type="text" name="pet_details" id="pet_details" placeholder="Type, breed, size..."
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>

                                <div>
                                    <label for="preferred_move_in_date" class="block text-sm font-medium text-gray-700 mb-1">Preferred Move-in Date</label>
                                    <input type="date" name="preferred_move_in_date" id="preferred_move_in_date"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>

                                <div>
                                    <label for="additional_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Comments</label>
                                    <textarea name="additional_notes" id="additional_notes" rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn"
                                class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg hover:shadow-xl">
                            Submit Application
                        </button>

                        <p class="text-xs text-gray-500 text-center">
                            Your information will be securely sent to the property agent
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all">
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-center text-gray-900 mb-2">Application Submitted!</h2>
            <p class="text-center text-gray-600 mb-6">
                Thank you for your application. The agency will review your information and contact you soon.
            </p>
            <button onclick="closeModal()" 
                    class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                Close
            </button>
        </div>
    </div>

    <script>
    function changeMainImage(url) {
        document.getElementById('mainImage').src = url;
    }

    function togglePetDetails() {
        const checkbox = document.getElementById('has_pets');
        const petDetailsDiv = document.getElementById('petDetailsDiv');
        
        if (checkbox.checked) {
            petDetailsDiv.classList.remove('hidden');
        } else {
            petDetailsDiv.classList.add('hidden');
        }
    }

    // Form submission
    document.getElementById('applicationForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Submitting...';
        
        const formData = new FormData(this);
        
        try {
            const response = await fetch('{{ route("property.apply", $property->public_url_code) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                document.getElementById('successModal').classList.remove('hidden');
                this.reset();
            } else {
                alert('Error: ' + (data.message || 'Something went wrong'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to submit application. Please try again.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Submit Application';
        }
    });

    function closeModal() {
        document.getElementById('successModal').classList.add('hidden');
    }

    // Close modal on backdrop click
    document.getElementById('successModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    </script>
</body>
</html>