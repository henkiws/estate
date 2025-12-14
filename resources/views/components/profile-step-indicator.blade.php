@props(['currentStep' => 1])

@php
    $steps = [
        1 => ['name' => 'Personal', 'label' => 'Personal Details'],
        2 => ['name' => 'Introduction', 'label' => 'Introduction'],
        3 => ['name' => 'Income', 'label' => 'Income Sources'],
        4 => ['name' => 'Employment', 'label' => 'Employment History'],
        5 => ['name' => 'Pets', 'label' => 'Pet Information'],
        6 => ['name' => 'Vehicles', 'label' => 'Vehicle Information'],
        7 => ['name' => 'Address', 'label' => 'Address History'],
        8 => ['name' => 'References', 'label' => 'References'],
        9 => ['name' => 'ID', 'label' => 'Identification'],
        10 => ['name' => 'Terms', 'label' => 'Terms & Conditions'],
    ];
    
    $userCurrentStep = auth()->user()->profile_current_step ?? 1;
@endphp

<div class="mb-8">
    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700">Profile Completion</span>
            <span class="text-sm font-semibold text-teal-600">{{ ($currentStep / 10) * 100 }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 h-2.5 rounded-full transition-all duration-500" 
                 style="width: {{ ($currentStep / 10) * 100 }}%"></div>
        </div>
    </div>

    <!-- Step Circles -->
    <div class="flex items-center justify-between">
        @foreach($steps as $stepNumber => $step)
            @php
                $isCompleted = $stepNumber < $currentStep;
                $isCurrent = $stepNumber == $currentStep;
                $isAccessible = $stepNumber <= $userCurrentStep; // Can only access up to their current progress
                $isClickable = $isCompleted && $isAccessible;
            @endphp
            
            <div class="flex flex-col items-center flex-1">
                <!-- Step Circle -->
                @if($isClickable)
                    <!-- Clickable completed step -->
                    <a href="{{ route('user.profile.complete', ['step' => $stepNumber]) }}" 
                       class="group relative">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300
                                    {{ $isCompleted ? 'bg-teal-600 text-white hover:bg-teal-700 hover:scale-110' : '' }}
                                    {{ $isCurrent ? 'bg-teal-600 text-white ring-4 ring-teal-200' : '' }}">
                            @if($isCompleted)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                {{ $stepNumber }}
                            @endif
                        </div>
                        <!-- Hover tooltip -->
                        <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity bg-gray-800 text-white text-xs py-1 px-2 rounded whitespace-nowrap pointer-events-none z-10">
                            Click to edit
                        </div>
                    </a>
                @else
                    <!-- Non-clickable step -->
                    <div class="w-12 h-12 rounded-full flex items-center justify-center font-semibold text-sm transition-all duration-300
                                {{ $isCompleted ? 'bg-teal-600 text-white' : '' }}
                                {{ $isCurrent ? 'bg-teal-600 text-white ring-4 ring-teal-200' : '' }}
                                {{ !$isCompleted && !$isCurrent ? 'bg-gray-200 text-gray-400' : '' }}">
                        @if($isCompleted)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        @else
                            {{ $stepNumber }}
                        @endif
                    </div>
                @endif
                
                <!-- Step Name -->
                <span class="text-xs mt-2 font-medium
                             {{ $isCompleted || $isCurrent ? 'text-teal-600' : 'text-gray-400' }}
                             {{ $isClickable ? 'hover:text-teal-700 cursor-pointer' : '' }}">
                    {{ $step['name'] }}
                </span>
            </div>
            
            <!-- Connector Line -->
            @if(!$loop->last)
                <div class="flex-1 h-1 mx-2 rounded-full transition-all duration-300
                            {{ $stepNumber < $currentStep ? 'bg-teal-600' : 'bg-gray-200' }}">
                </div>
            @endif
        @endforeach
    </div>
</div>