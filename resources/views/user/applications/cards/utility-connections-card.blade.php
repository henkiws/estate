<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card mb-4" data-section="utility_connections">
    <button type="button" onclick="toggleSection('utility_connections')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center section-status" id="status_utility_connections">
                <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="text-left">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-gray-900">Utility connection service</span>
                    <span class="text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full font-medium">Optional</span>
                </div>
                <p class="text-xs text-gray-500" id="utility-summary">Optional free service</p>
            </div>
        </div>
        <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
    
    <div class="section-content hidden px-6 pb-6">
        
        <!-- Utility Connection Section -->
        <div class="bg-gray-50 rounded-lg p-6 space-y-4">
            <div class="mb-4">
                <h4 class="text-base font-semibold text-plyform-dark">Utility Connections</h4>
                <p class="text-sm text-gray-600 mt-1">This is a free service that connects all your utilities</p>
            </div>
            
            <!-- Info Box -->
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg mb-6">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm text-blue-900 font-medium mb-1">Once we have received this application, we will call you to confirm your details.</p>
                        <p class="text-xs text-blue-800">Direct Connect will make all reasonable efforts to contact you within 24 hours of the nearest working day on receipt of this Application to confirm the information on this Application after signing and sending it to the utility providers. Direct Connect is a utility one stop connection service.</p>
                    </div>
                </div>
            </div>
            
            <!-- Utilities Selection -->
            <div class="bg-white rounded-lg p-5 border-2 border-gray-200">
                <h5 class="text-sm font-semibold text-plyform-dark mb-4">Please tick utilities as required</h5>
                
                <div class="grid md:grid-cols-3 gap-4">
                    
                    <!-- Electricity -->
                    <label class="flex items-center gap-3 cursor-pointer p-4 rounded-lg border-2 border-gray-200 hover:border-plyform-green hover:bg-plyform-green/5 transition-all group">
                        <input 
                            type="checkbox" 
                            name="utility_electricity" 
                            value="1"
                            {{ old('utility_electricity') ? 'checked' : '' }}
                            onchange="updateUtilitySummary()"
                            class="w-6 h-6 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                        >
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-900 group-hover:text-plyform-dark">Electricity</span>
                        </div>
                    </label>
                    
                    <!-- Gas -->
                    <label class="flex items-center gap-3 cursor-pointer p-4 rounded-lg border-2 border-gray-200 hover:border-plyform-green hover:bg-plyform-green/5 transition-all group">
                        <input 
                            type="checkbox" 
                            name="utility_gas" 
                            value="1"
                            {{ old('utility_gas') ? 'checked' : '' }}
                            onchange="updateUtilitySummary()"
                            class="w-6 h-6 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                        >
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-900 group-hover:text-plyform-dark">Gas</span>
                        </div>
                    </label>
                    
                    <!-- Internet -->
                    <label class="flex items-center gap-3 cursor-pointer p-4 rounded-lg border-2 border-gray-200 hover:border-plyform-green hover:bg-plyform-green/5 transition-all group">
                        <input 
                            type="checkbox" 
                            name="utility_internet" 
                            value="1"
                            {{ old('utility_internet') ? 'checked' : '' }}
                            onchange="updateUtilitySummary()"
                            class="w-6 h-6 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                        >
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-900 group-hover:text-plyform-dark">Internet</span>
                        </div>
                    </label>
                    
                </div>
            </div>
            
            <!-- Declaration -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-300">
                <h5 class="text-xs font-bold text-gray-900 mb-2 uppercase">Declaration and Execution</h5>
                <p class="text-xs text-gray-700 leading-relaxed">
                    By signing this application, I/we consent to Direct Connect arranging for the connection and disconnection of the nominated utility services and to providing information contained in this application to utility providers for the purpose acknowledged below. I/we have read, carefully considered the Terms and Conditions of Direct Connect and having read and understood them together with the Privacy Collection Notice set out below, declare that all the information contained in this Application is true and correct and that I/we can pay for, and are legally entitled to enter into a contract for the provision of the information disclosed in this Application to a supplier or potential supplier of the Services in accordance with the Privacy Collection Notice and to obtain any other information necessary in relation to the Services, pursuant to Direct Connect.
                </p>
            </div>
            
        </div>
        
    </div>
</div>

<script>
    // Utility Connection functions
    function updateUtilitySummary() {
        const electricity = document.querySelector('input[name="utility_electricity"]');
        const gas = document.querySelector('input[name="utility_gas"]');
        const internet = document.querySelector('input[name="utility_internet"]');
        const summary = document.getElementById('utility-summary');
        
        if (!summary) return;
        
        const selected = [];
        if (electricity && electricity.checked) selected.push('Electricity');
        if (gas && gas.checked) selected.push('Gas');
        if (internet && internet.checked) selected.push('Internet');
        
        if (selected.length === 0) {
            summary.textContent = 'Optional free service';
        } else {
            summary.textContent = selected.join(', ') + ' selected';
        }
    }

    // Initialize utility summary on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateUtilitySummary();
    });
</script>