<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900">Current Income</h2>
        <button type="button" onclick="addIncome()" 
                class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition">
            + Add Income
        </button>
    </div>

    <p class="text-gray-600">Please provide details of your current income sources</p>

    <div id="incomeContainer">
        @if($incomes->count() > 0)
            @foreach($incomes as $index => $income)
                <div class="income-item border rounded-lg p-4 mb-4 bg-gray-50" data-index="{{ $index }}">
                    <div class="flex justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Income {{ $index + 1 }}</h3>
                        <button type="button" onclick="removeIncome(this)" class="text-red-600 hover:text-red-800 font-medium">
                            Remove
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Source of Income *</label>
                            <input type="text" name="incomes[{{ $index }}][source_of_income]" 
                                   value="{{ $income->source_of_income }}" required
                                   placeholder="e.g., Full-time employment, Self-employed"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Net Weekly Amount *</label>
                            <div class="flex items-center">
                                <span class="px-3 py-2 bg-gray-200 border border-r-0 border-gray-300 rounded-l-lg text-gray-700">$</span>
                                <input type="number" name="incomes[{{ $index }}][net_weekly_amount]" 
                                       value="{{ $income->net_weekly_amount }}" step="0.01" required
                                       placeholder="0.00"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Approximately ${{ number_format($income->net_weekly_amount * 52, 0) }} per annum</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Attach Bank Statement (PDF, JPG, PNG - Max 10MB)
                        </label>
                        <input type="file" name="incomes[{{ $index }}][bank_statement]" 
                               accept=".pdf,.jpg,.jpeg,.png"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @if($income->bank_statement_path)
                            <p class="mt-1 text-sm text-green-600">✓ File uploaded previously</p>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="income-item border rounded-lg p-4 mb-4 bg-gray-50" data-index="0">
                <div class="flex justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Income 1</h3>
                    <button type="button" onclick="removeIncome(this)" class="text-red-600 hover:text-red-800 font-medium">
                        Remove
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Source of Income *</label>
                        <input type="text" name="incomes[0][source_of_income]" required
                               placeholder="e.g., Full-time employment, Self-employed"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Net Weekly Amount *</label>
                        <div class="flex items-center">
                            <span class="px-3 py-2 bg-gray-200 border border-r-0 border-gray-300 rounded-l-lg text-gray-700">$</span>
                            <input type="number" name="incomes[0][net_weekly_amount]" step="0.01" required
                                   placeholder="0.00"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Attach Bank Statement (PDF, JPG, PNG - Max 10MB)
                    </label>
                    <input type="file" name="incomes[0][bank_statement]" 
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>
        @endif
    </div>
</div>

<script>
let incomeIndex = {{ $incomes->count() > 0 ? $incomes->count() : 1 }};

function addIncome() {
    const container = document.getElementById('incomeContainer');
    const html = `
        <div class="income-item border rounded-lg p-4 mb-4 bg-gray-50" data-index="${incomeIndex}">
            <div class="flex justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Income ${incomeIndex + 1}</h3>
                <button type="button" onclick="removeIncome(this)" class="text-red-600 hover:text-red-800 font-medium">
                    Remove
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Source of Income *</label>
                    <input type="text" name="incomes[${incomeIndex}][source_of_income]" required
                           placeholder="e.g., Full-time employment, Self-employed"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Net Weekly Amount *</label>
                    <div class="flex items-center">
                        <span class="px-3 py-2 bg-gray-200 border border-r-0 border-gray-300 rounded-l-lg text-gray-700">$</span>
                        <input type="number" name="incomes[${incomeIndex}][net_weekly_amount]" step="0.01" required
                               placeholder="0.00"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Attach Bank Statement (PDF, JPG, PNG - Max 10MB)
                </label>
                <input type="file" name="incomes[${incomeIndex}][bank_statement]" 
                       accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    incomeIndex++;
}

function removeIncome(btn) {
    const items = document.querySelectorAll('.income-item');
    if (items.length > 1) {
        btn.closest('.income-item').remove();
    } else {
        alert('You must have at least one income source.');
    }
}
</script>