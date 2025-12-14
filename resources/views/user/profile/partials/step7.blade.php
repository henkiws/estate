<div class="space-y-6">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Address History</h2>
    <button type="button" onclick="addAddress()" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded-lg">+ Add Address</button>
    <div id="addressesContainer"></div>
</div>

<script>
let addressIndex = 0;

function addAddress() {
    const html = `
        <div class="address-item border rounded-lg p-4 mb-4 bg-gray-50">
            <div class="flex justify-between mb-4">
                <h3 class="font-semibold">Address ${addressIndex + 1}</h3>
                <button type="button" onclick="this.closest('.address-item').remove()" class="text-red-600">Remove</button>
            </div>
            <div class="space-y-4">
                <div><label class="block text-sm font-medium mb-2">Living Arrangement *</label>
                    <select name="addresses[${addressIndex}][living_arrangement]" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="owner">I'm the owner</option>
                        <option value="renting_agent">Renting through an agent</option>
                        <option value="renting_privately">Renting privately</option>
                        <option value="with_parents">With parents</option>
                        <option value="sharing">Sharing</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div><label class="block text-sm font-medium mb-2">Address *</label>
                    <textarea name="addresses[${addressIndex}][address]" required rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium mb-2">Years Lived *</label>
                        <input type="number" name="addresses[${addressIndex}][years_lived]" required min="0" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <div><label class="block text-sm font-medium mb-2">Months Lived *</label>
                        <input type="number" name="addresses[${addressIndex}][months_lived]" required min="0" max="11" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                </div>
                <div><label class="block text-sm font-medium mb-2">Reason for Leaving</label>
                    <textarea name="addresses[${addressIndex}][reason_for_leaving]" rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="addresses[${addressIndex}][different_postal_address]" value="1" onchange="togglePostal(this, ${addressIndex})" class="w-4 h-4 text-blue-600 rounded">
                        <span class="ml-2 text-sm">Different postal address?</span>
                    </label>
                </div>
                <div id="postalField_${addressIndex}" style="display:none;">
                    <label class="block text-sm font-medium mb-2">Postal Code</label>
                    <input type="text" name="addresses[${addressIndex}][postal_code]" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="addresses[${addressIndex}][is_current]" value="1" class="w-4 h-4 text-blue-600 rounded">
                        <span class="ml-2 text-sm">This is my current address</span>
                    </label>
                </div>
            </div>
        </div>
    `;
    document.getElementById('addressesContainer').insertAdjacentHTML('beforeend', html);
    addressIndex++;
}

function togglePostal(checkbox, index) {
    document.getElementById('postalField_' + index).style.display = checkbox.checked ? 'block' : 'none';
}

// Add first address automatically
if (addressIndex === 0) addAddress();
</script>