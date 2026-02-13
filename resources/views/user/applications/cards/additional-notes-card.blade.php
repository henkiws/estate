<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card mb-4" data-section="additional_notes">
    <button type="button" onclick="toggleSection('additional_notes')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center section-status" id="status_additional_notes">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
            </div>
            <div class="text-left">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-gray-900">Additional information</span>
                    <span class="text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full font-medium">Optional</span>
                </div>
                <p class="text-xs text-gray-500">Notes and special requests</p>
            </div>
        </div>
        <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
    
    <div class="section-content hidden px-6 pb-6">
        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Special Requests</label>
                <textarea 
                    name="special_requests" 
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                    placeholder="e.g., Pet accommodation, parking needs, early move-in..."
                >{{ old('special_requests') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Maximum 1000 characters</p>
            </div>
            
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Additional Notes</label>
                <textarea 
                    name="notes" 
                    rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                    placeholder="Anything else you'd like the property manager to know..."
                >{{ old('notes') }}</textarea>
            </div>
        </div>
    </div>
</div>