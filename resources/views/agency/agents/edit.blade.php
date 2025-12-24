@extends('layouts.admin')

@section('title', 'Edit Agent')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- Header with Breadcrumb --}}
    <div class="space-y-4">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm">
            <a href="{{ route('agency.dashboard') }}" class="text-gray-600 hover:text-plyform-dark">Dashboard</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('agency.agents.index') }}" class="text-gray-600 hover:text-plyform-dark">Agents</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('agency.agents.show', $agent) }}" class="text-gray-600 hover:text-plyform-dark">{{ $agent->full_name }}</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-plyform-dark font-medium">Edit</span>
        </nav>

        {{-- Page Header --}}
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('agency.agents.show', $agent) }}" 
                   class="p-2.5 hover:bg-plyform-mint/10 rounded-xl transition-colors group">
                    <svg class="w-6 h-6 text-gray-600 group-hover:text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-plyform-dark">Edit Agent</h1>
                    <p class="mt-1.5 text-gray-600">Update {{ $agent->full_name }}'s profile information</p>
                </div>
            </div>
            
            {{-- Status Badge --}}
            <div>
                @php
                    $statusColors = [
                        'active' => 'bg-plyform-mint text-plyform-dark',
                        'inactive' => 'bg-gray-100 text-gray-800',
                        'on_leave' => 'bg-plyform-yellow/30 text-plyform-dark',
                        'terminated' => 'bg-plyform-orange/20 text-plyform-orange',
                    ];
                    $statusColor = $statusColors[$agent->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="px-4 py-2 {{ $statusColor }} text-sm font-semibold rounded-xl">
                    {{ ucwords(str_replace('_', ' ', $agent->status)) }}
                </span>
            </div>
        </div>
    </div>

    <form action="{{ route('agency.agents.update', $agent) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- Personal Information --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-plyform-purple/10 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-gradient-to-br from-plyform-yellow to-plyform-mint rounded-lg">
                        <svg class="w-5 h-5 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-plyform-dark">Personal Information</h2>
                        <p class="text-sm text-gray-600">Basic details and contact information</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- First Name --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="first_name" 
                               value="{{ old('first_name', $agent->first_name) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all @error('first_name') border-red-500 @enderror">
                        @error('first_name')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="last_name" 
                               value="{{ old('last_name', $agent->last_name) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all @error('last_name') border-red-500 @enderror">
                        @error('last_name')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email', $agent->email) }}"
                                   required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all @error('email') border-red-500 @enderror">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Mobile --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Mobile Phone <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="tel" 
                                   name="mobile" 
                                   value="{{ old('mobile', $agent->mobile) }}"
                                   required
                                   placeholder="0412 345 678"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all @error('mobile') border-red-500 @enderror">
                        </div>
                        @error('mobile')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Office Phone --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Office Phone</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <input type="tel" 
                                   name="phone" 
                                   value="{{ old('phone', $agent->phone) }}"
                                   placeholder="02 1234 5678"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all">
                        </div>
                    </div>

                    {{-- License Number --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">License Number</label>
                        <input type="text" 
                               name="license_number" 
                               value="{{ old('license_number', $agent->license_number) }}"
                               placeholder="e.g., 20123456"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

        {{-- Professional Details --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-plyform-mint/20 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-gradient-to-br from-plyform-purple to-plyform-dark rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-plyform-dark">Professional Details</h2>
                        <p class="text-sm text-gray-600">Employment and role information</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Position --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Position <span class="text-red-500">*</span>
                        </label>
                        <select name="position" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none transition-all appearance-none bg-white @error('position') border-red-500 @enderror">
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
                            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Employment Type --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Employment Type <span class="text-red-500">*</span>
                        </label>
                        <select name="employment_type" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none transition-all appearance-none bg-white @error('employment_type') border-red-500 @enderror">
                            <option value="">Select Type</option>
                            <option value="full_time" {{ old('employment_type', $agent->employment_type) === 'full_time' ? 'selected' : '' }}>Full Time</option>
                            <option value="part_time" {{ old('employment_type', $agent->employment_type) === 'part_time' ? 'selected' : '' }}>Part Time</option>
                            <option value="contractor" {{ old('employment_type', $agent->employment_type) === 'contractor' ? 'selected' : '' }}>Contractor</option>
                            <option value="casual" {{ old('employment_type', $agent->employment_type) === 'casual' ? 'selected' : '' }}>Casual</option>
                        </select>
                        @error('employment_type')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Commission Rate --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Commission Rate (%)</label>
                        <div class="relative">
                            <input type="number" 
                                   name="commission_rate" 
                                   value="{{ old('commission_rate', $agent->commission_rate) }}"
                                   step="0.01"
                                   min="0"
                                   max="100"
                                   placeholder="2.5"
                                   class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none transition-all">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">%</span>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">Enter as percentage (e.g., 2.5 for 2.5%)</p>
                    </div>

                    {{-- Start Date --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date</label>
                        <input type="date" 
                               name="started_at" 
                               value="{{ old('started_at', $agent->started_at ? $agent->started_at->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none transition-all">
                    </div>

                    {{-- Specializations --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Specializations</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            @php
                                $allSpecializations = ['Residential Sales', 'Residential Leasing', 'Commercial Sales', 'Commercial Leasing', 'Property Management', 'Luxury Properties', 'Land Sales', 'Auctions'];
                                $selectedSpecializations = old('specializations', $agent->specializations ?? []);
                            @endphp
                            @foreach($allSpecializations as $specialization)
                                <label class="relative flex items-center gap-3 p-3.5 border-2 border-gray-200 rounded-xl hover:border-plyform-purple/50 hover:bg-plyform-purple/5 cursor-pointer transition-all group">
                                    <input type="checkbox" 
                                           name="specializations[]" 
                                           value="{{ $specialization }}"
                                           {{ in_array($specialization, $selectedSpecializations) ? 'checked' : '' }}
                                           class="w-4 h-4 text-plyform-purple border-gray-300 rounded focus:ring-plyform-purple/20">
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-plyform-purple">{{ $specialization }}</span>
                                    <div class="absolute inset-0 rounded-xl ring-2 ring-plyform-purple opacity-0 group-has-[:checked]:opacity-100 pointer-events-none"></div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Languages --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Languages Spoken</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            @php
                                $allLanguages = ['English', 'Mandarin', 'Cantonese', 'Arabic', 'Vietnamese', 'Greek', 'Italian', 'Spanish'];
                                $selectedLanguages = old('languages', $agent->languages ?? []);
                            @endphp
                            @foreach($allLanguages as $language)
                                <label class="relative flex items-center gap-3 p-3.5 border-2 border-gray-200 rounded-xl hover:border-plyform-purple/50 hover:bg-plyform-purple/5 cursor-pointer transition-all group">
                                    <input type="checkbox" 
                                           name="languages[]" 
                                           value="{{ $language }}"
                                           {{ in_array($language, $selectedLanguages) ? 'checked' : '' }}
                                           class="w-4 h-4 text-plyform-purple border-gray-300 rounded focus:ring-plyform-purple/20">
                                    <span class="text-sm font-medium text-gray-700 group-hover:text-plyform-purple">{{ $language }}</span>
                                    <div class="absolute inset-0 rounded-xl ring-2 ring-plyform-purple opacity-0 group-has-[:checked]:opacity-100 pointer-events-none"></div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bio & Photo --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-plyform-yellow/10 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-gradient-to-br from-plyform-yellow to-plyform-mint rounded-lg">
                        <svg class="w-5 h-5 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-plyform-dark">Bio & Photo</h2>
                        <p class="text-sm text-gray-600">Profile description and image</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bio</label>
                    <textarea name="bio" 
                              rows="5"
                              placeholder="Tell us about your experience, achievements, and what makes you stand out..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all resize-none">{{ old('bio', $agent->bio) }}</textarea>
                    <p class="mt-1.5 text-xs text-gray-500">This will appear on your public profile (Maximum 500 characters)</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Profile Photo</label>
                    
                    @if($agent->photo)
                        <div class="mb-4 flex items-center gap-4">
                            <img src="{{ $agent->photo_url }}" 
                                 alt="{{ $agent->full_name }}" 
                                 class="w-24 h-24 rounded-full object-cover border-4 border-plyform-yellow/30 shadow-md">
                            <div>
                                <p class="text-sm font-medium text-plyform-dark">Current Photo</p>
                                <p class="text-xs text-gray-500 mt-0.5">Upload a new photo to replace this one</p>
                            </div>
                        </div>
                    @endif
                    
                    <div class="relative">
                        <input type="file" 
                               name="photo" 
                               accept="image/jpeg,image/png,image/jpg"
                               id="photo-upload-edit"
                               class="hidden"
                               onchange="updateFileNameEdit(this)">
                        <label for="photo-upload-edit" 
                               class="flex items-center gap-3 px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl hover:border-plyform-yellow hover:bg-plyform-yellow/10 cursor-pointer transition-all group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm text-gray-600 group-hover:text-plyform-dark" id="file-name-edit">Choose new photo...</span>
                        </label>
                    </div>
                    <p class="mt-1.5 text-xs text-gray-500">JPG, JPEG or PNG. Max 2MB.</p>
                </div>
            </div>
        </div>

        {{-- Address --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-plyform-mint/30 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-plyform-mint rounded-lg">
                        <svg class="w-5 h-5 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-plyform-dark">Address Information</h2>
                        <p class="text-sm text-gray-600">Residential address details</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Street Address</label>
                        <input type="text" 
                               name="address_line1" 
                               value="{{ old('address_line1', $agent->address_line1) }}"
                               placeholder="123 Main Street"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-mint/30 focus:border-plyform-mint outline-none transition-all">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Address Line 2 (Optional)</label>
                        <input type="text" 
                               name="address_line2" 
                               value="{{ old('address_line2', $agent->address_line2) }}"
                               placeholder="Unit 5"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-mint/30 focus:border-plyform-mint outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Suburb</label>
                        <input type="text" 
                               name="suburb" 
                               value="{{ old('suburb', $agent->suburb) }}"
                               placeholder="Sydney"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-mint/30 focus:border-plyform-mint outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">State</label>
                        <select name="state"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-mint/30 focus:border-plyform-mint outline-none transition-all appearance-none bg-white">
                            <option value="">Select State</option>
                            @foreach(['NSW', 'VIC', 'QLD', 'WA', 'SA', 'TAS', 'ACT', 'NT'] as $state)
                                <option value="{{ $state }}" {{ old('state', $agent->state) === $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Postcode</label>
                        <input type="text" 
                               name="postcode" 
                               value="{{ old('postcode', $agent->postcode) }}"
                               maxlength="4"
                               placeholder="2000"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-mint/30 focus:border-plyform-mint outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

        {{-- Emergency Contact --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-plyform-orange/10 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-plyform-orange rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-plyform-dark">Emergency Contact</h2>
                        <p class="text-sm text-gray-600">For urgent situations</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Name</label>
                        <input type="text" 
                               name="emergency_contact_name" 
                               value="{{ old('emergency_contact_name', $agent->emergency_contact_name) }}"
                               placeholder="John Doe"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-orange/20 focus:border-plyform-orange outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Phone</label>
                        <input type="tel" 
                               name="emergency_contact_phone" 
                               value="{{ old('emergency_contact_phone', $agent->emergency_contact_phone) }}"
                               placeholder="0412 345 678"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-orange/20 focus:border-plyform-orange outline-none transition-all">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Relationship</label>
                        <input type="text" 
                               name="emergency_contact_relationship" 
                               value="{{ old('emergency_contact_relationship', $agent->emergency_contact_relationship) }}"
                               placeholder="Spouse, Parent, Sibling..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-orange/20 focus:border-plyform-orange outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

        {{-- Status & Settings --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-plyform-purple/10 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-gradient-to-br from-plyform-purple to-plyform-dark rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-plyform-dark">Status & Settings</h2>
                        <p class="text-sm text-gray-600">Agent status and preferences</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none transition-all appearance-none bg-white">
                        <option value="active" {{ old('status', $agent->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $agent->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="on_leave" {{ old('status', $agent->status) === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                        <option value="terminated" {{ old('status', $agent->status) === 'terminated' ? 'selected' : '' }}>Terminated</option>
                    </select>
                </div>

                <label class="flex items-start gap-4 p-4 border-2 border-gray-200 rounded-xl hover:border-plyform-yellow hover:bg-plyform-yellow/10 cursor-pointer transition-all group">
                    <input type="checkbox" 
                           name="is_featured" 
                           value="1" 
                           {{ old('is_featured', $agent->is_featured) ? 'checked' : '' }}
                           class="mt-1 w-5 h-5 text-plyform-yellow border-gray-300 rounded focus:ring-plyform-yellow/20">
                    <div class="flex-1">
                        <div class="font-semibold text-plyform-dark group-hover:text-plyform-dark">Feature this agent</div>
                        <p class="text-sm text-gray-600 mt-1">Display prominently on website and listings</p>
                    </div>
                </label>

                @if($agent->status === 'terminated' && $agent->ended_at)
                    <div class="p-4 bg-plyform-orange/10 border-2 border-plyform-orange rounded-xl">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-plyform-orange flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-plyform-dark">Agent Terminated</p>
                                <p class="text-sm text-gray-700">Terminated on {{ $agent->ended_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sticky Actions Footer --}}
        <div class="sticky bottom-0 bg-white border-t border-gray-200 shadow-lg rounded-t-2xl p-6 -mx-4 md:mx-0 md:rounded-2xl">
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <a href="{{ route('agency.agents.show', $agent) }}" 
                   class="w-full sm:w-auto px-8 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
                
                @if($agent->status !== 'terminated')
                    <button type="button" 
                            onclick="if(confirm('Are you sure you want to delete this agent? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }"
                            class="w-full sm:w-auto px-8 py-3.5 bg-red-100 hover:bg-red-200 text-red-700 font-semibold rounded-xl transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Agent
                    </button>
                @endif
                
                <button type="submit"
                        class="w-full sm:flex-1 px-8 py-3.5 bg-gradient-to-r from-plyform-yellow to-plyform-mint hover:from-plyform-yellow/90 hover:to-plyform-mint/90 text-plyform-dark font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
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

<script>
function updateFileNameEdit(input) {
    const fileName = input.files[0]?.name || 'Choose new photo...';
    document.getElementById('file-name-edit').textContent = fileName;
}
</script>

<style>
/* Custom checkbox styling for better visual feedback */
input[type="checkbox"]:checked + * {
    font-weight: 600;
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, opacity, transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}
</style>
@endsection