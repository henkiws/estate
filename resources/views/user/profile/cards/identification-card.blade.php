<!-- Identification Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4 hover:shadow-md transition-shadow" id="identification-card">
    
    <!-- Card Header (Always Visible) -->
    <div class="p-6">
        <div class="flex items-start justify-between">
            
            <!-- Left: Icon + Content -->
            <div class="flex items-start gap-4 flex-1">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-plyform-yellow/20 to-plyform-mint/30 flex items-center justify-center text-plyform-dark flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-plyform-dark">Identification</h3>
                    <p class="text-sm text-gray-600 mt-1" id="identification-summary">
                        @php
                            $totalPoints = $user->identifications->sum('points') ?? 0;
                        @endphp
                        @if($totalPoints > 0)
                            {{ $totalPoints }} ID points
                        @else
                            Not completed yet
                        @endif
                    </p>
                    
                    <!-- Status Badge -->
                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $totalPoints >= 80 ? 'bg-plyform-mint text-plyform-dark border border-plyform-mint' : 'bg-gray-100 text-gray-600 border border-gray-200' }}" id="identification-status">
                            @if($totalPoints >= 80)
                                Complete
                            @else
                                Incomplete
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Right: Completion % + Edit Button -->
            <div class="flex items-start gap-4 ml-4">
                <!-- Completion Percentage -->
                <div class="flex items-center justify-center w-14 h-14 rounded-full border-4 {{ $totalPoints >= 80 ? 'border-plyform-yellow' : 'border-gray-300' }} bg-white">
                    <span class="text-sm font-bold {{ $totalPoints >= 80 ? 'text-plyform-yellow' : 'text-gray-400' }}" id="identification-percentage">
                        @if($totalPoints >= 80)
                            100%
                        @else
                            0%
                        @endif
                    </span>
                </div>
                
                <!-- Edit Button -->
                <button 
                    type="button" 
                    onclick="toggleIdentification()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-plyform-purple hover:text-plyform-dark hover:bg-plyform-purple/10 rounded-lg transition"
                    id="identification-edit-btn"
                >
                    <span>Edit</span>
                    <svg class="w-4 h-4 transition-transform" id="identification-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            
        </div>
    </div>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="border-t border-gray-200 bg-gray-50 hidden" id="identification-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="9">
            
            <!-- Identification Section -->
            <div class="bg-white rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-plyform-dark">Identification Documents</h4>
                        <p class="text-sm text-gray-600 mt-1">Upload identification documents to verify your identity (minimum 80 points required)</p>
                    </div>
                    <span class="text-plyform-orange text-sm font-medium">* Required</span>
                </div>
                
                <!-- Points Information -->
                <div class="p-4 bg-plyform-yellow/10 border border-plyform-yellow/30 rounded-lg mb-6">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-plyform-dark flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-semibold text-plyform-dark mb-2">Document Points System:</h4>
                            <div class="grid md:grid-cols-2 gap-2 text-sm text-gray-700">
                                <div>• Australian Driver's Licence: <strong>40 points</strong></div>
                                <div>• Passport: <strong>70 points</strong></div>
                                <div>• Birth Certificate: <strong>70 points</strong></div>
                                <div>• Medicare Card: <strong>25 points</strong></div>
                            </div>
                            <p class="text-sm text-plyform-dark mt-2">
                                <strong>You need at least 80 points total.</strong> Example: Driver's Licence (40) + Medicare (25) + Birth Certificate (70) = 135 points ✓
                            </p>
                        </div>
                    </div>
                </div>
                
                <div id="identification-container">
                    @php
                        $identifications = old('identifications', $user->identifications->toArray() ?: [['identification_type' => '']]);
                    @endphp
                    
                    @foreach($identifications as $index => $id)
                        <div class="identification-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-yellow/50 transition-colors" data-index="{{ $index }}">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-semibold text-plyform-dark">Document {{ $index + 1 }}</h4>
                                @if($index > 0)
                                    <button 
                                        type="button" 
                                        onclick="removeIdentificationItem({{ $index }})"
                                        class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors"
                                    >
                                        Remove
                                    </button>
                                @endif
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- ID Type -->
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                        Document Type <span class="text-plyform-orange">*</span>
                                    </label>
                                    <select 
                                        name="identifications[{{ $index }}][identification_type]" 
                                        required
                                        onchange="updatePoints({{ $index }})"
                                        class="id-type-select w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all"
                                        data-index="{{ $index }}"
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
                                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Points Value</label>
                                    <div class="px-4 py-3 bg-gradient-to-br from-plyform-yellow/10 to-plyform-mint/10 border border-plyform-yellow/30 rounded-lg">
                                        <span class="text-2xl font-bold text-plyform-dark points-display" data-index="{{ $index }}">
                                            @php
                                                $pointsMap = [
                                                    'australian_drivers_licence' => 40,
                                                    'passport' => 70,
                                                    'birth_certificate' => 70,
                                                    'medicare' => 25,
                                                    'other' => 0
                                                ];
                                                echo $pointsMap[$id['identification_type'] ?? ''] ?? 0;
                                            @endphp
                                        </span>
                                        <span class="text-gray-600 ml-1">points</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Document Number (Optional) -->
                            <div class="mt-4">
                                <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                    Document Number (Optional)
                                </label>
                                <input 
                                    type="text" 
                                    name="identifications[{{ $index }}][document_number]"
                                    value="{{ $id['document_number'] ?? '' }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all"
                                    placeholder="e.g., ABC123456"
                                >
                            </div>
                            
                            <!-- Document Upload -->
                            <div class="mt-4">
                                <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                    Upload Document <span class="text-plyform-orange">*</span>
                                </label>
                                <input 
                                    type="file" 
                                    name="identifications[{{ $index }}][document]"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-plyform-yellow/20 file:text-plyform-dark hover:file:bg-plyform-yellow/30 transition-all"
                                >
                                <p class="mt-1 text-xs text-gray-500">Max size: 10MB. Accepted: PDF, JPG, PNG</p>
                                @if(isset($id['document_path']))
                                    <p class="mt-1 text-xs text-green-600 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Document already uploaded
                                    </p>
                                @endif
                            </div>
                            
                            <!-- Expiry Date (Optional) -->
                            <div class="mt-4">
                                <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                    Expiry Date (if applicable)
                                </label>
                                <input 
                                    type="date" 
                                    name="identifications[{{ $index }}][expiry_date]"
                                    value="{{ isset($id['expiry_date']) ? \Carbon\Carbon::parse($id['expiry_date'])->format('Y-m-d') : '' }}"
                                    min="{{ now()->format('Y-m-d') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all"
                                >
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Add ID Button -->
                <button 
                    type="button" 
                    onclick="addIdentificationItem()"
                    class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-yellow hover:text-plyform-dark hover:bg-plyform-yellow/5 transition flex items-center justify-center gap-2 font-medium"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Another Document
                </button>
                
                <!-- Total Points Tracker -->
                <div class="mt-6 p-6 rounded-xl" id="points-tracker">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-lg font-semibold text-plyform-dark">Total Points:</span>
                        <span class="text-4xl font-bold" id="total-points">0</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4 mt-3">
                        <div id="points-progress" class="h-4 rounded-full transition-all duration-500 bg-gray-400" style="width: 0%"></div>
                    </div>
                    <p class="text-sm mt-2 text-center font-medium" id="points-message">You need at least 80 points</p>
                </div>
                
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="toggleIdentification()"
                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                >
                    Cancel
                </button>
                
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-plyform-yellow to-plyform-mint text-plyform-dark font-semibold rounded-lg hover:from-plyform-yellow/90 hover:to-plyform-mint/90 transition shadow-sm flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>
            
        </form>
    </div>
    
