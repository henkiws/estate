@props(['currentStep' => 1, 'totalSteps' => 10])

@php
    $steps = [
        1 => ['name' => 'Personal', 'icon' => 'user'],
        2 => ['name' => 'Introduction', 'icon' => 'document'],
        3 => ['name' => 'Income', 'icon' => 'currency'],
        4 => ['name' => 'Employment', 'icon' => 'briefcase'],
        5 => ['name' => 'Pets', 'icon' => 'paw'],
        6 => ['name' => 'Vehicles', 'icon' => 'car'],
        7 => ['name' => 'Address', 'icon' => 'location'],
        8 => ['name' => 'References', 'icon' => 'users'],
        9 => ['name' => 'ID', 'icon' => 'identification'],
        10 => ['name' => 'Terms', 'icon' => 'check'],
    ];
    
    $progressPercentage = ($currentStep / $totalSteps) * 100;
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    
    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-600">Profile Completion</span>
            <span class="text-sm font-bold text-teal-600">{{ round($progressPercentage) }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 h-3 rounded-full transition-all duration-500" style="width: {{ $progressPercentage }}%"></div>
        </div>
    </div>
    
    <!-- Desktop Step Indicator (Hidden on mobile) -->
    <div class="hidden md:block">
        <div class="relative">
            <!-- Connecting Line -->
            <div class="absolute top-5 left-0 w-full h-0.5 bg-gray-200" style="z-index: 0;"></div>
            <div class="absolute top-5 left-0 h-0.5 bg-teal-500 transition-all duration-500" style="width: {{ ($currentStep - 1) * (100 / ($totalSteps - 1)) }}%; z-index: 1;"></div>
            
            <!-- Steps -->
            <div class="relative flex justify-between" style="z-index: 2;">
                @foreach($steps as $stepNum => $step)
                    @if($stepNum <= $currentStep)
                        <a href="{{ route('user.profile.complete', ['step' => $stepNum]) }}" 
                           class="flex flex-col items-center group">
                            <!-- Circle -->
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300
                                {{ $stepNum < $currentStep ? 'bg-teal-500 text-white group-hover:bg-teal-600 group-hover:scale-110' : '' }}
                                {{ $stepNum == $currentStep ? 'bg-teal-600 text-white ring-4 ring-teal-100' : '' }}
                                cursor-pointer
                            ">
                                @if($stepNum < $currentStep)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    {{ $stepNum }}
                                @endif
                            </div>
                            
                            <!-- Label -->
                            <span class="mt-2 text-xs font-medium text-center transition-colors
                                {{ $stepNum == $currentStep ? 'text-teal-600' : 'text-gray-600' }}
                                group-hover:text-teal-600
                            ">
                                {{ $step['name'] }}
                            </span>
                        </a>
                    @else
                        <div class="flex flex-col items-center opacity-50 cursor-not-allowed">
                            <!-- Circle -->
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 bg-gray-200 text-gray-500">
                                {{ $stepNum }}
                            </div>
                            
                            <!-- Label -->
                            <span class="mt-2 text-xs font-medium text-center text-gray-600">
                                {{ $step['name'] }}
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Mobile Step Indicator -->
    <div class="md:hidden">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-teal-50 border border-teal-200 rounded-full">
                <span class="text-teal-700 font-bold">Step {{ $currentStep }} of {{ $totalSteps }}</span>
                <span class="text-teal-600">•</span>
                <span class="text-teal-700">{{ $steps[$currentStep]['name'] }}</span>
            </div>
        </div>
        
        <!-- Mobile Navigation Dots -->
        <div class="flex justify-center gap-2 mt-4">
            @foreach($steps as $stepNum => $step)
                @if($stepNum <= $currentStep)
                    <a href="{{ route('user.profile.complete', ['step' => $stepNum]) }}" 
                       class="w-2 h-2 rounded-full transition-all
                           {{ $stepNum == $currentStep ? 'bg-teal-600 w-8' : 'bg-teal-400 hover:bg-teal-500' }}
                       ">
                    </a>
                @else
                    <div class="w-2 h-2 rounded-full bg-gray-300 cursor-not-allowed"></div>
                @endif
            @endforeach
        </div>
    </div>
    
    <!-- Current Step Info -->
    <div class="mt-6 pt-6 border-t border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Step {{ $currentStep }}: {{ $steps[$currentStep]['name'] }}</h3>
                <p class="text-sm text-gray-600 mt-1">
                    @switch($currentStep)
                        @case(1) Your basic personal information @break
                        @case(2) Tell us about yourself @break
                        @case(3) Your income sources @break
                        @case(4) Your employment history @break
                        @case(5) Information about your pets @break
                        @case(6) Your vehicle details @break
                        @case(7) Your previous addresses @break
                        @case(8) Your references (minimum 2) @break
                        @case(9) Identification documents (80 points required) @break
                        @case(10) Review and accept terms @break
                    @endswitch
                </p>
            </div>
            
            <!-- Time Estimate -->
            <div class="hidden sm:block text-right">
                <span class="text-xs text-gray-500">Estimated time</span>
                <div class="text-sm font-semibold text-gray-700">
                    @switch($currentStep)
                        @case(1) 5 min @break
                        @case(2) 3 min @break
                        @case(3) 7 min @break
                        @case(4) 8 min @break
                        @case(5) 2 min @break
                        @case(6) 2 min @break
                        @case(7) 10 min @break
                        @case(8) 5 min @break
                        @case(9) 10 min @break
                        @case(10) 2 min @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>
    
</div>