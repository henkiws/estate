@props(['application'])

<div class="space-y-4">
    @foreach($application->getTimelineSteps() as $index => $step)
        <div class="flex gap-4">
            <!-- Icon -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300
                    {{ $step['completed'] ? 'bg-teal-500 text-white' : 'bg-gray-200 text-gray-400' }}
                ">
                    @if($step['completed'])
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @else
                        <span class="font-bold text-sm">{{ $index + 1 }}</span>
                    @endif
                </div>
                
                @if($index < count($application->getTimelineSteps()) - 1)
                    <div class="w-0.5 h-12 transition-all duration-300
                        {{ $step['completed'] ? 'bg-teal-500' : 'bg-gray-200' }}
                    "></div>
                @endif
            </div>
            
            <!-- Content -->
            <div class="flex-1 pb-8">
                <h4 class="font-semibold text-gray-900 mb-1">{{ $step['label'] }}</h4>
                
                @if($step['completed'] && $step['date'])
                    <p class="text-sm text-gray-600">
                        {{ $step['date']->format('M j, Y') }} at {{ $step['date']->format('g:i A') }}
                    </p>
                    <p class="text-xs text-gray-500 mt-0.5">
                        {{ $step['date']->diffForHumans() }}
                    </p>
                @else
                    <p class="text-sm text-gray-500">Pending</p>
                @endif
                
                <!-- Additional info for specific steps -->
                @if($step['label'] === 'Rejected' && $step['completed'] && $application->rejection_reason)
                    <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm font-medium text-red-900 mb-1">Rejection Reason:</p>
                        <p class="text-sm text-red-700">{{ $application->rejection_reason }}</p>
                    </div>
                @endif
                
                @if($step['label'] === 'Approved' && $step['completed'])
                    <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-700">
                            🎉 Congratulations! Your application has been approved. The property manager will contact you shortly.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
    
    @if($application->isWithdrawn())
        <div class="flex gap-4">
            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-400 text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-gray-900 mb-1">Withdrawn</h4>
                <p class="text-sm text-gray-600">
                    {{ $application->withdrawn_at->format('M j, Y') }} at {{ $application->withdrawn_at->format('g:i A') }}
                </p>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $application->withdrawn_at->diffForHumans() }}
                </p>
                <div class="mt-2 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                    <p class="text-sm text-gray-700">You withdrew this application.</p>
                </div>
            </div>
        </div>
    @endif
</div>