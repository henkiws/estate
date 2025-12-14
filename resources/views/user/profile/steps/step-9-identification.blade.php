<x-form-section-card 
    title="Identification Documents" 
    description="Upload identification documents to verify your identity (minimum 80 points required)"
    required>
    
    <!-- Points Information -->
    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg mb-6">
        <h4 class="font-semibold text-blue-900 mb-2">Document Points System:</h4>
        <div class="grid md:grid-cols-2 gap-2 text-sm text-blue-800">
            <div>• Australian Driver's Licence: <strong>40 points</strong></div>
            <div>• Passport: <strong>70 points</strong></div>
            <div>• Birth Certificate: <strong>70 points</strong></div>
            <div>• Medicare Card: <strong>25 points</strong></div>
        </div>
        <p class="text-sm text-blue-800 mt-2">
            <strong>You need at least 80 points total.</strong> Example: Driver's Licence (40) + Medicare (25) + Birth Certificate (70) = 135 points ✓
        </p>
    </div>
    
    <div id="identification-container">
        @php
            $identifications = old('identifications', $user->identifications->toArray() ?: [['identification_type' => '']]);
        @endphp
        
        @foreach($identifications as $index => $id)
            <div class="identification-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="{{ $index }}">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-gray-900">Document {{ $index + 1 }}</h4>
                    @if($index > 0)
                        <button 
                            type="button" 
                            onclick="removeIdentification({{ $index }})"
                            class="text-red-600 hover:text-red-700 text-sm font-medium"
                        >
                            Remove
                        </button>
                    @endif
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- ID Type -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            Document Type <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="identifications[{{ $index }}][identification_type]" 
                            required
                            onchange="updatePoints({{ $index }})"
                            class="id-type-select w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                        >
                            <option value="">Select document type</option>
                            <option value="australian_drivers_licence" data-points="40" {{ ($id['identification_type'] ?? '') == 'australian_drivers_licence' ? 'selected' : '' }}>Australian Driver's Licence (40 pts)</option>
                            <option value="passport" data-points="70" {{ ($id['identification_type'] ?? '') == 'passport' ? 'selected' : '' }}>Passport (70 pts)</option>
                            <option value="birth_certificate" data-points="70" {{ ($id['identification_type'] ?? '') == 'birth_certificate' ? 'selected' : '' }}>Birth Certificate (70 pts)</option>
                            <option value="medicare" data-points="25" {{ ($id['identification_type'] ?? '') == 'medicare' ? 'selected' : '' }}>Medicare Card (25 pts)</option>
                            <option value="other" data-points="0" {{ ($id['identification_type'] ?? '') == 'other' ? 'selected' : '' }}>Other (0 pts)</option>
                        </select>
                    </div>
                    
                    <!-- Points Display -->
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Points Value</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg">
                            <span class="text-2xl font-bold text-teal-600 points-display" data-index="{{ $index }}">
                                {{ $id['points'] ?? 0 }}
                            </span>
                            <span class="text-gray-600 ml-1">points</span>
                        </div>
                    </div>
                </div>
                
                <!-- Document Upload -->
                <div class="mt-4">
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        Upload Document <span class="text-red-500">*</span>
                        <x-profile-help-text text="Clear photo or scan of your ID document (PDF, JPG, PNG - Max 10MB)" />
                    </label>
                    <input 
                        type="file" 
                        name="identifications[{{ $index }}][document]"
                        accept=".pdf,.jpg,.jpeg,.png"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100"
                    >
                    <p class="mt-1 text-xs text-gray-500">Max size: 10MB. Accepted: PDF, JPG, PNG</p>
                </div>
                
                <!-- Expiry Date (Optional) -->
                <div class="mt-4">
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        Expiry Date (if applicable)
                        <x-profile-help-text text="For driver's licence and passport" />
                    </label>
                    <input 
                        type="date" 
                        name="identifications[{{ $index }}][expiry_date]"
                        value="{{ $id['expiry_date'] ?? '' }}"
                        min="{{ now()->format('Y-m-d') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                    >
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Add ID Button -->
    <button 
        type="button" 
        onclick="addIdentification()"
        class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-teal-500 hover:text-teal-600 transition flex items-center justify-center gap-2"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Add Another Document
    </button>
    
    <!-- Total Points Tracker -->
    <div class="mt-6 p-6 rounded-xl" id="points-tracker">
        <div class="flex items-center justify-between mb-2">
            <span class="text-lg font-semibold text-gray-900">Total Points:</span>
            <span class="text-4xl font-bold" id="total-points">0</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-4 mt-3">
            <div id="points-progress" class="h-4 rounded-full transition-all duration-500" style="width: 0%"></div>
        </div>
        <p class="text-sm mt-2 text-center" id="points-message">You need at least 80 points</p>
    </div>
    
