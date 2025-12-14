@props(['title' => '', 'description' => '', 'required' => false])

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    
    @if($title)
        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                {{ $title }}
                @if($required)
                    <span class="text-red-500">*</span>
                @endif
            </h3>
            @if($description)
                <p class="text-sm text-gray-600 mt-1">{{ $description }}</p>
            @endif
        </div>
    @endif
    
    <div class="space-y-4">
        {{ $slot }}
    </div>
    
</div>