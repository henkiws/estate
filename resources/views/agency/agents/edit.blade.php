@extends('layouts.admin')

@section('title', 'Edit Agent')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Agent</h1>
            <p class="mt-1 text-gray-600">{{ $agent->full_name }}</p>
        </div>
        <a href="{{ route('agency.agents.show', $agent) }}" class="text-gray-600 hover:text-gray-900">
            ← Back to Agent Profile
        </a>
    </div>

    {{-- Form --}}
    <form action="{{ route('agency.agents.update', $agent) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- Personal Information --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Personal Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="first_name" value="{{ old('first_name', $agent->first_name) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('first_name') border-red-500 @enderror">
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Last Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="last_name" value="{{ old('last_name', $agent->last_name) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('last_name') border-red-500 @enderror">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $agent->email) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Mobile <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="mobile" value="{{ old('mobile', $agent->mobile) }}" required
                           placeholder="0412 345 678"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('mobile') border-red-500 @enderror">
                    @error('mobile')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Office Phone</label>
                    <input type="tel" name="phone" value="{{ old('phone', $agent->phone) }}"
                           placeholder="02 1234 5678"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">License Number</label>
                    <input type="text" name="license_number" value="{{ old('license_number', $agent->license_number) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
            </div>
        </div>

        {{-- Professional Details --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Professional Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Position <span class="text-red-500">*</span>
                    </label>
                    <select name="position" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('position') border-red-500 @enderror">
                        <option value="">Select Position</option>
                        <option value="Principal" {{ old('position', $agent->position) === 'Principal' ? 'selected' : '' }}>Principal</option>
                        <option value="Director" {{ old('position', $agent->position) === 'Director' ? 'selected' : '' }}>Director</option>
                        <option value="Senior Agent" {{ old('position', $agent->position) === 'Senior Agent' ? 'selected' : '' }}>Senior Agent</option>
                        <option value="Sales Agent" {{ old('position', $agent->position) === 'Sales Agent' ? 'selected' : '' }}>Sales Agent</option>
                        <option value="Property Manager" {{ old('position', $agent->position) === 'Property Manager' ? 'selected' : '' }}>Property Manager</option>
                        <option value="Leasing Consultant" {{ old('position', $agent->position) === 'Leasing Consultant' ? 'selected' : '' }}>Leasing Consultant</option>
                        <option value="Junior Agent" {{ old('position', $agent->position) === 'Junior Agent' ? 'selected' : '' }}>Junior Agent</option>
                        <option value="Assistant" {{ old('position', $agent->position) === 'Assistant' ? 'selected' : '' }}>Assistant</option>
                    </select>
                    @error('position')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Employment Type <span class="text-red-500">*</span>
                    </label>
                    <select name="employment_type" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('employment_type') border-red-500 @enderror">
                        <option value="">Select Type</option>
                        <option value="full_time" {{ old('employment_type', $agent->employment_type) === 'full_time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time" {{ old('employment_type', $agent->employment_type) === 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contractor" {{ old('employment_type', $agent->employment_type) === 'contractor' ? 'selected' : '' }}>Contractor</option>
                        <option value="casual" {{ old('employment_type', $agent->employment_type) === 'casual' ? 'selected' : '' }}>Casual</option>
                    </select>
                    @error('employment_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commission Rate (%)</label>
                    <input type="number" name="commission_rate" value="{{ old('commission_rate', $agent->commission_rate) }}"
                           step="0.01" min="0" max="100"
                           placeholder="2.5"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Enter as percentage (e.g., 2.5 for 2.5%)</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="date" name="started_at" value="{{ old('started_at', $agent->started_at ? $agent->started_at->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Specializations</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @php
                            $allSpecializations = ['Residential Sales', 'Residential Leasing', 'Commercial Sales', 'Commercial Leasing', 'Property Management', 'Luxury Properties', 'Land Sales', 'Auctions'];
                            $selectedSpecializations = old('specializations', $agent->specializations ?? []);
                        @endphp
                        @foreach($allSpecializations as $specialization)
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="specializations[]" value="{{ $specialization }}"
                                       {{ in_array($specialization, $selectedSpecializations) ? 'checked' : '' }}
                                       class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                <span class="text-sm text-gray-700">{{ $specialization }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Languages</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @php
                            $allLanguages = ['English', 'Mandarin', 'Cantonese', 'Arabic', 'Vietnamese', 'Greek', 'Italian', 'Spanish'];
                            $selectedLanguages = old('languages', $agent->languages ?? []);
                        @endphp
                        @foreach($allLanguages as $language)
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="languages[]" value="{{ $language }}"
                                       {{ in_array($language, $selectedLanguages) ? 'checked' : '' }}
                                       class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                <span class="text-sm text-gray-700">{{ $language }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Address --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Address</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
                    <input type="text" name="address_line1" value="{{ old('address_line1', $agent->address_line1) }}"
                           placeholder="123 Main Street"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address Line 2 (Optional)</label>
                    <input type="text" name="address_line2" value="{{ old('address_line2', $agent->address_line2) }}"
                           placeholder="Unit 5"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Suburb</label>
                    <input type="text" name="suburb" value="{{ old('suburb', $agent->suburb) }}"
                           placeholder="Sydney"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                    <select name="state"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Select State</option>
                        @foreach(['NSW', 'VIC', 'QLD', 'WA', 'SA', 'TAS', 'ACT', 'NT'] as $state)
                            <option value="{{ $state }}" {{ old('state', $agent->state) === $state ? 'selected' : '' }}>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Postcode</label>
                    <input type="text" name="postcode" value="{{ old('postcode', $agent->postcode) }}"
                           placeholder="2000"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
            </div>
        </div>

        {{-- Emergency Contact --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Emergency Contact</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $agent->emergency_contact_name) }}"
                           placeholder="John Doe"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact Phone</label>
                    <input type="tel" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $agent->emergency_contact_phone) }}"
                           placeholder="0412 345 678"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Relationship</label>
                    <input type="text" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship', $agent->emergency_contact_relationship) }}"
                           placeholder="Spouse, Parent, Sibling..."
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
            </div>
        </div>

        {{-- Bio & Photo --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Bio & Photo</h2>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                    <textarea name="bio" rows="5"
                              placeholder="Tell us about your experience, achievements, and what makes you stand out..."
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('bio', $agent->bio) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">This will appear on your public profile</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                    
                    @if($agent->photo)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current Photo:</p>
                            <img src="{{ $agent->photo_url }}" alt="{{ $agent->full_name }}" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-gray-100">
                        </div>
                    @endif
                    
                    <input type="file" name="photo" accept="image/*"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Upload a new photo to replace the current one. JPG, PNG or GIF. Max 2MB.</p>
                </div>
            </div>
        </div>

        {{-- Status & Settings --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Status & Settings</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="active" {{ old('status', $agent->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $agent->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="on_leave" {{ old('status', $agent->status) === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                        <option value="terminated" {{ old('status', $agent->status) === 'terminated' ? 'selected' : '' }}>Terminated</option>
                    </select>
                </div>

                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $agent->is_featured) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                        <span class="text-sm text-gray-700">Feature this agent (highlighted on website and listings)</span>
                    </label>
                </div>

                @if($agent->status === 'terminated' && $agent->ended_at)
                    <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                        <p class="text-sm text-red-800">
                            <strong>Terminated Date:</strong> {{ $agent->ended_at->format('d M Y') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between pb-6">
            <a href="{{ route('agency.agents.show', $agent) }}" 
               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                Cancel
            </a>
            
            <div class="flex items-center gap-3">
                @if($agent->status !== 'terminated')
                    <button type="button" 
                            onclick="if(confirm('Are you sure you want to delete this agent? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }"
                            class="px-6 py-3 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-xl transition-colors">
                        Delete Agent
                    </button>
                @endif
                
                <button type="submit"
                        class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                    Update Agent
                </button>
            </div>
        </div>
    </form>

    {{-- Delete Form (Hidden) --}}
    @if($agent->status !== 'terminated')
        <form id="delete-form" action="{{ route('agency.agents.destroy', $agent) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif
</div>
@endsection