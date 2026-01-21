@extends('layouts.user')

@section('title', 'New Application')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid lg:grid-cols-3 gap-8">
            
            <!-- Left Column - Property Preview -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-8">
                    
                    <!-- Property Image -->
                    @if($property->images->count() > 0)
                        <div class="relative mb-4 rounded-xl overflow-hidden group">
                            <img 
                                src="{{ Storage::url($property->images->first()->image_path) }}" 
                                alt="{{ $property->headline }}"
                                class="w-full h-48 object-cover"
                            >
                            @if($property->images->count() > 1)
                                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-sm font-semibold text-gray-700">
                                    📸 {{ $property->images->count() }} photos
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Property Title -->
                    <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $property->headline ?? $property->short_address }}</h2>
                    
                    <!-- Property Details -->
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $property->street_address }}, {{ $property->suburb }} {{ $property->state }} {{ $property->postcode }}
                        </div>
                    </div>
                    
                    <!-- Property Stats -->
                    <div class="flex items-center gap-4 py-3 border-y border-gray-200 mb-4">
                        @if($property->bedrooms)
                            <div class="flex items-center gap-1.5 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span class="text-sm font-medium">{{ $property->bedrooms }}</span>
                            </div>
                        @endif
                        
                        @if($property->bathrooms)
                            <div class="flex items-center gap-1.5 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-medium">{{ $property->bathrooms }}</span>
                            </div>
                        @endif
                        
                        @if($property->parking)
                            <div class="flex items-center gap-1.5 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                                <span class="text-sm font-medium">{{ $property->parking }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Rent/Price -->
                    <div class="mb-4">
                        <div class="text-sm text-gray-600 mb-1">Rent</div>
                        <div class="text-2xl font-bold text-gray-900">${{ number_format($property->rent_per_week) }} <span class="text-base font-normal text-gray-600">per week</span></div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="text-sm text-gray-600 mb-1">Bond</div>
                        <div class="text-xl font-bold text-gray-900">${{ number_format($property->bond_amount ?? ($property->rent_per_week * 4)) }}</div>
                    </div>
                    
                    <div class="mb-6">
                        <div class="text-sm text-gray-600 mb-1">Available</div>
                        <div class="text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($property->available_date)->format('d M Y') }}</div>
                    </div>
                    
                    <!-- Property Inspection Question -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-sm font-semibold text-gray-900 mb-3">Have you inspected the property?</div>
                        
                        <div class="space-y-2">
                            <label class="flex items-start cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="sidebar_inspection" 
                                    value="yes"
                                    class="mt-1 text-teal-600 focus:ring-teal-500"
                                    onchange="syncInspectionChoice('yes')"
                                >
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900 group-hover:text-teal-600">Yes, I have or plan to inspect the property</span>
                                </div>
                            </label>
                            
                            <label class="flex items-start cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="sidebar_inspection" 
                                    value="no"
                                    checked
                                    class="mt-1 text-teal-600 focus:ring-teal-500"
                                    onchange="syncInspectionChoice('no')"
                                >
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900 group-hover:text-teal-600">No, I accept the property as is</span>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Inspection Date Field (conditional) -->
                        <div id="inspection-date-sidebar" class="mt-3 hidden">
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Inspection Date</label>
                            <input 
                                type="date"
                                id="sidebar_inspection_date"
                                min="{{ date('Y-m-d') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500"
                                onchange="syncInspectionDate(this.value)"
                            >
                        </div>
                        
                        <div id="inspection-info-sidebar" class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-xs text-blue-700">Inspecting a property before applying can show property managers that you're serious</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Lease Details Quick Form -->
                    <div class="mt-6 space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Preferred lease start date</label>
                            <input 
                                type="date"
                                id="sidebar_move_in_date"
                                name="sidebar_move_in_date"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500"
                                placeholder="Day Month Year"
                                onchange="syncMoveInDate(this.value)"
                            >
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Initial lease term (months)</label>
                            <div class="grid grid-cols-4 gap-2">
                                <button type="button" onclick="setLeaseTerm(6)" class="lease-term-btn px-3 py-2 border-2 border-gray-300 rounded-lg text-sm font-semibold hover:border-teal-500 hover:bg-teal-50 transition">6</button>
                                <button type="button" onclick="setLeaseTerm(12)" class="lease-term-btn px-3 py-2 border-2 border-teal-500 bg-teal-50 rounded-lg text-sm font-semibold transition">12</button>
                                <button type="button" onclick="setLeaseTerm(18)" class="lease-term-btn px-3 py-2 border-2 border-gray-300 rounded-lg text-sm font-semibold hover:border-teal-500 hover:bg-teal-50 transition">18</button>
                                <button type="button" onclick="setLeaseTerm(24)" class="lease-term-btn px-3 py-2 border-2 border-gray-300 rounded-lg text-sm font-semibold hover:border-teal-500 hover:bg-teal-50 transition">24</button>
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">
                                Rent per week <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">$</span>
                                <input 
                                    type="number"
                                    id="rent_per_week_input"
                                    value="{{ number_format($property->rent_per_week, 2, '.', '') }}"
                                    required
                                    min="0"
                                    step="0.01"
                                    class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                    placeholder="Enter weekly rent amount"
                                >
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Enter the weekly rent amount for this property</p>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <!-- Right Column - Application Steps -->
            <div class="lg:col-span-2">
                
                <!-- Progress Header -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Application Progress</h1>
                            <p class="text-sm text-gray-600 mt-1">Review and complete your application</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-teal-600" id="progress-percentage">0%</div>
                            <div class="text-xs text-gray-600">Complete</div>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="progress-bar" class="bg-gradient-to-r from-teal-500 to-teal-600 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-red-800 mb-1">Please fix the following errors:</p>
                                <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('user.applications.store') }}" id="application-form">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                    <input type="hidden" name="move_in_date" id="move_in_date_hidden" value="{{ old('move_in_date') }}">
                    <input type="hidden" name="lease_term" id="lease_term_hidden" value="{{ old('lease_term', 12) }}">
                    <input type="hidden" name="rent_per_week" id="rent_per_week_hidden">
                    <input type="hidden" name="property_inspection" id="property_inspection_hidden" value="{{ old('property_inspection', 'no') }}">
                    <input type="hidden" name="inspection_date" id="inspection_date_hidden" value="{{ old('inspection_date') }}">
                    
                    <!-- Section Cards -->
                    <div class="space-y-4">
                        
                        <!-- About Me Section -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card" data-section="about_me">
                            <button type="button" onclick="toggleSection('about_me')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center section-status" id="status_about_me">
                                        <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <span class="font-semibold text-gray-900">About me</span>
                                        @if(auth()->user()->profile && auth()->user()->profile->first_name)
                                            <p class="text-xs text-gray-500">{{ auth()->user()->profile->first_name }} {{ auth()->user()->profile->last_name }}</p>
                                        @else
                                            <p class="text-xs text-gray-500">Complete your personal details</p>
                                        @endif
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            
                            <div class="section-content hidden px-6 pb-6">
                                
                                <!-- Personal Details Section -->
                                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="text-base font-semibold text-plyform-dark">Personal Details</h4>
                                            <p class="text-sm text-gray-600 mt-1">Your legal name as it appears on official documents</p>
                                        </div>
                                        <span class="text-plyform-orange text-sm font-medium">* Required</span>
                                    </div>
                                    
                                    <div class="grid md:grid-cols-3 gap-4">
                                        
                                        <!-- Title -->
                                        <div>
                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                Title <span class="text-plyform-orange">*</span>
                                            </label>
                                            <select 
                                                name="title" 
                                                required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('title') border-red-500 @enderror"
                                            >
                                                <option value="">Select title</option>
                                                <option value="Mr" {{ old('title', auth()->user()->profile->title ?? '') == 'Mr' ? 'selected' : '' }}>Mr</option>
                                                <option value="Mrs" {{ old('title', auth()->user()->profile->title ?? '') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                                <option value="Ms" {{ old('title', auth()->user()->profile->title ?? '') == 'Ms' ? 'selected' : '' }}>Ms</option>
                                                <option value="Miss" {{ old('title', auth()->user()->profile->title ?? '') == 'Miss' ? 'selected' : '' }}>Miss</option>
                                                <option value="Dr" {{ old('title', auth()->user()->profile->title ?? '') == 'Dr' ? 'selected' : '' }}>Dr</option>
                                                <option value="Prof" {{ old('title', auth()->user()->profile->title ?? '') == 'Prof' ? 'selected' : '' }}>Prof</option>
                                                <option value="Other" {{ old('title', auth()->user()->profile->title ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('title')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- First Name -->
                                        <div class="md:col-span-2">
                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                First Name <span class="text-plyform-orange">*</span>
                                            </label>
                                            <input 
                                                type="text" 
                                                name="first_name" 
                                                value="{{ old('first_name', auth()->user()->profile->first_name ?? '') }}"
                                                required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('first_name') border-red-500 @enderror"
                                                placeholder="Enter your first name"
                                            >
                                            @error('first_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        
                                        <!-- Middle Name -->
                                        <div>
                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                Middle Name
                                            </label>
                                            <input 
                                                type="text" 
                                                name="middle_name" 
                                                value="{{ old('middle_name', auth()->user()->profile->middle_name ?? '') }}"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('middle_name') border-red-500 @enderror"
                                                placeholder="Enter your middle name (optional)"
                                            >
                                            @error('middle_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Last Name -->
                                        <div>
                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                Last Name <span class="text-plyform-orange">*</span>
                                            </label>
                                            <input 
                                                type="text" 
                                                name="last_name" 
                                                value="{{ old('last_name', auth()->user()->profile->last_name ?? '') }}"
                                                required
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('last_name') border-red-500 @enderror"
                                                placeholder="Enter your last name"
                                            >
                                            @error('last_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        
                                        <!-- Surname -->
                                        <div class="hidden">
                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                Surname
                                            </label>
                                            <input 
                                                type="text" 
                                                name="surname" 
                                                value="{{ old('surname', auth()->user()->profile->surname ?? '') }}"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('surname') border-red-500 @enderror"
                                                placeholder="Enter surname (if applicable)"
                                            >
                                            @error('surname')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Date of Birth -->
                                        <div>
                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                Date of Birth <span class="text-plyform-orange">*</span>
                                            </label>
                                            <input 
                                                type="date" 
                                                name="date_of_birth" 
                                                value="{{ old('date_of_birth', auth()->user()->profile && auth()->user()->profile->date_of_birth ? auth()->user()->profile->date_of_birth->format('Y-m-d') : '') }}"
                                                required
                                                max="{{ now()->subYears(18)->format('Y-m-d') }}"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('date_of_birth') border-red-500 @enderror"
                                            >
                                            @error('date_of_birth')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                                <!-- Contact Information Section -->
                                <div class="bg-white rounded-lg p-6 space-y-4" style="overflow: visible;">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="text-base font-semibold text-plyform-dark">Contact Information</h4>
                                            <p class="text-sm text-gray-600 mt-1">How property managers can reach you</p>
                                        </div>
                                        <span class="text-plyform-orange text-sm font-medium">* Required</span>
                                    </div>
                                    
                                    <!-- Email Address -->
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Email Address <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="email" 
                                            name="email" 
                                            value="{{ old('email', auth()->user()->email) }}"
                                            required
                                            readonly
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed"
                                        >
                                        <p class="mt-1 text-xs text-gray-500">Email cannot be changed here. Contact support if you need to update it.</p>
                                    </div>
                                    
                                    <!-- Mobile Number -->
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Mobile Number <span class="text-plyform-orange">*</span>
                                        </label>
                                        
                                        <input 
                                            type="tel" 
                                            id="app_mobile_number" 
                                            name="mobile_number_display"
                                            value="{{ old('mobile_number', auth()->user()->profile->mobile_number ?? '') }}"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('mobile_number') border-red-500 @enderror"
                                            placeholder="Enter phone number"
                                        >
                                        
                                        <!-- Hidden fields for country code and number -->
                                        <input type="hidden" id="app_mobile_country_code" name="mobile_country_code" value="{{ old('mobile_country_code', auth()->user()->profile->mobile_country_code ?? '+61') }}">
                                        <input type="hidden" id="app_mobile_number_clean" name="mobile_number" value="{{ old('mobile_number', auth()->user()->profile->mobile_number ?? '') }}">
                                        
                                        @error('mobile_country_code')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        @error('mobile_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Select your country and enter your mobile number</p>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Address History -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card" data-section="address_history">
                            <button type="button" onclick="toggleSection('address_history')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ auth()->user()->addresses && auth()->user()->addresses->count() > 0 ? 'bg-teal-100' : 'bg-gray-100' }} flex items-center justify-center section-status" id="status_address_history">
                                        @if(auth()->user()->addresses && auth()->user()->addresses->count() > 0)
                                            <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="text-left">
                                        <span class="font-semibold text-gray-900">Address history</span>
                                        @if(auth()->user()->addresses && auth()->user()->addresses->count() > 0)
                                            <p class="text-xs text-gray-500">{{ auth()->user()->addresses->count() }} {{ Str::plural('address', auth()->user()->addresses->count()) }}</p>
                                        @else
                                            <p class="text-xs text-gray-500">Not completed yet</p>
                                        @endif
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            
                            <div class="section-content hidden px-6 pb-6">
                                
                                <!-- Address History Section -->
                                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="text-base font-semibold text-plyform-dark">Address History</h4>
                                            <p class="text-sm text-gray-600 mt-1">Provide details of your residential history for the past 3 years</p>
                                        </div>
                                        <span class="text-plyform-orange text-sm font-medium">* Required</span>
                                    </div>
                                    
                                    <!-- Info Box -->
                                    <div class="p-4 bg-plyform-green/10 border border-plyform-green/30 rounded-lg mb-6">
                                        <div class="flex gap-3">
                                            <svg class="w-5 h-5 text-plyform-dark flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <p class="text-sm text-plyform-dark">
                                                <strong>Note:</strong> Please provide at least 3 years of address history. Include your current address and previous addresses.
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div id="addresses-container">
                                        @php
                                            $addresses = old('addresses', auth()->user()->addresses->toArray() ?: [['living_arrangement' => '']]);
                                        @endphp
                                        
                                        @foreach($addresses as $index => $address)
                                            <div class="address-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-mint/50 transition-colors bg-white" data-index="{{ $index }}">
                                                <div class="flex items-center justify-between mb-4">
                                                    <div class="flex items-center gap-2">
                                                        <h4 class="font-semibold text-plyform-dark">Address {{ $index + 1 }}</h4>
                                                        @if($index === 0)
                                                            <span class="px-2 py-1 bg-plyform-mint text-plyform-dark text-xs font-semibold rounded">Current</span>
                                                        @endif
                                                    </div>
                                                    @if($index > 0)
                                                        <button 
                                                            type="button" 
                                                            onclick="removeAddressItem({{ $index }})"
                                                            class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors"
                                                        >
                                                            Remove
                                                        </button>
                                                    @endif
                                                </div>
                                                
                                                <!-- Living Arrangement -->
                                                <div class="mb-4">
                                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                        Living Arrangement <span class="text-plyform-orange">*</span>
                                                    </label>
                                                    <select 
                                                        name="addresses[{{ $index }}][living_arrangement]" 
                                                        required
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                    >
                                                        <option value="">Select arrangement</option>
                                                        <option value="owner" {{ ($address['living_arrangement'] ?? '') == 'owner' ? 'selected' : '' }}>Owner</option>
                                                        <option value="renting_agent" {{ ($address['living_arrangement'] ?? '') == 'renting_agent' ? 'selected' : '' }}>Renting through Agent</option>
                                                        <option value="renting_privately" {{ ($address['living_arrangement'] ?? '') == 'renting_privately' ? 'selected' : '' }}>Renting Privately</option>
                                                        <option value="with_parents" {{ ($address['living_arrangement'] ?? '') == 'with_parents' ? 'selected' : '' }}>Living with Parents</option>
                                                        <option value="sharing" {{ ($address['living_arrangement'] ?? '') == 'sharing' ? 'selected' : '' }}>Sharing</option>
                                                        <option value="other" {{ ($address['living_arrangement'] ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                </div>
                                                
                                                <!-- Full Address -->
                                                <div class="mb-4">
                                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                        Address <span class="text-plyform-orange">*</span>
                                                    </label>
                                                    <input 
                                                        type="text" 
                                                        name="addresses[{{ $index }}][address]" 
                                                        value="{{ $address['address'] ?? '' }}"
                                                        required
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                        placeholder="123 Main Street, Sydney NSW 2000"
                                                    >
                                                </div>
                                                
                                                <!-- Duration -->
                                                <div class="grid md:grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                            Years Lived <span class="text-plyform-orange">*</span>
                                                        </label>
                                                        <select 
                                                            name="addresses[{{ $index }}][years_lived]" 
                                                            required
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                        >
                                                            @for($i = 0; $i <= 20; $i++)
                                                                <option value="{{ $i }}" {{ ($address['years_lived'] ?? 0) == $i ? 'selected' : '' }}>{{ $i }} {{ $i === 1 ? 'year' : 'years' }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    
                                                    <div>
                                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                            Months Lived <span class="text-plyform-orange">*</span>
                                                        </label>
                                                        <select 
                                                            name="addresses[{{ $index }}][months_lived]" 
                                                            required
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                        >
                                                            @for($i = 0; $i <= 11; $i++)
                                                                <option value="{{ $i }}" {{ ($address['months_lived'] ?? 0) == $i ? 'selected' : '' }}>{{ $i }} {{ $i === 1 ? 'month' : 'months' }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <!-- Reason for Leaving -->
                                                @if($index > 0)
                                                    <div class="mb-4">
                                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                            Reason for Leaving
                                                        </label>
                                                        <textarea 
                                                            name="addresses[{{ $index }}][reason_for_leaving]" 
                                                            rows="3"
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all resize-none"
                                                            placeholder="e.g., End of lease, relocated for work, purchased property..."
                                                        >{{ $address['reason_for_leaving'] ?? '' }}</textarea>
                                                    </div>
                                                @endif
                                                
                                                <!-- Different Postal Address -->
                                                <div class="mb-4">
                                                    <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-plyform-mint/10 transition-colors">
                                                        <input 
                                                            type="checkbox" 
                                                            name="addresses[{{ $index }}][different_postal_address]" 
                                                            value="1"
                                                            onchange="togglePostalAddress({{ $index }})"
                                                            {{ ($address['different_postal_address'] ?? false) ? 'checked' : '' }}
                                                            class="w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-plyform-green/20"
                                                        >
                                                        <span class="text-sm text-gray-700 font-medium">My postal address is different from this address</span>
                                                    </label>
                                                </div>
                                                
                                                <div class="postal-address-field {{ ($address['different_postal_address'] ?? false) ? '' : 'hidden' }}" data-index="{{ $index }}">
                                                    <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                                        Postal Address <span class="text-plyform-orange">*</span>
                                                    </label>
                                                    <input 
                                                        type="text" 
                                                        name="addresses[{{ $index }}][postal_code]" 
                                                        value="{{ $address['postal_code'] ?? '' }}"
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                        placeholder="PO Box 123, Sydney NSW 2000"
                                                    >
                                                </div>
                                                
                                                <!-- Is Current Address -->
                                                @if($index === 0)
                                                    <input type="hidden" name="addresses[{{ $index }}][is_current]" value="1">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Add Address Button -->
                                    <button 
                                        type="button" 
                                        onclick="addAddressItem()"
                                        class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-green hover:text-plyform-dark hover:bg-plyform-green/5 transition flex items-center justify-center gap-2 font-medium"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Add Previous Address
                                    </button>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Employment -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card" data-section="employment">
                            <button type="button" onclick="toggleSection('employment')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ auth()->user()->employments && auth()->user()->employments->count() > 0 ? 'bg-teal-100' : 'bg-gray-100' }} flex items-center justify-center section-status" id="status_employment">
                                        @if(auth()->user()->employments && auth()->user()->employments->count() > 0)
                                            <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="text-left">
                                        <span class="font-semibold text-gray-900">Employment</span>
                                        @if(auth()->user()->employments && auth()->user()->employments->count() > 0)
                                            <p class="text-xs text-gray-500">Currently at {{ auth()->user()->employments->first()->company_name }}</p>
                                        @else
                                            <p class="text-xs text-gray-500">Not completed yet</p>
                                        @endif
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            
                            <div class="section-content hidden px-6 pb-6">
                                
                                <!-- Has Employment Toggle -->
                                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            name="has_employment" 
                                            id="has_employment_checkbox"
                                            value="1"
                                            onchange="toggleEmploymentSection()"
                                            {{ old('has_employment', auth()->user()->employments->count() > 0) ? 'checked' : '' }}
                                            class="w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                                        >
                                        <span class="font-medium text-plyform-dark">I am currently employed or have employment history</span>
                                    </label>
                                    <p class="text-sm text-gray-600 mt-2 ml-8">Check this if you have current or past employment to declare</p>
                                </div>

                                <div id="employment-section" class="{{ old('has_employment', auth()->user()->employments->count() > 0) ? '' : 'hidden' }}">
                                    <!-- Employment History Section -->
                                    <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <div>
                                                <h4 class="text-base font-semibold text-plyform-dark">Employment History</h4>
                                                <p class="text-sm text-gray-600 mt-1">Provide details about your current and previous employment</p>
                                            </div>
                                            <span class="text-plyform-orange text-sm font-medium">* Required</span>
                                        </div>
                                        
                                        <div id="employment-container">
                                            @php
                                                $employments = old('employments', auth()->user()->employments->toArray() ?: [['company_name' => '', 'position' => '']]);
                                            @endphp
                                            
                                            @foreach($employments as $index => $employment)
                                                <div class="employment-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-purple/30 transition-colors bg-white" data-index="{{ $index }}">
                                                    <div class="flex items-center justify-between mb-4">
                                                        <h4 class="font-semibold text-plyform-dark">Employment {{ $index + 1 }}</h4>
                                                        @if($index > 0)
                                                            <button 
                                                                type="button" 
                                                                onclick="removeEmployment({{ $index }})"
                                                                class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors"
                                                            >
                                                                Remove
                                                            </button>
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- Company & Position -->
                                                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                                Company Name <span class="text-plyform-orange">*</span>
                                                            </label>
                                                            <input 
                                                                type="text" 
                                                                name="employments[{{ $index }}][company_name]" 
                                                                value="{{ $employment['company_name'] ?? '' }}"
                                                                required
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                                placeholder="ABC Company Pty Ltd"
                                                            >
                                                        </div>
                                                        
                                                        <div>
                                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                                Position/Job Title <span class="text-plyform-orange">*</span>
                                                            </label>
                                                            <input 
                                                                type="text" 
                                                                name="employments[{{ $index }}][position]" 
                                                                value="{{ $employment['position'] ?? '' }}"
                                                                required
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                                placeholder="Senior Developer"
                                                            >
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Company Address -->
                                                    <div class="mb-4">
                                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                            Company Address <span class="text-plyform-orange">*</span>
                                                        </label>
                                                        <input 
                                                            type="text" 
                                                            name="employments[{{ $index }}][address]" 
                                                            value="{{ $employment['address'] ?? '' }}"
                                                            required
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                            placeholder="123 Business St, Sydney NSW 2000"
                                                        >
                                                    </div>
                                                    
                                                    <!-- Salary & Manager -->
                                                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                                                        <div class="hidden">
                                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                                Gross Annual Salary <span class="text-plyform-orange">*</span>
                                                            </label>
                                                            <div class="relative">
                                                                <span class="absolute left-4 top-3.5 text-gray-500">$</span>
                                                                <input 
                                                                    type="number" 
                                                                    name="employments[{{ $index }}][gross_annual_salary]" 
                                                                    value="{{ $employment['gross_annual_salary'] ?? '' }}"
                                                                    min="0"
                                                                    required
                                                                    class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                                    placeholder="75000"
                                                                >
                                                            </div>
                                                        </div>
                                                        
                                                        <div>
                                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                                Manager/Supervisor Name <span class="text-plyform-orange">*</span>
                                                            </label>
                                                            <input 
                                                                type="text" 
                                                                name="employments[{{ $index }}][manager_full_name]" 
                                                                value="{{ $employment['manager_full_name'] ?? '' }}"
                                                                required
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                                placeholder="John Smith"
                                                            >
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Contact Details -->
                                                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                                Contact Number <span class="text-plyform-orange">*</span>
                                                            </label>
                                                            
                                                            <input 
                                                                type="tel" 
                                                                id="employment_contact_{{ $index }}" 
                                                                name="employments[{{ $index }}][contact_number_display]"
                                                                value="{{ $employment['contact_number'] ?? '' }}"
                                                                required
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                                placeholder="Enter phone number"
                                                            >
                                                            
                                                            <!-- Hidden fields for country code and number -->
                                                            <input type="hidden" id="employment_country_code_{{ $index }}" name="employments[{{ $index }}][contact_country_code]" value="{{ $employment['contact_country_code'] ?? '+61' }}">
                                                            <input type="hidden" id="employment_contact_clean_{{ $index }}" name="employments[{{ $index }}][contact_number]" value="{{ $employment['contact_number'] ?? '' }}">
                                                            
                                                            <p class="mt-1 text-xs text-gray-500">Select country and enter contact number</p>
                                                        </div>
                                                        
                                                        <div>
                                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                                Email Address <span class="text-plyform-orange">*</span>
                                                            </label>
                                                            <input 
                                                                type="email" 
                                                                name="employments[{{ $index }}][email]" 
                                                                value="{{ $employment['email'] ?? '' }}"
                                                                required
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                                placeholder="manager@company.com"
                                                            >
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Employment Dates -->
                                                    <div class="grid md:grid-cols-3 gap-4 mb-4">
                                                        <div>
                                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                                Start Date <span class="text-plyform-orange">*</span>
                                                            </label>
                                                            <input 
                                                                type="date" 
                                                                name="employments[{{ $index }}][start_date]" 
                                                                value="{{ isset($employment['start_date']) ? \Carbon\Carbon::parse($employment['start_date'])->format('Y-m-d') : '' }}"
                                                                required
                                                                max="{{ now()->format('Y-m-d') }}"
                                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                            >
                                                        </div>
                                                        
                                                        <div>
                                                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                                Still Employed?
                                                            </label>
                                                            <label class="flex items-center gap-3 cursor-pointer mt-3 p-2 rounded-lg hover:bg-plyform-mint/10 transition-colors">
                                                                <input 
                                                                    type="checkbox" 
                                                                    name="employments[{{ $index }}][still_employed]" 
                                                                    value="1"
                                                                    onchange="toggleEndDate({{ $index }})"
                                                                    {{ ($employment['still_employed'] ?? false) ? 'checked' : '' }}
                                                                    class="w-5 h-5 text-plyform-green rounded focus:ring-plyform-green/20"
                                                                >
                                                                <span class="text-sm">Yes, currently employed</span>
                                                            </label>
                                                        </div>
                                                        
                                                        <div class="end-date-field transition-opacity" data-index="{{ $index }}">
                                                            <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                                                End Date <span class="text-plyform-orange required-if">*</span>
                                                            </label>
                                                            <input 
                                                                type="date" 
                                                                name="employments[{{ $index }}][end_date]" 
                                                                value="{{ isset($employment['end_date']) ? \Carbon\Carbon::parse($employment['end_date'])->format('Y-m-d') : '' }}"
                                                                max="{{ now()->format('Y-m-d') }}"
                                                                {{ ($employment['still_employed'] ?? false) ? 'disabled' : 'required' }}
                                                                class="employment-end-date w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all disabled:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                                                            >
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Employment Letter Upload -->
                                                    <div>
                                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                            Employment Letter (Optional)
                                                        </label>
                                                        <div class="space-y-3">
                                                            <!-- File Input (Hidden) -->
                                                            <input 
                                                                type="file" 
                                                                name="employments[{{ $index }}][employment_letter]"
                                                                id="employment_letter_{{ $index }}"
                                                                accept=".pdf,.jpg,.jpeg,.png"
                                                                onchange="previewEmploymentLetter({{ $index }})"
                                                                class="hidden"
                                                            >
                                                            
                                                            <!-- Upload Button/Preview Container -->
                                                            <div id="employment_letter_preview_{{ $index }}" class="space-y-2">
                                                                @if(!empty($employment['employment_letter_path']) && Storage::disk('public')->exists($employment['employment_letter_path']))
                                                                    <!-- EXISTING FILE PREVIEW -->
                                                                    <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3">
                                                                        <div class="flex items-center gap-3">
                                                                            <!-- File Icon/Thumbnail -->
                                                                            @if(in_array(pathinfo($employment['employment_letter_path'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                                                <img src="{{ Storage::url($employment['employment_letter_path']) }}" alt="Letter" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                                                                            @else
                                                                                <div class="w-16 h-16 bg-red-100 rounded-lg border-2 border-red-300 flex items-center justify-center">
                                                                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                                                    </svg>
                                                                                </div>
                                                                            @endif
                                                                            
                                                                            <!-- File Info -->
                                                                            <div class="flex-1 min-w-0">
                                                                                <p class="text-sm font-medium text-gray-900 truncate">{{ basename($employment['employment_letter_path']) }}</p>
                                                                                <p class="text-xs text-gray-500">Uploaded document</p>
                                                                            </div>
                                                                            
                                                                            <!-- View Button -->
                                                                            <a 
                                                                                href="{{ Storage::url($employment['employment_letter_path']) }}" 
                                                                                target="_blank"
                                                                                class="flex-shrink-0 text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded-lg"
                                                                                title="View document"
                                                                            >
                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                                </svg>
                                                                            </a>
                                                                            
                                                                            <!-- Remove Button -->
                                                                            <button 
                                                                                type="button" 
                                                                                onclick="removeEmploymentLetter({{ $index }})"
                                                                                class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                                                                                title="Remove document"
                                                                            >
                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                                </svg>
                                                                            </button>
                                                                            
                                                                            <!-- Re-upload Button -->
                                                                            <button 
                                                                                type="button" 
                                                                                onclick="document.getElementById('employment_letter_{{ $index }}').click()"
                                                                                class="flex-shrink-0 text-gray-600 hover:text-gray-800 transition p-2 hover:bg-gray-100 rounded-lg"
                                                                                title="Change document"
                                                                            >
                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Hidden input to track existing file -->
                                                                    <input type="hidden" name="employments[{{ $index }}][existing_letter]" value="{{ $employment['employment_letter_path'] }}">
                                                                @else
                                                                    <!-- NO FILE YET - UPLOAD BUTTON -->
                                                                    <button 
                                                                        type="button" 
                                                                        onclick="document.getElementById('employment_letter_{{ $index }}').click()"
                                                                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-green transition-colors text-center cursor-pointer"
                                                                    >
                                                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                                        </svg>
                                                                        <span class="text-sm text-gray-600">Click to upload employment letter</span>
                                                                        <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB)</span>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <p class="mt-1 text-xs text-gray-500">Recommended for verification (PDF, JPG, PNG - Max 10MB)</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <!-- Add Employment Button -->
                                        <button 
                                            type="button" 
                                            onclick="addEmployment()"
                                            class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-green hover:text-plyform-dark hover:bg-plyform-green/5 transition flex items-center justify-center gap-2 font-medium"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Add Previous Employment
                                        </button>
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Finances -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card" data-section="finances">
                            <button type="button" onclick="toggleSection('finances')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ auth()->user()->incomes && auth()->user()->incomes->count() > 0 ? 'bg-teal-100' : 'bg-gray-100' }} flex items-center justify-center section-status" id="status_finances">
                                        @if(auth()->user()->incomes && auth()->user()->incomes->count() > 0)
                                            <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="text-left">
                                        <span class="font-semibold text-gray-900">Finances</span>
                                        @if(auth()->user()->incomes && auth()->user()->incomes->count() > 0)
                                            @php
                                                $totalWeekly = auth()->user()->incomes->sum('net_weekly_amount');
                                                $totalAnnual = $totalWeekly * 52;
                                            @endphp
                                            <p class="text-xs text-gray-500">${{ number_format($totalAnnual, 2) }} per annum</p>
                                        @else
                                            <p class="text-xs text-gray-500">Not completed yet</p>
                                        @endif
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            
                            <div class="section-content hidden px-6 pb-6">
                                
                                <!-- Income Sources Section -->
                                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="text-base font-semibold text-plyform-dark">Income Sources</h4>
                                            <p class="text-sm text-gray-600 mt-1">Tell us about your income sources to demonstrate your ability to pay rent</p>
                                        </div>
                                        <span class="text-plyform-orange text-sm font-medium">* Required</span>
                                    </div>
                                    
                                    <div id="income-container">
                                        @php
                                            // Get incomes with their bank statements relationship loaded
                                            $userIncomes = auth()->user()->incomes()->with('bankStatements')->get();
                                            
                                            // Prepare incomes array for old() or from database
                                            if (old('incomes')) {
                                                $incomes = old('incomes');
                                            } elseif ($userIncomes->count() > 0) {
                                                $incomes = $userIncomes->map(function($income) {
                                                    return [
                                                        'source_of_income' => $income->source_of_income,
                                                        'net_weekly_amount' => $income->net_weekly_amount,
                                                        // Map bank statements to array of file paths
                                                        'bank_statements' => $income->bankStatements->pluck('file_path')->toArray(),
                                                    ];
                                                })->toArray();
                                            } else {
                                                $incomes = [['source_of_income' => '', 'net_weekly_amount' => '']];
                                            }
                                        @endphp
                                        
                                        @foreach($incomes as $index => $income)
                                            <div class="income-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-mint/50 transition-colors bg-white" data-index="{{ $index }}">
                                                <div class="flex items-center justify-between mb-4">
                                                    <h4 class="font-semibold text-plyform-dark">Income Source {{ $index + 1 }}</h4>
                                                    @if($index > 0)
                                                        <button 
                                                            type="button" 
                                                            onclick="removeIncome({{ $index }})"
                                                            class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors"
                                                        >
                                                            Remove
                                                        </button>
                                                    @endif
                                                </div>
                                                
                                                <div class="grid md:grid-cols-2 gap-4">
                                                    <!-- Source of Income -->
                                                    <div>
                                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                            Source of Income <span class="text-plyform-orange">*</span>
                                                        </label>
                                                        <select 
                                                            name="incomes[{{ $index }}][source_of_income]" 
                                                            required
                                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                        >
                                                            <option value="">Select source</option>
                                                            <option value="full_time_employment" {{ ($income['source_of_income'] ?? '') == 'full_time_employment' ? 'selected' : '' }}>Full-time Employment</option>
                                                            <option value="part_time_employment" {{ ($income['source_of_income'] ?? '') == 'part_time_employment' ? 'selected' : '' }}>Part-time Employment</option>
                                                            <option value="casual_employment" {{ ($income['source_of_income'] ?? '') == 'casual_employment' ? 'selected' : '' }}>Casual Employment</option>
                                                            <option value="self_employed" {{ ($income['source_of_income'] ?? '') == 'self_employed' ? 'selected' : '' }}>Self-Employed</option>
                                                            <option value="centrelink" {{ ($income['source_of_income'] ?? '') == 'centrelink' ? 'selected' : '' }}>Centrelink</option>
                                                            <option value="pension" {{ ($income['source_of_income'] ?? '') == 'pension' ? 'selected' : '' }}>Pension</option>
                                                            <option value="investment" {{ ($income['source_of_income'] ?? '') == 'investment' ? 'selected' : '' }}>Investment Income</option>
                                                            <option value="savings" {{ ($income['source_of_income'] ?? '') == 'savings' ? 'selected' : '' }}>Savings</option>
                                                            <option value="other" {{ ($income['source_of_income'] ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <!-- Net Weekly Amount -->
                                                    <div>
                                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                            Net Weekly Amount <span class="text-plyform-orange">*</span>
                                                        </label>
                                                        <div class="relative">
                                                            <span class="absolute left-4 top-3.5 text-gray-500 font-semibold">$</span>
                                                            <input 
                                                                type="number" 
                                                                name="incomes[{{ $index }}][net_weekly_amount]" 
                                                                value="{{ $income['net_weekly_amount'] ?? '' }}"
                                                                step="0.01"
                                                                min="0"
                                                                required
                                                                onchange="calculateTotal()"
                                                                class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                                placeholder="0.00"
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Bank Statement Upload (Multiple) -->
                                                <div class="mt-4">
                                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                        Proof you can pay rent
                                                        <span class="text-xs text-gray-500 font-normal">- Upload multiple documents</span>
                                                    </label>
                                                    <span class="text-xs text-gray-500 font-normal">Attach three recent payslips or other supporting documents. If using bank statements, hide account numbers and any non-income transactions.</span>
                                                    <div class="space-y-3">
                                                        <!-- File Input (Hidden, Multiple) -->
                                                        <input 
                                                            type="file" 
                                                            name="incomes[{{ $index }}][bank_statements][]"
                                                            id="income_statement_{{ $index }}"
                                                            accept=".pdf,.jpg,.jpeg,.png"
                                                            onchange="previewIncomeStatements({{ $index }})"
                                                            multiple
                                                            class="hidden"
                                                        >
                                                        
                                                        <!-- Preview Container for Multiple Files -->
                                                        <div id="income_statement_preview_{{ $index }}" class="space-y-2">
                                                            @if(!empty($income['bank_statements']) && is_array($income['bank_statements']))
                                                                <!-- EXISTING FILES PREVIEW -->
                                                                @foreach($income['bank_statements'] as $statementIndex => $statementPath)
                                                                    @if(Storage::disk('public')->exists($statementPath))
                                                                        <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3" data-existing-file="{{ $statementIndex }}">
                                                                            <div class="flex items-center gap-3">
                                                                                <!-- File Icon/Thumbnail -->
                                                                                @php
                                                                                    $extension = pathinfo($statementPath, PATHINFO_EXTENSION);
                                                                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                                                                                @endphp
                                                                                
                                                                                @if($isImage)
                                                                                    <img src="{{ Storage::url($statementPath) }}" alt="Statement" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                                                                                @else
                                                                                    <div class="w-16 h-16 bg-red-100 rounded-lg border-2 border-red-300 flex items-center justify-center">
                                                                                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                                                        </svg>
                                                                                    </div>
                                                                                @endif
                                                                                
                                                                                <!-- File Info -->
                                                                                <div class="flex-1 min-w-0">
                                                                                    <p class="text-sm font-medium text-gray-900 truncate">{{ basename($statementPath) }}</p>
                                                                                    <p class="text-xs text-gray-500">Uploaded document</p>
                                                                                </div>
                                                                                
                                                                                <!-- View Button -->
                                                                                <a 
                                                                                    href="{{ Storage::url($statementPath) }}" 
                                                                                    target="_blank"
                                                                                    class="flex-shrink-0 text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded-lg"
                                                                                    title="View document"
                                                                                >
                                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                                    </svg>
                                                                                </a>
                                                                                
                                                                                <!-- Remove Button -->
                                                                                <button 
                                                                                    type="button" 
                                                                                    onclick="removeExistingIncomeStatement({{ $index }}, {{ $statementIndex }})"
                                                                                    class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                                                                                    title="Remove document"
                                                                                >
                                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                                    </svg>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Hidden input to track existing file -->
                                                                        <input type="hidden" name="incomes[{{ $index }}][existing_statements][]" value="{{ $statementPath }}" id="existing_statement_{{ $index }}_{{ $statementIndex }}">
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        
                                                        <!-- Upload Button -->
                                                        <button 
                                                            type="button" 
                                                            onclick="document.getElementById('income_statement_{{ $index }}').click()"
                                                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-green transition-colors text-center cursor-pointer"
                                                        >
                                                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                            </svg>
                                                            <span class="text-sm text-gray-600">Click to upload bank statements</span>
                                                            <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB per file)</span>
                                                        </button>
                                                    </div>
                                                    <p class="mt-1 text-xs text-gray-500">Max size: 10MB per file. Formats: PDF, JPG, PNG. You can upload multiple files.</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Add Income Button -->
                                    <button 
                                        type="button" 
                                        onclick="addIncome()"
                                        class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-green hover:text-plyform-dark hover:bg-plyform-green/5 transition flex items-center justify-center gap-2 font-medium"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Add Another Income Source
                                    </button>
                                    
                                    <!-- Total Income Display -->
                                    <div class="mt-6 p-5 bg-plyform-mint/20 border border-plyform-mint/50 rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <span class="font-semibold text-plyform-dark">Total Weekly Income:</span>
                                                <p class="text-sm text-gray-600 mt-1">This helps property managers assess affordability</p>
                                            </div>
                                            <span class="text-3xl font-bold text-plyform-dark" id="total-income">$0.00</span>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Identity Documents -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card" data-section="identity_documents">
                            <button type="button" onclick="toggleSection('identity_documents')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ auth()->user()->identifications && auth()->user()->identifications->count() > 0 ? 'bg-teal-100' : 'bg-gray-100' }} flex items-center justify-center section-status" id="status_identity_documents">
                                        @if(auth()->user()->identifications && auth()->user()->identifications->count() > 0)
                                            <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="text-left">
                                        <span class="font-semibold text-gray-900">Identity documents</span>
                                        @if(auth()->user()->identifications && auth()->user()->identifications->count() > 0)
                                            <p class="text-xs text-gray-500">{{ auth()->user()->identifications->count() }} {{ Str::plural('document', auth()->user()->identifications->count()) }} uploaded</p>
                                        @else
                                            <p class="text-xs text-gray-500">Not completed yet</p>
                                        @endif
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            
                            <div class="section-content hidden px-6 pb-6">
                                
                                <!-- Identification Section -->
                                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="text-base font-semibold text-plyform-dark">Identification Documents</h4>
                                            <p class="text-sm text-gray-600 mt-1">Upload identification documents to verify your identity</p>
                                        </div>
                                        <span class="text-plyform-orange text-sm font-medium">* Required</span>
                                    </div>
                                    
                                    <!-- Info Box -->
                                    <div class="p-4 bg-plyform-green/10 border border-plyform-green/30 rounded-lg mb-6">
                                        <div class="flex gap-3">
                                            <svg class="w-5 h-5 text-plyform-dark flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-plyform-dark mb-2">Accepted Documents:</h4>
                                                <div class="grid md:grid-cols-2 gap-2 text-sm text-gray-700">
                                                    <div>• Australian Driver's Licence</div>
                                                    <div>• Passport</div>
                                                    <div>• Birth Certificate</div>
                                                    <div>• Medicare Card</div>
                                                </div>
                                                <p class="text-sm text-plyform-dark mt-2">
                                                    Upload clear, high-quality scans or photos of your documents.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="identification-container">
                                        @php
                                            $identifications = old('identifications', auth()->user()->identifications->toArray() ?: [['identification_type' => '']]);
                                        @endphp
                                        
                                        @foreach($identifications as $index => $id)
                                            <div class="identification-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-green/50 transition-colors bg-white" data-index="{{ $index }}">
                                                <div class="flex items-center justify-between mb-4">
                                                    <h4 class="font-semibold text-plyform-dark">Document {{ $index + 1 }}</h4>
                                                    @if($index > 0)
                                                        <button 
                                                            type="button" 
                                                            onclick="removeIdentificationItem({{ $index }})"
                                                            class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors"
                                                        >
                                                            Remove
                                                        </button>
                                                    @endif
                                                </div>
                                                
                                                <!-- ID Type -->
                                                <div class="mb-4">
                                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                        Document Type <span class="text-plyform-orange">*</span>
                                                    </label>
                                                    <select 
                                                        name="identifications[{{ $index }}][identification_type]" 
                                                        required
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                    >
                                                        <option value="">Select document type</option>
                                                        <option value="australian_drivers_licence" {{ ($id['identification_type'] ?? '') == 'australian_drivers_licence' ? 'selected' : '' }}>Australian Driver's Licence</option>
                                                        <option value="passport" {{ ($id['identification_type'] ?? '') == 'passport' ? 'selected' : '' }}>Passport</option>
                                                        <option value="birth_certificate" {{ ($id['identification_type'] ?? '') == 'birth_certificate' ? 'selected' : '' }}>Birth Certificate</option>
                                                        <option value="medicare" {{ ($id['identification_type'] ?? '') == 'medicare' ? 'selected' : '' }}>Medicare Card</option>
                                                        <option value="other" {{ ($id['identification_type'] ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                </div>
                                                
                                                <!-- Document Number (Optional) -->
                                                <div class="mb-4">
                                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                        Document Number (Optional)
                                                    </label>
                                                    <input 
                                                        type="text" 
                                                        name="identifications[{{ $index }}][document_number]"
                                                        value="{{ $id['document_number'] ?? '' }}"
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                        placeholder="e.g., ABC123456"
                                                    >
                                                </div>
                                                
                                                <!-- Document Upload -->
                                                <div class="mb-4">
                                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                        Upload Document <span class="text-plyform-orange">*</span>
                                                    </label>
                                                    <div class="space-y-3">
                                                        <!-- File Input (Hidden) -->
                                                        <input 
                                                            type="file" 
                                                            name="identifications[{{ $index }}][document]"
                                                            id="identification_document_{{ $index }}"
                                                            accept=".pdf,.jpg,.jpeg,.png"
                                                            {{ isset($id['document_path']) ? '' : 'required' }}
                                                            onchange="previewIdentificationDocument({{ $index }})"
                                                            class="hidden"
                                                        >
                                                        
                                                        <!-- Upload Button/Preview Container -->
                                                        <div id="identification_document_preview_{{ $index }}" class="space-y-2">
                                                            @if(!empty($id['document_path']) && Storage::disk('public')->exists($id['document_path']))
                                                                <!-- EXISTING FILE PREVIEW -->
                                                                <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3">
                                                                    <div class="flex items-center gap-3">
                                                                        <!-- File Icon/Thumbnail -->
                                                                        @if(in_array(pathinfo($id['document_path'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                                            <img src="{{ Storage::url($id['document_path']) }}" alt="Document" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                                                                        @else
                                                                            <div class="w-16 h-16 bg-blue-100 rounded-lg border-2 border-blue-300 flex items-center justify-center">
                                                                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                                                </svg>
                                                                            </div>
                                                                        @endif
                                                                        
                                                                        <!-- File Info -->
                                                                        <div class="flex-1 min-w-0">
                                                                            <p class="text-sm font-medium text-gray-900 truncate">{{ basename($id['document_path']) }}</p>
                                                                            <p class="text-xs text-green-600 flex items-center gap-1">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                                                </svg>
                                                                                Document uploaded
                                                                            </p>
                                                                        </div>
                                                                        
                                                                        <!-- View Button -->
                                                                        <a 
                                                                            href="{{ Storage::url($id['document_path']) }}" 
                                                                            target="_blank"
                                                                            class="flex-shrink-0 text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded-lg"
                                                                            title="View document"
                                                                        >
                                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                            </svg>
                                                                        </a>
                                                                        
                                                                        <!-- Remove Button -->
                                                                        <button 
                                                                            type="button" 
                                                                            onclick="removeIdentificationDocument({{ $index }})"
                                                                            class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                                                                            title="Remove document"
                                                                        >
                                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                            </svg>
                                                                        </button>
                                                                        
                                                                        <!-- Re-upload Button -->
                                                                        <button 
                                                                            type="button" 
                                                                            onclick="document.getElementById('identification_document_{{ $index }}').click()"
                                                                            class="flex-shrink-0 text-gray-600 hover:text-gray-800 transition p-2 hover:bg-gray-100 rounded-lg"
                                                                            title="Change document"
                                                                        >
                                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <!-- Hidden input to track existing file -->
                                                                <input type="hidden" name="identifications[{{ $index }}][existing_document]" value="{{ $id['document_path'] }}">
                                                            @else
                                                                <!-- NO FILE YET - UPLOAD BUTTON -->
                                                                <button 
                                                                    type="button" 
                                                                    onclick="document.getElementById('identification_document_{{ $index }}').click()"
                                                                    class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-green transition-colors text-center cursor-pointer"
                                                                >
                                                                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                                    </svg>
                                                                    <span class="text-sm text-gray-600">Click to upload identification document</span>
                                                                    <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB)</span>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <p class="mt-1 text-xs text-gray-500">Max size: 10MB. Accepted: PDF, JPG, PNG</p>
                                                </div>
                                                
                                                <!-- Expiry Date (Optional) -->
                                                <div>
                                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                        Expiry Date (if applicable)
                                                    </label>
                                                    <input 
                                                        type="date" 
                                                        name="identifications[{{ $index }}][expiry_date]"
                                                        value="{{ isset($id['expiry_date']) ? \Carbon\Carbon::parse($id['expiry_date'])->format('Y-m-d') : '' }}"
                                                        min="{{ now()->format('Y-m-d') }}"
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                    >
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Add ID Button -->
                                    <button 
                                        type="button" 
                                        onclick="addIdentificationItem()"
                                        class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-green hover:text-plyform-dark hover:bg-plyform-green/5 transition flex items-center justify-center gap-2 font-medium"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Add Another Document
                                    </button>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Emergency Contact -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card" data-section="emergency_contact">
                            <button type="button" onclick="toggleSection('emergency_contact')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ auth()->user()->profile && auth()->user()->profile->has_emergency_contact ? 'bg-teal-100' : 'bg-gray-100' }} flex items-center justify-center section-status" id="status_emergency_contact">
                                        @if(auth()->user()->profile && auth()->user()->profile->has_emergency_contact)
                                            <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="text-left">
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-gray-900">Emergency contact</span>
                                            <span class="text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full font-medium">Optional</span>
                                        </div>
                                        @if(auth()->user()->profile && auth()->user()->profile->has_emergency_contact)
                                            <p class="text-xs text-gray-500">{{ auth()->user()->profile->emergency_contact_name }}</p>
                                        @else
                                            <p class="text-xs text-gray-500">Not completed yet</p>
                                        @endif
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            
                            <div class="section-content hidden px-6 pb-6">
                                
                                <!-- Emergency Contact Section -->
                                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                    <div class="mb-4">
                                        <h4 class="text-base font-semibold text-plyform-dark">Emergency Contact</h4>
                                        <p class="text-sm text-gray-600 mt-1">Someone we can contact in case of emergency</p>
                                    </div>
                                    
                                    <!-- Has Emergency Contact Toggle -->
                                    <div class="mb-4">
                                        <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-plyform-mint/10 transition-colors">
                                            <div class="relative">
                                                <input 
                                                    type="checkbox" 
                                                    name="has_emergency_contact" 
                                                    id="has_emergency_contact"
                                                    value="1"
                                                    {{ old('has_emergency_contact', auth()->user()->profile->has_emergency_contact ?? false) ? 'checked' : '' }}
                                                    onchange="toggleEmergencyContact()"
                                                    class="sr-only peer"
                                                >
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-plyform-green/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-plyform-green"></div>
                                            </div>
                                            <span class="text-sm font-medium text-plyform-dark">I have an emergency contact</span>
                                        </label>
                                    </div>

                                    <div id="emergency-contact-fields" style="display: {{ old('has_emergency_contact', auth()->user()->profile->has_emergency_contact ?? false) ? 'block' : 'none' }};">
    
                                        <!-- Info Banner -->
                                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                            <div class="flex gap-3">
                                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <div class="flex-1">
                                                    <p class="text-sm text-blue-900 font-medium">Provide details of someone we can contact in case of emergency</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Emergency Contact Form -->
                                        <div class="bg-white rounded-lg border-2 border-gray-200 p-6 space-y-6">
                                            
                                            <!-- Name and Relationship Row -->
                                            <div class="grid md:grid-cols-2 gap-4">
                                                
                                                <!-- Emergency Contact Name -->
                                                <div>
                                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                        Full Name <span class="text-plyform-orange">*</span>
                                                    </label>
                                                    <input 
                                                        type="text" 
                                                        name="emergency_contact_name" 
                                                        value="{{ old('emergency_contact_name', auth()->user()->profile->emergency_contact_name ?? '') }}"
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all hover:border-gray-400 @error('emergency_contact_name') border-red-500 @enderror"
                                                        placeholder="e.g., Jane Smith"
                                                    >
                                                    @error('emergency_contact_name')
                                                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                            </svg>
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                                
                                                <!-- Relationship -->
                                                <div>
                                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                        </svg>
                                                        Relationship <span class="text-plyform-orange">*</span>
                                                    </label>
                                                    <select 
                                                        name="emergency_contact_relationship" 
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all hover:border-gray-400 @error('emergency_contact_relationship') border-red-500 @enderror"
                                                    >
                                                        <option value="">Select relationship</option>
                                                        <option value="parent" {{ old('emergency_contact_relationship', auth()->user()->profile->emergency_contact_relationship ?? '') == 'parent' ? 'selected' : '' }}>Parent</option>
                                                        <option value="sibling" {{ old('emergency_contact_relationship', auth()->user()->profile->emergency_contact_relationship ?? '') == 'sibling' ? 'selected' : '' }}>Sibling</option>
                                                        <option value="partner" {{ old('emergency_contact_relationship', auth()->user()->profile->emergency_contact_relationship ?? '') == 'partner' ? 'selected' : '' }}>Partner</option>
                                                        <option value="spouse" {{ old('emergency_contact_relationship', auth()->user()->profile->emergency_contact_relationship ?? '') == 'spouse' ? 'selected' : '' }}>Spouse</option>
                                                        <option value="friend" {{ old('emergency_contact_relationship', auth()->user()->profile->emergency_contact_relationship ?? '') == 'friend' ? 'selected' : '' }}>Friend</option>
                                                        <option value="other" {{ old('emergency_contact_relationship', auth()->user()->profile->emergency_contact_relationship ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                    @error('emergency_contact_relationship')
                                                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                            </svg>
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                                
                                            </div>
                                            
                                            <!-- Contact Details Row -->
                                            <div class="grid md:grid-cols-2 gap-4">
                                                
                                                <!-- Emergency Contact Phone -->
                                                <div>
                                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                        </svg>
                                                        Phone Number <span class="text-plyform-orange">*</span>
                                                    </label>
                                                    
                                                    <input 
                                                        type="tel" 
                                                        id="app_emergency_contact_phone" 
                                                        name="emergency_contact_number_display"
                                                        value="{{ old('emergency_contact_number', auth()->user()->profile->emergency_contact_number ?? '') }}"
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all hover:border-gray-400 @error('emergency_contact_number') border-red-500 @enderror"
                                                        placeholder="Enter phone number"
                                                    >
                                                    
                                                    <!-- Hidden fields for country code and number -->
                                                    <input type="hidden" id="app_emergency_contact_country_code" name="emergency_contact_country_code" value="{{ old('emergency_contact_country_code', auth()->user()->profile->emergency_contact_country_code ?? '+61') }}">
                                                    <input type="hidden" id="app_emergency_contact_number_clean" name="emergency_contact_number" value="{{ old('emergency_contact_number', auth()->user()->profile->emergency_contact_number ?? '') }}">
                                                    
                                                    @error('emergency_contact_country_code')
                                                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                            </svg>
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                    @error('emergency_contact_number')
                                                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                            </svg>
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                    <p class="mt-1 text-xs text-gray-500">Select country and enter emergency contact number</p>
                                                </div>
                                                
                                                <!-- Emergency Contact Email -->
                                                <div>
                                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                        </svg>
                                                        Email Address <span class="text-plyform-orange">*</span>
                                                    </label>
                                                    <input 
                                                        type="email" 
                                                        name="emergency_contact_email" 
                                                        value="{{ old('emergency_contact_email', auth()->user()->profile->emergency_contact_email ?? '') }}"
                                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all hover:border-gray-400 @error('emergency_contact_email') border-red-500 @enderror"
                                                        placeholder="emergency@example.com"
                                                    >
                                                    @error('emergency_contact_email')
                                                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                            </svg>
                                                            {{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                                
                                            </div>
                                            
                                            <!-- Helper Text -->
                                            <div class="pt-2 border-t border-gray-100">
                                                <p class="text-xs text-gray-500 flex items-start gap-2">
                                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                    </svg>
                                                    <span>This person will only be contacted in case of an emergency. Please ensure they are aware and willing to be listed as your emergency contact.</span>
                                                </p>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Household -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card" data-section="household">
                            <button type="button" onclick="toggleSection('household')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center section-status" id="status_household">
                                        <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <span class="font-semibold text-gray-900">Household</span>
                                        <p class="text-xs text-gray-500" id="household-summary">1 person (you)</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            
                            <div class="section-content hidden px-6 pb-6">
                                
                                <!-- Household Section -->
                                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="text-base font-semibold text-plyform-dark">Household Information</h4>
                                            <p class="text-sm text-gray-600 mt-1">Who will be living in this property?</p>
                                        </div>
                                        <span class="text-plyform-orange text-sm font-medium">* Required</span>
                                    </div>
                                    
                                    <!-- Number of Occupants -->
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Number of Occupants <span class="text-plyform-orange">*</span>
                                            <span class="text-xs text-gray-500 font-normal">(Including yourself)</span>
                                        </label>
                                        <input 
                                            type="number" 
                                            name="number_of_occupants" 
                                            value="{{ old('number_of_occupants', 1) }}"
                                            min="1"
                                            max="10"
                                            required
                                            onkeyup="validateOccupantsInput(this)"
                                            onchange="validateOccupantsInput(this)"
                                            oninput="validateOccupantsInput(this)"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('number_of_occupants') border-red-500 @enderror"
                                        >
                                        @error('number_of_occupants')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="text-xs text-gray-500 mt-1">Minimum 1 person (yourself). Maximum 10 people.</p>
                                    </div>
                                    
                                    <!-- Occupants Details Section -->
                                    <div id="occupants-section" class="hidden">
                                        <div class="mt-6 p-4 bg-white rounded-lg border-2 border-gray-200">
                                            <h5 class="text-sm font-semibold text-plyform-dark mb-4">Occupants Details</h5>
                                            <p class="text-sm text-gray-600 mb-4">Provide details about all people who will be living in the property</p>
                                            <div id="occupants-container"></div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Pets -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card" data-section="pets">
                            <button type="button" onclick="toggleSection('pets')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center section-status" id="status_pets">
                                        <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-gray-900">Pets</span>
                                            <span class="text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full font-medium">Optional</span>
                                        </div>
                                        @if(auth()->user()->pets && auth()->user()->pets->count() > 0)
                                            <p class="text-xs text-gray-500">{{ auth()->user()->pets->count() }} {{ Str::plural('pet', auth()->user()->pets->count()) }}</p>
                                        @else
                                            <p class="text-xs text-gray-500">None</p>
                                        @endif
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            
                            <div class="section-content hidden px-6 pb-6">
                                
                                <!-- Has Pets Toggle -->
                                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            name="has_pets" 
                                            id="has-pets"
                                            value="1"
                                            onchange="togglePetsSection()"
                                            {{ old('has_pets', auth()->user()->pets->count() > 0) ? 'checked' : '' }}
                                            class="w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                                        >
                                        <span class="font-medium text-plyform-dark">I have pets</span>
                                    </label>
                                    <p class="text-sm text-gray-600 mt-2 ml-8">Check this if you have any pets that will be living with you</p>
                                </div>

                                <div id="pets-section" style="display: {{ old('has_pets', auth()->user()->pets->count() > 0) ? 'block' : 'none' }};">
                                    <!-- Pet Information Section -->
                                    <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <div>
                                                <h4 class="text-base font-semibold text-plyform-dark">Pet Information</h4>
                                                <p class="text-sm text-gray-600 mt-1">Provide details about your pets</p>
                                            </div>
                                            <span class="text-plyform-orange text-sm font-medium">* Required</span>
                                        </div>
                                        
                                        <div id="pets-container">
                                            @php
                                                $pets = old('pets', auth()->user()->pets->toArray() ?: [['type' => '']]);
                                            @endphp
                                            
                                            @foreach($pets as $index => $pet)
                                                <div class="pet-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-orange/30 transition-colors bg-white" data-index="{{ $index }}">
                                                    <div class="flex items-center justify-between mb-4">
                                                        <h4 class="font-semibold text-plyform-dark">Pet {{ $index + 1 }}</h4>
                                                        @if($index > 0)
                                                            <button type="button" onclick="removePetItem({{ $index }})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">Remove</button>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="grid md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="text-sm font-medium text-plyform-dark mb-2 block">Pet Type <span class="text-plyform-orange">*</span></label>
                                                            <select name="pets[{{ $index }}][type]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                                                                <option value="">Select type</option>
                                                                <option value="dog" {{ ($pet['type'] ?? '') == 'dog' ? 'selected' : '' }}>Dog</option>
                                                                <option value="cat" {{ ($pet['type'] ?? '') == 'cat' ? 'selected' : '' }}>Cat</option>
                                                                <option value="bird" {{ ($pet['type'] ?? '') == 'bird' ? 'selected' : '' }}>Bird</option>
                                                                <option value="fish" {{ ($pet['type'] ?? '') == 'fish' ? 'selected' : '' }}>Fish</option>
                                                                <option value="rabbit" {{ ($pet['type'] ?? '') == 'rabbit' ? 'selected' : '' }}>Rabbit</option>
                                                                <option value="other" {{ ($pet['type'] ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div>
                                                            <label class="text-sm font-medium text-plyform-dark mb-2 block">Breed <span class="text-plyform-orange">*</span></label>
                                                            <input type="text" name="pets[{{ $index }}][breed]" value="{{ $pet['breed'] ?? '' }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="e.g., Golden Retriever">
                                                        </div>
                                                        
                                                        <div>
                                                            <label class="text-sm font-medium text-plyform-dark mb-2 block">Desexed <span class="text-plyform-orange">*</span></label>
                                                            <select name="pets[{{ $index }}][desexed]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                                                                <option value="">Select</option>
                                                                <option value="1" {{ ($pet['desexed'] ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                                                                <option value="0" {{ ($pet['desexed'] ?? '') == '0' ? 'selected' : '' }}>No</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div>
                                                            <label class="text-sm font-medium text-plyform-dark mb-2 block">Size <span class="text-plyform-orange">*</span></label>
                                                            <select name="pets[{{ $index }}][size]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                                                                <option value="">Select size</option>
                                                                <option value="small" {{ ($pet['size'] ?? '') == 'small' ? 'selected' : '' }}>Small (under 10kg)</option>
                                                                <option value="medium" {{ ($pet['size'] ?? '') == 'medium' ? 'selected' : '' }}>Medium (10-25kg)</option>
                                                                <option value="large" {{ ($pet['size'] ?? '') == 'large' ? 'selected' : '' }}>Large (over 25kg)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-4">
                                                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Registration Number (Optional)</label>
                                                        <input type="text" name="pets[{{ $index }}][registration_number]" value="{{ $pet['registration_number'] ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="e.g., 123456">
                                                        <p class="mt-1 text-xs text-gray-500">Council registration number if applicable</p>
                                                    </div>

                                                    <!-- Pet Photo Upload -->
                                                    <div class="mt-4">
                                                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Pet Photo <span class="text-plyform-orange">*</span></label>
                                                        <div class="space-y-3">
                                                            <!-- File Input (Hidden) -->
                                                            <input 
                                                                type="file" 
                                                                name="pets[{{ $index }}][photo]"
                                                                id="pet_photo_{{ $index }}"
                                                                accept="image/jpeg,image/jpg,image/png"
                                                                {{ isset($pet['photo_path']) ? '' : 'required' }}
                                                                onchange="previewPetPhoto({{ $index }})"
                                                                class="hidden"
                                                            >
                                                            
                                                            <!-- Upload Button/Preview Container -->
                                                            <div id="pet_photo_preview_{{ $index }}" class="space-y-2">
                                                                @if(!empty($pet['photo_path']) && Storage::disk('public')->exists($pet['photo_path']))
                                                                    <!-- EXISTING PHOTO PREVIEW -->
                                                                    <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3">
                                                                        <div class="flex items-center gap-3">
                                                                            <!-- Photo Thumbnail -->
                                                                            <img src="{{ Storage::url($pet['photo_path']) }}" alt="Pet Photo" class="w-20 h-20 object-cover rounded-lg border-2 border-plyform-orange/50">
                                                                            
                                                                            <!-- File Info -->
                                                                            <div class="flex-1 min-w-0">
                                                                                <p class="text-sm font-medium text-gray-900 truncate">{{ basename($pet['photo_path']) }}</p>
                                                                                <p class="text-xs text-green-600 flex items-center gap-1">
                                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                                                    </svg>
                                                                                    Photo uploaded
                                                                                </p>
                                                                            </div>
                                                                            
                                                                            <!-- View Button -->
                                                                            <a 
                                                                                href="{{ Storage::url($pet['photo_path']) }}" 
                                                                                target="_blank"
                                                                                class="flex-shrink-0 text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded-lg"
                                                                                title="View photo"
                                                                            >
                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                                </svg>
                                                                            </a>
                                                                            
                                                                            <!-- Remove Button -->
                                                                            <button 
                                                                                type="button" 
                                                                                onclick="removePetPhoto({{ $index }})"
                                                                                class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                                                                                title="Remove photo"
                                                                            >
                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                                </svg>
                                                                            </button>
                                                                            
                                                                            <!-- Re-upload Button -->
                                                                            <button 
                                                                                type="button" 
                                                                                onclick="document.getElementById('pet_photo_{{ $index }}').click()"
                                                                                class="flex-shrink-0 text-gray-600 hover:text-gray-800 transition p-2 hover:bg-gray-100 rounded-lg"
                                                                                title="Change photo"
                                                                            >
                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Hidden input to track existing file -->
                                                                    <input type="hidden" name="pets[{{ $index }}][existing_photo]" value="{{ $pet['photo_path'] }}">
                                                                @else
                                                                    <!-- NO PHOTO YET - UPLOAD BUTTON -->
                                                                    <button 
                                                                        type="button" 
                                                                        onclick="document.getElementById('pet_photo_{{ $index }}').click()"
                                                                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer"
                                                                    >
                                                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                                        </svg>
                                                                        <span class="text-sm text-gray-600">Click to upload pet photo</span>
                                                                        <span class="text-xs text-gray-500 block mt-1">JPG, PNG (Max 5MB)</span>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <p class="mt-1 text-xs text-gray-500">Upload a clear photo of your pet (JPG, PNG - Max 5MB)</p>
                                                    </div>

                                                    <!-- Pet Registration Document Upload -->
                                                    <div class="mt-4">
                                                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Pet Registration Document (Optional)</label>
                                                        <div class="space-y-3">
                                                            <!-- File Input (Hidden) -->
                                                            <input 
                                                                type="file" 
                                                                name="pets[{{ $index }}][document]"
                                                                id="pet_document_{{ $index }}"
                                                                accept=".pdf,.jpg,.jpeg,.png"
                                                                onchange="previewPetDocument({{ $index }})"
                                                                class="hidden"
                                                            >
                                                            
                                                            <!-- Upload Button/Preview Container -->
                                                            <div id="pet_document_preview_{{ $index }}" class="space-y-2">
                                                                @if(!empty($pet['document_path']) && Storage::disk('public')->exists($pet['document_path']))
                                                                    <!-- EXISTING DOCUMENT PREVIEW -->
                                                                    <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3">
                                                                        <div class="flex items-center gap-3">
                                                                            <!-- File Icon/Thumbnail -->
                                                                            @if(in_array(pathinfo($pet['document_path'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                                                <img src="{{ Storage::url($pet['document_path']) }}" alt="Document" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                                                                            @else
                                                                                <div class="w-16 h-16 bg-orange-100 rounded-lg border-2 border-plyform-orange/50 flex items-center justify-center">
                                                                                    <svg class="w-8 h-8 text-plyform-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                                                    </svg>
                                                                                </div>
                                                                            @endif
                                                                            
                                                                            <!-- File Info -->
                                                                            <div class="flex-1 min-w-0">
                                                                                <p class="text-sm font-medium text-gray-900 truncate">{{ basename($pet['document_path']) }}</p>
                                                                                <p class="text-xs text-gray-500">Registration certificate</p>
                                                                            </div>
                                                                            
                                                                            <!-- View Button -->
                                                                            <a 
                                                                                href="{{ Storage::url($pet['document_path']) }}" 
                                                                                target="_blank"
                                                                                class="flex-shrink-0 text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded-lg"
                                                                                title="View document"
                                                                            >
                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                                </svg>
                                                                            </a>
                                                                            
                                                                            <!-- Remove Button -->
                                                                            <button 
                                                                                type="button" 
                                                                                onclick="removePetDocument({{ $index }})"
                                                                                class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                                                                                title="Remove document"
                                                                            >
                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                                </svg>
                                                                            </button>
                                                                            
                                                                            <!-- Re-upload Button -->
                                                                            <button 
                                                                                type="button" 
                                                                                onclick="document.getElementById('pet_document_{{ $index }}').click()"
                                                                                class="flex-shrink-0 text-gray-600 hover:text-gray-800 transition p-2 hover:bg-gray-100 rounded-lg"
                                                                                title="Change document"
                                                                            >
                                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Hidden input to track existing file -->
                                                                    <input type="hidden" name="pets[{{ $index }}][existing_document]" value="{{ $pet['document_path'] }}">
                                                                @else
                                                                    <!-- NO DOCUMENT YET - UPLOAD BUTTON -->
                                                                    <button 
                                                                        type="button" 
                                                                        onclick="document.getElementById('pet_document_{{ $index }}').click()"
                                                                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer"
                                                                    >
                                                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                                        </svg>
                                                                        <span class="text-sm text-gray-600">Click to upload registration certificate</span>
                                                                        <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB)</span>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <p class="mt-1 text-xs text-gray-500">Upload registration certificate if available (PDF, JPG, PNG - Max 10MB)</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <button type="button" onclick="addAnotherPet()" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-green hover:text-plyform-dark hover:bg-plyform-green/5 transition flex items-center justify-center gap-2 font-medium">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Add Another Pet
                                        </button>
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <!-- Utility Connection Service -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card" data-section="utility_connections">
                            <button type="button" onclick="toggleSection('utility_connections')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center section-status" id="status_utility_connections">
                                        <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-gray-900">Utility connection service</span>
                                            <span class="text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full font-medium">Optional</span>
                                        </div>
                                        <p class="text-xs text-gray-500" id="utility-summary">Optional free service</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            
                            <div class="section-content hidden px-6 pb-6">
                                
                                <!-- Utility Connection Section -->
                                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                    <div class="mb-4">
                                        <h4 class="text-base font-semibold text-plyform-dark">Utility Connections</h4>
                                        <p class="text-sm text-gray-600 mt-1">This is a free service that connects all your utilities</p>
                                    </div>
                                    
                                    <!-- Info Box -->
                                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg mb-6">
                                        <div class="flex gap-3">
                                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-sm text-blue-900 font-medium mb-1">Once we have received this application, we will call you to confirm your details.</p>
                                                <p class="text-xs text-blue-800">Direct Connect will make all reasonable efforts to contact you within 24 hours of the nearest working day on receipt of this Application to confirm the information on this Application after signing and sending it to the utility providers. Direct Connect is a utility one stop connection service.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Utilities Selection -->
                                    <div class="bg-white rounded-lg p-5 border-2 border-gray-200">
                                        <h5 class="text-sm font-semibold text-plyform-dark mb-4">Please tick utilities as required</h5>
                                        
                                        <div class="grid md:grid-cols-3 gap-4">
                                            
                                            <!-- Electricity -->
                                            <label class="flex items-center gap-3 cursor-pointer p-4 rounded-lg border-2 border-gray-200 hover:border-plyform-green hover:bg-plyform-green/5 transition-all group">
                                                <input 
                                                    type="checkbox" 
                                                    name="utility_electricity" 
                                                    value="1"
                                                    {{ old('utility_electricity') ? 'checked' : '' }}
                                                    onchange="updateUtilitySummary()"
                                                    class="w-6 h-6 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                                                >
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                    </svg>
                                                    <span class="text-sm font-semibold text-gray-900 group-hover:text-plyform-dark">Electricity</span>
                                                </div>
                                            </label>
                                            
                                            <!-- Gas -->
                                            <label class="flex items-center gap-3 cursor-pointer p-4 rounded-lg border-2 border-gray-200 hover:border-plyform-green hover:bg-plyform-green/5 transition-all group">
                                                <input 
                                                    type="checkbox" 
                                                    name="utility_gas" 
                                                    value="1"
                                                    {{ old('utility_gas') ? 'checked' : '' }}
                                                    onchange="updateUtilitySummary()"
                                                    class="w-6 h-6 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                                                >
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                                                    </svg>
                                                    <span class="text-sm font-semibold text-gray-900 group-hover:text-plyform-dark">Gas</span>
                                                </div>
                                            </label>
                                            
                                            <!-- Internet -->
                                            <label class="flex items-center gap-3 cursor-pointer p-4 rounded-lg border-2 border-gray-200 hover:border-plyform-green hover:bg-plyform-green/5 transition-all group">
                                                <input 
                                                    type="checkbox" 
                                                    name="utility_internet" 
                                                    value="1"
                                                    {{ old('utility_internet') ? 'checked' : '' }}
                                                    onchange="updateUtilitySummary()"
                                                    class="w-6 h-6 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                                                >
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                    </svg>
                                                    <span class="text-sm font-semibold text-gray-900 group-hover:text-plyform-dark">Internet</span>
                                                </div>
                                            </label>
                                            
                                        </div>
                                    </div>
                                    
                                    <!-- Declaration -->
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-300">
                                        <h5 class="text-xs font-bold text-gray-900 mb-2 uppercase">Declaration and Execution</h5>
                                        <p class="text-xs text-gray-700 leading-relaxed">
                                            By signing this application, I/we consent to Direct Connect arranging for the connection and disconnection of the nominated utility services and to providing information contained in this application to utility providers for the purpose acknowledged below. I/we have read, carefully considered the Terms and Conditions of Direct Connect and having read and understood them together with the Privacy Collection Notice set out below, declare that all the information contained in this Application is true and correct and that I/we can pay for, and are legally entitled to enter into a contract for the provision of the information disclosed in this Application to a supplier or potential supplier of the Services in accordance with the Privacy Collection Notice and to obtain any other information necessary in relation to the Services, pursuant to Direct Connect.
                                        </p>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Additional Notes -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card" data-section="additional_notes">
                            <button type="button" onclick="toggleSection('additional_notes')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center section-status" id="status_additional_notes">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-gray-900">Additional information</span>
                                            <span class="text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full font-medium">Optional</span>
                                        </div>
                                        <p class="text-xs text-gray-500">Notes and special requests</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            
                            <div class="section-content hidden px-6 pb-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-700 mb-2 block">Special Requests</label>
                                        <textarea 
                                            name="special_requests" 
                                            rows="4"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                            placeholder="e.g., Pet accommodation, parking needs, early move-in..."
                                        >{{ old('special_requests') }}</textarea>
                                        <p class="mt-1 text-xs text-gray-500">Maximum 1000 characters</p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-gray-700 mb-2 block">Additional Notes</label>
                                        <textarea 
                                            name="notes" 
                                            rows="3"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                            placeholder="Anything else you'd like the property manager to know..."
                                        >{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card" data-section="terms_conditions">
                            <button type="button" onclick="toggleSection('terms_conditions')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center section-status" id="status_terms_conditions">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <span class="font-semibold text-gray-900">Terms and Conditions</span>
                                        <p class="text-xs text-gray-500" id="terms-summary">Must be accepted to submit</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            
                            <div class="section-content hidden px-6 pb-6">
                                
                                <!-- Terms Section -->
                                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                    <div class="mb-4">
                                        <h4 class="text-base font-semibold text-plyform-dark">Application Terms & Conditions</h4>
                                        <p class="text-sm text-gray-600 mt-1">Please read carefully before submitting your application</p>
                                    </div>
                                    
                                    <!-- Terms Content Box -->
                                    <div class="bg-white rounded-lg border-2 border-gray-200 p-6 max-h-96 overflow-y-auto">
                                        <div class="prose prose-sm max-w-none text-gray-700">
                                            <h5 class="text-sm font-bold text-plyform-dark mb-3">1. Application Agreement</h5>
                                            <p class="text-xs mb-4">
                                                By submitting this application, you acknowledge that all information provided is true, accurate, and complete to the best of your knowledge. You understand that providing false or misleading information may result in the rejection of your application or termination of any tenancy agreement.
                                            </p>
                                            
                                            <h5 class="text-sm font-bold text-plyform-dark mb-3">2. Privacy and Information Use</h5>
                                            <p class="text-xs mb-4">
                                                You consent to the collection, use, and disclosure of your personal information for the purposes of processing this rental application, including but not limited to: conducting reference checks, verifying employment and income, performing credit checks, and contacting emergency contacts if necessary. Your information will be handled in accordance with applicable privacy laws.
                                            </p>
                                            
                                            <h5 class="text-sm font-bold text-plyform-dark mb-3">3. Reference and Background Checks</h5>
                                            <p class="text-xs mb-4">
                                                You authorize the property manager/landlord to contact references provided, verify employment details, conduct credit checks, and perform any other reasonable background checks deemed necessary for assessing your application. You understand that these checks may involve contacting third parties including but not limited to previous landlords, employers, and credit reporting agencies.
                                            </p>
                                            
                                            <h5 class="text-sm font-bold text-plyform-dark mb-3">4. Application Fee and Processing</h5>
                                            <p class="text-xs mb-4">
                                                You acknowledge that submitting this application does not guarantee approval or create any tenancy agreement. The property manager reserves the right to accept or reject any application at their discretion. Application processing times may vary, and you will be notified of the outcome once a decision has been made.
                                            </p>
                                            
                                            <h5 class="text-sm font-bold text-plyform-dark mb-3">5. Accuracy of Information</h5>
                                            <p class="text-xs mb-4">
                                                You declare that all documents uploaded, information provided, and statements made in this application are genuine, accurate, and not misleading. You understand that any discrepancies discovered may lead to immediate rejection of your application or termination of tenancy.
                                            </p>
                                            
                                            <h5 class="text-sm font-bold text-plyform-dark mb-3">6. Property Viewing and Inspection</h5>
                                            <p class="text-xs mb-4">
                                                You acknowledge that you have either inspected the property or accept the property in its current condition as described. If you have not inspected the property, you understand that you are applying based on the information and images provided, and the property manager makes no warranties regarding the condition beyond what has been disclosed.
                                            </p>
                                            
                                            <h5 class="text-sm font-bold text-plyform-dark mb-3">7. Financial Obligations</h5>
                                            <p class="text-xs mb-4">
                                                If your application is successful, you agree to pay the bond, rent in advance, and any other applicable fees as specified in the lease agreement. You understand that failure to pay these amounts by the specified dates may result in the offer being withdrawn.
                                            </p>
                                            
                                            <h5 class="text-sm font-bold text-plyform-dark mb-3">8. Utility Connections (If Applicable)</h5>
                                            <p class="text-xs mb-4">
                                                If you have opted for utility connection services, you consent to Direct Connect or the appointed utility connection service contacting you and arranging connections on your behalf. You understand this is a free service and authorize the sharing of necessary information with utility providers.
                                            </p>
                                            
                                            <h5 class="text-sm font-bold text-plyform-dark mb-3">9. Changes to Application</h5>
                                            <p class="text-xs mb-4">
                                                You agree to notify the property manager immediately of any changes to the information provided in this application, including changes to employment, income, contact details, or number of occupants, prior to entering into a lease agreement.
                                            </p>
                                            
                                            <h5 class="text-sm font-bold text-plyform-dark mb-3">10. Governing Law</h5>
                                            <p class="text-xs mb-4">
                                                This application and any resulting tenancy agreement shall be governed by the laws of the state/territory in which the property is located. You agree to comply with all applicable residential tenancy legislation and regulations.
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Acceptance Checkboxes -->
                                    <div class="mt-6 space-y-4">
                                        
                                        <!-- Main Terms Acceptance -->
                                        <label class="flex items-start gap-3 cursor-pointer p-4 rounded-lg border-2 border-gray-300 hover:border-plyform-green hover:bg-plyform-green/5 transition-all group">
                                            <input 
                                                type="checkbox" 
                                                name="accept_terms" 
                                                id="accept_terms"
                                                value="1"
                                                required
                                                onchange="updateTermsStatus()"
                                                class="mt-1 w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                                            >
                                            <div class="flex-1">
                                                <span class="text-sm font-semibold text-gray-900 group-hover:text-plyform-dark">
                                                    I have read and agree to the Terms and Conditions <span class="text-plyform-orange">*</span>
                                                </span>
                                                <p class="text-xs text-gray-600 mt-1">By checking this box, you confirm that you have read, understood, and agree to abide by all terms and conditions outlined above.</p>
                                            </div>
                                        </label>
                                        
                                        <!-- Information Accuracy Declaration -->
                                        <label class="flex items-start gap-3 cursor-pointer p-4 rounded-lg border-2 border-gray-300 hover:border-plyform-green hover:bg-plyform-green/5 transition-all group">
                                            <input 
                                                type="checkbox" 
                                                name="declare_accuracy" 
                                                id="declare_accuracy"
                                                value="1"
                                                required
                                                onchange="updateTermsStatus()"
                                                class="mt-1 w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                                            >
                                            <div class="flex-1">
                                                <span class="text-sm font-semibold text-gray-900 group-hover:text-plyform-dark">
                                                    I declare that all information provided is true and accurate <span class="text-plyform-orange">*</span>
                                                </span>
                                                <p class="text-xs text-gray-600 mt-1">You confirm that all information, documents, and statements in this application are truthful, complete, and not misleading.</p>
                                            </div>
                                        </label>
                                        
                                        <!-- Privacy Consent -->
                                        <label class="flex items-start gap-3 cursor-pointer p-4 rounded-lg border-2 border-gray-300 hover:border-plyform-green hover:bg-plyform-green/5 transition-all group">
                                            <input 
                                                type="checkbox" 
                                                name="consent_privacy" 
                                                id="consent_privacy"
                                                value="1"
                                                required
                                                onchange="updateTermsStatus()"
                                                class="mt-1 w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                                            >
                                            <div class="flex-1">
                                                <span class="text-sm font-semibold text-gray-900 group-hover:text-plyform-dark">
                                                    I consent to privacy collection and use of my information <span class="text-plyform-orange">*</span>
                                                </span>
                                                <p class="text-xs text-gray-600 mt-1">You authorize the collection, use, and disclosure of your personal information for application processing, reference checks, and property management purposes.</p>
                                            </div>
                                        </label>
                                        
                                    </div>
                                    
                                    <!-- Warning Message -->
                                    <div class="mt-4 p-4 bg-plyform-orange/10 border border-plyform-orange/30 rounded-lg">
                                        <div class="flex gap-3">
                                            <svg class="w-5 h-5 text-plyform-orange flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-plyform-dark mb-1">Important Notice</p>
                                                <p class="text-xs text-gray-700">All three checkboxes above must be ticked before you can submit your application. Please ensure you have read and understood all terms and conditions.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                    
                    <!-- Terms and Conditions -->
                    <div class="mt-6 bg-gray-50 rounded-xl p-6">
                        <p class="text-sm text-gray-600 mb-4 text-center">
                            By submitting an application, you accept our 
                            <a href="#" class="text-teal-600 hover:underline">Terms and conditions</a> 
                            and the 
                            <a href="#" class="text-teal-600 hover:underline">Personal Information Declaration Statement</a>.
                        </p>
                        
                        <!-- Submit Button -->
                       <button 
                            type="submit"
                            id="submit-btn"
                            disabled
                            class="w-full bg-gradient-to-r from-[#0d9488] to-[#0f766e] text-white font-bold py-4 rounded-xl
                                hover:from-[#0f766e] hover:to-[#115e59]
                                transition shadow-lg text-lg opacity-50 cursor-not-allowed"
                        >
                            Submit application
                        </button>

                        <p class="text-sm text-gray-600 mb-4 text-center mt-4">
                            Your application will be sent to <br>
                            <strong>{{ $property->headline }}</strong>
                        </p>

                    </div>
                    
                </form>
                
            </div>
            
        </div>
        
    </div>
</div>

<style>
    /* intl-tel-input custom styling */
    .iti {
        display: block;
        width: 100%;
    }

    .iti__flag-container {
        position: absolute;
        top: 0;
        bottom: 0;
        right: auto;
        left: 0;
        padding: 0;
    }

    .iti__selected-flag {
        padding: 0 12px;
        height: 100%;
        display: flex;
        align-items: center;
        border-right: 1px solid #d1d5db;
        background-color: #f9fafb;
        border-radius: 0.5rem 0 0 0.5rem;
        transition: all 0.2s;
    }

    .iti__selected-flag:hover {
        background-color: #f3f4f6;
    }

    .iti__country-list {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        max-height: 300px;
        margin-top: 4px;
    }

    .iti__country {
        padding: 10px 16px;
        transition: background-color 0.2s;
    }

    .iti__country:hover {
        background-color: #E6FF4B;
    }

    .iti__country.iti__highlight {
        background-color: #DDEECD;
    }

    .iti__country-name {
        margin-right: 8px;
        font-weight: 500;
    }

    .iti__dial-code {
        color: #6b7280;
    }

    .iti__selected-dial-code {
        font-weight: 600;
        color: #374151;
        margin-left: 4px;
    }

    .iti input[type="tel"] {
        padding-left: 70px !important;
        padding-right: 1rem !important;
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
    }

    /* Search box in dropdown */
    .iti__search-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        margin: 8px;
        width: calc(100% - 16px);
    }

    .iti__search-input:focus {
        outline: none;
        border-color: #5E17EB;
        box-shadow: 0 0 0 3px rgba(94, 23, 235, 0.1);
    }

    /* Divider */
    .iti__divider {
        border-bottom: 1px solid #e5e7eb;
        margin: 4px 0;
    }

    /* Arrow */
    .iti__arrow {
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 4px solid #6b7280;
        margin-left: 6px;
    }

    .iti__arrow--up {
        border-top: none;
        border-bottom: 4px solid #6b7280;
    }
</style>

<script>
    // Section toggle
    function toggleSection(sectionId) {
        const card = document.querySelector(`[data-section="${sectionId}"]`);
        const content = card.querySelector('.section-content');
        const chevron = card.querySelector('.section-chevron');
        
        const isHidden = content.classList.contains('hidden');
        
        if (isHidden) {
            content.classList.remove('hidden');
            chevron.style.transform = 'rotate(90deg)';
        } else {
            content.classList.add('hidden');
            chevron.style.transform = 'rotate(0deg)';
        }
        
        updateProgress();
    }

    // Update progress
    function updateProgress() {
        // Define which sections are required vs optional
        const requiredSections = [
            'about_me',
            'address_history',
            'employment',
            'finances',
            'identity_documents',
            'household',
            'terms_conditions'
        ];
        
        const optionalSections = [
            'emergency_contact',
            'pets',
            'utility_connections',
            'additional_notes'
        ];
        
        // Count only required sections
        let completedCount = 0;
        
        requiredSections.forEach(sectionId => {
            const statusIcon = document.querySelector(`#status_${sectionId}`);
            if (statusIcon && statusIcon.classList.contains('bg-teal-100')) {
                completedCount++;
            }
        });
        
        const totalRequired = requiredSections.length;
        const percentage = Math.round((completedCount / totalRequired) * 100);
        
        // Update progress display
        const progressPercentage = document.getElementById('progress-percentage');
        const progressBar = document.getElementById('progress-bar');
        
        if (progressPercentage) {
            progressPercentage.textContent = percentage + '%';
        }
        
        if (progressBar) {
            progressBar.style.width = percentage + '%';
            
            // Change color based on progress
            if (percentage === 100) {
                progressBar.className = 'bg-gradient-to-r from-teal-500 to-teal-600 h-2 rounded-full transition-all duration-500';
            } else if (percentage >= 70) {
                progressBar.className = 'bg-gradient-to-r from-teal-500 to-teal-600 h-2 rounded-full transition-all duration-500';
            } else {
                progressBar.className = 'bg-gradient-to-r from-teal-500 to-teal-600 h-2 rounded-full transition-all duration-500';
            }
        }
    }

    // Sync inspection choice
    function syncInspectionChoice(value) {
        document.getElementById('property_inspection_hidden').value = value;
        
        // Show/hide inspection date field
        const inspectionDateSidebar = document.getElementById('inspection-date-sidebar');
        if (value === 'yes') {
            inspectionDateSidebar.classList.remove('hidden');
            document.getElementById('inspection-info-sidebar').classList.add('hidden');
        } else {
            inspectionDateSidebar.classList.add('hidden');
            document.getElementById('inspection-info-sidebar').classList.remove('hidden');
            document.getElementById('sidebar_inspection_date').value = '';
            document.getElementById('inspection_date_hidden').value = '';
        }
    }

    // Sync inspection date
    function syncInspectionDate(value) {
        document.getElementById('inspection_date_hidden').value = value;
    }

    // Sync move-in date
    function syncMoveInDate(value) {
        document.getElementById('move_in_date_hidden').value = value;
        console.log('Move-in date synced:', value); // Debug log
    }

    // Set lease term
    function setLeaseTerm(months) {
        document.getElementById('lease_term_hidden').value = months;
        
        // Update button styles
        document.querySelectorAll('.lease-term-btn').forEach(btn => {
            btn.classList.remove('border-teal-500', 'bg-teal-50');
            btn.classList.add('border-gray-300');
        });
        
        event.target.classList.remove('border-gray-300');
        event.target.classList.add('border-teal-500', 'bg-teal-50');
    }

    // Update occupants summary
    function updateOccupantsSummary(additionalCount) {
        const total = parseInt(additionalCount) + 1;
        const summaries = document.querySelectorAll('#occupants-summary, #household-summary');
        summaries.forEach(summary => {
            summary.textContent = `Summary: ${total} person${total > 1 ? 's' : ''} (1 leaseholder${additionalCount > 0 ? ', ' + additionalCount + ' additional' : ''})`;
        });
    }

    // Form submission handling
    document.addEventListener('DOMContentLoaded', function() {
        updateProgress();
        
        const form = document.getElementById('application-form');
        const submitBtn = document.getElementById('submit-btn');
        
        // Disable HTML5 validation to handle it ourselves
        form.setAttribute('novalidate', 'novalidate');
        
        form.addEventListener('submit', async function (e) {
            e.preventDefault(); // Prevent default first, we'll submit manually if valid

            // ENSURE move-in date is synced FIRST
            const sidebarMoveIn = document.getElementById('sidebar_move_in_date');
            const hiddenMoveIn = document.getElementById('move_in_date_hidden');
            if (sidebarMoveIn && sidebarMoveIn.value && hiddenMoveIn) {
                hiddenMoveIn.value = sidebarMoveIn.value;
            }

            // Copy sidebar values to hidden fields
            const rentInput = document.getElementById('rent_per_week_input');
            const rentHidden = document.getElementById('rent_per_week_hidden');
            
            if (rentInput && rentHidden) {
                rentHidden.value = rentInput.value;
            }
            
            // Validate rent
            if (!rentInput || !rentInput.value || parseFloat(rentInput.value) <= 0) {
                alert('Please enter a valid rent amount.');
                rentInput.focus();
                return false;
            }
            
            // Clear any existing error messages
            document.querySelectorAll('.field-error-message').forEach(el => el.remove());
            document.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
            });
            
            // Object to store first error found
            let firstError = null;
            
            // Helper function to show error on field
            function showFieldError(field, message, sectionName = null) {
                if (!firstError) {
                    firstError = { field, message, sectionName };
                }
                
                // Add red border to field
                field.classList.add('border-red-500');
                
                // Create error message element
                const errorEl = document.createElement('p');
                errorEl.className = 'field-error-message mt-1 text-sm text-red-600 font-medium';
                errorEl.textContent = message;
                
                // Insert error message after the field
                if (field.parentElement) {
                    field.parentElement.appendChild(errorEl);
                }
            }
            
            // 1. Validate Terms & Conditions (check this first as it's at the bottom)
            const acceptTerms = document.getElementById('accept_terms');
            const declareAccuracy = document.getElementById('declare_accuracy');
            const consentPrivacy = document.getElementById('consent_privacy');
            
            if (!acceptTerms?.checked) {
                showFieldError(acceptTerms, 'You must accept the Terms and Conditions to submit.', 'terms_conditions');
            }
            if (!declareAccuracy?.checked) {
                showFieldError(declareAccuracy, 'You must declare that all information is accurate.', 'terms_conditions');
            }
            if (!consentPrivacy?.checked) {
                showFieldError(consentPrivacy, 'You must consent to privacy collection.', 'terms_conditions');
            }
            
            // 2. Validate About Me section
            const title = document.querySelector('select[name="title"]');
            if (!title?.value) {
                showFieldError(title, 'Please select your title.', 'about_me');
            }
            
            const firstName = document.querySelector('input[name="first_name"]');
            if (!firstName?.value || firstName.value.trim() === '') {
                showFieldError(firstName, 'First name is required.', 'about_me');
            }
            
            const lastName = document.querySelector('input[name="last_name"]');
            if (!lastName?.value || lastName.value.trim() === '') {
                showFieldError(lastName, 'Last name is required.', 'about_me');
            }
            
            const dob = document.querySelector('input[name="date_of_birth"]');
            if (!dob?.value) {
                showFieldError(dob, 'Date of birth is required.', 'about_me');
            }
            
            const email = document.querySelector('input[name="email"]');
            if (!email?.value || email.value.trim() === '') {
                showFieldError(email, 'Email is required.', 'about_me');
            }
            
            const mobileNumber = document.querySelector('input[name="mobile_number"]');
            if (!mobileNumber?.value || mobileNumber.value.trim() === '') {
                showFieldError(mobileNumber, 'Mobile number is required.', 'about_me');
            }
            
            // 3. Validate Address History
            const address0 = document.querySelector('input[name="addresses[0][address]"]');
            if (!address0?.value || address0.value.trim() === '') {
                showFieldError(address0, 'At least one address is required.', 'address_history');
            }
            
            const living0 = document.querySelector('select[name="addresses[0][living_arrangement]"]');
            if (!living0?.value) {
                showFieldError(living0, 'Living arrangement is required.', 'address_history');
            }
            
            // 4. Validate Employment IF checkbox is checked
            const hasEmployment = document.getElementById('has_employment_checkbox');
            if (hasEmployment?.checked) {
                const company0 = document.querySelector('input[name="employments[0][company_name]"]');
                if (!company0?.value || company0.value.trim() === '') {
                    showFieldError(company0, 'Company name is required.', 'employment');
                }
                
                const position0 = document.querySelector('input[name="employments[0][position]"]');
                if (!position0?.value || position0.value.trim() === '') {
                    showFieldError(position0, 'Position is required.', 'employment');
                }
                
                // const salary0 = document.querySelector('input[name="employments[0][gross_annual_salary]"]');
                // if (!salary0?.value) {
                //     showFieldError(salary0, 'Gross annual salary is required.', 'employment');
                // }
            }
            
            // 5. Validate Income/Finances (always required)
            const incomeSource0 = document.querySelector('select[name="incomes[0][source_of_income]"]');
            if (!incomeSource0?.value) {
                showFieldError(incomeSource0, 'Source of income is required.', 'finances');
            }
            
            const incomeAmount0 = document.querySelector('input[name="incomes[0][net_weekly_amount]"]');
            if (!incomeAmount0?.value) {
                showFieldError(incomeAmount0, 'Net weekly amount is required.', 'finances');
            }
            
            // 6. Validate Identity Documents (always required)
            const idType0 = document.querySelector('select[name="identifications[0][identification_type]"]');
            if (!idType0?.value) {
                showFieldError(idType0, 'Document type is required.', 'identity_documents');
            }
            
            // 7. Validate Household (always required)
            const numOccupants = document.querySelector('input[name="number_of_occupants"]');
            if (!numOccupants?.value || numOccupants.value < 1) {
                showFieldError(numOccupants, 'Number of occupants is required (minimum 1).', 'household');
            }
            
            const primaryFirstName = document.querySelector('input[name="occupants_details[0][first_name]"]');
            if (!primaryFirstName?.value || primaryFirstName.value.trim() === '') {
                showFieldError(primaryFirstName, 'Primary applicant first name is required.', 'household');
            }
            
            const primaryLastName = document.querySelector('input[name="occupants_details[0][last_name]"]');
            if (!primaryLastName?.value || primaryLastName.value.trim() === '') {
                showFieldError(primaryLastName, 'Primary applicant last name is required.', 'household');
            }
            
            const primaryAge = document.querySelector('input[name="occupants_details[0][age]"]');
            if (!primaryAge?.value) {
                showFieldError(primaryAge, 'Primary applicant age is required.', 'household');
            } else if (parseInt(primaryAge.value) < 18) {
                showFieldError(primaryAge, 'Primary applicant must be 18 years or older.', 'household');
            }
            
            // 8. Validate Pets IF checkbox is checked
            const hasPets = document.getElementById('has-pets');
            if (hasPets?.checked) {
                const petType0 = document.querySelector('select[name="pets[0][type]"]');
                if (!petType0?.value) {
                    showFieldError(petType0, 'Pet type is required.', 'pets');
                }
                
                const petBreed0 = document.querySelector('input[name="pets[0][breed]"]');
                if (!petBreed0?.value || petBreed0.value.trim() === '') {
                    showFieldError(petBreed0, 'Pet breed is required.', 'pets');
                }
                
                const petDesexed0 = document.querySelector('select[name="pets[0][desexed]"]');
                if (!petDesexed0?.value && petDesexed0?.value !== '0') {
                    showFieldError(petDesexed0, 'Please specify if pet is desexed.', 'pets');
                }
                
                const petSize0 = document.querySelector('select[name="pets[0][size]"]');
                if (!petSize0?.value) {
                    showFieldError(petSize0, 'Pet size is required.', 'pets');
                }
            }
            
            // 9. Validate move-in date from sidebar
            const moveInDate = document.getElementById('move_in_date_hidden');
            if (!moveInDate?.value) {
                // Show error in sidebar
                const moveInDateDisplay = document.getElementById('sidebar_move_in_date');
                if (moveInDateDisplay) {
                    moveInDateDisplay.classList.add('border-2', 'border-red-500');
                    
                    const errorEl = document.createElement('p');
                    errorEl.className = 'field-error-message mt-2 text-sm text-red-600 font-medium';
                    errorEl.textContent = 'Please select a move-in date.';
                    moveInDateDisplay.parentElement.appendChild(errorEl);
                    
                    if (!firstError) {
                        firstError = { 
                            field: moveInDateDisplay, 
                            message: 'Please select a move-in date.', 
                            sectionName: null,
                            isSidebar: true
                        };
                    }
                }
            }

            // 10. Validate rent per week from sidebar
            const rentPerWeek = document.getElementById('rent_per_week_hidden');
            const rentPerWeekInput = document.getElementById('rent_per_week_input');
            if (!rentPerWeek?.value || parseFloat(rentPerWeek.value) <= 0) {
                // Show error in sidebar
                if (rentPerWeekInput) {
                    rentPerWeekInput.classList.add('border-2', 'border-red-500');
                    
                    const errorEl = document.createElement('p');
                    errorEl.className = 'field-error-message mt-2 text-sm text-red-600 font-medium';
                    errorEl.textContent = 'Please enter a valid rent amount.';
                    rentPerWeekInput.parentElement.appendChild(errorEl);
                    
                    if (!firstError) {
                        firstError = { 
                            field: rentPerWeekInput, 
                            message: 'Please enter a valid rent amount.', 
                            sectionName: null,
                            isSidebar: true
                        };
                    }
                }
            }
            
            // If there are errors, focus on first error
            if (firstError) {
                // If error is in a collapsible section, open it
                if (firstError.sectionName) {
                    const sectionContent = document.querySelector(`[data-section="${firstError.sectionName}"] .section-content`);
                    if (sectionContent && sectionContent.classList.contains('hidden')) {
                        toggleSection(firstError.sectionName);
                    }
                }
                
                // Scroll to and focus the field
                setTimeout(() => {
                    if (firstError.isSidebar) {
                        // For sidebar elements, just scroll to them
                        firstError.field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        // For form fields, scroll and focus
                        firstError.field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.field.focus();
                    }
                    
                    // Show toast notification with error count
                    const errorCount = document.querySelectorAll('.field-error-message').length;
                    showToast(`Please fix ${errorCount} error${errorCount > 1 ? 's' : ''} to submit your application.`, 'error');
                }, 300);
                
                return false;
            }
            
            // ============================================
            // All validation passed - PREPARE FOR SUBMIT
            // ============================================
            
            // DON'T remove fields - just disable them if unchecked
            // This preserves file inputs
            
            if (!hasPets?.checked) {
                // Disable pet fields instead of removing them
                document.querySelectorAll('[name^="pets["]').forEach(field => {
                    field.disabled = true;
                });
            }

            if (!hasEmployment?.checked) {
                // Disable employment fields instead of removing them
                document.querySelectorAll('[name^="employments["]').forEach(field => {
                    field.disabled = true;
                });
            }

            const hasEmergencyContact = document.getElementById('has_emergency_contact');
            if (!hasEmergencyContact?.checked) {
                // Disable emergency contact fields instead of removing them
                document.querySelectorAll('[name^="emergency_contact_"]').forEach(field => {
                    if (field.name !== 'has_emergency_contact') {
                        field.disabled = true;
                    }
                });
            }

            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Submitting...</span>';

            // Use HTMLFormElement.submit() method which preserves all data including files
            // DO NOT use form.submit() - use requestSubmit() instead to trigger native form submission
            // form.requestSubmit();
            // form.submit();

            try {
                const response = await fetch('{{ route("user.applications.store") }}', {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const result = await response.json();

                if (!response.ok) {
                    // Handle validation errors
                    if (response.status === 422 && result.errors) {
                        let errorMessage = 'Please fix the following errors:\n\n';
                        Object.keys(result.errors).forEach(key => {
                            errorMessage += `• ${result.errors[key][0]}\n`;
                        });
                        alert(errorMessage);
                    } else {
                        // Handle other errors
                        alert(result.message || 'Failed to submit application');
                    }
                    throw new Error(result.message || 'Failed to submit');
                }

                // ✅ Success - redirect to application show page
                // alert(result.message);
                window.location.href = result.redirect_url;

            } catch (error) {
                console.error('Submission error:', error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Submit application';
            }
        });
    });

    // Toast notification helper
    function showToast(message, type = 'error') {
        // Remove existing toasts
        document.querySelectorAll('.validation-toast').forEach(el => el.remove());
        
        const toast = document.createElement('div');
        toast.className = 'validation-toast fixed top-20 right-4 z-50 max-w-md px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-0';
        
        if (type === 'error') {
            toast.classList.add('bg-red-50', 'border-2', 'border-red-500', 'text-red-800');
            toast.innerHTML = `
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="font-semibold mb-1">Validation Error</p>
                        <p class="text-sm">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `;
        }
        
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(120%)';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    // Initialize address index
    var addressIndex = {{ count($addresses ?? []) }};

    // Toggle postal address field
    function togglePostalAddress(index) {
        const checkbox = document.querySelector(`input[name="addresses[${index}][different_postal_address]"]`);
        const postalField = document.querySelector(`.postal-address-field[data-index="${index}"]`);
        
        if (!checkbox || !postalField) {
            return;
        }
        
        const postalInput = postalField.querySelector('input');
        
        if (checkbox.checked) {
            postalField.classList.remove('hidden');
            if (postalInput) postalInput.required = true;
        } else {
            postalField.classList.add('hidden');
            if (postalInput) {
                postalInput.required = false;
                postalInput.value = '';
            }
        }
    }

    // Add new address
    function addAddressItem() {
        const container = document.getElementById('addresses-container');
        
        if (!container) {
            console.error('Container not found!');
            return;
        }
        
        const newAddressHtml = `
            <div class="address-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-mint/50 transition-colors bg-white" data-index="${addressIndex}">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-plyform-dark">Address ${addressIndex + 1}</h4>
                    <button type="button" onclick="removeAddressItem(${addressIndex})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">
                        Remove
                    </button>
                </div>
                
                <div class="mb-4">
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Living Arrangement <span class="text-plyform-orange">*</span></label>
                    <select name="addresses[${addressIndex}][living_arrangement]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                        <option value="">Select arrangement</option>
                        <option value="owner">Owner</option>
                        <option value="renting_agent">Renting through Agent</option>
                        <option value="renting_privately">Renting Privately</option>
                        <option value="with_parents">Living with Parents</option>
                        <option value="sharing">Sharing</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Full Address <span class="text-plyform-orange">*</span></label>
                    <input type="text" name="addresses[${addressIndex}][address]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="123 Main Street, Sydney NSW 2000">
                </div>
                
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Years Lived <span class="text-plyform-orange">*</span></label>
                        <select name="addresses[${addressIndex}][years_lived]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                            ${Array.from({length: 21}, (_, i) => `<option value="${i}">${i} ${i === 1 ? 'year' : 'years'}</option>`).join('')}
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Months Lived <span class="text-plyform-orange">*</span></label>
                        <select name="addresses[${addressIndex}][months_lived]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                            ${Array.from({length: 12}, (_, i) => `<option value="${i}">${i} ${i === 1 ? 'month' : 'months'}</option>`).join('')}
                        </select>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Reason for Leaving</label>
                    <textarea name="addresses[${addressIndex}][reason_for_leaving]" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all resize-none" placeholder="e.g., End of lease, relocated for work, purchased property..."></textarea>
                </div>
                
                <div class="mb-4">
                    <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-plyform-mint/10 transition-colors">
                        <input type="checkbox" name="addresses[${addressIndex}][different_postal_address]" value="1" onchange="togglePostalAddress(${addressIndex})" class="w-5 h-5 text-plyform-green rounded focus:ring-plyform-green/20">
                        <span class="text-sm text-gray-700 font-medium">My postal address is different from this address</span>
                    </label>
                </div>
                
                <div class="postal-address-field hidden" data-index="${addressIndex}">
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Postal Address <span class="text-plyform-orange">*</span></label>
                    <input type="text" name="addresses[${addressIndex}][postal_code]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="PO Box 123, Sydney NSW 2000">
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', newAddressHtml);
        addressIndex++;
    }

    // Remove address
    function removeAddressItem(index) {
        const item = document.querySelector(`.address-item[data-index="${index}"]`);
        if (item) {
            item.remove();
            // Renumber remaining addresses
            document.querySelectorAll('.address-item').forEach((el, idx) => {
                const heading = el.querySelector('h4');
                if (idx === 0) {
                    heading.innerHTML = 'Address 1 <span class="px-2 py-1 bg-plyform-mint text-plyform-dark text-xs font-semibold rounded ml-2">Current</span>';
                } else {
                    heading.textContent = `Address ${idx + 1}`;
                }
            });
        }
    }

    // Initialize postal address fields on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[name^="addresses"][name$="[different_postal_address]"]').forEach((checkbox) => {
            const match = checkbox.name.match(/addresses\[(\d+)\]/);
            if (match && checkbox.checked) {
                const index = parseInt(match[1]);
                togglePostalAddress(index);
            }
        });
    });

    // Employment functions
    let employmentIndex = {{ count($employments ?? []) }};

    function toggleEmploymentSection() {
        const checkbox = document.getElementById('has_employment_checkbox');
        const section = document.getElementById('employment-section');
        
        if (checkbox && section) {
            if (checkbox.checked) {
                section.classList.remove('hidden');
            } else {
                section.classList.add('hidden');
            }
        }
    }

    function toggleEndDate(index) {
        const checkbox = document.querySelector(`input[name="employments[${index}][still_employed]"]`);
        const endDateField = document.querySelector(`.end-date-field[data-index="${index}"] input`);
        const endDateContainer = document.querySelector(`.end-date-field[data-index="${index}"]`);
        const requiredStar = document.querySelector(`.end-date-field[data-index="${index}"] .required-if`);
        
        if (checkbox && checkbox.checked) {
            // Still employed - disable and hide end date
            endDateField.required = false;
            endDateField.disabled = true;
            endDateField.value = '';
            endDateContainer.classList.add('opacity-50', 'pointer-events-none');
            if (requiredStar) requiredStar.classList.add('hidden');
        } else {
            // Not employed anymore - enable end date
            endDateField.required = true;
            endDateField.disabled = false;
            endDateContainer.classList.remove('opacity-50', 'pointer-events-none');
            if (requiredStar) requiredStar.classList.remove('hidden');
            
            // Reinitialize flatpickr for this field
            if (typeof flatpickr !== 'undefined') {
                // Destroy existing flatpickr instance if any
                if (endDateField._flatpickr) {
                    endDateField._flatpickr.destroy();
                }
                
                // Create new flatpickr instance
                flatpickr(endDateField, {
                    dateFormat: "Y-m-d",
                    // maxDate: "today",
                    allowInput: true,
                    disableMobile: false,
                    monthSelectorType: "dropdown",
                    onChange: function(selectedDates, dateStr, instance) {
                        endDateField.value = dateStr;
                    }
                });
            }
        }
    }

    function addEmployment() {
        const container = document.getElementById('employment-container');
        const today = new Date().toISOString().split('T')[0];
        
        const newEmployment = `
            <div class="employment-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-purple/30 transition-colors bg-white" data-index="${employmentIndex}">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-plyform-dark">Employment ${employmentIndex + 1}</h4>
                    <button type="button" onclick="removeEmployment(${employmentIndex})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">Remove</button>
                </div>
                
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Company Name <span class="text-plyform-orange">*</span></label>
                        <input type="text" name="employments[${employmentIndex}][company_name]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="ABC Company Pty Ltd">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Position <span class="text-plyform-orange">*</span></label>
                        <input type="text" name="employments[${employmentIndex}][position]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="Senior Developer">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Company Address <span class="text-plyform-orange">*</span></label>
                    <input type="text" name="employments[${employmentIndex}][address]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="123 Business St, Sydney NSW 2000">
                </div>
                
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div class="hidden">
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Gross Annual Salary <span class="text-plyform-orange">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-500">$</span>
                            <input type="number" name="employments[${employmentIndex}][gross_annual_salary]" required class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="75000">
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Manager Name <span class="text-plyform-orange">*</span></label>
                        <input type="text" name="employments[${employmentIndex}][manager_full_name]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="John Smith">
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Contact Number <span class="text-plyform-orange">*</span></label>
                        <input 
                            type="tel" 
                            id="employment_contact_${employmentIndex}" 
                            name="employments[${employmentIndex}][contact_number_display]"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                            placeholder="Enter phone number"
                        >
                        <input type="hidden" id="employment_country_code_${employmentIndex}" name="employments[${employmentIndex}][contact_country_code]" value="+61">
                        <input type="hidden" id="employment_contact_clean_${employmentIndex}" name="employments[${employmentIndex}][contact_number]">
                        <p class="mt-1 text-xs text-gray-500">Select country and enter contact number</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Email <span class="text-plyform-orange">*</span></label>
                        <input type="email" name="employments[${employmentIndex}][email]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="manager@company.com">
                    </div>
                </div>
                
                <div class="grid md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Start Date <span class="text-plyform-orange">*</span></label>
                        <input type="date" name="employments[${employmentIndex}][start_date]" required max="${today}" class="employment-start-date w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Still Employed?</label>
                        <label class="flex items-center gap-3 cursor-pointer mt-3 p-2 rounded-lg hover:bg-plyform-mint/10 transition-colors">
                            <input type="checkbox" name="employments[${employmentIndex}][still_employed]" value="1" onchange="toggleEndDate(${employmentIndex})" class="w-5 h-5 text-plyform-green rounded focus:ring-plyform-green/20">
                            <span class="text-sm">Yes, currently employed</span>
                        </label>
                    </div>
                    <div class="end-date-field" data-index="${employmentIndex}">
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">End Date <span class="text-plyform-orange required-if">*</span></label>
                        <input type="date" name="employments[${employmentIndex}][end_date]" required max="${today}" class="employment-end-date w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Employment Letter (Optional)</label>
                    <input type="file" name="employments[${employmentIndex}][employment_letter]" id="employment_letter_${employmentIndex}" accept=".pdf,.jpg,.jpeg,.png" onchange="previewEmploymentLetter(${employmentIndex})" class="hidden">
                    <div id="employment_letter_preview_${employmentIndex}">
                        <button type="button" onclick="document.getElementById('employment_letter_${employmentIndex}').click()" class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-green transition-colors text-center cursor-pointer">
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <span class="text-sm text-gray-600">Click to upload employment letter</span>
                            <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB)</span>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Recommended for verification (PDF, JPG, PNG - Max 10MB)</p>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', newEmployment);
    
        // Initialize date pickers and phone for new employment
        const newElement = container.lastElementChild;
        initializeDatePickers(newElement);
        
        // Initialize phone input for the new employment
        setTimeout(() => {
            initializeEmploymentPhones();
        }, 100);
        
        employmentIndex++;
    }

    function removeEmployment(index) {
        const item = document.querySelector(`.employment-item[data-index="${index}"]`);
        if (item) {
            item.remove();
            // Renumber remaining items
            document.querySelectorAll('.employment-item').forEach((el, idx) => {
                el.querySelector('h4').textContent = `Employment ${idx + 1}`;
            });
        }
    }

    // Initialize flatpickr for date fields
    function initializeDatePickers(container = document) {
        if (typeof flatpickr === 'undefined') return;
        
        // Initialize start date fields
        container.querySelectorAll('.employment-start-date, input[name^="employments"][name$="[start_date]"]').forEach(field => {
            if (field._flatpickr) {
                field._flatpickr.destroy();
            }
            
            flatpickr(field, {
                dateFormat: "Y-m-d",
                maxDate: "today",
                allowInput: true,
                disableMobile: false,
                monthSelectorType: "dropdown",
                onChange: function(selectedDates, dateStr, instance) {
                    field.value = dateStr;
                }
            });
        });
        
        // Initialize end date fields (only if not disabled)
        container.querySelectorAll('.employment-end-date, input[name^="employments"][name$="[end_date]"]').forEach(field => {
            if (!field.disabled) {
                if (field._flatpickr) {
                    field._flatpickr.destroy();
                }
                
                flatpickr(field, {
                    dateFormat: "Y-m-d",
                    maxDate: "today",
                    allowInput: true,
                    disableMobile: false,
                    monthSelectorType: "dropdown",
                    onChange: function(selectedDates, dateStr, instance) {
                        field.value = dateStr;
                    }
                });
            }
        });
    }

    // Initialize on page load for employment
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all date pickers on page load
        initializeDatePickers();
        
        // Check "still employed" checkboxes and disable end dates accordingly
        document.querySelectorAll('input[name^="employments"][name$="[still_employed]"]').forEach((checkbox) => {
            const match = checkbox.name.match(/employments\[(\d+)\]\[still_employed\]/);
            if (match) {
                const index = match[1];
                if (checkbox.checked) {
                    toggleEndDate(index);
                }
            }
        });
    });

    // Income/Finances functions
    let incomeIndex = {{ count($incomes ?? []) }};

    function addIncome() {
        const container = document.getElementById('income-container');
        const newIncome = `
            <div class="income-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-mint/50 transition-colors bg-white" data-index="${incomeIndex}">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-plyform-dark">Income Source ${incomeIndex + 1}</h4>
                    <button 
                        type="button" 
                        onclick="removeIncome(${incomeIndex})"
                        class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors"
                    >
                        Remove
                    </button>
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">
                            Source of Income <span class="text-plyform-orange">*</span>
                        </label>
                        <select name="incomes[${incomeIndex}][source_of_income]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                            <option value="">Select source</option>
                            <option value="full_time_employment">Full-time Employment</option>
                            <option value="part_time_employment">Part-time Employment</option>
                            <option value="casual_employment">Casual Employment</option>
                            <option value="self_employed">Self-Employed</option>
                            <option value="centrelink">Centrelink</option>
                            <option value="pension">Pension</option>
                            <option value="investment">Investment Income</option>
                            <option value="savings">Savings</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">
                            Net Weekly Amount <span class="text-plyform-orange">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-500 font-semibold">$</span>
                            <input type="number" name="incomes[${incomeIndex}][net_weekly_amount]" step="0.01" min="0" required class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="0.00" onchange="calculateTotal()">
                        </div>
                    </div>
                </div>
                
                <!-- Bank Statement Upload -->
                <div class="mt-4">
                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                        Proof you can pay rent
                        <span class="text-xs text-gray-500 font-normal">- Upload multiple documents</span>
                    </label>
                    <span class="text-xs text-gray-500 font-normal">Attach three recent payslips or other supporting documents. If using bank statements, hide account numbers and any non-income transactions.</span>
                    <div class="space-y-3">
                        <!-- File Input (Hidden, Multiple) -->
                        <input 
                            type="file" 
                            name="incomes[${incomeIndex}][bank_statements][]"
                            id="income_statement_${incomeIndex}"
                            accept=".pdf,.jpg,.jpeg,.png"
                            onchange="previewIncomeStatements(${incomeIndex})"
                            multiple
                            class="hidden"
                        >
                        
                        <!-- Preview Container -->
                        <div id="income_statement_preview_${incomeIndex}" class="space-y-2"></div>
                        
                        <!-- Upload Button -->
                        <button 
                            type="button" 
                            onclick="document.getElementById('income_statement_${incomeIndex}').click()"
                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-green transition-colors text-center cursor-pointer"
                        >
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <span class="text-sm text-gray-600">Click to upload bank statements</span>
                            <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB per file)</span>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Max size: 10MB per file. Formats: PDF, JPG, PNG. You can upload multiple files.</p>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', newIncome);
        incomeIndex++;
        calculateTotal();
    }

    function removeIncome(index) {
        const item = document.querySelector(`.income-item[data-index="${index}"]`);
        if (item) {
            item.remove();
            calculateTotal();
            // Renumber remaining items
            document.querySelectorAll('.income-item').forEach((el, idx) => {
                el.querySelector('h4').textContent = `Income Source ${idx + 1}`;
            });
        }
    }

    function calculateTotal() {
        const inputs = document.querySelectorAll('input[name^="incomes"][name$="[net_weekly_amount]"]');
        let total = 0;
        inputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        const totalElement = document.getElementById('total-income');
        if (totalElement) {
            totalElement.textContent = '$' + total.toFixed(2);
        }
    }

    // Calculate total income on page load and when sections are opened
    document.addEventListener('DOMContentLoaded', function() {
        // Calculate total when page loads
        setTimeout(() => {
            calculateTotal();
        }, 100);
    });

    // Identity Documents functions
    var idIndex = {{ count($identifications ?? []) }};

    // Add new identification
    function addIdentificationItem() {
        const container = document.getElementById('identification-container');
        
        if (!container) return;
        
        const today = new Date().toISOString().split('T')[0];
        
        const newIdHtml = `
            <div class="identification-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-green/50 transition-colors bg-white" data-index="${idIndex}">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-plyform-dark">Document ${idIndex + 1}</h4>
                    <button type="button" onclick="removeIdentificationItem(${idIndex})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">Remove</button>
                </div>
                
                <div class="mb-4">
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Document Type <span class="text-plyform-orange">*</span></label>
                    <select name="identifications[${idIndex}][identification_type]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                        <option value="">Select document type</option>
                        <option value="australian_drivers_licence">Australian Driver's Licence</option>
                        <option value="passport">Passport</option>
                        <option value="birth_certificate">Birth Certificate</option>
                        <option value="medicare">Medicare Card</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Document Number (Optional)</label>
                    <input type="text" name="identifications[${idIndex}][document_number]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="e.g., ABC123456">
                </div>
                
                <div class="mb-4">
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Upload Document <span class="text-plyform-orange">*</span></label>
                    <input type="file" name="identifications[${idIndex}][document]" id="identification_document_${idIndex}" accept=".pdf,.jpg,.jpeg,.png" required onchange="previewIdentificationDocument(${idIndex})" class="hidden">
                    <div id="identification_document_preview_${idIndex}">
                        <button type="button" onclick="document.getElementById('identification_document_${idIndex}').click()" class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-green transition-colors text-center cursor-pointer">
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <span class="text-sm text-gray-600">Click to upload identification document</span>
                            <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB)</span>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Max size: 10MB. Accepted: PDF, JPG, PNG</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Expiry Date (if applicable)</label>
                    <input type="date" name="identifications[${idIndex}][expiry_date]" min="${today}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', newIdHtml);
        idIndex++;
    }

    // Remove identification
    function removeIdentificationItem(index) {
        const item = document.querySelector(`.identification-item[data-index="${index}"]`);
        
        if (item) {
            item.remove();
            // Renumber remaining documents
            document.querySelectorAll('.identification-item').forEach((el, idx) => {
                el.querySelector('h4').textContent = `Document ${idx + 1}`;
            });
        }
    }

    // Emergency Contact toggle function
    function toggleEmergencyContact() {
        const checkbox = document.getElementById('has_emergency_contact');
        const fields = document.getElementById('emergency-contact-fields');
        
        if (checkbox && fields) {
            if (checkbox.checked) {
                fields.style.display = 'block';
            } else {
                fields.style.display = 'none';
            }
        }
    }

    // Pets functions
    var petIndex = {{ count($pets ?? []) }};

    // Toggle pets section visibility
    function togglePetsSection() {
        const checkbox = document.getElementById('has-pets');
        const section = document.getElementById('pets-section');
        
        if (checkbox && section) {
            if (checkbox.checked) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        }
    }

    // Add new pet
    function addAnotherPet() {
        const container = document.getElementById('pets-container');
        
        if (!container) {
            console.error('Container not found!');
            return;
        }
        
        const newPetHtml = `
            <div class="pet-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-orange/30 transition-colors bg-white" data-index="${petIndex}">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-plyform-dark">Pet ${petIndex + 1}</h4>
                    <button type="button" onclick="removePetItem(${petIndex})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">Remove</button>
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Pet Type <span class="text-plyform-orange">*</span></label>
                        <select name="pets[${petIndex}][type]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                            <option value="">Select type</option>
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                            <option value="bird">Bird</option>
                            <option value="fish">Fish</option>
                            <option value="rabbit">Rabbit</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Breed <span class="text-plyform-orange">*</span></label>
                        <input type="text" name="pets[${petIndex}][breed]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="e.g., Golden Retriever">
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Desexed <span class="text-plyform-orange">*</span></label>
                        <select name="pets[${petIndex}][desexed]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Size <span class="text-plyform-orange">*</span></label>
                        <select name="pets[${petIndex}][size]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                            <option value="">Select size</option>
                            <option value="small">Small (under 10kg)</option>
                            <option value="medium">Medium (10-25kg)</option>
                            <option value="large">Large (over 25kg)</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-4">
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Registration Number (Optional)</label>
                    <input type="text" name="pets[${petIndex}][registration_number]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="e.g., 123456">
                    <p class="mt-1 text-xs text-gray-500">Council registration number if applicable</p>
                </div>
                
                <!-- Pet Photo Upload -->
                <div class="mt-4">
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Pet Photo <span class="text-plyform-orange">*</span></label>
                    <input type="file" name="pets[${petIndex}][photo]" id="pet_photo_${petIndex}" accept="image/jpeg,image/jpg,image/png" required onchange="previewPetPhoto(${petIndex})" class="hidden">
                    <div id="pet_photo_preview_${petIndex}">
                        <button type="button" onclick="document.getElementById('pet_photo_${petIndex}').click()" class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer">
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm text-gray-600">Click to upload pet photo</span>
                            <span class="text-xs text-gray-500 block mt-1">JPG, PNG (Max 5MB)</span>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Upload a clear photo of your pet (JPG, PNG - Max 5MB)</p>
                </div>
                
                <!-- Pet Registration Document -->
                <div class="mt-4">
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Pet Registration Document (Optional)</label>
                    <input type="file" name="pets[${petIndex}][document]" id="pet_document_${petIndex}" accept=".pdf,.jpg,.jpeg,.png" onchange="previewPetDocument(${petIndex})" class="hidden">
                    <div id="pet_document_preview_${petIndex}">
                        <button type="button" onclick="document.getElementById('pet_document_${petIndex}').click()" class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer">
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <span class="text-sm text-gray-600">Click to upload registration certificate</span>
                            <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB)</span>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Upload registration certificate if available (PDF, JPG, PNG - Max 10MB)</p>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', newPetHtml);
        petIndex++;
    }

    // Remove pet
    function removePetItem(index) {
        const item = document.querySelector(`.pet-item[data-index="${index}"]`);
        if (item) {
            item.remove();
            // Renumber remaining pets
            document.querySelectorAll('.pet-item').forEach((el, idx) => {
                el.querySelector('h4').textContent = `Pet ${idx + 1}`;
            });
        }
    }

    // Household/Occupants functions
    // Validate and update occupants input
    function validateOccupantsInput(input) {
        let value = parseInt(input.value);
        
        // Prevent negative numbers and 0
        if (value < 1 || isNaN(value)) {
            input.value = 1;
            value = 1;
        }
        
        // Prevent more than 10
        if (value > 10) {
            input.value = 10;
            value = 10;
        }
        
        // Update the occupants fields
        updateOccupantsFields(value);
    }

    // Update occupants fields function (keep existing, just update the call)
    function updateOccupantsFields(count) {
        const container = document.getElementById('occupants-container');
        const section = document.getElementById('occupants-section');
        const summary = document.getElementById('household-summary');
        
        // Convert to number and validate
        count = parseInt(count) || 1; // Default to 1 instead of 0
        
        // Ensure minimum of 1
        if (count < 1) {
            count = 1;
        }
        
        // Ensure maximum of 10
        if (count > 10) {
            count = 10;
        }
        
        // Update summary
        if (summary) {
            if (count === 1) {
                summary.textContent = '1 person (you)';
            } else {
                summary.textContent = `${count} people (including you)`;
            }
        }
        
        // Always show section (since minimum is 1)
        section.classList.remove('hidden');
        
        // Clear existing
        container.innerHTML = '';
        
        // Create fields for ALL occupants (including yourself as Occupant 1)
        for (let i = 0; i < count; i++) {
            const occupantNumber = i + 1;
            const isPrimary = i === 0;
            
            const occupantFields = `
                <div class="p-4 border-2 ${isPrimary ? 'border-plyform-mint bg-plyform-mint/10' : 'border-gray-200 bg-white'} rounded-lg mb-4">
                    <div class="flex items-center gap-2 mb-3">
                        <h4 class="font-semibold text-plyform-dark">
                            ${isPrimary ? '👤 Primary Applicant (You)' : `Occupant ${occupantNumber}`}
                        </h4>
                        ${isPrimary ? '<span class="text-xs bg-plyform-green text-plyform-dark px-2 py-1 rounded-full font-semibold">Primary</span>' : ''}
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                First Name <span class="text-plyform-orange">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="occupants_details[${i}][first_name]" 
                                value="${getOldValue('occupants_details.' + i + '.first_name', isPrimary ? '{{ auth()->user()->profile->first_name ?? "" }}' : '')}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                placeholder="${isPrimary ? 'Your first name' : 'First name'}"
                            >
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                Last Name <span class="text-plyform-orange">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="occupants_details[${i}][last_name]" 
                                value="${getOldValue('occupants_details.' + i + '.last_name', isPrimary ? '{{ auth()->user()->profile->last_name ?? "" }}' : '')}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                placeholder="${isPrimary ? 'Your last name' : 'Last name'}"
                            >
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                Relationship <span class="text-plyform-orange">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="occupants_details[${i}][relationship]" 
                                value="${isPrimary ? 'Primary Applicant' : getOldValue('occupants_details.' + i + '.relationship')}"
                                ${isPrimary ? 'readonly' : 'required'}
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all ${isPrimary ? 'bg-gray-100' : ''}"
                                placeholder="${isPrimary ? 'Primary Applicant' : 'e.g., Partner, Child, Roommate'}"
                            >
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                Age ${isPrimary ? '<span class="text-plyform-orange">*</span>' : '(Optional)'}
                            </label>
                            <input 
                                type="number" 
                                name="occupants_details[${i}][age]" 
                                value="${getOldValue('occupants_details.' + i + '.age')}"
                                min="${isPrimary ? '18' : '0'}"
                                max="120"
                                ${isPrimary ? 'required' : ''}
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                placeholder="${isPrimary ? 'Your age (must be 18+)' : 'Age'}"
                            >
                            ${isPrimary ? '<p class="text-xs text-gray-500 mt-1">Primary applicant must be 18 or older</p>' : ''}
                        </div>
                        
                        ${isPrimary ? `
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                Email <span class="text-plyform-orange">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="occupants_details[${i}][email]" 
                                value="{{ auth()->user()->email }}"
                                readonly
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100"
                            >
                            <p class="text-xs text-gray-500 mt-1">From your account</p>
                        </div>
                        ` : ''}
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', occupantFields);
        }
    }

    // Helper function to get old values (for form repopulation after validation errors)
    function getOldValue(key, defaultValue = '') {
        // This is a simple implementation - you may need to enhance it based on your needs
        return defaultValue;
    }

    // Initialize occupants fields on page load
    document.addEventListener('DOMContentLoaded', function() {
        const occupantsInput = document.querySelector('input[name="number_of_occupants"]');
        if (occupantsInput && occupantsInput.value) {
            updateOccupantsFields(occupantsInput.value);
        }
    });

    // Utility Connection functions
    function updateUtilitySummary() {
        const electricity = document.querySelector('input[name="utility_electricity"]');
        const gas = document.querySelector('input[name="utility_gas"]');
        const internet = document.querySelector('input[name="utility_internet"]');
        const summary = document.getElementById('utility-summary');
        
        if (!summary) return;
        
        const selected = [];
        if (electricity && electricity.checked) selected.push('Electricity');
        if (gas && gas.checked) selected.push('Gas');
        if (internet && internet.checked) selected.push('Internet');
        
        if (selected.length === 0) {
            summary.textContent = 'Optional free service';
        } else {
            summary.textContent = selected.join(', ') + ' selected';
        }
    }

    // Initialize utility summary on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateUtilitySummary();
    });

    // Terms and Conditions functions
    function updateTermsStatus() {
        const acceptTerms = document.getElementById('accept_terms');
        const declareAccuracy = document.getElementById('declare_accuracy');
        const consentPrivacy = document.getElementById('consent_privacy');
        const statusIcon = document.querySelector('#status_terms_conditions');
        const summary = document.getElementById('terms-summary');
        const submitBtn = document.getElementById('submit-btn');
        
        // Check if all checkboxes are checked
        const allChecked = acceptTerms?.checked && declareAccuracy?.checked && consentPrivacy?.checked;
        
        // Update status icon
        if (statusIcon) {
            if (allChecked) {
                statusIcon.innerHTML = `
                    <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                `;
                statusIcon.classList.remove('bg-gray-100');
                statusIcon.classList.add('bg-teal-100');
            } else {
                statusIcon.innerHTML = `
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                `;
                statusIcon.classList.remove('bg-teal-100');
                statusIcon.classList.add('bg-gray-100');
            }
        }
        
        // Update summary
        if (summary) {
            if (allChecked) {
                summary.textContent = 'All terms accepted';
                summary.classList.remove('text-gray-500');
                summary.classList.add('text-teal-600');
            } else {
                summary.textContent = 'Must be accepted to submit';
                summary.classList.remove('text-teal-600');
                summary.classList.add('text-gray-500');
            }
        }
        
        // Enable/disable submit button
        if (submitBtn) {
            if (allChecked) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
    }

    // Initialize terms status on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateTermsStatus();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // ========================================
        // MOBILE NUMBER - intl-tel-input
        // ========================================
        const phoneInput = document.querySelector("#mobile_number");
        if (phoneInput) {
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "au",
                preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: "polite",
                formatOnDisplay: true,
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return "e.g. " + selectedCountryPlaceholder;
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
            });

            // Set initial value if exists
            const existingCountryCode = document.getElementById('mobile_country_code').value;
            const existingNumber = document.getElementById('mobile_number_clean').value;
            
            if (existingCountryCode && existingNumber) {
                const countryCode = existingCountryCode.replace('+', '');
                // Use window.intlTelInputGlobals instead of iti instance
                const allCountries = window.intlTelInputGlobals.getCountryData();
                const countryData = allCountries.find(country => country.dialCode === countryCode);
                if (countryData) {
                    iti.setCountry(countryData.iso2);
                }
                phoneInput.value = existingNumber;
            }

            phoneInput.addEventListener('blur', function() {
                updatePhoneFields();
            });

            phoneInput.addEventListener('countrychange', function() {
                updatePhoneFields();
            });

            function updatePhoneFields() {
                const countryData = iti.getSelectedCountryData();
                document.getElementById('mobile_country_code').value = '+' + countryData.dialCode;
                const fullNumber = iti.getNumber();
                const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
                document.getElementById('mobile_number_clean').value = numberWithoutCode;
            }

            // Validate on form submit
            const form = document.getElementById('application-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    updatePhoneFields();
                    
                    // Validate phone number
                    if (phoneInput.value && !iti.isValidNumber()) {
                        e.preventDefault();
                        phoneInput.classList.add('border-red-500');
                        
                        let errorMsg = phoneInput.parentElement.querySelector('.phone-error');
                        if (!errorMsg) {
                            errorMsg = document.createElement('p');
                            errorMsg.className = 'phone-error mt-1 text-sm text-red-600';
                            phoneInput.parentElement.appendChild(errorMsg);
                        }
                        errorMsg.textContent = 'Please enter a valid phone number for the selected country.';
                        
                        phoneInput.focus();
                        return false;
                    } else {
                        phoneInput.classList.remove('border-red-500');
                        const errorMsg = phoneInput.parentElement.querySelector('.phone-error');
                        if (errorMsg) {
                            errorMsg.remove();
                        }
                    }
                });
            }
        }

        // ========================================
        // EMERGENCY CONTACT PHONE - intl-tel-input
        // ========================================
        const emergencyPhoneInput = document.querySelector("#emergency_contact_phone");
        if (emergencyPhoneInput) {
            const emergencyIti = window.intlTelInput(emergencyPhoneInput, {
                initialCountry: "au",
                preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: "polite",
                formatOnDisplay: true,
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return "e.g. " + selectedCountryPlaceholder;
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
            });

            const existingEmergencyCountryCode = document.getElementById('emergency_contact_country_code').value;
            const existingEmergencyNumber = document.getElementById('emergency_contact_number_clean').value;
            
            if (existingEmergencyCountryCode && existingEmergencyNumber) {
                const countryCode = existingEmergencyCountryCode.replace('+', '');
                // Use window.intlTelInputGlobals instead of emergencyIti instance
                const allCountries = window.intlTelInputGlobals.getCountryData();
                const countryData = allCountries.find(country => country.dialCode === countryCode);
                if (countryData) {
                    emergencyIti.setCountry(countryData.iso2);
                }
                emergencyPhoneInput.value = existingEmergencyNumber;
            }

            emergencyPhoneInput.addEventListener('blur', function() {
                updateEmergencyPhoneFields();
            });

            emergencyPhoneInput.addEventListener('countrychange', function() {
                updateEmergencyPhoneFields();
            });

            function updateEmergencyPhoneFields() {
                const countryData = emergencyIti.getSelectedCountryData();
                document.getElementById('emergency_contact_country_code').value = '+' + countryData.dialCode;
                const fullNumber = emergencyIti.getNumber();
                const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
                document.getElementById('emergency_contact_number_clean').value = numberWithoutCode;
            }

            // Validate emergency contact phone on form submission
            const form = document.getElementById('application-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const hasEmergencyContact = document.getElementById('has_emergency_contact');
                    
                    if (hasEmergencyContact && hasEmergencyContact.checked) {
                        updateEmergencyPhoneFields();
                        
                        if (emergencyPhoneInput.value && !emergencyIti.isValidNumber()) {
                            e.preventDefault();
                            emergencyPhoneInput.classList.add('border-red-500');
                            
                            let errorMsg = emergencyPhoneInput.parentElement.querySelector('.emergency-phone-error');
                            if (!errorMsg) {
                                errorMsg = document.createElement('p');
                                errorMsg.className = 'emergency-phone-error mt-1 text-sm text-red-600';
                                emergencyPhoneInput.parentElement.appendChild(errorMsg);
                            }
                            errorMsg.textContent = 'Please enter a valid emergency contact phone number.';
                            
                            emergencyPhoneInput.focus();
                            return false;
                        } else {
                            emergencyPhoneInput.classList.remove('border-red-500');
                            const errorMsg = emergencyPhoneInput.parentElement.querySelector('.emergency-phone-error');
                            if (errorMsg) {
                                errorMsg.remove();
                            }
                        }
                    }
                });
            }
        }

        // ========================================
        // GUARANTOR PHONE - intl-tel-input
        // ========================================
        const guarantorPhoneInput = document.querySelector("#guarantor_phone");
        if (guarantorPhoneInput) {
            const guarantorIti = window.intlTelInput(guarantorPhoneInput, {
                initialCountry: "au",
                preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: "polite",
                formatOnDisplay: true,
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return "e.g. " + selectedCountryPlaceholder;
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
            });

            const existingGuarantorCountryCode = document.getElementById('guarantor_country_code').value;
            const existingGuarantorNumber = document.getElementById('guarantor_number_clean').value;
            
            if (existingGuarantorCountryCode && existingGuarantorNumber) {
                const countryCode = existingGuarantorCountryCode.replace('+', '');
                const allCountries = window.intlTelInputGlobals.getCountryData();
                const countryData = allCountries.find(country => country.dialCode === countryCode);
                if (countryData) {
                    guarantorIti.setCountry(countryData.iso2);
                }
                guarantorPhoneInput.value = existingGuarantorNumber;
            }

            guarantorPhoneInput.addEventListener('blur', function() {
                updateGuarantorPhoneFields();
            });

            guarantorPhoneInput.addEventListener('countrychange', function() {
                updateGuarantorPhoneFields();
            });

            function updateGuarantorPhoneFields() {
                const countryData = guarantorIti.getSelectedCountryData();
                document.getElementById('guarantor_country_code').value = '+' + countryData.dialCode;
                const fullNumber = guarantorIti.getNumber();
                const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
                document.getElementById('guarantor_number_clean').value = numberWithoutCode;
            }

            // Validate guarantor phone on form submission
            const form = document.getElementById('application-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const hasGuarantor = document.getElementById('has_guarantor');
                    
                    if (hasGuarantor && hasGuarantor.checked) {
                        updateGuarantorPhoneFields();
                        
                        if (guarantorPhoneInput.value && !guarantorIti.isValidNumber()) {
                            e.preventDefault();
                            guarantorPhoneInput.classList.add('border-red-500');
                            
                            let errorMsg = guarantorPhoneInput.parentElement.querySelector('.guarantor-phone-error');
                            if (!errorMsg) {
                                errorMsg = document.createElement('p');
                                errorMsg.className = 'guarantor-phone-error mt-1 text-sm text-red-600';
                                guarantorPhoneInput.parentElement.appendChild(errorMsg);
                            }
                            errorMsg.textContent = 'Please enter a valid guarantor phone number.';
                            
                            guarantorPhoneInput.focus();
                            return false;
                        } else {
                            guarantorPhoneInput.classList.remove('border-red-500');
                            const errorMsg = guarantorPhoneInput.parentElement.querySelector('.guarantor-phone-error');
                            if (errorMsg) {
                                errorMsg.remove();
                            }
                        }
                    }
                });
            }
        }
    });
</script>

@endsection

@push('styles')

<style>
    /* intl-tel-input custom styling */
    .iti {
        display: block;
        width: 100%;
    }

    .iti__flag-container {
        position: absolute;
        top: 0;
        bottom: 0;
        right: auto;
        left: 0;
        padding: 0;
    }

    .iti__selected-flag {
        padding: 0 12px;
        height: 100%;
        display: flex;
        align-items: center;
        border-right: 1px solid #d1d5db;
        background-color: #f9fafb;
        border-radius: 0.5rem 0 0 0.5rem;
        transition: all 0.2s;
    }

    .iti__selected-flag:hover {
        background-color: #f3f4f6;
    }

    .iti__country-list {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        max-height: 300px;
        margin-top: 4px;
    }

    .iti__country {
        padding: 10px 16px;
        transition: background-color 0.2s;
    }

    .iti__country:hover {
        background-color: #E6FF4B;
    }

    .iti__country.iti__highlight {
        background-color: #DDEECD;
    }

    .iti__country-name {
        margin-right: 8px;
        font-weight: 500;
    }

    .iti__dial-code {
        color: #6b7280;
    }

    .iti__selected-dial-code {
        font-weight: 600;
        color: #374151;
        margin-left: 4px;
    }

    .iti input[type="tel"] {
        padding-left: 70px !important;
        padding-right: 1rem !important;
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
    }

    /* Search box in dropdown */
    .iti__search-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        margin: 8px;
        width: calc(100% - 16px);
    }

    .iti__search-input:focus {
        outline: none;
        border-color: #5E17EB;
        box-shadow: 0 0 0 3px rgba(94, 23, 235, 0.1);
    }

    /* Divider */
    .iti__divider {
        border-bottom: 1px solid #e5e7eb;
        margin: 4px 0;
    }

    /* Arrow */
    .iti__arrow {
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 4px solid #6b7280;
        margin-left: 6px;
    }

    .iti__arrow--up {
        border-top: none;
        border-bottom: 4px solid #6b7280;
    }
</style>
<style>
    /* Flatpickr Custom Styling */
    .flatpickr-calendar {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        font-family: inherit;
    }

    .flatpickr-months {
        padding: 10px;
        background: linear-gradient(135deg, #5E17EB 0%, #8B5CF6 100%);
        border-radius: 12px 12px 0 0;
    }

    .flatpickr-month {
        height: auto;
        color: white;
    }

    .flatpickr-current-month {
        font-size: 16px;
        font-weight: 600;
        color: white;
        padding: 5px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .flatpickr-current-month .flatpickr-monthDropdown-months {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 600;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 20 20'%3E%3Cpath d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 16px;
        padding-right: 32px;
    }

    .flatpickr-current-month .flatpickr-monthDropdown-months:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .flatpickr-current-month .numInputWrapper {
        width: 80px;
    }

    .flatpickr-current-month input.cur-year {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 600;
        text-align: center;
    }

    .flatpickr-current-month input.cur-year:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Navigation Arrows */
    .flatpickr-prev-month,
    .flatpickr-next-month {
        fill: white !important;
        padding: 8px;
        position: static;
        height: auto;
        width: auto;
    }

    .flatpickr-prev-month:hover,
    .flatpickr-next-month:hover {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 6px;
    }

    .flatpickr-prev-month svg,
    .flatpickr-next-month svg {
        width: 14px;
        height: 14px;
    }

    /* Weekdays */
    .flatpickr-weekdays {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }

    span.flatpickr-weekday {
        color: #6b7280;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
    }

    /* Days */
    .flatpickr-days {
        border: none;
    }

    .flatpickr-day {
        border-radius: 8px;
        color: #374151;
        font-weight: 500;
        border: none;
        margin: 2px;
    }

    .flatpickr-day.today {
        border: 2px solid #5E17EB;
        background: transparent;
        color: #5E17EB;
        font-weight: 700;
    }

    .flatpickr-day.today:hover {
        background: #5E17EB;
        color: white;
    }

    .flatpickr-day.selected {
        background: #5E17EB;
        color: white;
        border: none;
        font-weight: 700;
    }

    .flatpickr-day.selected:hover {
        background: #7C3AED;
    }

    .flatpickr-day:hover {
        background: #E6FF4B;
        color: #374151;
        border: none;
    }

    .flatpickr-day.disabled,
    .flatpickr-day.disabled:hover {
        color: #d1d5db;
        background: transparent;
        cursor: not-allowed;
    }

    .flatpickr-day.prevMonthDay,
    .flatpickr-day.nextMonthDay {
        color: #9ca3af;
    }

    /* Input styling when calendar is open */
    .flatpickr-input.active {
        border-color: #5E17EB !important;
        box-shadow: 0 0 0 3px rgba(94, 23, 235, 0.1) !important;
    }
</style>
<style>
    /* Fix intl-tel-input dropdown appearing behind other elements */
    .iti {
        display: block;
        position: relative;
        z-index: 10;
    }

    .iti__country-list {
        z-index: 999 !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        max-height: 200px;
        overflow-y: auto;
    }

    /* Ensure parent containers don't create new stacking contexts */
    .iti--separate-dial-code .iti__selected-flag {
        z-index: 1;
    }

    /* Make sure the dropdown appears above cards */
    .iti--container {
        z-index: 999 !important;
    }
    /* If the form section or card has overflow hidden, adjust it */
    

    /* Or specifically target the contact information section */
    
    .overflow-hidden {
        overflow: visible !important;
    }
</style>
@endpush

@push('scripts')
<script>
// Initialize intl-tel-input for application mobile number
document.addEventListener('DOMContentLoaded', function() {
    const appMobileInput = document.querySelector("#app_mobile_number");
    
    if (appMobileInput) {
        const appMobileIti = window.intlTelInput(appMobileInput, {
            initialCountry: "au",
            preferredCountries: ["au", "nz", "us", "gb"],
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/js/utils.js"
        });
        
        // Pre-populate if values exist
        const savedCountryCode = document.getElementById('app_mobile_country_code').value;
        const savedNumber = document.getElementById('app_mobile_number_clean').value;
        
        if (savedCountryCode && savedNumber) {
            appMobileIti.setNumber(savedCountryCode + savedNumber);
        }
        
        // Update hidden fields on change
        appMobileInput.addEventListener('blur', function() {
            const countryData = appMobileIti.getSelectedCountryData();
            const number = appMobileIti.getNumber(intlTelInputUtils.numberFormat.E164);
            const nationalNumber = appMobileIti.getNumber(intlTelInputUtils.numberFormat.NATIONAL).replace(/\s/g, '');
            
            document.getElementById('app_mobile_country_code').value = '+' + countryData.dialCode;
            document.getElementById('app_mobile_number_clean').value = nationalNumber;
        });
        
        // Also update on country change
        appMobileInput.addEventListener('countrychange', function() {
            const countryData = appMobileIti.getSelectedCountryData();
            document.getElementById('app_mobile_country_code').value = '+' + countryData.dialCode;
        });
    }
});

// ========================================
// EMPLOYMENT CONTACT PHONE - intl-tel-input
// ========================================
function initializeEmploymentPhones() {
    // Initialize all existing employment contact phones
    document.querySelectorAll('[id^="employment_contact_"]').forEach(function(phoneInput) {
        if (phoneInput._iti) return; // Skip if already initialized
        
        const match = phoneInput.id.match(/employment_contact_(\d+)/);
        if (!match) return;
        
        const index = match[1];
        
        const iti = window.intlTelInput(phoneInput, {
            initialCountry: "au",
            preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
            separateDialCode: true,
            nationalMode: false,
            autoPlaceholder: "polite",
            formatOnDisplay: true,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                return "e.g. " + selectedCountryPlaceholder;
            },
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
        });
        
        // Store the instance
        phoneInput._iti = iti;
        
        // Set initial value if exists
        const existingCountryCode = document.getElementById('employment_country_code_' + index).value;
        const existingNumber = document.getElementById('employment_contact_clean_' + index).value;
        
        if (existingCountryCode && existingNumber) {
            const countryCode = existingCountryCode.replace('+', '');
            const allCountries = window.intlTelInputGlobals.getCountryData();
            const countryData = allCountries.find(country => country.dialCode === countryCode);
            if (countryData) {
                iti.setCountry(countryData.iso2);
            }
            phoneInput.value = existingNumber;
        }
        
        phoneInput.addEventListener('blur', function() {
            updateEmploymentPhoneFields(index);
        });
        
        phoneInput.addEventListener('countrychange', function() {
            updateEmploymentPhoneFields(index);
        });
    });
}

function updateEmploymentPhoneFields(index) {
    const phoneInput = document.getElementById('employment_contact_' + index);
    if (!phoneInput || !phoneInput._iti) return;
    
    const iti = phoneInput._iti;
    const countryData = iti.getSelectedCountryData();
    document.getElementById('employment_country_code_' + index).value = '+' + countryData.dialCode;
    const fullNumber = iti.getNumber();
    const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
    document.getElementById('employment_contact_clean_' + index).value = numberWithoutCode;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeEmploymentPhones();
});

// ========================================
// EMPLOYMENT LETTER FILE PREVIEW
// ========================================
function previewEmploymentLetter(index) {
    const input = document.getElementById('employment_letter_' + index);
    const preview = document.getElementById('employment_letter_preview_' + index);
    const file = input.files[0];
    
    if (!file) return;
    
    // Validate file size (10MB)
    if (file.size > 10 * 1024 * 1024) {
        alert('File size must be less than 10MB');
        input.value = '';
        return;
    }
    
    // Validate file type
    const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
    if (!validTypes.includes(file.type)) {
        alert('Please upload a PDF, JPG, or PNG file');
        input.value = '';
        return;
    }
    
    // Create preview
    const reader = new FileReader();
    reader.onload = function(e) {
        let thumbnail = '';
        
        if (file.type.startsWith('image/')) {
            thumbnail = `<img src="${e.target.result}" alt="Letter" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">`;
        } else {
            thumbnail = `
                <div class="w-16 h-16 bg-red-100 rounded-lg border-2 border-red-300 flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
            `;
        }
        
        preview.innerHTML = `
            <div class="relative bg-gray-50 border-2 border-plyform-green rounded-lg p-3">
                <div class="flex items-center gap-3">
                    ${thumbnail}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                        <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
                    </div>
                    <button 
                        type="button" 
                        onclick="removeEmploymentLetter(${index})"
                        class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                        title="Remove document"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    };
    reader.readAsDataURL(file);
}

function removeEmploymentLetter(index) {
    const input = document.getElementById('employment_letter_' + index);
    const preview = document.getElementById('employment_letter_preview_' + index);
    
    input.value = '';
    
    preview.innerHTML = `
        <button 
            type="button" 
            onclick="document.getElementById('employment_letter_${index}').click()"
            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-green transition-colors text-center cursor-pointer"
        >
            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            <span class="text-sm text-gray-600">Click to upload employment letter</span>
            <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB)</span>
        </button>
    `;
}

// ========================================
// INCOME BANK STATEMENT FILE PREVIEW (MULTIPLE)
// ========================================
// Preview multiple income statements - FIXED VERSION
function previewIncomeStatements(incomeIndex) {
    const input = document.getElementById('income_statement_' + incomeIndex);
    const previewContainer = document.getElementById('income_statement_preview_' + incomeIndex);
    
    if (input.files && input.files.length > 0) {
        // Clear ONLY the new file previews (not the input itself)
        const newFilePreviews = previewContainer.querySelectorAll('[data-new-file]');
        newFilePreviews.forEach(preview => preview.remove());
        
        // Create previews for newly selected files
        Array.from(input.files).forEach((file, fileIndex) => {
            // Validate file size (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert(`File "${file.name}" is too large. Maximum size is 10MB.`);
                return;
            }
            
            // Validate file type
            const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                alert(`File "${file.name}" has invalid format. Please upload PDF, JPG, or PNG.`);
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'relative bg-gray-50 border-2 border-plyform-green rounded-lg p-3';
                previewDiv.setAttribute('data-new-file', fileIndex);
                
                const isPDF = file.type === 'application/pdf';
                const isImage = file.type.startsWith('image/');
                
                let thumbnail = '';
                if (isImage) {
                    thumbnail = `<img src="${e.target.result}" alt="Preview" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">`;
                } else {
                    thumbnail = `
                        <div class="w-16 h-16 bg-red-100 rounded-lg border-2 border-red-300 flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    `;
                }
                
                previewDiv.innerHTML = `
                    <div class="flex items-center gap-3">
                        ${thumbnail}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                            <p class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB - New upload</p>
                        </div>
                        <button 
                            type="button" 
                            onclick="removeNewIncomeStatementPreview(${incomeIndex}, ${fileIndex})"
                            class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                            title="Remove from preview"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                `;
                
                previewContainer.appendChild(previewDiv);
            };
            
            reader.readAsDataURL(file);
        });
    }
}

// Remove new income statement PREVIEW ONLY (don't clear the input)
function removeNewIncomeStatementPreview(incomeIndex, fileIndex) {
    const previewDiv = document.querySelector(`#income_statement_preview_${incomeIndex} [data-new-file="${fileIndex}"]`);
    if (previewDiv) {
        previewDiv.remove();
    }
    // NOTE: We're NOT clearing the file input here because you can't selectively remove files
    // If user wants to change files, they need to re-select all files
}

// Remove existing income statement
function removeExistingIncomeStatement(incomeIndex, statementIndex) {
    if (confirm('Are you sure you want to remove this document?')) {
        // Hide the preview div
        const previewDiv = document.querySelector(`#income_statement_preview_${incomeIndex} [data-existing-file="${statementIndex}"]`);
        if (previewDiv) {
            previewDiv.style.display = 'none';
        }
        
        // Remove the hidden input that tracks this file
        const hiddenInput = document.getElementById(`existing_statement_${incomeIndex}_${statementIndex}`);
        if (hiddenInput) {
            hiddenInput.remove();
        }
    }
}

// ========================================
// IDENTIFICATION DOCUMENT FILE PREVIEW
// ========================================
function previewIdentificationDocument(index) {
    const input = document.getElementById('identification_document_' + index);
    const preview = document.getElementById('identification_document_preview_' + index);
    const file = input.files[0];
    
    if (!file) return;
    
    // Validate file size (10MB)
    if (file.size > 10 * 1024 * 1024) {
        alert('File size must be less than 10MB');
        input.value = '';
        return;
    }
    
    // Validate file type
    const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
    if (!validTypes.includes(file.type)) {
        alert('Please upload a PDF, JPG, or PNG file');
        input.value = '';
        return;
    }
    
    // Create preview
    const reader = new FileReader();
    reader.onload = function(e) {
        let thumbnail = '';
        
        if (file.type.startsWith('image/')) {
            thumbnail = `<img src="${e.target.result}" alt="Document" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">`;
        } else {
            thumbnail = `
                <div class="w-16 h-16 bg-blue-100 rounded-lg border-2 border-blue-300 flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            `;
        }
        
        preview.innerHTML = `
            <div class="relative bg-gray-50 border-2 border-plyform-green rounded-lg p-3">
                <div class="flex items-center gap-3">
                    ${thumbnail}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                        <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
                    </div>
                    <button 
                        type="button" 
                        onclick="removeIdentificationDocument(${index})"
                        class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                        title="Remove document"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    };
    reader.readAsDataURL(file);
}

function removeIdentificationDocument(index) {
    const input = document.getElementById('identification_document_' + index);
    const preview = document.getElementById('identification_document_preview_' + index);
    
    input.value = '';
    
    // Mark as required again
    input.required = true;
    
    preview.innerHTML = `
        <button 
            type="button" 
            onclick="document.getElementById('identification_document_${index}').click()"
            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-green transition-colors text-center cursor-pointer"
        >
            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            <span class="text-sm text-gray-600">Click to upload identification document</span>
            <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB)</span>
        </button>
    `;
}

// ========================================
// EMERGENCY CONTACT PHONE - intl-tel-input (Application Form)
// ========================================
const appEmergencyPhoneInput = document.querySelector("#app_emergency_contact_phone");
if (appEmergencyPhoneInput) {
    const appEmergencyIti = window.intlTelInput(appEmergencyPhoneInput, {
        initialCountry: "au",
        preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
        separateDialCode: true,
        nationalMode: false,
        autoPlaceholder: "polite",
        formatOnDisplay: true,
        customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
            return "e.g. " + selectedCountryPlaceholder;
        },
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
    });

    const existingEmergencyCountryCode = document.getElementById('app_emergency_contact_country_code').value;
    const existingEmergencyNumber = document.getElementById('app_emergency_contact_number_clean').value;
    
    if (existingEmergencyCountryCode && existingEmergencyNumber) {
        const countryCode = existingEmergencyCountryCode.replace('+', '');
        const allCountries = window.intlTelInputGlobals.getCountryData();
        const countryData = allCountries.find(country => country.dialCode === countryCode);
        if (countryData) {
            appEmergencyIti.setCountry(countryData.iso2);
        }
        appEmergencyPhoneInput.value = existingEmergencyNumber;
    }

    appEmergencyPhoneInput.addEventListener('blur', function() {
        updateAppEmergencyPhoneFields();
    });

    appEmergencyPhoneInput.addEventListener('countrychange', function() {
        updateAppEmergencyPhoneFields();
    });

    function updateAppEmergencyPhoneFields() {
        const countryData = appEmergencyIti.getSelectedCountryData();
        document.getElementById('app_emergency_contact_country_code').value = '+' + countryData.dialCode;
        const fullNumber = appEmergencyIti.getNumber();
        const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
        document.getElementById('app_emergency_contact_number_clean').value = numberWithoutCode;
    }

    // Validate emergency contact phone on form submission (if checkbox is checked)
    const form = document.getElementById('application-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const hasEmergencyContact = document.getElementById('has_emergency_contact');
            
            if (hasEmergencyContact && hasEmergencyContact.checked) {
                updateAppEmergencyPhoneFields();
                
                if (appEmergencyPhoneInput.value && !appEmergencyIti.isValidNumber()) {
                    e.preventDefault();
                    appEmergencyPhoneInput.classList.add('border-red-500');
                    
                    let errorMsg = appEmergencyPhoneInput.parentElement.querySelector('.app-emergency-phone-error');
                    if (!errorMsg) {
                        errorMsg = document.createElement('p');
                        errorMsg.className = 'app-emergency-phone-error mt-1 text-sm text-red-600 flex items-center gap-1';
                        errorMsg.innerHTML = `
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Please enter a valid emergency contact phone number.
                        `;
                        appEmergencyPhoneInput.parentElement.appendChild(errorMsg);
                    }
                    
                    // Scroll to the error
                    appEmergencyPhoneInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    appEmergencyPhoneInput.focus();
                    
                    return false;
                } else {
                    appEmergencyPhoneInput.classList.remove('border-red-500');
                    const errorMsg = appEmergencyPhoneInput.parentElement.querySelector('.app-emergency-phone-error');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            }
        });
    }
}

// ========================================
// PET PHOTO FILE PREVIEW
// ========================================
function previewPetPhoto(index) {
    const input = document.getElementById('pet_photo_' + index);
    const preview = document.getElementById('pet_photo_preview_' + index);
    const file = input.files[0];
    
    if (!file) return;
    
    // Validate file size (5MB for photos)
    if (file.size > 5 * 1024 * 1024) {
        alert('Photo size must be less than 5MB');
        input.value = '';
        return;
    }
    
    // Validate file type (images only)
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!validTypes.includes(file.type)) {
        alert('Please upload a JPG or PNG image');
        input.value = '';
        return;
    }
    
    // Create preview
    const reader = new FileReader();
    reader.onload = function(e) {
        preview.innerHTML = `
            <div class="relative bg-gray-50 border-2 border-plyform-orange rounded-lg p-3">
                <div class="flex items-center gap-3">
                    <img src="${e.target.result}" alt="Pet Photo" class="w-20 h-20 object-cover rounded-lg border-2 border-plyform-orange/50">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                        <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
                    </div>
                    <button 
                        type="button" 
                        onclick="removePetPhoto(${index})"
                        class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                        title="Remove photo"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    };
    reader.readAsDataURL(file);
}

function removePetPhoto(index) {
    const input = document.getElementById('pet_photo_' + index);
    const preview = document.getElementById('pet_photo_preview_' + index);
    
    input.value = '';
    input.required = true;
    
    preview.innerHTML = `
        <button 
            type="button" 
            onclick="document.getElementById('pet_photo_${index}').click()"
            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer"
        >
            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-sm text-gray-600">Click to upload pet photo</span>
            <span class="text-xs text-gray-500 block mt-1">JPG, PNG (Max 5MB)</span>
        </button>
    `;
}

// ========================================
// PET DOCUMENT FILE PREVIEW
// ========================================
function previewPetDocument(index) {
    const input = document.getElementById('pet_document_' + index);
    const preview = document.getElementById('pet_document_preview_' + index);
    const file = input.files[0];
    
    if (!file) return;
    
    // Validate file size (10MB)
    if (file.size > 10 * 1024 * 1024) {
        alert('File size must be less than 10MB');
        input.value = '';
        return;
    }
    
    // Validate file type
    const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
    if (!validTypes.includes(file.type)) {
        alert('Please upload a PDF, JPG, or PNG file');
        input.value = '';
        return;
    }
    
    // Create preview
    const reader = new FileReader();
    reader.onload = function(e) {
        let thumbnail = '';
        
        if (file.type.startsWith('image/')) {
            thumbnail = `<img src="${e.target.result}" alt="Document" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">`;
        } else {
            thumbnail = `
                <div class="w-16 h-16 bg-orange-100 rounded-lg border-2 border-plyform-orange/50 flex items-center justify-center">
                    <svg class="w-8 h-8 text-plyform-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            `;
        }
        
        preview.innerHTML = `
            <div class="relative bg-gray-50 border-2 border-plyform-orange rounded-lg p-3">
                <div class="flex items-center gap-3">
                    ${thumbnail}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                        <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
                    </div>
                    <button 
                        type="button" 
                        onclick="removePetDocument(${index})"
                        class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                        title="Remove document"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    };
    reader.readAsDataURL(file);
}

function removePetDocument(index) {
    const input = document.getElementById('pet_document_' + index);
    const preview = document.getElementById('pet_document_preview_' + index);
    
    input.value = '';
    
    preview.innerHTML = `
        <button 
            type="button" 
            onclick="document.getElementById('pet_document_${index}').click()"
            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer"
        >
            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            <span class="text-sm text-gray-600">Click to upload registration certificate</span>
            <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB)</span>
        </button>
    `;
}
</script>
@endpush