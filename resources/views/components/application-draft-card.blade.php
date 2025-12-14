@props(['draft'])

<div class="bg-white rounded-xl border border-gray-200 hover:border-teal-300 hover:shadow-md transition p-4">
    <div class="flex items-start justify-between mb-3">
        <div class="flex-1">
            <!-- Property Address -->
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <h4 class="font-semibold text-gray-900">{{ $draft->display_address }}</h4>
            </div>
            
            <!-- Status and Time -->
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <span class="inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    {{ $draft->last_edited_human }}
                </span>
                <span class="text-gray-400">•</span>
                <span class="inline-flex items-center gap-1 text-yellow-600">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    Draft
                </span>
            </div>
        </div>
        
        <!-- Delete Button -->
        <form action="{{ route('user.drafts.destroy', $draft->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this draft?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </form>
    </div>
    
    <!-- Progress Bar -->
    <div class="mb-3">
        <div class="flex items-center justify-between mb-1">
            <span class="text-xs font-medium text-gray-600">Progress</span>
            <span class="text-xs font-bold text-teal-600">{{ $draft->progress_percentage }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-teal-500 h-2 rounded-full transition-all duration-300" style="width: {{ $draft->progress_percentage }}%"></div>
        </div>
        <p class="text-xs text-gray-500 mt-1">Step {{ $draft->current_step }} of {{ $draft->total_steps }}</p>
    </div>
    
    <!-- Action Buttons -->
    <div class="flex gap-2">
        <a href="{{ route('user.drafts.continue', $draft->id) }}" class="flex-1 text-center px-4 py-2 bg-teal-600 text-white text-sm font-semibold rounded-lg hover:bg-teal-700 transition">
            Continue
        </a>
        <a href="{{ route('user.drafts.show', $draft->id) }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition">
            View
        </a>
    </div>
    
    <!-- Expiry Warning (if close to expiring) -->
    @if($draft->expires_at && $draft->expires_at->diffInDays(now()) < 7)
        <div class="mt-3 p-2 bg-orange-50 border border-orange-200 rounded-lg">
            <p class="text-xs text-orange-800">
                <svg class="w-4 h-4 inline-block" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                Expires in {{ $draft->expires_at->diffForHumans() }}
            </p>
        </div>
    @endif
</div>