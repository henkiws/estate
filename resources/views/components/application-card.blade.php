@props(['application', 'viewMode' => 'grid'])

@if($viewMode === 'grid')
    <!-- Grid View Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 overflow-hidden group">
        <!-- Property Image -->
        <div class="relative h-48 bg-gray-200 overflow-hidden">
            @if($application->property->images->count() > 0)
                <img 
                    src="{{ Storage::url($application->property->images->first()->image_path) }}" 
                    alt="{{ $application->property->address }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                >
            @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
            @endif
            
            <!-- Status Badge Overlay -->
            <div class="absolute top-3 right-3">
                <x-application-status-badge :status="$application->status" size="sm" />
            </div>
        </div>
        
        <!-- Card Content -->
        <div class="p-4">
            <!-- Property Address -->
            <h3 class="font-bold text-gray-900 mb-1 line-clamp-1">
                {{ $application->property->address }}
            </h3>
            
            <!-- Property Details -->
            <p class="text-sm text-gray-600 mb-3">
                ${{ number_format($application->property->price_per_week) }}/week • 
                {{ $application->property->bedrooms }} bed • 
                {{ $application->property->bathrooms }} bath
            </p>
            
            <!-- Application Info -->
            <div class="flex items-center justify-between mb-3 pb-3 border-b border-gray-100">
                <div>
                    <p class="text-xs text-gray-500">Applied</p>
                    <p class="text-sm font-medium text-gray-700">{{ $application->getDaysAgo() }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">Move-in</p>
                    <p class="text-sm font-medium text-gray-700">{{ $application->move_in_date->format('M j') }}</p>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex gap-2">
                <a 
                    href="{{ route('user.applications.show', $application) }}" 
                    class="flex-1 px-4 py-2 bg-teal-600 text-white text-sm font-semibold rounded-lg hover:bg-teal-700 transition text-center"
                >
                    View Details
                </a>
                
                {{-- @if($application->canWithdraw())
                    <button 
                        onclick="confirmWithdraw({{ $application->id }})"
                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition"
                        title="Withdraw Application"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                @endif --}}
            </div>
        </div>
    </div>
@else
    <!-- List View Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 overflow-hidden">
        <div class="flex">
            <!-- Property Image -->
            <div class="w-48 h-32 bg-gray-200 flex-shrink-0 overflow-hidden">
                @if($application->property->images->count() > 0)
                    <img 
                        src="{{ Storage::url($application->property->images->first()->image_path) }}" 
                        alt="{{ $application->property->address }}"
                        class="w-full h-full object-cover"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                @endif
            </div>
            
            <!-- Content -->
            <div class="flex-1 p-4 flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">{{ $application->property->address }}</h3>
                            <p class="text-sm text-gray-600">
                                ${{ number_format($application->property->price_per_week) }}/week • 
                                {{ $application->property->bedrooms }} bed • 
                                {{ $application->property->bathrooms }} bath
                            </p>
                        </div>
                        <x-application-status-badge :status="$application->status" size="sm" />
                    </div>
                    
                    <div class="flex items-center gap-6 text-sm text-gray-600 mt-3">
                        <div>
                            <span class="text-gray-500">Applied:</span> 
                            <span class="font-medium">{{ $application->getDaysAgo() }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Move-in:</span> 
                            <span class="font-medium">{{ $application->move_in_date->format('M j, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Lease:</span> 
                            <span class="font-medium">{{ $application->lease_term }} months</span>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-2 ml-4">
                    <a 
                        href="{{ route('user.applications.show', $application) }}" 
                        class="px-6 py-2 bg-teal-600 text-white text-sm font-semibold rounded-lg hover:bg-teal-700 transition"
                    >
                        View Details
                    </a>
                    
                    {{-- @if($application->canWithdraw())
                        <button 
                            onclick="confirmWithdraw({{ $application->id }})"
                            class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition"
                            title="Withdraw Application"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
@endif

<script>
function confirmWithdraw(applicationId) {
    if (confirm('Are you sure you want to withdraw this application? This action cannot be undone.')) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/user/applications/${applicationId}/withdraw`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>