</x-form-section-card>

<!-- Navigation -->
<div class="flex items-center justify-between mt-6">
    <button type="button" onclick="window.history.back()" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back
    </button>
    
    <button type="submit" id="submit-btn" class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm flex items-center gap-2">
        Save & Continue
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
</div>

<script>
let idIndex = {{ count($identifications) }};

function updatePoints(index) {
    const select = document.querySelector(`select[name="identifications[${index}][identification_type]"]`);
    const selectedOption = select.options[select.selectedIndex];
    const points = parseInt(selectedOption.dataset.points) || 0;
    const pointsDisplay = document.querySelector(`.points-display[data-index="${index}"]`);
    
    if (pointsDisplay) {
        pointsDisplay.textContent = points;
    }
    
    calculateTotalPoints();
}

function calculateTotalPoints() {
    const selects = document.querySelectorAll('.id-type-select');
    let total = 0;
    
    selects.forEach(select => {
        const selectedOption = select.options[select.selectedIndex];
        const points = parseInt(selectedOption.dataset.points) || 0;
        total += points;
    });
    
    const totalDisplay = document.getElementById('total-points');
    const progressBar = document.getElementById('points-progress');
    const message = document.getElementById('points-message');
    const tracker = document.getElementById('points-tracker');
    const submitBtn = document.getElementById('submit-btn');
    
    totalDisplay.textContent = total;
    
    const percentage = Math.min((total / 80) * 100, 100);
    progressBar.style.width = percentage + '%';
    
    if (total >= 80) {
        progressBar.className = 'h-4 rounded-full transition-all duration-500 bg-green-500';
        tracker.className = 'mt-6 p-6 rounded-xl bg-green-50 border-2 border-green-500';
        totalDisplay.className = 'text-4xl font-bold text-green-600';
        message.textContent = '✓ You have enough points!';
        message.className = 'text-sm mt-2 text-center text-green-700 font-semibold';
        submitBtn.disabled = false;
    } else {
        progressBar.className = 'h-4 rounded-full transition-all duration-500 bg-orange-500';
        tracker.className = 'mt-6 p-6 rounded-xl bg-orange-50 border-2 border-orange-300';
        totalDisplay.className = 'text-4xl font-bold text-orange-600';
        message.textContent = `You need ${80 - total} more points to reach 80`;
        message.className = 'text-sm mt-2 text-center text-orange-700';
        submitBtn.disabled = true;
    }
}

function addIdentification() {
    const container = document.getElementById('identification-container');
    const newId = `
        <div class="identification-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="${idIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Document ${idIndex + 1}</h4>
                <button type="button" onclick="removeIdentification(${idIndex})" class="text-red-600 hover:text-red-700 text-sm font-medium">Remove</button>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Document Type <span class="text-red-500">*</span></label>
                    <select name="identifications[${idIndex}][identification_type]" required onchange="updatePoints(${idIndex})" class="id-type-select w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Select document type</option>
                        <option value="australian_drivers_licence" data-points="40">Australian Driver's Licence (40 pts)</option>
                        <option value="passport" data-points="70">Passport (70 pts)</option>
                        <option value="birth_certificate" data-points="70">Birth Certificate (70 pts)</option>
                        <option value="medicare" data-points="25">Medicare Card (25 pts)</option>
                        <option value="other" data-points="0">Other (0 pts)</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Points Value</label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg">
                        <span class="text-2xl font-bold text-teal-600 points-display" data-index="${idIndex}">0</span>
                        <span class="text-gray-600 ml-1">points</span>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <label class="text-sm font-medium text-gray-700 mb-2 block">Upload Document <span class="text-red-500">*</span></label>
                <input type="file" name="identifications[${idIndex}][document]" accept=".pdf,.jpg,.jpeg,.png" required class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>
            <div class="mt-4">
                <label class="text-sm font-medium text-gray-700 mb-2 block">Expiry Date (if applicable)</label>
                <input type="date" name="identifications[${idIndex}][expiry_date]" min="{{ now()->format('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newId);
    idIndex++;
}

function removeIdentification(index) {
    const item = document.querySelector(`.identification-item[data-index="${index}"]`);
    if (item) {
        item.remove();
        calculateTotalPoints();
    }
}

// Calculate on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateTotalPoints();
    
    // Update points when selections change
    document.querySelectorAll('.id-type-select').forEach((select, index) => {
        select.addEventListener('change', () => updatePoints(index));
    });
});
</script>