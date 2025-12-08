<x-public-layout :title="$property->full_address">
    <!-- Alpine.js data for modals -->
    <div x-data="{
        loginModalOpen: false,
        shareModalOpen: false,
        activeTab: 'login',
        saving: false,
        openLoginModal() {
            this.loginModalOpen = true;
            this.activeTab = 'login';
        },
        closeLoginModal() {
            this.loginModalOpen = false;
        },
        copyLink() {
            navigator.clipboard.writeText(window.location.href);
            alert('Link copied to clipboard!');
        },
        async shareNative() {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: '{{ $property->headline ?? $property->short_address }}',
                        text: 'Check out this property: {{ $property->full_address }}',
                        url: window.location.href
                    });
                } catch (err) {
                    this.shareModalOpen = true;
                }
            } else {
                this.shareModalOpen = true;
            }
        }
    }">
        
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
                @if($regularImages->count() > 0)
                    <div class="grid grid-cols-4 gap-4" style="height: 500px;">
                        <!-- Main Image - Takes 3 columns on desktop, full width on mobile -->
                        <div class="col-span-4 md:col-span-3 h-full">
                            <a href="{{ Storage::disk('public')->url($regularImages->first()->file_path) }}" 
                               class="glightbox block w-full h-full rounded-2xl overflow-hidden"
                               data-gallery="property-gallery"
                               data-title="{{ $regularImages->first()->title ?? 'Property Image' }}">
                                <img src="{{ Storage::disk('public')->url($regularImages->first()->file_path) }}" 
                                     alt="{{ $property->full_address }}"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                     style="object-fit: cover;">
                            </a>
                        </div>

                        <!-- Side Images - Hidden on mobile, shown on desktop -->
                        @if($regularImages->count() > 1)
                            <div class="hidden md:grid grid-rows-2 gap-4 h-full">
                                @foreach($regularImages->skip(1)->take(2) as $image)
                                    <a href="{{ Storage::disk('public')->url($image->file_path) }}" 
                                       class="glightbox block w-full h-full rounded-2xl overflow-hidden"
                                       data-gallery="property-gallery"
                                       data-title="{{ $image->title ?? 'Property Image' }}">
                                        <img src="{{ Storage::disk('public')->url($image->file_path) }}" 
                                             alt="Property image"
                                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Hidden images for lightbox (remaining images) -->
                    @foreach($regularImages->skip(3) as $image)
                        <a href="{{ Storage::disk('public')->url($image->file_path) }}" 
                           class="glightbox hidden"
                           data-gallery="property-gallery"
                           data-title="{{ $image->title ?? 'Property Image' }}"></a>
                    @endforeach

                    <!-- View All Photos Button -->
                    @if($regularImages->count() > 3)
                        <div class="mt-4 flex items-center gap-4">
                            <button onclick="GLightbox({ selector: '.glightbox' }).open();" 
                                    class="px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-xl transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                View All {{ $regularImages->count() }} Photos
                            </button>

                            <!-- Floorplans Button -->
                            @if($floorplans->count() > 0)
                                <button onclick="GLightbox({ selector: '.glightbox-floorplan' }).open();" 
                                        class="px-6 py-3 bg-white hover:bg-gray-50 border-2 border-gray-300 text-gray-900 font-semibold rounded-xl transition-colors flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    View Floorplans ({{ $floorplans->count() }})
                                </button>
                            @endif
                        </div>
                    @endif

                    <!-- Hidden floorplans for separate lightbox -->
                    @foreach($floorplans as $index => $floorplan)
                        <a href="{{ Storage::disk('public')->url($floorplan->file_path) }}" 
                           class="glightbox-floorplan hidden"
                           data-gallery="floorplans"
                           data-title="Floorplan {{ $index + 1 }}"></a>
                    @endforeach
                @else
                    <!-- No Images Placeholder -->
                    <div class="h-[500px] bg-gray-100 rounded-2xl flex items-center justify-center">
                        <div class="text-center text-gray-400">
                            <svg class="w-20 h-20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-lg font-medium">No images available</p>
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
                                    <span class="inline-block px-4 py-1 bg-primary/10 text-primary text-sm font-semibold rounded-full">
                                        {{ ucfirst($property->listing_type) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Key Features -->
                            <div class="flex flex-wrap items-center gap-6 py-6 border-y border-gray-200">
                                @if($property->bedrooms)
                                    <div class="flex items-center gap-2">
                                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
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
                                                <div class="relative h-40 overflow-hidden bg-gray-100">
                                                    @if($similar->featuredImage)
                                                        <img src="{{ Storage::disk('public')->url($similar->featuredImage->file_path) }}" 
                                                             alt="{{ $similar->full_address }}"
                                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                            </svg>
                                                        </div>
                                                    @endif
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

                    <!-- Right Column - Enquiry Form & Actions -->
                    <div class="space-y-6">
                        <!-- Enquiry Form Card -->
                        <div class="bg-white rounded-2xl border border-gray-200 p-6 sticky top-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Enquire About This Property</h3>
                            
                            @if(session('success'))
                                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @auth
                                @if(Auth::user()->hasRole('user'))
                                    <!-- Enquiry Form for Logged In Users -->
                                    <form action="{{ route('properties.enquiry', $property->property_code) }}" method="POST" class="space-y-4">
                                        @csrf
                                        
                                        <div>
                                            <input type="text" 
                                                   name="name" 
                                                   placeholder="Your Name"
                                                   value="{{ Auth::user()->name }}"
                                                   required
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                        </div>

                                        <div>
                                            <input type="email" 
                                                   name="email" 
                                                   placeholder="Email"
                                                   value="{{ Auth::user()->email }}"
                                                   required
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                        </div>

                                        <div>
                                            <input type="tel" 
                                                   name="phone" 
                                                   placeholder="Phone"
                                                   value="{{ Auth::user()->phone }}"
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
                                @else
                                    <!-- Non-user roles see login prompt -->
                                    <div class="text-center py-8">
                                        <p class="text-gray-600 mb-4">Please login with a user account to send enquiries</p>
                                        <button @click="openLoginModal()" class="px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                                            Login to Enquire
                                        </button>
                                    </div>
                                @endif
                            @else
                                <!-- Not logged in - show login prompt -->
                                <div class="text-center py-8">
                                    <p class="text-gray-600 mb-4">Please login to send an enquiry</p>
                                    <button @click="openLoginModal()" class="px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                                        Login to Enquire
                                    </button>
                                </div>
                            @endauth
                        </div>

                        <!-- Apply Now Button (for rentals) -->
                        @if($property->listing_type === 'rent')
                            <div class="bg-gradient-to-br from-primary to-primary-dark rounded-2xl p-6 text-white">
                                <h3 class="text-xl font-bold mb-2">Interested in this property?</h3>
                                <p class="text-primary-light mb-4">Submit your rental application now</p>
                                
                                @auth
                                    @if(Auth::user()->hasRole('user'))
                                        <a href="{{ route('user.apply', $property->property_code) }}" 
                                           class="block w-full px-6 py-3 bg-white hover:bg-gray-100 text-primary font-semibold rounded-xl text-center transition-colors">
                                            Apply Now
                                        </a>
                                    @else
                                        <button @click="openLoginModal()" 
                                                class="block w-full px-6 py-3 bg-white hover:bg-gray-100 text-primary font-semibold rounded-xl text-center transition-colors">
                                            Login to Apply
                                        </button>
                                    @endif
                                @else
                                    <button @click="openLoginModal()" 
                                            class="block w-full px-6 py-3 bg-white hover:bg-gray-100 text-primary font-semibold rounded-xl text-center transition-colors">
                                        Login to Apply
                                    </button>
                                @endauth
                            </div>
                        @endif

                        <!-- Share & Save -->
                        <div class="bg-white rounded-2xl border border-gray-200 p-6">
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Share Button -->
                                <button @click="shareNative()" class="px-4 py-3 border border-gray-300 hover:border-primary hover:text-primary rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                    </svg>
                                    Share
                                </button>
                                
                                <!-- Save Button -->
                                @auth
                                    @if(Auth::user()->hasRole('user'))
                                        <form action="{{ route('properties.toggle-save', $property->property_code) }}" method="POST" class="w-full" x-data="{ saved: {{ $isSaved ? 'true' : 'false' }} }">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full px-4 py-3 border rounded-xl font-medium transition-colors flex items-center justify-center gap-2"
                                                    :class="saved ? 'border-red-500 text-red-500 hover:bg-red-50' : 'border-gray-300 hover:border-primary hover:text-primary'">
                                                <svg class="w-5 h-5" :class="saved ? 'fill-current' : ''" :fill="saved ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>
                                                <span x-text="saved ? 'Saved' : 'Save'"></span>
                                            </button>
                                        </form>
                                    @else
                                        <button @click="openLoginModal()" class="px-4 py-3 border border-gray-300 hover:border-primary hover:text-primary rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            Save
                                        </button>
                                    @endif
                                @else
                                    <button @click="openLoginModal()" class="px-4 py-3 border border-gray-300 hover:border-primary hover:text-primary rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        Save
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login/Register Modal -->
        <div x-show="loginModalOpen" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div x-show="loginModalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                     @click="closeLoginModal()"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div x-show="loginModalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <!-- Close Button -->
                        <button @click="closeLoginModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Welcome Back</h3>

                        <!-- Tabs -->
                        <div class="flex border-b border-gray-200 mb-6">
                            <button @click="activeTab = 'login'" 
                                    :class="activeTab === 'login' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                                Login
                            </button>
                            <button @click="activeTab = 'register'" 
                                    :class="activeTab === 'register' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                                Register
                            </button>
                        </div>

                        <!-- Login Form -->
                        <div x-show="activeTab === 'login'" class="space-y-4">
                            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                    <input type="password" name="password" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>

                                <div class="flex items-center justify-between">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary">
                                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                    </label>
                                    <a href="{{ route('password.request') }}" class="text-sm text-primary hover:text-primary-dark">
                                        Forgot password?
                                    </a>
                                </div>

                                <button type="submit" class="w-full px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                                    Login
                                </button>
                            </form>
                        </div>

                        <!-- Register Form -->
                        <div x-show="activeTab === 'register'" class="space-y-4">
                            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" name="name" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                    <input type="tel" name="phone" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                    <input type="password" name="password" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                                    <input type="password" name="password_confirmation" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>

                                <button type="submit" class="w-full px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                                    Create Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Share Modal -->
        <div x-show="shareModalOpen" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             role="dialog" 
             aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div x-show="shareModalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                     @click="shareModalOpen = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div x-show="shareModalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <!-- Close Button -->
                        <button @click="shareModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Share This Property</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank"
                               class="flex flex-col items-center gap-2 p-4 border border-gray-200 rounded-xl hover:border-primary hover:bg-primary/5 transition-colors">
                                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                <span class="text-sm font-medium">Facebook</span>
                            </a>

                            <!-- Twitter -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($property->headline ?? $property->short_address) }}" 
                               target="_blank"
                               class="flex flex-col items-center gap-2 p-4 border border-gray-200 rounded-xl hover:border-primary hover:bg-primary/5 transition-colors">
                                <svg class="w-8 h-8 text-sky-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                                <span class="text-sm font-medium">Twitter</span>
                            </a>

                            <!-- WhatsApp -->
                            <a href="https://wa.me/?text={{ urlencode($property->headline ?? $property->short_address) }}%20{{ urlencode(url()->current()) }}" 
                               target="_blank"
                               class="flex flex-col items-center gap-2 p-4 border border-gray-200 rounded-xl hover:border-primary hover:bg-primary/5 transition-colors">
                                <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                                <span class="text-sm font-medium">WhatsApp</span>
                            </a>

                            <!-- LinkedIn -->
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                               target="_blank"
                               class="flex flex-col items-center gap-2 p-4 border border-gray-200 rounded-xl hover:border-primary hover:bg-primary/5 transition-colors">
                                <svg class="w-8 h-8 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                                <span class="text-sm font-medium">LinkedIn</span>
                            </a>

                            <!-- Email -->
                            <a href="mailto:?subject={{ urlencode($property->headline ?? $property->short_address) }}&body={{ urlencode('Check out this property: ' . url()->current()) }}" 
                               class="flex flex-col items-center gap-2 p-4 border border-gray-200 rounded-xl hover:border-primary hover:bg-primary/5 transition-colors">
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-medium">Email</span>
                            </a>

                            <!-- Copy Link -->
                            <button @click="copyLink()" 
                                    class="flex flex-col items-center gap-2 p-4 border border-gray-200 rounded-xl hover:border-primary hover:bg-primary/5 transition-colors">
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-medium">Copy Link</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GLightbox CSS & JS -->
    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        // Initialize GLightbox for property images
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            autoplayVideos: true
        });

        // Initialize separate GLightbox for floorplans
        const floorplanLightbox = GLightbox({
            selector: '.glightbox-floorplan',
            touchNavigation: true,
            loop: true
        });
    </script>
    @endpush
</x-public-layout>