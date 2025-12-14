<div class="space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">Employment</h2>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="has_employment" value="1" id="hasEmploymentToggle" 
                   {{ $employments->count() > 0 ? 'checked' : '' }}
                   class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900">Do you have employment references?</span>
        </label>
    </div>

    <div id="employmentSection" style="{{ $employments->count() > 0 ? '' : 'display:none;' }}" class="space-y-4">
        <div class="flex justify-end">
            <button type="button" onclick="addEmployment()" 
                    class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition">
                + Add Employment
            </button>
        </div>

        <div id="employmentContainer">
            @if($employments->count() > 0)
                @foreach($employments as $index => $employment)
                <div class="employment-item border rounded-lg p-4 mb-4 bg-gray-50">
                    <div class="flex justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">Employment {{ $index + 1 }}</h3>
                        <button type="button" onclick="removeEmployment(this)" class="text-red-600 hover:text-red-800 font-medium">Remove</button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                            <input type="text" name="employments[{{ $index }}][company_name]" value="{{ $employment->company_name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Position *</label>
                            <input type="text" name="employments[{{ $index }}][position]" value="{{ $employment->position }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <textarea name="employments[{{ $index }}][address]" required rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ $employment->address }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gross Annual Salary *</label>
                            <div class="flex items-center">
                                <span class="px-3 py-2 bg-gray-200 border border-r-0 border-gray-300 rounded-l-lg">$</span>
                                <input type="number" name="employments[{{ $index }}][gross_annual_salary]" value="{{ $employment->gross_annual_salary }}" step="0.01" required class="flex-1 px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Manager Full Name *</label>
                            <input type="text" name="employments[{{ $index }}][manager_full_name]" value="{{ $employment->manager_full_name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contact Number *</label>
                            <input type="text" name="employments[{{ $index }}][contact_number]" value="{{ $employment->contact_number }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="employments[{{ $index }}][email]" value="{{ $employment->email }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                            <input type="date" name="employments[{{ $index }}][start_date]" value="{{ $employment->start_date->format('Y-m-d') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="employments[{{ $index }}][still_employed]" value="1" onchange="toggleEndDate(this, {{ $index }})" {{ $employment->still_employed ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Still in the job?</span>
                            </label>
                        </div>
                        <div id="endDateField_{{ $index }}" style="{{ $employment->still_employed ? 'display:none;' : '' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-2">When did you finish?</label>
                            <input type="date" name="employments[{{ $index }}][end_date]" value="{{ $employment->end_date ? $employment->end_date->format('Y-m-d') : '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Employment Letter (PDF, JPG, PNG - Max 10MB)</label>
                            <input type="file" name="employments[{{ $index }}][employment_letter]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @if($employment->employment_letter_path)
                                <p class="mt-1 text-sm text-green-600">✓ File uploaded</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Empty state - will be populated by JavaScript -->
            @endif
        </div>
    </div>

    <div id="noEmploymentMessage" style="{{ $employments->count() > 0 ? 'display:none;' : '' }}" class="text-center py-8 text-gray-500">
        <p>Toggle the switch above if you have employment references to add</p>
    </div>
</div>

<script>
let employmentIndex = {{ $employments->count() > 0 ? $employments->count() : 1 }};

document.getElementById('hasEmploymentToggle').addEventListener('change', function() {
    document.getElementById('employmentSection').style.display = this.checked ? 'block' : 'none';
    document.getElementById('noEmploymentMessage').style.display = this.checked ? 'none' : 'block';
});

function addEmployment() {
    const container = document.getElementById('employmentContainer');
    const html = getEmploymentHTML(employmentIndex, null);
    container.insertAdjacentHTML('beforeend', html);
    employmentIndex++;
}

function removeEmployment(btn) {
    const items = document.querySelectorAll('.employment-item');
    if (items.length > 1) {
        btn.closest('.employment-item').remove();
    } else {
        alert('You must have at least one employment record if this section is enabled.');
    }
}

function toggleEndDate(checkbox, index) {
    const endDateField = document.getElementById('endDateField_' + index);
    endDateField.style.display = checkbox.checked ? 'none' : 'block';
}

function getEmploymentHTML(index, employment) {
    return `
        <div class="employment-item border rounded-lg p-4 mb-4 bg-gray-50">
            <div class="flex justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Employment ${index + 1}</h3>
                <button type="button" onclick="removeEmployment(this)" class="text-red-600 hover:text-red-800 font-medium">Remove</button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                    <input type="text" name="employments[${index}][company_name]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Position *</label>
                    <input type="text" name="employments[${index}][position]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                    <textarea name="employments[${index}][address]" required rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gross Annual Salary *</label>
                    <div class="flex items-center">
                        <span class="px-3 py-2 bg-gray-200 border border-r-0 border-gray-300 rounded-l-lg">$</span>
                        <input type="number" name="employments[${index}][gross_annual_salary]" step="0.01" required class="flex-1 px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Manager Full Name *</label>
                    <input type="text" name="employments[${index}][manager_full_name]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Number *</label>
                    <input type="text" name="employments[${index}][contact_number]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="employments[${index}][email]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                    <input type="date" name="employments[${index}][start_date]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="employments[${index}][still_employed]" value="1" onchange="toggleEndDate(this, ${index})" checked class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Still in the job?</span>
                    </label>
                </div>
                <div id="endDateField_${index}" style="display:none;">
                    <label class="block text-sm font-medium text-gray-700 mb-2">When did you finish?</label>
                    <input type="date" name="employments[${index}][end_date]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Employment Letter (PDF, JPG, PNG - Max 10MB)</label>
                    <input type="file" name="employments[${index}][employment_letter]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>
        </div>
    `;
}
</script>