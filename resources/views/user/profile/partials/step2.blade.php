<div class="space-y-6">
    <h2 class="text-xl font-bold text-gray-900 mb-4">Introduction</h2>
    <p class="text-gray-600 mb-4">A little about me...</p>
    
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Please tell us a bit about yourself (optional)
        </label>
        <textarea name="introduction" rows="6" 
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                  placeholder="Tell us about yourself, your lifestyle, hobbies, work, etc...">{{ old('introduction', $profile->introduction) }}</textarea>
        <p class="mt-1 text-sm text-gray-500">Maximum 1000 characters</p>
    </div>
</div>