<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reference Request - Plyform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'plyform-mint': '#DDEECD',
                        'plyform-dark': '#1E1C1C',
                        'plyform-yellow': '#E6FF4B',
                        'plyform-orange': '#FF3600',
                        'plyform-purple': '#5E17EB',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-plyform-mint to-plyform-yellow rounded-t-2xl p-8 text-center">
                <h1 class="text-3xl font-bold text-plyform-dark mb-2">Reference Request</h1>
                <p class="text-plyform-dark/80">for {{ $user->name }}</p>
            </div>
            
            <!-- Form Card -->
            <div class="bg-white shadow-xl rounded-b-2xl p-8">
                
                <!-- Introduction -->
                <div class="mb-8 p-6 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-blue-900 mb-1">Thank you for providing a reference</h3>
                            <p class="text-sm text-blue-800">
                                <strong>{{ $user->name }}</strong> has listed you as a <strong>{{ ucwords(str_replace('_', ' ', $reference->relationship)) }}</strong> 
                                reference for their rental application. Your honest feedback will help property managers make an informed decision. 
                                All information will be kept confidential.
                            </p>
                        </div>
                    </div>
                </div>

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-800">{{ session('error') }}</p>
                    </div>
                @endif
                
                <!-- Form -->
                <form method="POST" action="{{ route('reference.submit', $token) }}" class="space-y-6">
                    @csrf
                    
                    <!-- How Long Known -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            How long have you known {{ $user->name }}? <span class="text-red-600">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="how_long_known" 
                            value="{{ old('how_long_known') }}"
                            placeholder="e.g., 5 years, 2 months"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none"
                        >
                        @error('how_long_known')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Relationship Context -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Please describe your relationship with {{ $user->name }} <span class="text-red-600">*</span>
                        </label>
                        <textarea 
                            name="relationship_context" 
                            rows="4"
                            required
                            placeholder="How do you know them? What is the nature of your relationship?"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none"
                        >{{ old('relationship_context') }}</textarea>
                        @error('relationship_context')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Character Assessment -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            How would you rate {{ $user->name }}'s character? <span class="text-red-600">*</span>
                        </label>
                        <select 
                            name="character_assessment" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none"
                        >
                            <option value="">Select rating</option>
                            <option value="excellent" {{ old('character_assessment') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                            <option value="good" {{ old('character_assessment') == 'good' ? 'selected' : '' }}>Good</option>
                            <option value="fair" {{ old('character_assessment') == 'fair' ? 'selected' : '' }}>Fair</option>
                            <option value="poor" {{ old('character_assessment') == 'poor' ? 'selected' : '' }}>Poor</option>
                        </select>
                        @error('character_assessment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Reliability Assessment -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            How would you rate {{ $user->name }}'s reliability? <span class="text-red-600">*</span>
                        </label>
                        <select 
                            name="reliability_assessment" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none"
                        >
                            <option value="">Select rating</option>
                            <option value="excellent" {{ old('reliability_assessment') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                            <option value="good" {{ old('reliability_assessment') == 'good' ? 'selected' : '' }}>Good</option>
                            <option value="fair" {{ old('reliability_assessment') == 'fair' ? 'selected' : '' }}>Fair</option>
                            <option value="poor" {{ old('reliability_assessment') == 'poor' ? 'selected' : '' }}>Poor</option>
                        </select>
                        @error('reliability_assessment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Would Recommend -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-3">
                            Would you recommend {{ $user->name }} as a tenant? <span class="text-red-600">*</span>
                        </label>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-plyform-purple transition">
                                <input type="radio" name="would_recommend" value="1" {{ old('would_recommend') == '1' ? 'checked' : '' }} required class="w-5 h-5 text-plyform-purple">
                                <span class="ml-3 text-gray-900 font-medium">Yes, I would recommend them</span>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-plyform-purple transition">
                                <input type="radio" name="would_recommend" value="0" {{ old('would_recommend') == '0' ? 'checked' : '' }} required class="w-5 h-5 text-plyform-purple">
                                <span class="ml-3 text-gray-900 font-medium">No, I would not recommend them</span>
                            </label>
                        </div>
                        @error('would_recommend')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Recommendation Reason -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Please explain your recommendation <span class="text-red-600">*</span>
                        </label>
                        <textarea 
                            name="recommendation_reason" 
                            rows="4"
                            required
                            placeholder="Why would or wouldn't you recommend them as a tenant?"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none"
                        >{{ old('recommendation_reason') }}</textarea>
                        @error('recommendation_reason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Additional Comments -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Additional comments (optional)
                        </label>
                        <textarea 
                            name="additional_comments" 
                            rows="3"
                            placeholder="Any other information you'd like to share..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none"
                        >{{ old('additional_comments') }}</textarea>
                        @error('additional_comments')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Name Confirmation -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Please confirm your full name <span class="text-red-600">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="referee_name_confirmation" 
                            value="{{ old('referee_name_confirmation', $reference->full_name) }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none"
                        >
                        @error('referee_name_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button 
                            type="submit" 
                            class="w-full py-4 bg-gradient-to-r from-plyform-purple to-purple-700 text-white font-bold rounded-lg hover:from-plyform-purple/90 hover:to-purple-700/90 transition shadow-lg flex items-center justify-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Submit Reference
                        </button>
                    </div>
                    
                </form>
                
                <!-- Privacy Notice -->
                <div class="mt-8 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <p class="text-xs text-gray-600 text-center">
                        🔒 Your information is secure and will only be used for this rental application. 
                        We respect your privacy and will not share your details with third parties.
                    </p>
                </div>
                
            </div>
            
        </div>
    </div>
    
</body>
</html>