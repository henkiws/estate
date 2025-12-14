<x-form-section-card 
    title="Income Sources" 
    description="Tell us about your income sources to demonstrate your ability to pay rent"
    required>
    
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
                            <x-profile-help-text text="e.g., Full-time employment, Part-time job, Centrelink, Savings, Investment" />
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
                            <x-profile-help-text text="Your income after tax per week (in AUD)" />
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
                        <x-profile-help-text text="Upload recent bank statement as proof of income (PDF, JPG, PNG - Max 10MB)" />
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
    
</x-form-section-card>

<!-- Navigation -->
@php
    $previousStep = max(1, $currentStep - 1);
@endphp

<!-- Navigation Buttons -->
<div class="flex items-center justify-between mt-6">
    @if($currentStep > 1)
        <!-- Back Button (Steps 2-10) -->
        <a href="{{ route('user.profile.complete', ['step' => $previousStep]) }}" 
           class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back
        </a>
    @else
        <!-- Cancel Button (Step 1 only) -->
        <a href="{{ route('user.dashboard') }}" 
           class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Cancel
        </a>
    @endif
    
    <!-- Save & Continue Button (All steps) -->
    <button type="submit" class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm flex items-center gap-2">
        Save & Continue
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
</div>

<script>
let incomeIndex = {{ count($incomes) }};

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
    document.getElementById('total-income').textContent = '$' + total.toFixed(2);
}

// Calculate on page load
document.addEventListener('DOMContentLoaded', calculateTotal);
</script>