<div class="space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">Vehicles</h2>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="has_vehicles" value="1" id="hasVehiclesToggle" {{ $vehicles->count() > 0 ? 'checked' : '' }} class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium">Do you have vehicles?</span>
        </label>
    </div>

    <div id="vehiclesSection" style="{{ $vehicles->count() > 0 ? '' : 'display:none;' }}">
        <button type="button" onclick="addVehicle()" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded-lg">+ Add Vehicle</button>
        <div id="vehiclesContainer"></div>
    </div>
</div>

<script>
let vehicleIndex = 0;
document.getElementById('hasVehiclesToggle').addEventListener('change', function() {
    document.getElementById('vehiclesSection').style.display = this.checked ? 'block' : 'none';
});

function addVehicle() {
    const html = `
        <div class="vehicle-item border rounded-lg p-4 mb-4 bg-gray-50">
            <div class="flex justify-between mb-4">
                <h3 class="font-semibold">Vehicle ${vehicleIndex + 1}</h3>
                <button type="button" onclick="this.closest('.vehicle-item').remove()" class="text-red-600">Remove</button>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium mb-2">Type *</label>
                    <select name="vehicles[${vehicleIndex}][vehicle_type]" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="car">Car</option>
                        <option value="motorcycle">Motorcycle</option>
                    </select>
                </div>
                <div><label class="block text-sm font-medium mb-2">Year *</label>
                    <input type="text" name="vehicles[${vehicleIndex}][year]" required maxlength="4" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div><label class="block text-sm font-medium mb-2">Make *</label>
                    <input type="text" name="vehicles[${vehicleIndex}][make]" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div><label class="block text-sm font-medium mb-2">Model *</label>
                    <input type="text" name="vehicles[${vehicleIndex}][model]" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div><label class="block text-sm font-medium mb-2">State *</label>
                    <input type="text" name="vehicles[${vehicleIndex}][state]" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div><label class="block text-sm font-medium mb-2">Registration Number *</label>
                    <input type="text" name="vehicles[${vehicleIndex}][registration_number]" required class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
        </div>
    `;
    document.getElementById('vehiclesContainer').insertAdjacentHTML('beforeend', html);
    vehicleIndex++;
}
</script>