</div>

<script>
// Initialize ID index
var idIndex = {{ count($identifications ?? []) }};

function toggleIdentification() {
    const formDiv = document.getElementById('identification-form');
    const chevron = document.getElementById('identification-chevron');
    const editBtn = document.getElementById('identification-edit-btn');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
        editBtn.querySelector('span').textContent = 'Close';
        
        // Calculate on expand
        calculateTotalPoints();
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('identification-card').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 100);
    } else {
        // Collapse
        formDiv.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
        editBtn.querySelector('span').textContent = 'Edit';
    }
}

// Update points for specific document
function updatePoints(index) {
    const select = document.querySelector(`select[name="identifications[${index}][identification_type]"]`);
    
    if (!select) return;
    
    const selectedOption = select.options[select.selectedIndex];
    const points = parseInt(selectedOption.dataset.points) || 0;
    const pointsDisplay = document.querySelector(`.points-display[data-index="${index}"]`);
    
    if (pointsDisplay) {
        pointsDisplay.textContent = points;
    }
    
    calculateTotalPoints();
}

// Calculate total points
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
    
    if (!totalDisplay || !progressBar || !message || !tracker) return;
    
    totalDisplay.textContent = total;
    
    const percentage = Math.min((total / 80) * 100, 100);
    progressBar.style.width = percentage + '%';
    
    if (total >= 80) {
        progressBar.className = 'h-4 rounded-full transition-all duration-500 bg-plyform-mint';
        tracker.className = 'mt-6 p-6 rounded-xl bg-plyform-mint/30 border-2 border-plyform-mint';
        totalDisplay.className = 'text-4xl font-bold text-plyform-dark';
        message.textContent = '✓ You have enough points!';
        message.className = 'text-sm mt-2 text-center font-semibold text-plyform-dark';
    } else {
        progressBar.className = 'h-4 rounded-full transition-all duration-500 bg-plyform-orange';
        tracker.className = 'mt-6 p-6 rounded-xl bg-plyform-orange/10 border-2 border-plyform-orange/30';
        totalDisplay.className = 'text-4xl font-bold text-plyform-orange';
        message.textContent = `You need ${80 - total} more points to reach 80`;
        message.className = 'text-sm mt-2 text-center font-medium text-plyform-orange';
    }
}

