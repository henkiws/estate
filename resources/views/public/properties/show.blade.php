<x-public-layout :title="$property->full_address">
    <div class="bg-white">
        <!-- Breadcrumb -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm text-gray-600">
                <a href="{{ route('homepage') }}" class="hover:text-primary">Home</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('properties.index') }}" class="hover:text-primary">Properties</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 font-medium">{{ $property->short_address }}</span>
            </nav>
        </div>

        <!-- Image Gallery -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @if($property->images->count() > 0)
                <div class="grid grid-cols-4 gap-4 h-[500px]">
                    <!-- Main Image -->
                    <div class="col-span-4 md:col-span-3 h-full">
                        <img src="{{ Storage::disk('public')->url($property->featuredImage->file_path ?? $property->images->first()->file_path) }}" 
                             alt="{{ $property->full_address }}"
                             class="w-full h-full object-cover rounded-2xl">
                    </div>

                    <!-- Side Images -->
                    <div class="hidden md:grid grid-rows-2 gap-4 h-full">
                        @foreach($property->images->take(2) as $index => $image)
                            @if($index > 0 || !$property->featuredImage)
                                <img src="{{ Storage::disk('public')->url($image->file_path) }}" 
                                     alt="Property image"
                                     class="w-full h-full object-cover rounded-2xl">
                            @endif
                        @endforeach
                    </div>
                </div>

                @if($property->images->count() > 3)
                    <div class="mt-4 text-center">
                        <button class="px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-xl transition-colors">
                            View All {{ $property->images->count() }} Photos
                        </button>
                    </div>
                @endif
            @else
                <div class="h-[500px] bg-gray-200 rounded-2xl flex items-center justify-center">
                    <div class="text-center text-gray-400">
                        <svg class="w-20 h-20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-lg">No images available</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Header -->
                    <div>
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $property->full_address }}</h1>
                                <p class="text-gray-600">{{ $property->suburb }}, {{ $property->state }} {{ $property->postcode }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-4xl font-bold text-primary mb-1">{{ $property->display_price }}</p>
                                <span class="inline-block px-4 py-1 bg-primary-light text-primary text-sm font-semibold rounded-full">
                                    {{ ucfirst($property->listing_type) }}
                                </span>
                            </div>
                        </div>

                        <!-- Key Features -->
                        <div class="flex flex-wrap items-center gap-6 py-6 border-y border-gray-200">
                            @if($property->bedrooms)
                                <div class="flex items-center gap-2">
                                    <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-gray-900">{{ $property->bedrooms }}</p>
                                        <p class="text-sm text-gray-600">Bedrooms</p>
                                    </div>
                                </div>
                            @endif

                            @if($property->bathrooms)
                                <div class="flex items-center gap-2">
                                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-gray-900">{{ $property->bathrooms }}</p>
                                        <p class="text-sm text-gray-600">Bathrooms</p>
                                    </div>
                                </div>
                            @endif

                            @if($property->parking_spaces)
                                <div class="flex items-center gap-2">
                                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-gray-900">{{ $property->parking_spaces }}</p>
                                        <p class="text-sm text-gray-600">Parking</p>
                                    </div>
                                </div>
                            @endif

                            @if($property->land_area)
                                <div class="flex items-center gap-2">
                                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-gray-900">{{ number_format($property->land_area) }}</p>
                                        <p class="text-sm text-gray-600">m² Land</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    @if($property->headline || $property->description)
                        <div class="bg-white rounded-2xl border border-gray-200 p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Description</h2>
                            
                            @if($property->headline)
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ $property->headline }}</h3>
                            @endif
                            
                            @if($property->description)
                                <div class="prose max-w-none text-gray-700 leading-relaxed">
                                    {!! nl2br(e($property->description)) !!}
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Features -->
                    @if($property->features && count($property->features) > 0)
                        <div class="bg-white rounded-2xl border border-gray-200 p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Features</h2>
                            
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($property->features as $feature)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-700">{{ $feature }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Property Details -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Property Details</h2>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="py-3 border-b border-gray-100">
                                <p class="text-sm text-gray-600 mb-1">Property Type</p>
                                <p class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $property->property_type)) }}</p>
                            </div>

                            @if($property->year_built)
                                <div class="py-3 border-b border-gray-100">
                                    <p class="text-sm text-gray-600 mb-1">Year Built</p>
                                    <p class="font-semibold text-gray-900">{{ $property->year_built }}</p>
                                </div>
                            @endif

                            @if($property->floor_area)
                                <div class="py-3 border-b border-gray-100">
                                    <p class="text-sm text-gray-600 mb-1">Floor Area</p>
                                    <p class="font-semibold text-gray-900">{{ number_format($property->floor_area) }} m²</p>
                                </div>
                            @endif

                            @if($property->listing_type === 'rent' && $property->available_from)
                                <div class="py-3 border-b border-gray-100">
                                    <p class="text-sm text-gray-600 mb-1">Available From</p>
                                    <p class="font-semibold text-gray-900">{{ $property->available_from->format('M d, Y') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Similar Properties -->
                    @if($similarProperties->count() > 0)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Similar Properties</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                @foreach($similarProperties as $similar)
                                    <a href="{{ route('properties.show', $similar->property_code) }}" class="group">
                                        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                            <div class="relative h-40 overflow-hidden">
                                                <img src="{{ $similar->featured_image_url }}" 
                                                     alt="{{ $similar->full_address }}"
                                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            </div>
                                            <div class="p-4">
                                                <p class="text-xl font-bold text-primary mb-1">{{ $similar->display_price }}</p>
                                                <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ $similar->short_address }}</p>
                                                <p class="text-xs text-gray-600">{{ $similar->suburb }}</p>
                                                <div class="flex items-center gap-3 text-xs text-gray-700 mt-2">
                                                    @if($similar->bedrooms)<span>{{ $similar->bedrooms }} bed</span>@endif
                                                    @if($similar->bathrooms)<span>{{ $similar->bathrooms }} bath</span>@endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Contact Forms -->
                <div class="space-y-6">
                    <!-- Listing Agent Card -->
                    @if($property->listingAgent)
                        <div class="bg-white rounded-2xl border border-gray-200 p-6 sticky top-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Contact Agent</h3>
                            
                            @isset($property->listingAgent->photo)
                            <div class="flex items-center gap-4 mb-6">
                                @if($property->listingAgent->photo)
                                    <img src="{{ $property->listingAgent->photo_url }}" 
                                         alt="{{ $property->listingAgent->full_name }}"
                                         class="w-16 h-16 rounded-full object-cover">
                                @else
                                    <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center">
                                        <span class="text-xl font-bold text-primary">{{ $property->listingAgent->initials }}</span>
                                    </div>
                                @endif
                                
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $property->listingAgent->full_name }}</p>
                                    @if($property->listingAgent->position)
                                        <p class="text-sm text-gray-600">{{ $property->listingAgent->position }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">{{ $property->agency->agency_name }}</p>
                                </div>
                            </div>
                            @endisset

                            <!-- Enquiry Form -->
                            <form action="{{ route('properties.enquiry', $property->property_code) }}" method="POST" class="space-y-4">
                                @csrf
                                
                                <div>
                                    <input type="text" 
                                           name="name" 
                                           placeholder="Your Name"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>

                                <div>
                                    <input type="email" 
                                           name="email" 
                                           placeholder="Email"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>

                                <div>
                                    <input type="tel" 
                                           name="phone" 
                                           placeholder="Phone"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>

                                <div>
                                    <textarea name="message" 
                                              rows="4" 
                                              placeholder="Message"
                                              required
                                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                                </div>

                                <button type="submit" class="w-full px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                                    Send Enquiry
                                </button>
                            </form>

                            <div class="mt-4 pt-4 border-t border-gray-200 space-y-2">
                                @isset($property->listingAgent->mobile)
                                    @if($property->listingAgent->mobile)
                                        <a href="tel:{{ $property->listingAgent->mobile }}" 
                                        class="flex items-center gap-2 text-sm text-gray-700 hover:text-primary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            {{ $property->listingAgent->mobile }}
                                        </a>
                                    @endif
                                @endisset
                                
                                @isset($property->listingAgent->email)
                                    @if($property->listingAgent->email)
                                        <a href="mailto:{{ $property->listingAgent->email }}" 
                                        class="flex items-center gap-2 text-sm text-gray-700 hover:text-primary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $property->listingAgent->email }}
                                        </a>
                                    @endif
                                @endisset
                            </div>
                        </div>
                    @endif

                    <!-- Apply Now Button (for rentals) -->
                    @if($property->listing_type === 'rent')
                        <div class="bg-gradient-to-br from-primary to-primary-dark rounded-2xl p-6 text-white">
                            <h3 class="text-xl font-bold mb-2">Interested in this property?</h3>
                            <p class="text-primary-light mb-4">Submit your rental application now</p>
                            <a href="#apply-modal" 
                               class="block w-full px-6 py-3 bg-white hover:bg-gray-100 text-primary font-semibold rounded-xl text-center transition-colors">
                                Apply Now
                            </a>
                        </div>
                    @endif

                    <!-- Share & Save -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-6">
                        <div class="grid grid-cols-2 gap-3">
                            <button class="px-4 py-3 border border-gray-300 hover:border-primary hover:text-primary rounded-xl font-medium transition-colors">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                                Share
                            </button>
                            <button class="px-4 py-3 border border-gray-300 hover:border-primary hover:text-primary rounded-xl font-medium transition-colors">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>