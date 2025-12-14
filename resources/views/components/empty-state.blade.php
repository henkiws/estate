@props([
    'icon' => 'document',
    'title' => 'No items found',
    'message' => 'There are no items to display.',
    'actionText' => null,
    'actionUrl' => null,
    'secondaryActionText' => null,
    'secondaryActionUrl' => null,
])

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
    
    <!-- Icon -->
    <div class="mb-6">
        @if($icon === 'document')
            <svg class="w-20 h-20 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        @elseif($icon === 'search')
            <svg class="w-20 h-20 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        @elseif($icon === 'home')
            <svg class="w-20 h-20 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        @elseif($icon === 'inbox')
            <svg class="w-20 h-20 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        @elseif($icon === 'clipboard')
            <svg class="w-20 h-20 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        @else
            <!-- Custom icon slot -->
            {{ $icon }}
        @endif
    </div>
    
    <!-- Title -->
    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $title }}</h3>
    
    <!-- Message -->
    <p class="text-gray-600 mb-6 max-w-md mx-auto">{{ $message }}</p>
    
    <!-- Actions -->
    @if($actionText && $actionUrl)
        <div class="flex items-center justify-center gap-4">
            <a href="{{ $actionUrl }}" class="px-6 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm">
                {{ $actionText }}
            </a>
            
            @if($secondaryActionText && $secondaryActionUrl)
                <a href="{{ $secondaryActionUrl }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                    {{ $secondaryActionText }}
                </a>
            @endif
        </div>
    @endif
    
    <!-- Custom action slot -->
    {{ $slot }}
</div>