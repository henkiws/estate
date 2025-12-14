<div class="space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">Pets</h2>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="has_pets" value="1" id="hasPetsToggle" 
                   {{ $pets->count() > 0 ? 'checked' : '' }}
                   class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900">Do you have pets?</span>
        </label>
    </div>

    <div id="petsSection" style="{{ $pets->count() > 0 ? '' : 'display:none;' }}">
        <button type="button" onclick="addPet()" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Add Pet</button>
        <div id="petsContainer"></div>
    </div>
</div>

<script>
let petIndex = 0;
document.getElementById('hasPetsToggle').addEventListener('change', function() {
    document.getElementById('petsSection').style.display = this.checked ? 'block' : 'none';
});

function addPet() {
    const html = `
        <div class="pet-item border rounded-lg p-4 mb-4 bg-gray-50">
            <div class="flex justify-between mb-4">
                <h3 class="font-semibold">Pet ${petIndex + 1}</h3>
                <button type="button" onclick="this.closest('.pet-item').remove()" class="text-red-600">Remove</button>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium mb-2">Type *</label>
                    <select name="pets[${petIndex}][type]" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="dog">Dog</option>
                        <option value="cat">Cat</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div><label class="block text-sm font-medium mb-2">Breed *</label>
                    <input type="text" name="pets[${petIndex}][breed]" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div><label class="block text-sm font-medium mb-2">Desexed *</label>
                    <select name="pets[${petIndex}][desexed]" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div><label class="block text-sm font-medium mb-2">Size *</label>
                    <select name="pets[${petIndex}][size]" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                    </select>
                </div>
                <div><label class="block text-sm font-medium mb-2">Registration/Microchip Number</label>
                    <input type="text" name="pets[${petIndex}][registration_number]" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div><label class="block text-sm font-medium mb-2">Document</label>
                    <input type="file" name="pets[${petIndex}][document]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
        </div>
    `;
    document.getElementById('petsContainer').insertAdjacentHTML('beforeend', html);
    petIndex++;
}
</script>