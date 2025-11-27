@extends('layouts.admin')

@section('title', 'Add New Agent')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('agency.agents.index') }}" 
           class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Add New Agent</h1>
            <p class="mt-1 text-gray-600">Add a new team member to your agency</p>
        </div>
    </div>

    <form action="{{ route('agency.agents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Personal Information --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Personal Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- First Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="first_name" 
                           value="{{ old('first_name') }}"
                           required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('first_name') border-red-500 @enderror">
                    @error('first_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Last Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Last Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="last_name" 
                           value="{{ old('last_name') }}"
                           required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('last_name') border-red-500 @enderror">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mobile --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Phone</label>
                    <input type="text" 
                           name="mobile" 
                           value="{{ old('mobile') }}"
                           placeholder="+61 4XX XXX XXX"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('mobile') border-red-500 @enderror">
                    @error('mobile')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Office Phone --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Office Phone</label>
                    <input type="text" 
                           name="phone" 
                           value="{{ old('phone') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Photo Upload --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                    <input type="file" 
                           name="photo" 
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('photo') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">JPG, JPEG or PNG. Max 2MB.</p>
                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Bio --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Bio / About</label>
                <textarea name="bio" 
                          rows="4"
                          placeholder="Write a brief introduction about this agent..."
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('bio') border-red-500 @enderror">{{ old('bio') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">This will be displayed on the agent's public profile.</p>
                @error('bio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Professional Details --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Professional Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Position --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Position/Title</label>
                    <input type="text" 
                           name="position" 
                           value="{{ old('position') }}"
                           placeholder="e.g., Sales Agent, Property Manager"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                {{-- Employment Type --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Employment Type <span class="text-red-500">*</span>
                    </label>
                    <select name="employment_type" 
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="full_time" {{ old('employment_type') === 'full_time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time" {{ old('employment_type') === 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contractor" {{ old('employment_type') === 'contractor' ? 'selected' : '' }}>Contractor</option>
                        <option value="intern" {{ old('employment_type') === 'intern' ? 'selected' : '' }}>Intern</option>
                    </select>
                </div>

                {{-- License Number --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">License Number</label>
                    <input type="text" 
                           name="license_number" 
                           value="{{ old('license_number') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                {{-- License Expiry --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">License Expiry Date</label>
                    <input type="date" 
                           name="license_expiry" 
                           value="{{ old('license_expiry') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                {{-- Commission Rate --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commission Rate (%)</label>
                    <input type="number" 
                           name="commission_rate" 
                           value="{{ old('commission_rate') }}"
                           step="0.01"
                           min="0"
                           max="100"
                           placeholder="0.00"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                {{-- Start Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="date" 
                           name="started_at" 
                           value="{{ old('started_at', date('Y-m-d')) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
            </div>

            {{-- Specializations --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Specializations</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach(['Residential Sales', 'Commercial Sales', 'Property Management', 'Leasing', 'Auctions', 'Luxury Properties', 'First Home Buyers', 'Investments'] as $spec)
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" 
                                   name="specializations[]" 
                                   value="{{ $spec }}"
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="text-sm text-gray-700">{{ $spec }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Languages --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Languages Spoken</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach(['English', 'Mandarin', 'Cantonese', 'Arabic', 'Vietnamese', 'Spanish', 'Italian', 'Greek'] as $lang)
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" 
                                   name="languages[]" 
                                   value="{{ $lang }}"
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="text-sm text-gray-700">{{ $lang }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Address --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Address Information</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
                    <input type="text" 
                           name="address_line1" 
                           value="{{ old('address_line1') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Suburb</label>
                        <input type="text" 
                               name="suburb" 
                               value="{{ old('suburb') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                        <select name="state" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Select State</option>
                            <option value="NSW" {{ old('state') === 'NSW' ? 'selected' : '' }}>NSW</option>
                            <option value="VIC" {{ old('state') === 'VIC' ? 'selected' : '' }}>VIC</option>
                            <option value="QLD" {{ old('state') === 'QLD' ? 'selected' : '' }}>QLD</option>
                            <option value="SA" {{ old('state') === 'SA' ? 'selected' : '' }}>SA</option>
                            <option value="WA" {{ old('state') === 'WA' ? 'selected' : '' }}>WA</option>
                            <option value="TAS" {{ old('state') === 'TAS' ? 'selected' : '' }}>TAS</option>
                            <option value="NT" {{ old('state') === 'NT' ? 'selected' : '' }}>NT</option>
                            <option value="ACT" {{ old('state') === 'ACT' ? 'selected' : '' }}>ACT</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Postcode</label>
                        <input type="text" 
                               name="postcode" 
                               value="{{ old('postcode') }}"
                               maxlength="4"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                </div>
            </div>
        </div>

        {{-- Emergency Contact --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Emergency Contact</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Name</label>
                    <input type="text" 
                           name="emergency_contact_name" 
                           value="{{ old('emergency_contact_name') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
                    <input type="text" 
                           name="emergency_contact_phone" 
                           value="{{ old('emergency_contact_phone') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Relationship</label>
                    <input type="text" 
                           name="emergency_contact_relationship" 
                           value="{{ old('emergency_contact_relationship') }}"
                           placeholder="e.g., Spouse, Parent"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
            </div>
        </div>

        {{-- Settings --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Settings</h2>
            
            <div class="space-y-4">
                <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer">
                    <input type="checkbox" 
                           name="is_featured" 
                           value="1"
                           {{ old('is_featured') ? 'checked' : '' }}
                           class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                    <div>
                        <div class="font-medium text-gray-900">Feature this agent</div>
                        <div class="text-sm text-gray-600">Display prominently on your agency website</div>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer">
                    <input type="checkbox" 
                           name="is_accepting_new_listings" 
                           value="1"
                           {{ old('is_accepting_new_listings', true) ? 'checked' : '' }}
                           class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                    <div>
                        <div class="font-medium text-gray-900">Accepting new listings</div>
                        <div class="text-sm text-gray-600">Agent is available to take on new properties</div>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer">
                    <input type="checkbox" 
                           name="send_invitation" 
                           value="1"
                           {{ old('send_invitation', true) ? 'checked' : '' }}
                           class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                    <div>
                        <div class="font-medium text-gray-900">Send account invitation</div>
                        <div class="text-sm text-gray-600">Agent will receive an email to set up their account</div>
                    </div>
                </label>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-4">
            <button type="submit" 
                    class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                Add Agent
            </button>
            <a href="{{ route('agency.agents.index') }}" 
               class="px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection