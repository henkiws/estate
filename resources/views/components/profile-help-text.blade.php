@props(['text' => '', 'position' => 'right'])

<div class="relative inline-block group">
    <button type="button" class="text-gray-400 hover:text-teal-600 transition focus:outline-none">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
        </svg>
    </button>
    
    <!-- Tooltip -->
    <div class="absolute {{ $position === 'left' ? 'right-0' : 'left-0' }} bottom-full mb-2 hidden group-hover:block z-10 w-64">
        <div class="bg-gray-900 text-white text-sm rounded-lg py-2 px-3 shadow-lg">
            {{ $text ?? $slot }}
            <!-- Arrow -->
            <div class="absolute {{ $position === 'left' ? 'right-4' : 'left-4' }} top-full">
                <svg class="w-3 h-2 text-gray-900" viewBox="0 0 12 6" fill="currentColor">
                    <path d="M6 6L0 0h12z"/>
                </svg>
            </div>
        </div>
    </div>
</div>