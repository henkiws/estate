<!-- Income Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4 hover:shadow-md transition-shadow" id="income-card">
    
    <!-- Card Header (Always Visible) -->
    <div class="p-6">
        <div class="flex items-start justify-between">
            
            <!-- Left: Icon + Content -->
            <div class="flex items-start gap-4 flex-1">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-plyform-green/20 to-plyform-mint/30 flex items-center justify-center text-plyform-dark flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-plyform-dark">Current Income</h3>
                    <p class="text-sm text-gray-600 mt-1" id="income-summary">
                        @if($user->incomes && $user->incomes->count() > 0)
                            @php
                                $totalWeekly = $user->incomes->sum('net_weekly_amount');
                                $totalAnnual = $totalWeekly * 52;
                            @endphp
                            ${{ number_format($totalAnnual, 2) }} per annum
                        @else
                            Not completed yet
                        @endif
                    </p>
                    
                    <!-- Status Badge -->
                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->incomes && $user->incomes->count() > 0 ? 'bg-plyform-mint text-plyform-dark border border-plyform-mint' : 'bg-gray-100 text-gray-600 border border-gray-200' }}" id="income-status">
                            @if($user->incomes && $user->incomes->count() > 0)
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
                <div class="flex items-center justify-center w-14 h-14 rounded-full border-4 {{ $user->incomes && $user->incomes->count() > 0 ? 'border-[#5E17EB]' : 'border-gray-300' }} bg-white">
                    <span class="text-xs font-bold {{ $user->incomes && $user->incomes->count() > 0 ? 'text-[#5E17EB]' : 'text-gray-400' }}" id="income-percentage">
                        @if($user->incomes && $user->incomes->count() > 0)
                            100%
                        @else
                            0%
                        @endif
                    </span>
                </div>
                
                <!-- Edit Button -->
                <button 
                    type="button" 
                    onclick="toggleIncome()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-plyform-purple hover:text-plyform-dark hover:bg-plyform-purple/10 rounded-lg transition"
                    id="income-edit-btn"
                >
                    <span>Edit</span>
                    <svg class="w-4 h-4 transition-transform" id="income-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            
        </div>
    </div>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="border-t border-gray-200 bg-gray-50 hidden" id="income-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="3">
            
            <!-- Income Sources Section -->
            <div class="bg-white rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-plyform-dark">Income Sources</h4>
                        <p class="text-sm text-gray-600 mt-1">Tell us about your income sources to demonstrate your ability to pay rent</p>
                    </div>
                    <span class="text-plyform-orange text-sm font-medium">* Required</span>
                </div>
                
                <div id="income-container">
                    @php
                        $incomes = old('incomes', $user->incomes->toArray() ?: [['source_of_income' => '', 'net_weekly_amount' => '', 'bank_statements' => []]]);
                    @endphp
                    
                    @foreach($incomes as $index => $income)
                        <div class="income-item p-4 border border-gray-200 rounded-lg mb-4 hover:border-plyform-mint/50 transition-colors" data-index="{{ $index }}">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-semibold text-plyform-dark">Income Source {{ $index + 1 }}</h4>
                                @if($index > 0)
                                    <button 
                                        type="button" 
                                        onclick="removeIncome({{ $index }})"
                                        class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors"
                                    >
                                        Remove
                                    </button>
                                @endif
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- Source of Income -->
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                        Source of Income <span class="text-plyform-orange">*</span>
                                    </label>
                                    <select 
                                        name="incomes[{{ $index }}][source_of_income]" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                    >
                                        <option value="">Select source</option>
                                        <option value="full_time_employment" {{ ($income['source_of_income'] ?? '') == 'full_time_employment' ? 'selected' : '' }}>Full-time Employment</option>
                                        <option value="part_time_employment" {{ ($income['source_of_income'] ?? '') == 'part_time_employment' ? 'selected' : '' }}>Part-time Employment</option>
                                        <option value="casual_employment" {{ ($income['source_of_income'] ?? '') == 'casual_employment' ? 'selected' : '' }}>Casual Employment</option>
                                        <option value="self_employed" {{ ($income['source_of_income'] ?? '') == 'self_employed' ? 'selected' : '' }}>Self-Employed</option>
                                        <option value="centrelink" {{ ($income['source_of_income'] ?? '') == 'centrelink' ? 'selected' : '' }}>Centrelink</option>
                                        <option value="pension" {{ ($income['source_of_income'] ?? '') == 'pension' ? 'selected' : '' }}>Pension</option>
                                        <option value="investment" {{ ($income['source_of_income'] ?? '') == 'investment' ? 'selected' : '' }}>Investment Income</option>
                                        <option value="savings" {{ ($income['source_of_income'] ?? '') == 'savings' ? 'selected' : '' }}>Savings</option>
                                        <option value="other" {{ ($income['source_of_income'] ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                
                                <!-- Net Weekly Amount -->
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                        Net Weekly Amount <span class="text-plyform-orange">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-3.5 text-gray-500 font-semibold">$</span>
                                        <input 
                                            type="number" 
                                            name="incomes[{{ $index }}][net_weekly_amount]" 
                                            value="{{ $income['net_weekly_amount'] ?? '' }}"
                                            step="0.01"
                                            min="0"
                                            required
                                            onchange="calculateTotal()"
                                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                            placeholder="0.00"
                                        >
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bank Statement Upload (Multiple) -->
                            <div class="mt-4">
                                <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                    Proof you can pay rent
                                    <span class="text-xs text-gray-500 font-normal">- Upload multiple documents</span>
                                </label>
                                <span class="text-xs text-gray-500 font-normal">Attach three recent payslips or other supporting documents. If using bank statements, hide account numbers and any non-income transactions.</span>
                                
                                <div class="space-y-3">
                                    <!-- File Input (Hidden) - Multiple -->
                                    <input 
                                        type="file" 
                                        name="incomes[{{ $index }}][bank_statements][]"
                                        id="income_statements_{{ $index }}"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        multiple
                                        onchange="previewIncomeStatements({{ $index }})"
                                        class="hidden"
                                    >
                                    
                                    <!-- Upload Button -->
                                    <button 
                                        type="button" 
                                        onclick="document.getElementById('income_statements_{{ $index }}').click()"
                                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-green transition-colors text-center cursor-pointer"
                                    >
                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <span class="text-sm text-gray-600">Click to upload bank statements</span>
                                        <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB each) - Multiple files allowed</span>
                                    </button>
                                    
                                    <!-- Preview Container -->
                                    <div id="income_statements_preview_{{ $index }}" class="space-y-2">
                                        @if(isset($income['id']))
                                            @php
                                                $existingStatements = \App\Models\UserIncomeBankStatement::where('user_income_id', $income['id'])->get();
                                            @endphp
                                            @foreach($existingStatements as $statement)
                                                <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3" data-statement-id="{{ $statement->id }}">
                                                    <div class="flex items-center gap-3">
                                                        <!-- File Icon/Thumbnail -->
                                                        @if(in_array(pathinfo($statement->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ Storage::url($statement->file_path) }}" alt="Statement" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                                                        @else
                                                            <div class="w-16 h-16 bg-red-100 rounded-lg border-2 border-red-300 flex items-center justify-center">
                                                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        
                                                        <!-- File Info -->
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-gray-900 truncate">{{ basename($statement->file_path) }}</p>
                                                            <p class="text-xs text-gray-500">Uploaded document</p>
                                                        </div>
                                                        
                                                        <!-- View Button -->
                                                        <a 
                                                            href="{{ Storage::url($statement->file_path) }}" 
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
                                                            onclick="removeExistingStatement({{ $index }}, {{ $statement->id }})"
                                                            class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                                                            title="Remove document"
                                                        >
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <!-- Hidden input to track deletion -->
                                                    <input type="hidden" name="incomes[{{ $index }}][delete_statements][]" value="" class="delete-statement-input">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Max size: 10MB per file. Formats: PDF, JPG, PNG</p>
                            </div>
                            
                            <!-- Hidden input for income ID if updating -->
                            @if(isset($income['id']))
                                <input type="hidden" name="incomes[{{ $index }}][id]" value="{{ $income['id'] }}">
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <!-- Add Income Button -->
                <button 
                    type="button" 
                    onclick="addIncome()"
                    class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-green hover:text-plyform-dark hover:bg-plyform-green/5 transition flex items-center justify-center gap-2 font-medium"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Another Income Source
                </button>
                
                <!-- Total Income Display -->
                <div class="mt-6 p-5 bg-plyform-mint/20 border border-plyform-mint/50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-semibold text-plyform-dark">Total Weekly Income:</span>
                            <p class="text-sm text-gray-600 mt-1">This helps property managers assess affordability</p>
                        </div>
                        <span class="text-3xl font-bold text-plyform-dark" id="total-income">$0.00</span>
                    </div>
                </div>
                
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="toggleIncome()"
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

<script>
let incomeIndex = {{ count($incomes ?? []) }};

function toggleIncome() {
    const formDiv = document.getElementById('income-form');
    const chevron = document.getElementById('income-chevron');
    const editBtn = document.getElementById('income-edit-btn');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
        editBtn.querySelector('span').textContent = 'Close';
        
        // Calculate total on expand
        calculateTotal();
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('income-card').scrollIntoView({ 
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

function addIncome() {
    const container = document.getElementById('income-container');
    const newIncome = `
        <div class="income-item p-4 border border-gray-200 rounded-lg mb-4 hover:border-plyform-mint/50 transition-colors" data-index="${incomeIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-plyform-dark">Income Source ${incomeIndex + 1}</h4>
                <button type="button" onclick="removeIncome(${incomeIndex})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">
                    Remove
                </button>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">
                        Source of Income <span class="text-plyform-orange">*</span>
                    </label>
                    <select name="incomes[${incomeIndex}][source_of_income]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                        <option value="">Select source</option>
                        <option value="full_time_employment">Full-time Employment</option>
                        <option value="part_time_employment">Part-time Employment</option>
                        <option value="casual_employment">Casual Employment</option>
                        <option value="self_employed">Self-Employed</option>
                        <option value="centrelink">Centrelink</option>
                        <option value="pension">Pension</option>
                        <option value="investment">Investment Income</option>
                        <option value="savings">Savings</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">
                        Net Weekly Amount <span class="text-plyform-orange">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-gray-500 font-semibold">$</span>
                        <input type="number" name="incomes[${incomeIndex}][net_weekly_amount]" step="0.01" min="0" required class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="0.00" onchange="calculateTotal()">
                    </div>
                </div>
            </div>
            
            <!-- Bank Statements Upload (Multiple) -->
            <div class="mt-4">
                <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                    Proof you can pay rent
                    <span class="text-xs text-gray-500 font-normal">- Upload multiple documents</span>
                </label>
                <span class="text-xs text-gray-500 font-normal">Attach three recent payslips or other supporting documents. If using bank statements, hide account numbers and any non-income transactions.</span>
                <div class="space-y-3">
                    <input 
                        type="file" 
                        name="incomes[${incomeIndex}][bank_statements][]"
                        id="income_statements_${incomeIndex}"
                        accept=".pdf,.jpg,.jpeg,.png"
                        multiple
                        onchange="previewIncomeStatements(${incomeIndex})"
                        class="hidden"
                    >
                    
                    <button 
                        type="button" 
                        onclick="document.getElementById('income_statements_${incomeIndex}').click()"
                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-green transition-colors text-center cursor-pointer"
                    >
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span class="text-sm text-gray-600">Click to upload bank statements</span>
                        <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB each) - Multiple files allowed</span>
                    </button>
                    
                    <div id="income_statements_preview_${incomeIndex}" class="space-y-2"></div>
                </div>
                <p class="mt-1 text-xs text-gray-500">Max size: 10MB per file. Formats: PDF, JPG, PNG</p>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newIncome);
    incomeIndex++;
    calculateTotal();
}

function removeIncome(index) {
    const item = document.querySelector(`.income-item[data-index="${index}"]`);
    if (item) {
        item.remove();
        calculateTotal();
        // Renumber remaining items
        document.querySelectorAll('.income-item').forEach((el, idx) => {
            el.querySelector('h4').textContent = `Income Source ${idx + 1}`;
        });
    }
}

function calculateTotal() {
    const inputs = document.querySelectorAll('input[name^="incomes"][name$="[net_weekly_amount]"]');
    let total = 0;
    inputs.forEach(input => {
        const value = parseFloat(input.value) || 0;
        total += value;
    });
    const totalElement = document.getElementById('total-income');
    if (totalElement) {
        totalElement.textContent = '$' + total.toFixed(2);
    }
}

// Calculate on page load when form is expanded
document.addEventListener('DOMContentLoaded', function() {
    const formDiv = document.getElementById('income-form');
    if (formDiv && !formDiv.classList.contains('hidden')) {
        calculateTotal();
    }
});

// Preview multiple income statements
function previewIncomeStatements(index) {
    const input = document.getElementById(`income_statements_${index}`);
    const previewContainer = document.getElementById(`income_statements_preview_${index}`);
    
    if (!input || !input.files || input.files.length === 0) {
        return;
    }
    
    // Clear previous new file previews (keep existing ones)
    const newPreviews = previewContainer.querySelectorAll('[data-new-file="true"]');
    newPreviews.forEach(preview => preview.remove());
    
    Array.from(input.files).forEach((file, fileIndex) => {
        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert(`File "${file.name}" is too large. Maximum size is 10MB.`);
            return;
        }
        
        // Validate file type
        const validTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            alert(`File "${file.name}" is not a valid type. Please select PDF, JPG, or PNG.`);
            return;
        }
        
        const fileExtension = file.name.split('.').pop().toLowerCase();
        const isImage = ['jpg', 'jpeg', 'png'].includes(fileExtension);
        const uniqueId = `${index}_${Date.now()}_${fileIndex}`;
        
        if (isImage) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewHTML = `
                    <div class="relative bg-green-50 border-2 border-green-300 rounded-lg p-3" data-new-file="true" data-file-id="${uniqueId}">
                        <div class="flex items-center gap-3">
                            <img src="${e.target.result}" alt="Statement" class="w-16 h-16 object-cover rounded-lg border-2 border-green-400">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                                <p class="text-xs text-green-600 font-medium">New upload • ${(file.size / 1024).toFixed(2)} KB</p>
                            </div>
                            <button 
                                type="button" 
                                onclick="removeNewFilePreview('${uniqueId}', ${index})"
                                class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                                title="Remove file"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
                previewContainer.insertAdjacentHTML('beforeend', previewHTML);
            };
            reader.readAsDataURL(file);
        } else {
            // PDF preview
            const previewHTML = `
                <div class="relative bg-green-50 border-2 border-green-300 rounded-lg p-3" data-new-file="true" data-file-id="${uniqueId}">
                    <div class="flex items-center gap-3">
                        <div class="w-16 h-16 bg-red-100 rounded-lg border-2 border-red-300 flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                            <p class="text-xs text-green-600 font-medium">New upload • ${(file.size / 1024).toFixed(2)} KB</p>
                        </div>
                        <button 
                            type="button" 
                            onclick="removeNewFilePreview('${uniqueId}', ${index})"
                            class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                            title="Remove file"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            previewContainer.insertAdjacentHTML('beforeend', previewHTML);
        }
    });
}

// Remove new file preview
function removeNewFilePreview(fileId, index) {
    const preview = document.querySelector(`[data-file-id="${fileId}"]`);
    if (preview) {
        preview.remove();
    }
    
    // Reset the file input to remove the file
    const input = document.getElementById(`income_statements_${index}`);
    if (input) {
        input.value = '';
    }
}

// Remove existing statement (mark for deletion)
function removeExistingStatement(incomeIndex, statementId) {
    const statementDiv = document.querySelector(`[data-statement-id="${statementId}"]`);
    if (statementDiv) {
        // Mark for deletion by setting the hidden input value
        const deleteInput = statementDiv.querySelector('.delete-statement-input');
        if (deleteInput) {
            deleteInput.value = statementId;
        }
        
        // Visual feedback - fade out
        statementDiv.style.opacity = '0.5';
        statementDiv.style.pointerEvents = 'none';
        
        // Add deleted indicator
        const fileInfo = statementDiv.querySelector('.flex-1.min-w-0 p');
        if (fileInfo) {
            const deletedBadge = document.createElement('p');
            deletedBadge.className = 'text-xs text-red-600 font-medium mt-1';
            deletedBadge.textContent = 'Will be deleted on save';
            fileInfo.appendChild(deletedBadge);
        }
    }
}
</script>