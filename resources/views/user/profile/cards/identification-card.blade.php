<!-- Identification Card -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card mb-4" id="identification-card">
    
    <!-- Card Header - Collapsible Button (Always Visible) -->
    <button type="button" onclick="toggleIdentification()" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
        <div class="flex items-center gap-3">
            <!-- Status Icon -->
            @php
                $totalPoints = $user->identifications->sum('points') ?? 0;
            @endphp
            <div class="w-8 h-8 rounded-full {{ $totalPoints >= 80 ? 'bg-teal-100' : 'bg-gray-100' }} flex items-center justify-center section-status" id="status_identification">
                @if($totalPoints >= 80)
                    <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                @endif
            </div>
            
            <!-- Title and Summary -->
            <div class="text-left">
                <span class="font-semibold text-gray-900">Identification</span>
                @if($totalPoints >= 80)
                    <span class="text-xs bg-green-200 text-green-600 px-2 py-0.5 rounded-full font-medium">Completed</span>
                @endif
                <p class="text-xs text-gray-500" id="identification-summary">
                    @if($totalPoints > 0)
                        {{ $totalPoints }} ID points
                    @else
                        Not completed yet
                    @endif
                </p>
            </div>
        </div>
        
        <!-- Right Side: Percentage + Chevron -->
        <div class="flex items-center gap-4">
            <!-- Completion Percentage Circle -->
            <div class="flex items-center justify-center w-12 h-12 rounded-full border-3 {{ $totalPoints >= 80 ? 'border-teal-600 bg-teal-50' : 'border-gray-300 bg-gray-50' }}" id="identification-percentage-circle">
                <span class="text-xs font-bold {{ $totalPoints >= 80 ? 'text-teal-600' : 'text-gray-400' }}" id="identification-percentage">
                    @if($totalPoints >= 80)
                        100%
                    @else
                        0%
                    @endif
                </span>
            </div>
            
            <!-- Chevron Icon -->
            <svg class="w-5 h-5 text-gray-400 section-chevron transition-transform" id="identification-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </button>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="section-content hidden px-6 pb-6" id="identification-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="9">
            <input type="hidden" name="mode" value="{{ $mode }}">
            
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
                <div class="p-4 bg-plyform-green/10 border border-plyform-green/30 rounded-lg mb-6">
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
                        <div class="identification-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-green/50 transition-colors" data-index="{{ $index }}">
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
                                        class="id-type-select w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
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
                                    <div class="px-4 py-3 bg-gradient-to-br from-plyform-green/10 to-plyform-mint/10 border border-plyform-green/30 rounded-lg">
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                    placeholder="e.g., ABC123456"
                                >
                            </div>
                            
                            <!-- Document Upload - MULTIPLE FILES -->
                            <div class="mt-4">
                                <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                    Upload Documents <span class="text-plyform-orange">*</span>
                                </label>
                                <div class="space-y-3">
                                    <!-- Hidden File Input (Multiple) -->
                                    <input 
                                        type="file" 
                                        name="identifications[{{ $index }}][documents][]"
                                        id="identification_documents_{{ $index }}"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        multiple
                                        {{ empty($id['document_paths']) ? 'required' : '' }}
                                        onchange="previewIdentificationDocuments({{ $index }})"
                                        class="hidden"
                                    >
                                    
                                    <!-- Preview Container -->
                                    <div id="identification_documents_preview_{{ $index }}" class="space-y-2">
                                        @if(!empty($id['document_paths']))
                                            <!-- EXISTING DOCUMENTS LIST -->
                                            @foreach($id['document_paths'] as $docIndex => $docPath)
                                                @if(Storage::disk('public')->exists($docPath))
                                                    <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3 existing-document" data-doc-index="{{ $docIndex }}">
                                                        <div class="flex items-center gap-3">
                                                            <!-- File Icon/Thumbnail -->
                                                            @if(in_array(pathinfo($docPath, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                                <img src="{{ Storage::url($docPath) }}" alt="ID Document {{ $docIndex + 1 }}" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                                                            @else
                                                                <div class="w-16 h-16 bg-red-100 rounded-lg border-2 border-red-300 flex items-center justify-center">
                                                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                            
                                                            <!-- File Info -->
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-sm font-medium text-gray-900 truncate">{{ basename($docPath) }}</p>
                                                                <p class="text-xs text-gray-500">Document {{ $docIndex + 1 }}</p>
                                                            </div>
                                                            
                                                            <!-- View Button -->
                                                            <a 
                                                                href="{{ Storage::url($docPath) }}" 
                                                                target="_blank"
                                                                class="flex-shrink-0 text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded-lg"
                                                                title="View document"
                                                            >
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                </svg>
                                                            </a>
                                                            
                                                            <!-- Remove Button -->
                                                            <button 
                                                                type="button" 
                                                                onclick="removeExistingIdentificationDocument({{ $index }}, {{ $docIndex }})"
                                                                class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                                                                title="Remove document"
                                                            >
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <!-- Hidden input to track existing document -->
                                                        <input type="hidden" name="identifications[{{ $index }}][existing_documents][]" value="{{ $docPath }}">
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                    
                                    <!-- Upload Button -->
                                    <button 
                                        type="button" 
                                        onclick="document.getElementById('identification_documents_{{ $index }}').click()"
                                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-green transition-colors text-center cursor-pointer"
                                    >
                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <span class="text-sm text-gray-600">Click to upload identification documents</span>
                                        <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB each) - Select multiple files</span>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Upload at least 1 document. You can select multiple files at once (e.g., front and back of license).</p>
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                >
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Add ID Button -->
                <button 
                    type="button" 
                    onclick="addIdentificationItem()"
                    class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-green hover:text-plyform-dark hover:bg-plyform-green/5 transition flex items-center justify-center gap-2 font-medium"
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
                    class="px-8 py-3 bg-gradient-to-r from-plyform-green to-plyform-green text-white font-semibold rounded-lg hover:from-plyform-green/90 hover:to-plyform-green/90 transition shadow-sm flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save And Next
                </button>
            </div>
            
        </form>
    </div>
    
</div>

<!-- ===================== IDENTIFICATION CONFIRM MODAL ===================== -->
<div id="modal-remove-id-document" class="fixed inset-0 z-50 flex items-center justify-center hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('modal-remove-id-document')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden animate-modal-in">
        <div class="h-1.5 w-full bg-gradient-to-r from-orange-400 to-red-400"></div>
        <div class="p-7">
            <div class="flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-full bg-orange-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-center text-gray-900 mb-2">Remove Document?</h3>
            <p class="text-sm text-center text-gray-500 mb-6">This document will be removed from your identification. This action cannot be undone.</p>
            <div class="flex gap-3">
                <button type="button" onclick="closeModal('modal-remove-id-document')" class="flex-1 px-4 py-2.5 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Cancel</button>
                <button type="button" onclick="fireModalCallback('modal-remove-id-document')" class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold text-sm transition shadow-sm">Remove</button>
            </div>
        </div>
    </div>
</div>
<!-- ===================== END MODAL ===================== -->

<style>
/* Skip if already defined by employment-modals.html */
@keyframes modalIn {
    from { opacity: 0; transform: scale(0.92) translateY(16px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}
.animate-modal-in {
    animation: modalIn 0.22s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}
</style>

<script>
    // ── Modal helpers — only define if NOT already loaded by employment-modals ──

// Initialize ID index
var idIndex = {{ count($identifications ?? []) }};

function toggleIdentification() {
    const formDiv = document.getElementById('identification-form');
    const chevron = document.getElementById('identification-chevron');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(90deg)';
        
        // Calculate on expand
        calculateTotalPoints();
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('identification-card')?.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 100);
    } else {
        // Collapse
        formDiv.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
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
        <div class="identification-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-green/50 transition-colors" data-index="${idIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-plyform-dark">Document ${idIndex + 1}</h4>
                <button type="button" onclick="removeIdentificationItem(${idIndex})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">Remove</button>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Document Type <span class="text-plyform-orange">*</span></label>
                    <select name="identifications[${idIndex}][identification_type]" required onchange="updatePoints(${idIndex})" class="id-type-select w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" data-index="${idIndex}">
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
                    <div class="px-4 py-3 bg-gradient-to-br from-plyform-green/10 to-plyform-mint/10 border border-plyform-green/30 rounded-lg">
                        <span class="text-2xl font-bold text-plyform-dark points-display" data-index="${idIndex}">0</span>
                        <span class="text-gray-600 ml-1">points</span>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Document Number (Optional)</label>
                <input type="text" name="identifications[${idIndex}][document_number]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="e.g., ABC123456">
            </div>
            
            <!-- Document Upload - MULTIPLE FILES -->
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Upload Documents <span class="text-plyform-orange">*</span></label>
                <div class="space-y-3">
                    <input 
                        type="file" 
                        name="identifications[${idIndex}][documents][]"
                        id="identification_documents_${idIndex}"
                        accept=".pdf,.jpg,.jpeg,.png"
                        multiple
                        required
                        onchange="previewIdentificationDocuments(${idIndex})"
                        class="hidden"
                    >
                    
                    <div id="identification_documents_preview_${idIndex}" class="space-y-2"></div>
                    
                    <button 
                        type="button" 
                        onclick="document.getElementById('identification_documents_${idIndex}').click()"
                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-green transition-colors text-center cursor-pointer"
                    >
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span class="text-sm text-gray-600">Click to upload identification documents</span>
                        <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB each) - Select multiple files</span>
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500">Upload at least 1 document. You can select multiple files at once (e.g., front and back of license).</p>
            </div>
            
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Expiry Date (if applicable)</label>
                <input type="date" name="identifications[${idIndex}][expiry_date]" min="${today}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
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

// Preview multiple identification documents
function previewIdentificationDocuments(index) {
    const input = document.getElementById(`identification_documents_${index}`);
    const previewContainer = document.getElementById(`identification_documents_preview_${index}`);
    
    if (!input || !input.files || input.files.length === 0) {
        return;
    }
    
    // Clear new previews (keep existing ones)
    const newPreviews = previewContainer.querySelectorAll('.new-document');
    newPreviews.forEach(el => el.remove());
    
    // Process each file
    Array.from(input.files).forEach((file, fileIndex) => {
        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert(`File "${file.name}" is too large. Maximum size is 10MB.`);
            return;
        }
        
        // Validate file type
        const validTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            alert(`File "${file.name}" must be PDF, JPG, or PNG.`);
            return;
        }
        
        const fileExtension = file.name.split('.').pop().toLowerCase();
        const isImage = ['jpg', 'jpeg', 'png'].includes(fileExtension);
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            let thumbnailHtml = '';
            if (isImage) {
                thumbnailHtml = `<img src="${e.target.result}" alt="New document ${fileIndex + 1}" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">`;
            } else {
                thumbnailHtml = `
                    <div class="w-16 h-16 bg-red-100 rounded-lg border-2 border-red-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                `;
            }
            
            const previewHtml = `
                <div class="relative bg-gray-50 border-2 border-green-200 rounded-lg p-3 new-document">
                    <div class="flex items-center gap-3">
                        ${thumbnailHtml}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                            <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
                        </div>
                        <span class="flex-shrink-0 text-xs text-green-600 font-medium bg-green-100 px-2 py-1 rounded">New</span>
                    </div>
                </div>
            `;
            previewContainer.insertAdjacentHTML('beforeend', previewHtml);
        };
        
        reader.readAsDataURL(file);
    });
}

// Remove existing identification document
function removeExistingIdentificationDocument(idIndex, docIndex) {
    openModal('modal-remove-id-document', () => {
        const docDiv = document.querySelector(
            `#identification_documents_preview_${idIndex} .existing-document[data-doc-index="${docIndex}"]`
        );
        if (docDiv) docDiv.remove();
    });
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