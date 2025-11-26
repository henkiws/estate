@extends('layouts.admin')

@section('title', 'Upload Documents - Step 2 of 2')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700">Step {{ $currentStep }} of 2</span>
            <span class="text-sm font-medium text-primary">100% Complete</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-primary h-3 rounded-full transition-all duration-500" style="width: 100%"></div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-xl p-4 animate-slideDown">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-xl p-4 animate-slideDown">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-red-800 font-medium">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        
        <!-- Title -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Upload Required Documents</h1>
            <p class="text-gray-600">Upload all documents to submit your application for admin review</p>
        </div>

        <!-- Upload Progress -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">Document Upload Progress</span>
                <span class="text-sm font-medium {{ $progress >= 100 ? 'text-green-600' : 'text-primary' }}">
                    {{ $uploadedCount }}/{{ $requiredCount }} uploaded ({{ $progress }}%)
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="h-2 rounded-full transition-all duration-500 {{ $progress >= 100 ? 'bg-green-500' : 'bg-blue-500' }}" 
                     style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <!-- Status Alert -->
        @if($progress < 100)
        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-yellow-800 font-semibold mb-1">Documents Required</h3>
                    <p class="text-yellow-700 text-sm">Please upload all {{ $requiredCount }} required documents to submit your application.</p>
                </div>
            </div>
        </div>
        @else
        <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-green-800 font-semibold">All required documents uploaded!</p>
                    <p class="text-green-700 text-sm">You can now submit your application for admin review.</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Documents List -->
        <div class="space-y-6 mb-8">
            @foreach($documents as $doc)
            <div class="border border-gray-200 rounded-xl p-6 hover:border-blue-300 transition-colors">
                <div class="flex items-start gap-4">
                    <!-- Status Icon -->
                    <div class="flex-shrink-0 mt-1">
                        @if($doc->file_path && $doc->status === 'approved')
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        @elseif($doc->file_path && $doc->status === 'pending_review')
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        @elseif($doc->file_path && $doc->status === 'rejected')
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        @else
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        @endif
                    </div>

                    <!-- Document Info -->
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <h3 class="font-semibold text-gray-900">{{ $doc->name }}</h3>
                            @if($doc->is_required)
                            <span class="text-xs px-2 py-0.5 bg-red-100 text-red-700 rounded-full font-medium">Required</span>
                            @endif
                            
                            @if($doc->file_path)
                                @if($doc->status === 'approved')
                                <span class="text-xs px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-medium">✓ Approved</span>
                                @elseif($doc->status === 'pending_review')
                                <span class="text-xs px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full font-medium">⏳ Pending Review</span>
                                @elseif($doc->status === 'rejected')
                                <span class="text-xs px-2 py-0.5 bg-red-100 text-red-700 rounded-full font-medium">✗ Rejected</span>
                                @endif
                            @else
                            <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full font-medium">Not Uploaded</span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 mb-3">{{ $doc->description }}</p>

                        @if($doc->file_path)
                        <!-- Uploaded File Info -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mb-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $doc->file_name }}</p>
                                        <p class="text-xs text-gray-500">Uploaded {{ $doc->uploaded_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @if($doc->status !== 'approved')
                                <form action="{{ route('agency.onboarding.documents.delete', $doc->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Delete this document?')"
                                            class="text-red-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>

                        <!-- Rejection Reason -->
                        @if($doc->status === 'rejected' && $doc->rejection_reason)
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-3">
                            <p class="text-sm font-medium text-red-800 mb-1">Rejection Reason:</p>
                            <p class="text-sm text-red-700">{{ $doc->rejection_reason }}</p>
                        </div>
                        @endif
                        @endif

                        <!-- Upload Form -->
                        @if(!$doc->file_path || $doc->status === 'rejected')
                        <form action="{{ route('agency.onboarding.documents.upload') }}" 
                              method="POST" 
                              enctype="multipart/form-data"
                              class="mt-3">
                            @csrf
                            <input type="hidden" name="document_id" value="{{ $doc->id }}">
                            
                            <div class="flex items-center gap-3">
                                <label class="flex-1 flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-primary hover:bg-blue-50 transition-colors">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700">Choose File</span>
                                    <input type="file" 
                                           name="file" 
                                           accept=".pdf,.jpg,.jpeg,.png" 
                                           required 
                                           class="hidden"
                                           onchange="this.form.querySelector('.file-name').textContent = this.files[0]?.name || 'No file chosen'">
                                </label>
                                <button type="submit" 
                                        class="px-6 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-dark transition-colors">
                                    Upload
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                <span class="file-name">No file chosen</span> • 
                                PDF, JPG, PNG • Max: 5MB
                            </p>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Help Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-blue-800 font-semibold mb-1">After Submission</h3>
                    <p class="text-blue-700 text-sm">Once you submit, our admin team will review your documents. You'll receive an email notification when approved (usually within 24-48 hours). After approval, you can choose your subscription plan and start using the platform!</p>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex gap-4">
            <a href="{{ route('agency.onboarding', ['step' => 1]) }}" 
               class="flex-1 py-4 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors text-center">
                ← Previous
            </a>
            
            @if($progress >= 100)
            <form action="{{ route('agency.onboarding.submit') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" 
                        onclick="return confirm('Submit your application for review? You can still update documents later if needed.')"
                        class="w-full py-4 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors shadow-lg flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Submit for Admin Review
                </button>
            </form>
            @else
            <button disabled 
                    class="flex-1 py-4 bg-gray-300 text-gray-500 font-semibold rounded-xl cursor-not-allowed"
                    title="Please upload all required documents">
                Submit for Admin Review
            </button>
            @endif
        </div>
    </div>
</div>

<style>
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slideDown {
    animation: slideDown 0.3s ease-out;
}
</style>

<script>
// Auto-hide success/error messages
setTimeout(() => {
    const alerts = document.querySelectorAll('.animate-slideDown');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s, transform 0.5s';
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>

@endsection