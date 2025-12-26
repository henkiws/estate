@extends('layouts.admin')

@section('title', 'Edit Agency Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-plyform-dark">Agency Profile</h1>
        <p class="text-gray-600 mt-1">Manage your agency information and settings</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-plyform-mint/20 border-2 border-plyform-mint text-plyform-dark px-4 py-3 rounded-xl flex items-center gap-2">
            <svg class="w-5 h-5 text-plyform-mint" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-t-xl shadow-sm border border-gray-100 border-b-0">
        <div class="flex overflow-x-auto">
            <button onclick="showTab('company')" id="tab-company" class="tab-button active px-6 py-4 font-medium text-sm border-b-2 border-plyform-purple text-plyform-purple whitespace-nowrap">
                <svg class="w-5 h-5 inline mr-2 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Company Info
            </button>
            <button onclick="showTab('contact')" id="tab-contact" class="tab-button px-6 py-4 font-medium text-sm border-b-2 border-transparent text-gray-600 hover:text-plyform-dark hover:border-plyform-mint/50 whitespace-nowrap">
                <svg class="w-5 h-5 inline mr-2 text-plyform-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Contact Details
            </button>
            <button onclick="showTab('branding')" id="tab-branding" class="tab-button px-6 py-4 font-medium text-sm border-b-2 border-transparent text-gray-600 hover:text-plyform-dark hover:border-plyform-mint/50 whitespace-nowrap">
                <svg class="w-5 h-5 inline mr-2 text-plyform-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
                Branding
            </button>
            <button onclick="showTab('social')" id="tab-social" class="tab-button px-6 py-4 font-medium text-sm border-b-2 border-transparent text-gray-600 hover:text-plyform-dark hover:border-plyform-mint/50 whitespace-nowrap">
                <svg class="w-5 h-5 inline mr-2 text-plyform-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                </svg>
                Social Media
            </button>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('agency.profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-b-xl shadow-sm border border-gray-100">
        @csrf
        @method('PATCH')

        <!-- Tab Content -->
        <div class="p-6 space-y-6">
            
            <!-- Company Info Tab -->
            <div id="content-company" class="tab-content">
                <h2 class="text-xl font-bold text-plyform-dark mb-6">Company Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Agency Name -->
                    <div class="md:col-span-2">
                        <label for="agency_name" class="block text-sm font-medium text-gray-700 mb-2">Agency Name *</label>
                        <input type="text" name="agency_name" id="agency_name" value="{{ old('agency_name', $agency->agency_name) }}" required disabled
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed @error('agency_name') border-red-500 @enderror">
                        @error('agency_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Trading Name -->
                    <div class="md:col-span-2">
                        <label for="trading_name" class="block text-sm font-medium text-gray-700 mb-2">Trading Name (if different)</label>
                        <input type="text" name="trading_name" id="trading_name" value="{{ old('trading_name', $agency->trading_name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('trading_name') border-red-500 @enderror">
                        @error('trading_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ABN -->
                    <div>
                        <label for="abn" class="block text-sm font-medium text-gray-700 mb-2">ABN *</label>
                        <input type="text" name="abn" id="abn" value="{{ old('abn', $agency->abn) }}" required disabled maxlength="11" pattern="[0-9]{11}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed @error('abn') border-red-500 @enderror"
                               placeholder="12345678901">
                        @error('abn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">11 digits, numbers only</p>
                    </div>

                    <!-- ACN -->
                    <div>
                        <label for="acn" class="block text-sm font-medium text-gray-700 mb-2">ACN (if applicable)</label>
                        <input type="text" name="acn" id="acn" value="{{ old('acn', $agency->acn) }}" disabled maxlength="9" pattern="[0-9]{9}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed @error('acn') border-red-500 @enderror"
                               placeholder="123456789">
                        @error('acn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">9 digits, numbers only</p>
                    </div>

                    <!-- Business Type -->
                    <div>
                        <label for="business_type" class="block text-sm font-medium text-gray-700 mb-2">Business Type *</label>
                        <select name="business_type" id="business_type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('business_type') border-red-500 @enderror">
                            <option value="">Select type...</option>
                            <option value="sole_trader" {{ old('business_type', $agency->business_type) == 'sole_trader' ? 'selected' : '' }}>Sole Trader</option>
                            <option value="partnership" {{ old('business_type', $agency->business_type) == 'partnership' ? 'selected' : '' }}>Partnership</option>
                            <option value="company" {{ old('business_type', $agency->business_type) == 'company' ? 'selected' : '' }}>Company</option>
                            <option value="trust" {{ old('business_type', $agency->business_type) == 'trust' ? 'selected' : '' }}>Trust</option>
                        </select>
                        @error('business_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- License Number -->
                    <div>
                        <label for="license_number" class="block text-sm font-medium text-gray-700 mb-2">License Number *</label>
                        <input type="text" name="license_number" id="license_number" value="{{ old('license_number', $agency->license_number) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('license_number') border-red-500 @enderror">
                        @error('license_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- License Holder Name -->
                    <div class="md:col-span-2">
                        <label for="license_holder_name" class="block text-sm font-medium text-gray-700 mb-2">License Holder Name *</label>
                        <input type="text" name="license_holder_name" id="license_holder_name" value="{{ old('license_holder_name', $agency->license_holder_name) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('license_holder_name') border-red-500 @enderror">
                        @error('license_holder_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- License Expiry Date -->
                    <div>
                        <label for="license_expiry_date" class="block text-sm font-medium text-gray-700 mb-2">License Expiry Date *</label>
                        <input type="date" name="license_expiry_date" id="license_expiry_date" value="{{ old('license_expiry_date', $agency->license_expiry_date?->format('Y-m-d')) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('license_expiry_date') border-red-500 @enderror">
                        @error('license_expiry_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Must be a future date</p>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Company Description</label>
                        <textarea name="description" id="description" rows="4" maxlength="1000"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('description') border-red-500 @enderror"
                                  placeholder="Tell us about your agency, your mission, and what makes you unique...">{{ old('description', $agency->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500"><span id="charCount" class="text-plyform-purple font-medium">{{ strlen(old('description', $agency->description ?? '')) }}</span>/1000 characters</p>
                    </div>
                </div>
            </div>

            <!-- Contact Details Tab -->
            <div id="content-contact" class="tab-content hidden">
                <h2 class="text-xl font-bold text-plyform-dark mb-6">Contact Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Business Address -->
                    <div class="md:col-span-2">
                        <label for="business_address" class="block text-sm font-medium text-gray-700 mb-2">Business Address *</label>
                        <textarea name="business_address" id="business_address" rows="3" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('business_address') border-red-500 @enderror"
                                  placeholder="Street address, suburb, city...">{{ old('business_address', $agency->business_address) }}</textarea>
                        @error('business_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- State -->
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                        <select name="state" id="state" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('state') border-red-500 @enderror">
                            <option value="">Select state...</option>
                            <option value="NSW" {{ old('state', $agency->state) == 'NSW' ? 'selected' : '' }}>New South Wales</option>
                            <option value="VIC" {{ old('state', $agency->state) == 'VIC' ? 'selected' : '' }}>Victoria</option>
                            <option value="QLD" {{ old('state', $agency->state) == 'QLD' ? 'selected' : '' }}>Queensland</option>
                            <option value="SA" {{ old('state', $agency->state) == 'SA' ? 'selected' : '' }}>South Australia</option>
                            <option value="WA" {{ old('state', $agency->state) == 'WA' ? 'selected' : '' }}>Western Australia</option>
                            <option value="TAS" {{ old('state', $agency->state) == 'TAS' ? 'selected' : '' }}>Tasmania</option>
                            <option value="NT" {{ old('state', $agency->state) == 'NT' ? 'selected' : '' }}>Northern Territory</option>
                            <option value="ACT" {{ old('state', $agency->state) == 'ACT' ? 'selected' : '' }}>Australian Capital Territory</option>
                        </select>
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Postcode -->
                    <div>
                        <label for="postcode" class="block text-sm font-medium text-gray-700 mb-2">Postcode *</label>
                        <input type="text" name="postcode" id="postcode" value="{{ old('postcode', $agency->postcode) }}" required maxlength="4"
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('postcode') border-red-500 @enderror">
                        @error('postcode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Business Phone -->
                    <div>
                        <label for="business_phone" class="block text-sm font-medium text-gray-700 mb-2">Business Phone *</label>
                        <input type="tel" name="business_phone" id="business_phone" value="{{ old('business_phone', $agency->business_phone) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('business_phone') border-red-500 @enderror"
                               placeholder="(02) 1234 5678">
                        @error('business_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Business Email -->
                    <div>
                        <label for="business_email" class="block text-sm font-medium text-gray-700 mb-2">Business Email *</label>
                        <input type="email" name="business_email" id="business_email" value="{{ old('business_email', $agency->business_email) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('business_email') border-red-500 @enderror"
                               placeholder="contact@agency.com">
                        @error('business_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website URL -->
                    <div class="md:col-span-2">
                        <label for="website_url" class="block text-sm font-medium text-gray-700 mb-2">Website URL</label>
                        <input type="url" name="website_url" id="website_url" value="{{ old('website_url', $agency->website_url) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('website_url') border-red-500 @enderror"
                               placeholder="https://www.yourwebsite.com">
                        @error('website_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Branding Tab -->
            <div id="content-branding" class="tab-content hidden">
                <h2 class="text-xl font-bold text-plyform-dark mb-6">Branding & Logo</h2>
                
                <!-- Current Logo Display -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Current Logo</label>
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            @if($agency->hasLogo())
                                <img id="logoPreview" src="{{ $agency->logo_url }}" alt="Agency Logo" class="w-32 h-32 object-contain border-2 border-plyform-purple/30 rounded-xl p-2">
                                <button type="button" onclick="deleteLogo()" class="absolute -top-2 -right-2 w-8 h-8 bg-plyform-orange text-white rounded-full hover:bg-plyform-orange/90 transition flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            @else
                                <div id="logoPreview" class="w-32 h-32 bg-gradient-to-br from-plyform-purple to-plyform-dark rounded-xl flex items-center justify-center text-white font-bold text-3xl">
                                    {{ $agency->initials }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Upload your agency logo</p>
                            <p class="text-xs text-gray-500">Recommended: Square image, JPG or PNG, Max 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Logo Upload -->
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Upload New Logo</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-plyform-purple transition">
                        <input type="file" name="logo" id="logo" accept=".jpg,.jpeg,.png" class="hidden" onchange="previewLogo(this)">
                        <label for="logo" class="cursor-pointer">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">Click to upload logo</p>
                            <p class="text-xs text-gray-500">JPG or PNG, Max 2MB</p>
                        </label>
                    </div>
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div id="newLogoPreview" class="mt-4 hidden"></div>
                </div>
            </div>

            <!-- Social Media Tab -->
            <div id="content-social" class="tab-content hidden">
                <h2 class="text-xl font-bold text-plyform-dark mb-6">Social Media Links</h2>
                <p class="text-gray-600 mb-6">Add your social media profiles (all optional)</p>
                
                <div class="space-y-4">
                    <!-- Facebook -->
                    <div>
                        <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </label>
                        <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $agency->facebook_url) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('facebook_url') border-red-500 @enderror"
                               placeholder="https://facebook.com/yourpage">
                        @error('facebook_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- LinkedIn -->
                    <div>
                        <label for="linkedin_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-5 h-5 inline mr-2 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </label>
                        <input type="url" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $agency->linkedin_url) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('linkedin_url') border-red-500 @enderror"
                               placeholder="https://linkedin.com/company/yourcompany">
                        @error('linkedin_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instagram -->
                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-5 h-5 inline mr-2 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                            Instagram
                        </label>
                        <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $agency->instagram_url) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('instagram_url') border-red-500 @enderror"
                               placeholder="https://instagram.com/yourprofile">
                        @error('instagram_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Twitter -->
                    <div>
                        <label for="twitter_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-5 h-5 inline mr-2 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Twitter / X
                        </label>
                        <input type="url" name="twitter_url" id="twitter_url" value="{{ old('twitter_url', $agency->twitter_url) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none @error('twitter_url') border-red-500 @enderror"
                               placeholder="https://twitter.com/yourprofile">
                        @error('twitter_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

        </div>

        <!-- Form Actions -->
        <div class="border-t border-gray-200 px-6 py-4 bg-plyform-mint/10 rounded-b-xl flex items-center justify-between">
            <a href="{{ route('agency.dashboard') }}" class="text-gray-600 hover:text-plyform-dark font-medium transition-colors">
                ← Back to Dashboard
            </a>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-plyform-yellow to-plyform-mint hover:from-plyform-yellow/90 hover:to-plyform-mint/90 text-plyform-dark rounded-xl transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save Changes
            </button>
        </div>
    </form>
</div>

<script>
// Tab switching
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-plyform-purple', 'text-plyform-purple');
        button.classList.add('border-transparent', 'text-gray-600');
    });
    
    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Add active class to selected tab button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.add('active', 'border-plyform-purple', 'text-plyform-purple');
    activeButton.classList.remove('border-transparent', 'text-gray-600');
}

// Character counter for description
document.getElementById('description')?.addEventListener('input', function() {
    document.getElementById('charCount').textContent = this.value.length;
});

// Logo preview
function previewLogo(input) {
    const preview = document.getElementById('newLogoPreview');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="flex items-center gap-3 p-3 bg-plyform-mint/10 border-2 border-plyform-mint rounded-xl">
                    <img src="${e.target.result}" class="w-24 h-24 object-contain rounded">
                    <div>
                        <p class="text-sm font-medium text-plyform-dark">New logo selected</p>
                        <p class="text-xs text-gray-600">${input.files[0].name}</p>
                        <p class="text-xs text-gray-500">${(input.files[0].size / 1024 / 1024).toFixed(2)} MB</p>
                    </div>
                </div>
            `;
            preview.classList.remove('hidden');
            
            // Also update main preview
            document.getElementById('logoPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Delete logo
async function deleteLogo() {
    if (!confirm('Are you sure you want to delete the agency logo?')) {
        return;
    }
    
    try {
        const response = await fetch('{{ route("agency.profile.delete-logo") }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Replace logo with initials
            document.getElementById('logoPreview').outerHTML = `
                <div id="logoPreview" class="w-32 h-32 bg-gradient-to-br from-plyform-purple to-plyform-dark rounded-xl flex items-center justify-center text-white font-bold text-3xl">
                    {{ $agency->initials }}
                </div>
            `;
            alert('Logo deleted successfully');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to delete logo');
    }
}
</script>

<style>
.tab-button.active {
    border-bottom-width: 2px;
}
</style>
@endsection