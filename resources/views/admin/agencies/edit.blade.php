@extends('layouts.admin')

@section('title', 'Edit ' . $agency->agency_name)

@section('content')

{{-- Header --}}
<div class="mb-8">
    <div class="flex items-center gap-3 mb-4">
        <a href="{{ route('admin.agencies.show', $agency->id) }}" class="p-2 hover:bg-[#DDEECD] rounded-lg transition">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Agency</h1>
            <p class="text-gray-600 mt-1">{{ $agency->agency_name }}</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.agencies.update', $agency->id) }}" method="POST" class="max-w-4xl">
    @csrf
    @method('PATCH')

    <div class="space-y-8">
        {{-- Agency Information --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">Agency Information</h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Agency Name --}}
                    <div>
                        <label for="agency_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Agency Name <span class="text-gray-500">*</span>
                        </label>
                        <input type="text" 
                               id="agency_name" 
                               name="agency_name"
                               value="{{ old('agency_name', $agency->agency_name) }}"
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all">
                        @error('agency_name')
                            <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Trading Name --}}
                    <div>
                        <label for="trading_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Trading Name
                        </label>
                        <input type="text" 
                               id="trading_name" 
                               name="trading_name"
                               value="{{ old('trading_name', $agency->trading_name) }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all">
                    </div>

                    {{-- ABN --}}
                    <div>
                        <label for="abn" class="block text-sm font-semibold text-gray-700 mb-2">
                            ABN <span class="text-gray-500">*</span>
                        </label>
                        <input type="text" 
                               id="abn" 
                               name="abn"
                               value="{{ old('abn', $agency->abn) }}"
                               required
                               pattern="[0-9\s]{11,14}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all">
                        @error('abn')
                            <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ACN --}}
                    <div>
                        <label for="acn" class="block text-sm font-semibold text-gray-700 mb-2">
                            ACN
                        </label>
                        <input type="text" 
                               id="acn" 
                               name="acn"
                               value="{{ old('acn', $agency->acn) }}"
                               pattern="[0-9\s]{9,11}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all">
                    </div>

                    {{-- Business Type --}}
                    <div>
                        <label for="business_type" class="block text-sm font-semibold text-gray-700 mb-2">
                            Business Type <span class="text-gray-500">*</span>
                        </label>
                        <select id="business_type" 
                                name="business_type"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all bg-white">
                            <option value="sole_trader" {{ old('business_type', $agency->business_type) == 'sole_trader' ? 'selected' : '' }}>Sole Trader</option>
                            <option value="partnership" {{ old('business_type', $agency->business_type) == 'partnership' ? 'selected' : '' }}>Partnership</option>
                            <option value="company" {{ old('business_type', $agency->business_type) == 'company' ? 'selected' : '' }}>Company (Pty Ltd)</option>
                        </select>
                    </div>

                    {{-- License Number --}}
                    <div>
                        <label for="license_number" class="block text-sm font-semibold text-gray-700 mb-2">
                            License Number <span class="text-gray-500">*</span>
                        </label>
                        <input type="text" 
                               id="license_number" 
                               name="license_number"
                               value="{{ old('license_number', $agency->license_number) }}"
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all">
                        @error('license_number')
                            <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- License Holder --}}
                    <div>
                        <label for="license_holder_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            License Holder Name <span class="text-gray-500">*</span>
                        </label>
                        <input type="text" 
                               id="license_holder_name" 
                               name="license_holder_name"
                               value="{{ old('license_holder_name', $agency->license_holder_name) }}"
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all">
                    </div>

                    {{-- License Expiry --}}
                    <div>
                        <label for="license_expiry_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            License Expiry Date
                        </label>
                        <input type="date" 
                               id="license_expiry_date" 
                               name="license_expiry_date"
                               value="{{ old('license_expiry_date', $agency->license_expiry_date?->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Information --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">Contact Information</h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Business Address --}}
                    <div class="md:col-span-2">
                        <label for="business_address" class="block text-sm font-semibold text-gray-700 mb-2">
                            Business Address <span class="text-gray-500">*</span>
                        </label>
                        <input type="text" 
                               id="business_address" 
                               name="business_address"
                               value="{{ old('business_address', $agency->business_address) }}"
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all">
                    </div>

                    {{-- State --}}
                    <div>
                        <label for="state" class="block text-sm font-semibold text-gray-700 mb-2">
                            State/Territory <span class="text-gray-500">*</span>
                        </label>
                        <select id="state" 
                                name="state"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all bg-white">
                            <option value="NSW" {{ old('state', $agency->state) == 'NSW' ? 'selected' : '' }}>New South Wales (NSW)</option>
                            <option value="VIC" {{ old('state', $agency->state) == 'VIC' ? 'selected' : '' }}>Victoria (VIC)</option>
                            <option value="QLD" {{ old('state', $agency->state) == 'QLD' ? 'selected' : '' }}>Queensland (QLD)</option>
                            <option value="WA" {{ old('state', $agency->state) == 'WA' ? 'selected' : '' }}>Western Australia (WA)</option>
                            <option value="SA" {{ old('state', $agency->state) == 'SA' ? 'selected' : '' }}>South Australia (SA)</option>
                            <option value="TAS" {{ old('state', $agency->state) == 'TAS' ? 'selected' : '' }}>Tasmania (TAS)</option>
                            <option value="ACT" {{ old('state', $agency->state) == 'ACT' ? 'selected' : '' }}>Australian Capital Territory (ACT)</option>
                            <option value="NT" {{ old('state', $agency->state) == 'NT' ? 'selected' : '' }}>Northern Territory (NT)</option>
                        </select>
                    </div>

                    {{-- Postcode --}}
                    <div>
                        <label for="postcode" class="block text-sm font-semibold text-gray-700 mb-2">
                            Postcode <span class="text-gray-500">*</span>
                        </label>
                        <input type="text" 
                               id="postcode" 
                               name="postcode"
                               value="{{ old('postcode', $agency->postcode) }}"
                               required
                               pattern="[0-9]{4}"
                               maxlength="4"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all">
                    </div>

                    {{-- Business Phone --}}
                    <div>
                        <label for="business_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Business Phone <span class="text-gray-500">*</span>
                        </label>
                        <input type="tel" 
                               id="business_phone" 
                               name="business_phone"
                               value="{{ old('business_phone', $agency->business_phone) }}"
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all">
                    </div>

                    {{-- Business Email --}}
                    <div>
                        <label for="business_email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Business Email <span class="text-gray-500">*</span>
                        </label>
                        <input type="email" 
                               id="business_email" 
                               name="business_email"
                               value="{{ old('business_email', $agency->business_email) }}"
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all">
                        @error('business_email')
                            <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Website --}}
                    <div class="md:col-span-2">
                        <label for="website_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            Website URL
                        </label>
                        <input type="url" 
                               id="website_url" 
                               name="website_url"
                               value="{{ old('website_url', $agency->website_url) }}"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all">
                    </div>
                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">Agency Status</h2>
            </div>
            <div class="p-6">
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-gray-500">*</span>
                    </label>
                    <select id="status" 
                            name="status"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-[#DDEECD] focus:ring-4 focus:ring-[#DDEECD]/20 hover:border-[#DDEECD]/50 outline-none transition-all bg-white">
                        <option value="pending" {{ old('status', $agency->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ old('status', $agency->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ old('status', $agency->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="inactive" {{ old('status', $agency->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex gap-4">
            <button type="submit" class="px-8 py-4 bg-[#E6FF4B] text-gray-800 rounded-xl font-semibold hover:bg-[#E6FF4B]/80 transition flex items-center gap-2 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Changes
            </button>
            <a href="{{ route('admin.agencies.show', $agency->id) }}" class="px-8 py-4 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition">
                Cancel
            </a>
        </div>
    </div>
</form>

@endsection