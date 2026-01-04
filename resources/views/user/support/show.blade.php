@extends('layouts.user')

@section('title', 'Support Ticket #' . $ticket->ticket_number)

@section('content')
<div class="py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('user.support.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-teal-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Help & Support
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $ticket->ticket_number }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-red-800">{{ session('error') }}</p>
            </div>
        @endif
        
        <!-- Ticket Header Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6">
                <!-- Ticket Info -->
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-lg font-mono text-gray-500">{{ $ticket->ticket_number }}</span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $ticket->status_color }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $ticket->priority_color }}">
                                {{ ucfirst($ticket->priority) }} Priority
                            </span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                {{ ucfirst($ticket->category) }}
                            </span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $ticket->subject }}</h1>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Created {{ $ticket->created_at->format('M d, Y \a\t g:i A') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Updated {{ $ticket->updated_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    @if($ticket->status !== 'closed')
                        <form method="POST" action="{{ route('user.support.close', $ticket) }}" onsubmit="return confirm('Are you sure you want to close this ticket?');">
                            @csrf
                            @method('PATCH')
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                            >
                                Close Ticket
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Original Message -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                            <span class="text-teal-600 font-bold text-sm">{{ substr($ticket->user->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-semibold text-gray-900">{{ $ticket->user->name }}</span>
                            <span class="text-sm text-gray-500">{{ $ticket->created_at->format('M d, Y \a\t g:i A') }}</span>
                        </div>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($ticket->message)) !!}
                        </div>
                        
                        <!-- Attachments -->
                        @if($ticket->attachments->where('reply_id', null)->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Attachments:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($ticket->attachments->where('reply_id', null) as $attachment)
                                        <a 
                                            href="{{ asset('storage/' . $attachment->file_path) }}" 
                                            target="_blank"
                                            class="flex items-center gap-2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition text-sm"
                                        >
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                            </svg>
                                            <span class="text-gray-700">{{ $attachment->original_name }}</span>
                                            <span class="text-gray-500">({{ number_format($attachment->file_size / 1024, 0) }} KB)</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Replies -->
        @foreach($ticket->replies as $reply)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-4 {{ $reply->is_staff_reply ? 'ml-8 border-l-4 border-l-teal-500' : '' }}">
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 {{ $reply->is_staff_reply ? 'bg-teal-500' : 'bg-gray-200' }} rounded-full flex items-center justify-center">
                                @if($reply->is_staff_reply)
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                @else
                                    <span class="text-gray-600 font-bold text-sm">{{ substr($reply->user->name, 0, 1) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="font-semibold text-gray-900">
                                    {{ $reply->user->name }}
                                    @if($reply->is_staff_reply)
                                        <span class="ml-2 px-2 py-0.5 bg-teal-100 text-teal-700 text-xs font-semibold rounded">Support Team</span>
                                    @endif
                                </span>
                                <span class="text-sm text-gray-500">{{ $reply->created_at->format('M d, Y \a\t g:i A') }}</span>
                            </div>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($reply->message)) !!}
                            </div>
                            
                            <!-- Reply Attachments -->
                            @if($ticket->attachments->where('reply_id', $reply->id)->count() > 0)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-sm font-semibold text-gray-700 mb-2">Attachments:</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($ticket->attachments->where('reply_id', $reply->id) as $attachment)
                                            <a 
                                                href="{{ asset('storage/' . $attachment->file_path) }}" 
                                                target="_blank"
                                                class="flex items-center gap-2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition text-sm"
                                            >
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                </svg>
                                                <span class="text-gray-700">{{ $attachment->original_name }}</span>
                                                <span class="text-gray-500">({{ number_format($attachment->file_size / 1024, 0) }} KB)</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
        <!-- Reply Form -->
        @if($ticket->status !== 'closed')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Add a Reply</h3>
                    <form method="POST" action="{{ route('user.support.reply', $ticket) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="space-y-4">
                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                    Your Reply <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    id="message" 
                                    name="message" 
                                    rows="5" 
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('message') border-red-500 @enderror"
                                    placeholder="Type your reply here..."
                                >{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Attachments -->
                            <div>
                                <label for="reply-attachments" class="block text-sm font-medium text-gray-700 mb-2">
                                    Attachments (Optional)
                                </label>
                                <input 
                                    type="file" 
                                    id="reply-attachments" 
                                    name="attachments[]" 
                                    multiple
                                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                >
                                <p class="mt-2 text-sm text-gray-500">Allowed: JPG, PNG, PDF, DOC, DOCX (Max 5MB each)</p>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex items-center justify-end gap-3">
                            <a 
                                href="{{ route('user.support.index') }}" 
                                class="px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                            >
                                Back to Tickets
                            </a>
                            <button 
                                type="submit" 
                                class="px-6 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition flex items-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Send Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <!-- Closed Notice -->
            <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <p class="text-gray-600 font-semibold">This ticket is closed</p>
                <p class="text-sm text-gray-500 mt-1">Create a new ticket if you need further assistance</p>
            </div>
        @endif
        
    </div>
</div>
@endsection