// Add new identification
function addIdentificationItem() {
    const container = document.getElementById('identification-container');
    
    if (!container) return;
    
    const today = new Date().toISOString().split('T')[0];
    
    const newIdHtml = `
        <div class="identification-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-yellow/50 transition-colors" data-index="${idIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-plyform-dark">Document ${idIndex + 1}</h4>
                <button type="button" onclick="removeIdentificationItem(${idIndex})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">Remove</button>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Document Type <span class="text-plyform-orange">*</span></label>
                    <select name="identifications[${idIndex}][identification_type]" required onchange="updatePoints(${idIndex})" class="id-type-select w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all" data-index="${idIndex}">
                        <option value="">Select document type</option>
                        <option value="australian_drivers_licence" data-points="40">Australian Driver's Licence (40 pts)</option>
                        <option value="passport" data-points="70">Passport (70 pts)</option>
                        <option value="birth_certificate" data-points="70">Birth Certificate (70 pts)</option>
                        <option value="medicare" data-points="25">Medicare Card (25 pts)</option>
                        <option value="other" data-points="0">Other (0 pts)</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Points Value</label>
                    <div class="px-4 py-3 bg-gradient-to-br from-plyform-yellow/10 to-plyform-mint/10 border border-plyform-yellow/30 rounded-lg">
                        <span class="text-2xl font-bold text-plyform-dark points-display" data-index="${idIndex}">0</span>
                        <span class="text-gray-600 ml-1">points</span>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Document Number (Optional)</label>
                <input type="text" name="identifications[${idIndex}][document_number]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all" placeholder="e.g., ABC123456">
            </div>
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Upload Document <span class="text-plyform-orange">*</span></label>
                <input type="file" name="identifications[${idIndex}][document]" accept=".pdf,.jpg,.jpeg,.png" required class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-plyform-yellow/20 file:text-plyform-dark hover:file:bg-plyform-yellow/30 transition-all">
                <p class="mt-1 text-xs text-gray-500">Max size: 10MB. Accepted: PDF, JPG, PNG</p>
            </div>
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Expiry Date (if applicable)</label>
                <input type="date" name="identifications[${idIndex}][expiry_date]" min="${today}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all">
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newIdHtml);

    const newElement = container.lastElementChild;
    if (typeof reinitializePlugins === 'function') {
        reinitializePlugins(newElement);
    }
    
    idIndex++;
}

// Remove identification
function removeIdentificationItem(index) {
    const item = document.querySelector(`.identification-item[data-index="${index}"]`);
    
    if (item) {
        item.remove();
        calculateTotalPoints();
        // Renumber remaining documents
        document.querySelectorAll('.identification-item').forEach((el, idx) => {
            el.querySelector('h4').textContent = `Document ${idx + 1}`;
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateTotalPoints();
    
    // Add change listeners to existing selects
    document.querySelectorAll('.id-type-select').forEach(select => {
        const index = select.dataset.index;
        select.addEventListener('change', () => updatePoints(index));
        
        // Trigger initial calculation if already selected
        if (select.value) {
            updatePoints(index);
        }
    });
});
</script>