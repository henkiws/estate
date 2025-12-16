@extends('layouts.admin')

@section('title', 'Add New Agent')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- Header with Breadcrumb --}}
    <div class="space-y-4">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm">
            <a href="{{ route('agency.dashboard') }}" class="text-gray-500 hover:text-gray-700">Dashboard</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('agency.agents.index') }}" class="text-gray-500 hover:text-gray-700">Agents</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 font-medium">Add New Agent</span>
        </nav>

        {{-- Page Header --}}
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('agency.agents.index') }}" 
                   class="p-2.5 hover:bg-gray-100 rounded-xl transition-colors group">
                    <svg class="w-6 h-6 text-gray-600 group-hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Add New Agent</h1>
                    <p class="mt-1.5 text-gray-600">Create a new team member profile and send them an invitation</p>
                </div>
            </div>
            
            {{-- Quick Help --}}
            <div class="hidden lg:block">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 max-w-xs">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-blue-900">Quick Tip</h3>
                            <p class="text-xs text-blue-800 mt-1">Enable "Send invitation" to let the agent set their own password and access their account.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('agency.agents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Personal Information --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-600 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Personal Information</h2>
                        <p class="text-sm text-gray-600">Basic details about the agent</p>
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
                               value="{{ old('first_name') }}"
                               required
                               placeholder="John"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('first_name') border-red-500 @enderror">
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
                               value="{{ old('last_name') }}"
                               required
                               placeholder="Smith"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('last_name') border-red-500 @enderror">
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
                                   value="{{ old('email') }}"
                                   required
                                   placeholder="john.smith@agency.com"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror">
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
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Mobile Phone</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="mobile" 
                                   value="{{ old('mobile') }}"
                                   placeholder="+61 4XX XXX XXX"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('mobile') border-red-500 @enderror">
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
                            <input type="text" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   placeholder="(02) 1234 5678"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('phone') border-red-500 @enderror">
                        </div>
                        @error('phone')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Photo Upload --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Profile Photo</label>
                        <div class="relative">
                            <input type="file" 
                                   name="photo" 
                                   accept="image/jpeg,image/png,image/jpg"
                                   id="photo-upload"
                                   class="hidden"
                                   onchange="updateFileName(this)">
                            <label for="photo-upload" 
                                   class="flex items-center gap-3 px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl hover:border-blue-500 hover:bg-blue-50 cursor-pointer transition-all group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm text-gray-600 group-hover:text-blue-600" id="file-name">Choose photo...</span>
                            </label>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">JPG, JPEG or PNG. Max 2MB.</p>
                        @error('photo')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Bio --}}
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bio / About</label>
                    <textarea name="bio" 
                              rows="4"
                              placeholder="Write a brief introduction about this agent... This will be displayed on their public profile."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none @error('bio') border-red-500 @enderror">{{ old('bio') }}</textarea>
                    <p class="mt-1.5 text-xs text-gray-500">Maximum 500 characters</p>
                    @error('bio')
                        <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Professional Details --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-purple-600 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Professional Details</h2>
                        <p class="text-sm text-gray-600">Employment and licensing information</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Position --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Position/Title</label>
                        <input type="text" 
                               name="position" 
                               value="{{ old('position') }}"
                               placeholder="e.g., Sales Agent, Property Manager"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>

                    {{-- Employment Type --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Employment Type <span class="text-red-500">*</span>
                        </label>
                        <select name="employment_type" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all appearance-none bg-white">
                            <option value="full_time" {{ old('employment_type') === 'full_time' ? 'selected' : '' }}>Full Time</option>
                            <option value="part_time" {{ old('employment_type') === 'part_time' ? 'selected' : '' }}>Part Time</option>
                            <option value="contractor" {{ old('employment_type') === 'contractor' ? 'selected' : '' }}>Contractor</option>
                            <option value="intern" {{ old('employment_type') === 'intern' ? 'selected' : '' }}>Intern</option>
                        </select>
                    </div>

                    {{-- License Number --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">License Number</label>
                        <input type="text" 
                               name="license_number" 
                               value="{{ old('license_number') }}"
                               placeholder="e.g., 20123456"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>

                    {{-- License Expiry --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">License Expiry Date</label>
                        <input type="date" 
                               name="license_expiry" 
                               value="{{ old('license_expiry') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>

                    {{-- Commission Rate --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Commission Rate (%)</label>
                        <div class="relative">
                            <input type="number" 
                                   name="commission_rate" 
                                   value="{{ old('commission_rate') }}"
                                   step="0.01"
                                   min="0"
                                   max="100"
                                   placeholder="0.00"
                                   class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Start Date --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date</label>
                        <input type="date" 
                               name="started_at" 
                               value="{{ old('started_at', date('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                </div>

                {{-- Specializations --}}
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Specializations</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach(['Residential Sales', 'Commercial Sales', 'Property Management', 'Leasing', 'Auctions', 'Luxury Properties', 'First Home Buyers', 'Investments'] as $spec)
                            <label class="relative flex items-center gap-3 p-3.5 border-2 border-gray-200 rounded-xl hover:border-purple-300 hover:bg-purple-50 cursor-pointer transition-all group">
                                <input type="checkbox" 
                                       name="specializations[]" 
                                       value="{{ $spec }}"
                                       class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">{{ $spec }}</span>
                                <div class="absolute inset-0 rounded-xl ring-2 ring-purple-500 opacity-0 group-has-[:checked]:opacity-100 pointer-events-none"></div>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Languages --}}
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Languages Spoken</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach(['English', 'Mandarin', 'Cantonese', 'Arabic', 'Vietnamese', 'Spanish', 'Italian', 'Greek'] as $lang)
                            <label class="relative flex items-center gap-3 p-3.5 border-2 border-gray-200 rounded-xl hover:border-purple-300 hover:bg-purple-50 cursor-pointer transition-all group">
                                <input type="checkbox" 
                                       name="languages[]" 
                                       value="{{ $lang }}"
                                       class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">{{ $lang }}</span>
                                <div class="absolute inset-0 rounded-xl ring-2 ring-purple-500 opacity-0 group-has-[:checked]:opacity-100 pointer-events-none"></div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Address --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-green-600 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Address Information</h2>
                        <p class="text-sm text-gray-600">Residential address details</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Street Address</label>
                    <input type="text" 
                           name="address_line1" 
                           value="{{ old('address_line1') }}"
                           placeholder="123 Main Street"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Suburb</label>
                        <input type="text" 
                               name="suburb" 
                               value="{{ old('suburb') }}"
                               placeholder="Sydney"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">State</label>
                        <select name="state" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all appearance-none bg-white">
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
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Postcode</label>
                        <input type="text" 
                               name="postcode" 
                               value="{{ old('postcode') }}"
                               maxlength="4"
                               placeholder="2000"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    </div>
                </div>
            </div>
        </div>

        {{-- Emergency Contact --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-600 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Emergency Contact</h2>
                        <p class="text-sm text-gray-600">For urgent situations</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Name</label>
                        <input type="text" 
                               name="emergency_contact_name" 
                               value="{{ old('emergency_contact_name') }}"
                               placeholder="Jane Doe"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Phone</label>
                        <input type="text" 
                               name="emergency_contact_phone" 
                               value="{{ old('emergency_contact_phone') }}"
                               placeholder="+61 4XX XXX XXX"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Relationship</label>
                        <input type="text" 
                               name="emergency_contact_relationship" 
                               value="{{ old('emergency_contact_relationship') }}"
                               placeholder="e.g., Spouse, Parent"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                    </div>
                </div>
            </div>
        </div>

        {{-- Settings --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-gray-700 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Agent Settings</h2>
                        <p class="text-sm text-gray-600">Profile and account preferences</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 space-y-3">
                <label class="flex items-start gap-4 p-4 border-2 border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 cursor-pointer transition-all group">
                    <input type="checkbox" 
                           name="is_featured" 
                           value="1"
                           {{ old('is_featured') ? 'checked' : '' }}
                           class="mt-1 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-900 group-hover:text-blue-900">Feature this agent</span>
                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Recommended</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1 group-hover:text-blue-800">Display prominently on your agency website and listings</p>
                    </div>
                </label>

                <label class="flex items-start gap-4 p-4 border-2 border-gray-200 rounded-xl hover:border-green-300 hover:bg-green-50 cursor-pointer transition-all group">
                    <input type="checkbox" 
                           name="is_accepting_new_listings" 
                           value="1"
                           {{ old('is_accepting_new_listings', true) ? 'checked' : '' }}
                           class="mt-1 w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                    <div class="flex-1">
                        <div class="font-semibold text-gray-900 group-hover:text-green-900">Accepting new listings</div>
                        <p class="text-sm text-gray-600 mt-1 group-hover:text-green-800">Agent is available to take on new properties and clients</p>
                    </div>
                </label>

                <label class="flex items-start gap-4 p-4 border-2 border-gray-200 rounded-xl hover:border-purple-300 hover:bg-purple-50 cursor-pointer transition-all group">
                    <input type="checkbox" 
                           name="send_invitation" 
                           value="1"
                           {{ old('send_invitation', true) ? 'checked' : '' }}
                           class="mt-1 w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <div class="flex-1">
                        <div class="font-semibold text-gray-900 group-hover:text-purple-900">Send account invitation</div>
                        <p class="text-sm text-gray-600 mt-1 group-hover:text-purple-800">Agent will receive an email to set their password and access their account</p>
                    </div>
                </label>
            </div>
        </div>

        {{-- Sticky Actions Footer --}}
        <div class="sticky bottom-0 bg-white border-t border-gray-200 shadow-lg rounded-t-2xl p-6 -mx-4 md:mx-0 md:rounded-2xl">
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <button type="submit" 
                        class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Agent
                </button>
                <a href="{{ route('agency.agents.index') }}" 
                   class="w-full sm:w-auto px-8 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
                <div class="hidden sm:block flex-1"></div>
                <p class="text-xs text-gray-500 text-center sm:text-right">
                    <span class="text-red-500">*</span> Required fields
                </p>
            </div>
        </div>
    </form>
</div>

<script>
function updateFileName(input) {
    const fileName = input.files[0]?.name || 'Choose photo...';
    document.getElementById('file-name').textContent = fileName;
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