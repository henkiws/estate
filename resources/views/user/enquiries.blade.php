<x-user-layout title="My Enquiries">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Enquiries</h1>
        <p class="mt-2 text-gray-600">View your property enquiries and responses</p>
    </div>

    @if($enquiries->count() > 0)
        <div class="space-y-4 mb-8">
            @foreach($enquiries as $enquiry)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                            @if($enquiry->property->featuredImage)
                                <img src="{{ Storage::disk('public')->url($enquiry->property->featuredImage->file_path) }}" 
                                     alt="{{ $enquiry->property->short_address }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <a href="{{ route('properties.show', $enquiry->property->property_code) }}" 
                                       class="text-lg font-bold text-gray-900 hover:text-primary">
                                        {{ $enquiry->property->full_address }}
                                    </a>
                                    <p class="text-sm text-gray-600">{{ $enquiry->property->suburb }}, {{ $enquiry->property->state }}</p>
                                </div>
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                    @if($enquiry->status === 'new') bg-blue-100 text-blue-800
                                    @elseif($enquiry->status === 'replied') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($enquiry->status) }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-600 mb-2">
                                <strong>Sent:</strong> {{ $enquiry->created_at->format('M d, Y g:i A') }}
                            </p>

                            <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                                <p class="text-sm font-semibold text-gray-900 mb-2">Your Message:</p>
                                <p class="text-sm text-gray-700">{{ $enquiry->message }}</p>
                            </div>

                            @if($enquiry->agency_reply)
                                <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-sm font-semibold text-green-900">Agency Response:</p>
                                        <p class="text-xs text-green-700">{{ $enquiry->replied_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                    <p class="text-sm text-green-800">{{ $enquiry->agency_reply }}</p>
                                </div>
                            @else
                                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-xl">
                                    <p class="text-sm text-blue-800">Awaiting agency response</p>
                                </div>
                            @endif

                            <div class="mt-4 flex gap-3">
                                <a href="{{ route('properties.show', $enquiry->property->property_code) }}" 
                                   class="px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-xl transition-colors">
                                    View Property
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $enquiries->links() }}
    @else
        <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No enquiries yet</h3>
            <p class="text-gray-600 mb-6">You haven't sent any property enquiries</p>
            <a href="{{ route('properties.index') }}" class="inline-block px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                Browse Properties
            </a>
        </div>
    @endif
</x-user-layout>