<!-- Income Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4" id="income-card">
    
    <!-- Card Header (Always Visible) -->
    <div class="p-6">
        <div class="flex items-start justify-between">
            
            <!-- Left: Icon + Content -->
            <div class="flex items-start gap-4 flex-1">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-teal-500 flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">Current Income</h3>
                    <p class="text-sm text-gray-500 mt-1" id="income-summary">
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
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->incomes && $user->incomes->count() > 0 ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'bg-gray-50 text-gray-700 border border-gray-200' }}" id="income-status">
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
                <div class="flex items-center justify-center w-14 h-14 rounded-full border-4 {{ $user->incomes && $user->incomes->count() > 0 ? 'border-teal-500' : 'border-gray-300' }} bg-white">
                    <span class="text-sm font-bold {{ $user->incomes && $user->incomes->count() > 0 ? 'text-teal-600' : 'text-gray-400' }}" id="income-percentage">
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
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-teal-600 hover:text-teal-700 hover:bg-teal-50 rounded-lg transition"
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
                        <h4 class="text-base font-semibold text-gray-900">Income Sources</h4>
                        <p class="text-sm text-gray-500 mt-1">Tell us about your income sources to demonstrate your ability to pay rent</p>
                    </div>
                    <span class="text-red-500 text-sm font-medium">* Required</span>
                </div>
                
                <div id="income-container">
                    @php
                        $incomes = old('incomes', $user->incomes->toArray() ?: [['source_of_income' => '', 'net_weekly_amount' => '']]);
                    @endphp
                    
                    @foreach($incomes as $index => $income)
                        <div class="income-item p-4 border border-gray-200 rounded-lg mb-4" data-index="{{ $index }}">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-semibold text-gray-900">Income Source {{ $index + 1 }}</h4>
                                @if($index > 0)
                                    <button 
                                        type="button" 
                                        onclick="removeIncome({{ $index }})"
                                        class="text-red-600 hover:text-red-700 text-sm font-medium"
                                    >
                                        Remove
                                    </button>
                                @endif
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- Source of Income -->
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                        Source of Income <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        name="incomes[{{ $index }}][source_of_income]" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
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
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                        Net Weekly Amount <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-3.5 text-gray-500">$</span>
                                        <input 
                                            type="number" 
                                            name="incomes[{{ $index }}][net_weekly_amount]" 
                                            value="{{ $income['net_weekly_amount'] ?? '' }}"
                                            step="0.01"
                                            min="0"
                                            required
                                            onchange="calculateTotal()"
                                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                                            placeholder="0.00"
                                        >
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bank Statement Upload -->
                            <div class="mt-4">
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                    Bank Statement (Optional)
                                </label>
                                <input 
                                    type="file" 
                                    name="incomes[{{ $index }}][bank_statement]"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100"
                                >
                                <p class="mt-1 text-xs text-gray-500">Max size: 10MB. Formats: PDF, JPG, PNG</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Add Income Button -->
                <button 
                    type="button" 
                    onclick="addIncome()"
                    class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-teal-500 hover:text-teal-600 transition flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Another Income Source
                </button>
                
                <!-- Total Income Display -->
                <div class="mt-6 p-4 bg-teal-50 border border-teal-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-gray-900">Total Weekly Income:</span>
                        <span class="text-2xl font-bold text-teal-600" id="total-income">$0.00</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">This helps property managers assess affordability</p>
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
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-teal-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-teal-700 transition shadow-sm flex items-center gap-2"
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
        <div class="income-item p-4 border border-gray-200 rounded-lg mb-4" data-index="${incomeIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Income Source ${incomeIndex + 1}</h4>
                <button type="button" onclick="removeIncome(${incomeIndex})" class="text-red-600 hover:text-red-700 text-sm font-medium">
                    Remove
                </button>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">
                        Source of Income <span class="text-red-500">*</span>
                    </label>
                    <select name="incomes[${incomeIndex}][source_of_income]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
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
                    <label class="text-sm font-medium text-gray-700 mb-2 block">
                        Net Weekly Amount <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-gray-500">$</span>
                        <input type="number" name="incomes[${incomeIndex}][net_weekly_amount]" step="0.01" min="0" required class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="0.00" onchange="calculateTotal()">
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <label class="text-sm font-medium text-gray-700 mb-2 block">Bank Statement (Optional)</label>
                <input type="file" name="incomes[${incomeIndex}][bank_statement]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                <p class="mt-1 text-xs text-gray-500">Max size: 10MB. Formats: PDF, JPG, PNG</p>
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
    // Only calculate if form is visible
    const formDiv = document.getElementById('income-form');
    if (formDiv && !formDiv.classList.contains('hidden')) {
        calculateTotal();
    }
});
</script>