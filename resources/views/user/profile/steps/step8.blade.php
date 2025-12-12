<div class="space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">References</h2>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="has_references" value="1" id="hasReferencesToggle" {{ $references->count() > 0 ? 'checked' : '' }} class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            <span class="ml-3 text-sm font-medium">Add personal references?</span>
        </label>
    </div>

    <div id="referencesSection" style="{{ $references->count() > 0 ? '' : 'display:none;' }}">
        <button type="button" onclick="addReference()" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded-lg">+ Add Reference</button>
        <div id="referencesContainer"></div>
    </div>
</div>

<script>
let referenceIndex = 0;
document.getElementById('hasReferencesToggle').addEventListener('change', function() {
    document.getElementById('referencesSection').style.display = this.checked ? 'block' : 'none';
});

function addReference() {
    const html = `
        <div class="reference-item border rounded-lg p-4 mb-4 bg-gray-50">
            <div class="flex justify-between mb-4">
                <h3 class="font-semibold">Reference ${referenceIndex + 1}</h3>
                <button type="button" onclick="this.closest('.reference-item').remove()" class="text-red-600">Remove</button>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium mb-2">Full Name *</label>
                    <input type="text" name="references[${referenceIndex}][full_name]" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div><label class="block text-sm font-medium mb-2">Relationship *</label>
                    <input type="text" name="references[${referenceIndex}][relationship]" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div><label class="block text-sm font-medium mb-2">Mobile Number *</label>
                    <div class="flex gap-2">
                        <select name="references[${referenceIndex}][mobile_country_code]" required class="w-32 px-4 py-2 border rounded-lg">
                            <option value="+61">🇦🇺 +61</option>
                            <option value="+1">🇺🇸 +1</option>
                            <option value="+44">🇬🇧 +44</option>
                        </select>
                        <input type="text" name="references[${referenceIndex}][mobile_number]" required class="flex-1 px-4 py-2 border rounded-lg">
                    </div>
                </div>
                <div><label class="block text-sm font-medium mb-2">Email *</label>
                    <input type="email" name="references[${referenceIndex}][email]" required class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
        </div>
    `;
    document.getElementById('referencesContainer').insertAdjacentHTML('beforeend', html);
    referenceIndex++;
}
</script>