@php
    $quickStartItems = $quickStartItems ?? [
        [
            'title' => 'Create your first draft application',
            'completed' => false,
            'link' => '#'
        ],
        [
            'title' => 'Complete profile',
            'completed' => false,
            'link' => route('user.profile.complete')
        ],
        [
            'title' => 'Submit your first application',
            'completed' => false,
            'link' => '#'
        ]
    ];
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center gap-3 mb-6">
        <div class="flex-shrink-0 p-2 bg-teal-100 rounded-lg">
            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900">Quick start</h3>
    </div>
    
    <div class="space-y-3">
        @foreach($quickStartItems as $item)
            <a href="{{ $item['link'] }}" class="flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:border-teal-300 hover:bg-teal-50 transition group">
                <div class="flex items-center gap-3">
                    <!-- Checkbox -->
                    @if($item['completed'])
                        <div class="flex-shrink-0 w-5 h-5 rounded-full bg-green-500 flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @else
                        <div class="flex-shrink-0 w-5 h-5 rounded-full border-2 border-gray-300 group-hover:border-teal-500 transition"></div>
                    @endif
                    
                    <!-- Text -->
                    <span class="text-sm font-medium text-gray-700 group-hover:text-teal-700 transition">
                        {{ $item['title'] }}
                    </span>
                </div>
                
                <!-- Arrow -->
                <svg class="w-5 h-5 text-gray-400 group-hover:text-teal-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @endforeach
    </div>
    
    <!-- Progress Bar (Optional) -->
    @php
        $completedCount = collect($quickStartItems)->where('completed', true)->count();
        $totalCount = count($quickStartItems);
        $progress = $totalCount > 0 ? ($completedCount / $totalCount) * 100 : 0;
    @endphp
    
    @if($progress > 0 && $progress < 100)
        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-gray-600">Progress</span>
                <span class="text-xs font-bold text-teal-600">{{ $completedCount }}/{{ $totalCount }} completed</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-teal-500 h-2 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
            </div>
        </div>
    @endif
</div>