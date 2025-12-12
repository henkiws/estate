<div class="space-y-6">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Identification Documents</h2>
    
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-yellow-800">ID Points Required</h3>
                <p class="mt-1 text-sm text-yellow-700">You must supply at least 80 ID Points for your application to be considered.</p>
                <p class="mt-2 text-sm text-yellow-700 font-medium">Current Total: <span id="totalPoints">0</span> points</p>
            </div>
        </div>
    </div>

    <button type="button" onclick="addIdentification()" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded-lg">+ Add ID Document</button>
    <div id="identificationsContainer"></div>
</div>

<script>
let idIndex = 0;
const idPoints = {
    'australian_drivers_licence': 40,
    'passport': 40,
    'birth_certificate': 30,
    'medicare': 20,
    'other': 10
};

function addIdentification() {
    const html = `
        <div class="id-item border rounded-lg p-4 mb-4 bg-gray-50">
            <div class="flex justify-between mb-4">
                <h3 class="font-semibold">ID Document ${idIndex + 1}</h3>
                <button type="button" onclick="removeId(this)" class="text-red-600">Remove</button>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-2">Identification Type *</label>
                    <select name="identifications[${idIndex}][identification_type]" required onchange="updatePoints()" class="id-type w-full px-4 py-2 border rounded-lg">
                        <option value="">Select ID Type</option>
                        <option value="australian_drivers_licence">Australian Drivers Licence (40 points)</option>
                        <option value="passport">Passport (40 points)</option>
                        <option value="birth_certificate">Birth Certificate (30 points)</option>
                        <option value="medicare">Medicare (20 points)</option>
                        <option value="other">Other (10 points)</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium mb-2">Document *</label>
                    <input type="file" name="identifications[${idIndex}][document]" required accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Expiry Date</label>
                    <input type="date" name="identifications[${idIndex}][expiry_date]" class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
        </div>
    `;
    document.getElementById('identificationsContainer').insertAdjacentHTML('beforeend', html);
    idIndex++;
}

function removeId(btn) {
    btn.closest('.id-item').remove();
    updatePoints();
}

function updatePoints() {
    let total = 0;
    document.querySelectorAll('.id-type').forEach(select => {
        if (select.value) {
            total += idPoints[select.value];
        }
    });
    document.getElementById('totalPoints').textContent = total;
}

// Add first ID automatically
if (idIndex === 0) addIdentification();
</script>