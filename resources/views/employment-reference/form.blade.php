<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employment Reference Form - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .plyform-green { color: #0d9488; }
        .bg-plyform-green { background-color: #0d9488; }
        .plyform-yellow { color: #E6FF4B; }
        .bg-plyform-yellow { background-color: #E6FF4B; }
        .plyform-purple { color: #5E17EB; }
        .bg-plyform-purple { background-color: #5E17EB; }
        .plyform-orange { color: #FF3600; }
        .bg-plyform-orange { background-color: #FF3600; }
        .plyform-dark { color: #1E1C1C; }
        .bg-plyform-dark { background-color: #1E1C1C; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-plyform-dark text-white py-6">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-2xl font-bold" style="color: #E6FF4B;">{{ config('app.name') }}</h1>
            <p class="text-gray-300 mt-1">Employment Reference Form</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-8">
        <!-- Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Employment Reference Form</h2>
            <p class="text-gray-700 mb-4">You are completing an employment reference for <strong>{{ $user->name }}</strong>.</p>
            
            <!-- Applicant Info -->
            <div class="bg-gray-50 border-l-4 border-plyform-yellow p-4 rounded">
                <p class="text-sm text-gray-700"><strong>Name:</strong> {{ $user->name }}</p>
                <p class="text-sm text-gray-700"><strong>Company:</strong> {{ $employment->company_name }}</p>
                <p class="text-sm text-gray-700"><strong>Job title:</strong> {{ $employment->position }}</p>
                <p class="text-sm text-gray-700"><strong>Starting:</strong> {{ $employment->start_date->format('M Y') }}</p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('employment.reference.submit', $employment->reference_token) }}" class="space-y-6">
            @csrf

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Questions Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Questions</h3>

                <!-- Question 1: Currently Works There -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <label class="block text-sm font-medium text-gray-900 mb-3">
                        Does the applicant currently work at {{ $employment->company_name }}? <span class="text-red-600">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" onclick="selectOption('currently_works_there', 1, this)" 
                            class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('currently_works_there') == '1' ? 'border-plyform-green bg-green-50' : '' }}">
                            Yes
                        </button>
                        <button type="button" onclick="selectOption('currently_works_there', 0, this)"
                            class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('currently_works_there') == '0' ? 'border-plyform-green bg-green-50' : '' }}">
                            No
                        </button>
                    </div>
                    <input type="hidden" name="currently_works_there" id="currently_works_there" value="{{ old('currently_works_there') }}">
                    @error('currently_works_there')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    
                    <div class="mt-3">
                        <button type="button" onclick="toggleComment('current_works_there_comment_section')" class="text-sm text-blue-600 hover:underline">
                            Add comment
                        </button>
                        <div id="current_works_there_comment_section" class="mt-2 {{ old('current_works_there_comment') ? '' : 'hidden' }}">
                            <input type="text" name="current_works_there_comment" value="{{ old('current_works_there_comment') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                placeholder="Add a comment (optional)">
                        </div>
                    </div>
                </div>

                <!-- Question 2: Job Title Correct -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <label class="block text-sm font-medium text-gray-900 mb-3">
                        Is "{{ $employment->position }}" their job description? <span class="text-red-600">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" onclick="selectOption('job_title_correct', 1, this)"
                            class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('job_title_correct') == '1' ? 'border-plyform-green bg-green-50' : '' }}">
                            Yes
                        </button>
                        <button type="button" onclick="selectOption('job_title_correct', 0, this)"
                            class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('job_title_correct') == '0' ? 'border-plyform-green bg-green-50' : '' }}">
                            No
                        </button>
                    </div>
                    <input type="hidden" name="job_title_correct" id="job_title_correct" value="{{ old('job_title_correct') }}">
                    @error('job_title_correct')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    
                    <div class="mt-3">
                        <button type="button" onclick="toggleComment('job_title_comment_section')" class="text-sm text-blue-600 hover:underline">
                            Add comment
                        </button>
                        <div id="job_title_comment_section" class="mt-2 {{ old('job_title_comment') ? '' : 'hidden' }}">
                            <input type="text" name="job_title_comment" value="{{ old('job_title_comment') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                placeholder="Add a comment (optional)">
                        </div>
                    </div>
                </div>

                <!-- Question 3: Employment Type -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <label class="block text-sm font-medium text-gray-900 mb-3">
                        What's their employment type? <span class="text-red-600">*</span>
                    </label>
                    <select name="employment_type" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green">
                        <option value="">Select</option>
                        <option value="full_time" {{ old('employment_type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time" {{ old('employment_type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="casual" {{ old('employment_type') == 'casual' ? 'selected' : '' }}>Casual</option>
                        <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="other" {{ old('employment_type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('employment_type')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    
                    <div class="mt-3">
                        <button type="button" onclick="toggleComment('employment_type_comment_section')" class="text-sm text-blue-600 hover:underline">
                            Add comment
                        </button>
                        <div id="employment_type_comment_section" class="mt-2 {{ old('employment_type_comment') ? '' : 'hidden' }}">
                            <input type="text" name="employment_type_comment" value="{{ old('employment_type_comment') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                placeholder="Add a comment (optional)">
                        </div>
                    </div>
                </div>

                <!-- Question 4: Start Date -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <label class="block text-sm font-medium text-gray-900 mb-3">
                        Did they start working at {{ $employment->company_name }} in {{ $employment->start_date->format('M Y') }}?
                    </label>
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <button type="button" onclick="toggleStartDate(true, this)"
                            class="start-date-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors">
                            Yes
                        </button>
                        <button type="button" onclick="toggleStartDate(false, this)"
                            class="start-date-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors">
                            No
                        </button>
                    </div>
                    
                    <div id="actual_start_date_section" class="mt-3 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Actual start date</label>
                        <input type="date" name="actual_start_date" value="{{ old('actual_start_date') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green">
                    </div>
                    
                    <div class="mt-3">
                        <button type="button" onclick="toggleComment('start_date_comment_section')" class="text-sm text-blue-600 hover:underline">
                            Add comment
                        </button>
                        <div id="start_date_comment_section" class="mt-2 {{ old('start_date_comment') ? '' : 'hidden' }}">
                            <input type="text" name="start_date_comment" value="{{ old('start_date_comment') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                placeholder="Add a comment (optional)">
                        </div>
                    </div>
                </div>

                <!-- Question 5: Annual Income -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <label class="block text-sm font-medium text-gray-900 mb-3">
                        What is the applicant's annual income (after tax)? <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-gray-500">$</span>
                        <input type="number" name="annual_income" value="{{ old('annual_income') }}" required
                            step="0.01" min="0"
                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                            placeholder="Enter amount">
                    </div>
                    @error('annual_income')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    
                    <div class="mt-3">
                        <button type="button" onclick="toggleComment('annual_income_comment_section')" class="text-sm text-blue-600 hover:underline">
                            Add comment
                        </button>
                        <div id="annual_income_comment_section" class="mt-2 {{ old('annual_income_comment') ? '' : 'hidden' }}">
                            <input type="text" name="annual_income_comment" value="{{ old('annual_income_comment') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                placeholder="Add a comment (optional)">
                        </div>
                    </div>
                </div>

                <!-- Question 6: Role Ongoing -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-900 mb-3">
                        Is the applicant's role likely to be ongoing? <span class="text-red-600">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" onclick="selectOption('role_ongoing', 1, this)"
                            class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('role_ongoing') == '1' ? 'border-plyform-green bg-green-50' : '' }}">
                            Yes
                        </button>
                        <button type="button" onclick="selectOption('role_ongoing', 0, this)"
                            class="option-btn border-2 border-gray-300 rounded-lg py-3 px-4 text-center hover:border-plyform-green transition-colors {{ old('role_ongoing') == '0' ? 'border-plyform-green bg-green-50' : '' }}">
                            No
                        </button>
                    </div>
                    <input type="hidden" name="role_ongoing" id="role_ongoing" value="{{ old('role_ongoing') }}">
                    @error('role_ongoing')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    
                    <div class="mt-3">
                        <button type="button" onclick="toggleComment('role_ongoing_comment_section')" class="text-sm text-blue-600 hover:underline">
                            Add comment
                        </button>
                        <div id="role_ongoing_comment_section" class="mt-2 {{ old('role_ongoing_comment') ? '' : 'hidden' }}">
                            <input type="text" name="role_ongoing_comment" value="{{ old('role_ongoing_comment') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                                placeholder="Add a comment (optional)">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Your Details Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hidden">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Your Details</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="referee_name" value="{{ old('referee_name', $employment->manager_full_name) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                            placeholder="Your full name">
                        @error('referee_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-600">*</span>
                        </label>
                        <input type="email" name="referee_email" value="{{ old('referee_email', $employment->email) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                            placeholder="your.email@company.com">
                        @error('referee_email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Your Position/Title <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="referee_position" value="{{ old('referee_position') }}"  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                            placeholder="e.g., HR Manager">
                        @error('referee_position')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Additional Comments (Optional)
                        </label>
                        <textarea name="additional_comments" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green focus:border-plyform-green"
                            placeholder="Any additional information you'd like to provide...">{{ old('additional_comments') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" 
                    class="bg-plyform-green text-white px-8 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                    Submit reference
                </button>
            </div>
        </form>

        <!-- Privacy Notice -->
        <div class="mt-6 text-center text-xs text-gray-500">
            <p>By submitting this form, you confirm that the information provided is accurate.</p>
            <p class="mt-2">
                <a href="{{ config('app.url') }}/privacy" class="text-blue-600 hover:underline">Privacy Policy</a> | 
                <a href="{{ config('app.url') }}/terms" class="text-blue-600 hover:underline">Terms of Use</a>
            </p>
        </div>
    </main>

    <script>
        // Select option for Yes/No questions
        function selectOption(fieldName, value, button) {
            // Update hidden input
            document.getElementById(fieldName).value = value;
            
            // Update button styles
            const container = button.parentElement;
            container.querySelectorAll('.option-btn').forEach(btn => {
                btn.classList.remove('border-plyform-green', 'bg-green-50');
                btn.classList.add('border-gray-300');
            });
            button.classList.remove('border-gray-300');
            button.classList.add('border-plyform-green', 'bg-green-50');
        }

        // Toggle comment section
        function toggleComment(sectionId) {
            const section = document.getElementById(sectionId);
            section.classList.toggle('hidden');
            if (!section.classList.contains('hidden')) {
                section.querySelector('input').focus();
            }
        }

        // Toggle start date input
        function toggleStartDate(isCorrect, button) {
            const container = button.parentElement;
            const dateSection = document.getElementById('actual_start_date_section');
            
            // Update button styles
            container.querySelectorAll('.start-date-btn').forEach(btn => {
                btn.classList.remove('border-plyform-green', 'bg-green-50');
                btn.classList.add('border-gray-300');
            });
            button.classList.remove('border-gray-300');
            button.classList.add('border-plyform-green', 'bg-green-50');
            
            // Show/hide date input
            if (!isCorrect) {
                dateSection.classList.remove('hidden');
            } else {
                dateSection.classList.add('hidden');
                dateSection.querySelector('input').value = '';
            }
        }
    </script>
</body>
</html>