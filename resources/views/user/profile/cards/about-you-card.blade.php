<!-- About You Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" id="about-you-card">
    
    <!-- Card Header -->
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900">About you</h3>
                <p class="text-sm text-gray-600 mt-1">Select the state/territory where you are looking for your next home</p>
            </div>
        </div>
    </div>
    
    <!-- Card Content -->
    <div class="p-6 bg-gradient-to-br from-purple-50 to-indigo-50">
        <form method="POST" action="{{ route('user.profile.update-state') }}" id="state-form">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8 gap-3">
                @php
                    $states = [
                        'ACT' => 'Australian Capital Territory',
                        'NSW' => 'New South Wales',
                        'SA' => 'South Australia',
                        'TAS' => 'Tasmania',
                        'QLD' => 'Queensland',
                        'VIC' => 'Victoria',
                        'WA' => 'Western Australia',
                        'NT' => 'Northern Territory',
                    ];
                    $userState = auth()->user()->preferred_state ?? null;
                @endphp
                
                @foreach($states as $code => $name)
                    <button 
                        type="button"
                        onclick="selectState('{{ $code }}')"
                        data-state="{{ $code }}"
                        class="state-btn px-4 py-3 rounded-xl font-bold text-sm transition-all border-2 
                            {{ $userState === $code 
                                ? 'bg-teal-600 text-white border-teal-600' 
                                : 'bg-white text-gray-700 border-gray-300 hover:border-teal-500 hover:text-teal-600' 
                            }}"
                        title="{{ $name }}"
                    >
                        {{ $code }}
                    </button>
                @endforeach
            </div>
            
            <input type="hidden" name="preferred_state" id="preferred_state" value="{{ $userState }}">
        </form>
    </div>
    
</div>

@push('scripts')
<script>
function selectState(stateCode) {
    // Update hidden input
    document.getElementById('preferred_state').value = stateCode;
    
    // Update button styles
    document.querySelectorAll('.state-btn').forEach(btn => {
        const btnState = btn.getAttribute('data-state');
        if (btnState === stateCode) {
            // Selected state
            btn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
            btn.classList.add('bg-teal-600', 'text-white', 'border-teal-600');
        } else {
            // Unselected states
            btn.classList.remove('bg-teal-600', 'text-white', 'border-teal-600');
            btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
        }
    });
    
    // Auto-submit the form
    document.getElementById('state-form').submit();
}
</script>
@endpush