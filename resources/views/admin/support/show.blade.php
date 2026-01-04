@extends('layouts.admin')

@section('title', 'Ticket #' . $ticket->ticket_number)

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.support.tickets.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#5E17EB]">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Support Tickets
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
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content - Ticket Thread -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Ticket Header -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="text-lg font-mono text-gray-500">{{ $ticket->ticket_number }}</span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $ticket->status_color }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $ticket->priority_color }}">
                                {{ ucfirst($ticket->priority) }} Priority
                            </span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-{{ $ticket->user_type === 'agency' ? 'blue' : 'teal' }}-100 text-{{ $ticket->user_type === 'agency' ? 'blue' : 'teal' }}-700">
                                {{ ucfirst($ticket->user_type) }}
                            </span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                {{ ucfirst(str_replace('_', ' ', $ticket->category)) }}
                            </span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $ticket->subject }}</h1>
                        
                        <!-- User Info -->
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-[#DDEECD] rounded-full flex items-center justify-center">
                                <span class="text-gray-800 font-bold text-lg">{{ substr($ticket->user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $ticket->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $ticket->user->email }}</p>
                            </div>
                            <div class="text-right text-sm text-gray-500">
                                <p>Created {{ $ticket->created_at->format('M d, Y') }}</p>
                                <p>{{ $ticket->created_at->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Original Message -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-gray-600 font-bold text-sm">{{ substr($ticket->user->name, 0, 1) }}</span>
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
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden {{ $reply->is_staff_reply ? 'border-l-4 border-l-[#5E17EB]' : '' }}">
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 {{ $reply->is_staff_reply ? 'bg-[#5E17EB]' : 'bg-gray-200' }} rounded-full flex items-center justify-center">
                                        @if($reply->is_staff_reply)
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
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
                                                <span class="ml-2 px-2 py-0.5 bg-[#5E17EB] text-white text-xs font-semibold rounded">Staff</span>
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
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Add Staff Reply</h3>
                            <form method="POST" action="{{ route('admin.support.tickets.reply', $ticket) }}" enctype="multipart/form-data">
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
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent @error('message') border-red-500 @enderror"
                                            placeholder="Type your staff response here..."
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
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent"
                                        >
                                        <p class="mt-2 text-sm text-gray-500">Allowed: JPG, PNG, PDF, DOC, DOCX (Max 5MB each)</p>
                                    </div>
                                </div>
                                
                                <div class="mt-6 flex items-center justify-end gap-3">
                                    <a 
                                        href="{{ route('admin.support.tickets.index') }}" 
                                        class="px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                                    >
                                        Back to Tickets
                                    </a>
                                    <button 
                                        type="submit" 
                                        class="px-6 py-2 bg-[#5E17EB] text-white font-semibold rounded-lg hover:bg-[#4c12bc] transition flex items-center gap-2"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        Send Staff Reply
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
                        <p class="text-sm text-gray-500 mt-1">Change status to reopen if needed</p>
                    </div>
                @endif
                
            </div>
            
            <!-- Sidebar - Ticket Management -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
                    
                    <!-- Update Status -->
                    <form method="POST" action="{{ route('admin.support.tickets.update-status', $ticket) }}" class="mb-4">
                        @csrf
                        @method('PATCH')
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <div class="flex gap-2">
                            <select 
                                name="status" 
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent text-sm"
                            >
                                <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="waiting_response" {{ $ticket->status === 'waiting_response' ? 'selected' : '' }}>Waiting Response</option>
                                <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-[#DDEECD] text-gray-800 font-semibold rounded-lg hover:bg-[#E6FF4B] transition text-sm"
                            >
                                Update
                            </button>
                        </div>
                    </form>
                    
                    <!-- Update Priority -->
                    <form method="POST" action="{{ route('admin.support.tickets.update-priority', $ticket) }}" class="mb-4">
                        @csrf
                        @method('PATCH')
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                        <div class="flex gap-2">
                            <select 
                                name="priority" 
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent text-sm"
                            >
                                <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ $ticket->priority === 'urgent' ? 'selected' : '' }}>Urgent</option>
                                <option value="critical" {{ $ticket->priority === 'critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-[#DDEECD] text-gray-800 font-semibold rounded-lg hover:bg-[#E6FF4B] transition text-sm"
                            >
                                Update
                            </button>
                        </div>
                    </form>
                    
                    <!-- Assign to Staff -->
                    <form method="POST" action="{{ route('admin.support.tickets.assign', $ticket) }}">
                        @csrf
                        @method('PATCH')
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assign To</label>
                        <div class="flex gap-2">
                            <select 
                                name="assigned_to" 
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent text-sm"
                            >
                                <option value="">Unassigned</option>
                                @foreach($staffMembers as $staff)
                                    <option value="{{ $staff->id }}" {{ $ticket->assigned_to == $staff->id ? 'selected' : '' }}>
                                        {{ $staff->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-[#DDEECD] text-gray-800 font-semibold rounded-lg hover:bg-[#E6FF4B] transition text-sm"
                            >
                                Assign
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Ticket Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Ticket Information</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-gray-600">Category:</span>
                            <span class="ml-2 font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $ticket->category)) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">User Type:</span>
                            <span class="ml-2 font-semibold text-gray-900">{{ ucfirst($ticket->user_type) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Created:</span>
                            <span class="ml-2 font-semibold text-gray-900">{{ $ticket->created_at->format('M d, Y g:i A') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="ml-2 font-semibold text-gray-900">{{ $ticket->updated_at->format('M d, Y g:i A') }}</span>
                        </div>
                        @if($ticket->resolved_at)
                            <div>
                                <span class="text-gray-600">Resolved:</span>
                                <span class="ml-2 font-semibold text-green-600">{{ $ticket->resolved_at->format('M d, Y g:i A') }}</span>
                            </div>
                        @endif
                        @if($ticket->closed_at)
                            <div>
                                <span class="text-gray-600">Closed:</span>
                                <span class="ml-2 font-semibold text-gray-600">{{ $ticket->closed_at->format('M d, Y g:i A') }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="text-gray-600">Replies:</span>
                            <span class="ml-2 font-semibold text-gray-900">{{ $ticket->replies->count() }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Activity Log -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Recent Activity</h3>
                    
                    <div class="space-y-3">
                        @foreach($ticket->replies->sortByDesc('created_at')->take(5) as $reply)
                            <div class="flex items-start gap-3 text-sm">
                                <div class="w-2 h-2 bg-[#5E17EB] rounded-full mt-1.5 flex-shrink-0"></div>
                                <div class="flex-1">
                                    <p class="text-gray-900">
                                        <span class="font-semibold">{{ $reply->user->name }}</span>
                                        {{ $reply->is_staff_reply ? 'replied (Staff)' : 'replied' }}
                                    </p>
                                    <p class="text-gray-500 text-xs">{{ $reply->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="flex items-start gap-3 text-sm">
                            <div class="w-2 h-2 bg-gray-400 rounded-full mt-1.5 flex-shrink-0"></div>
                            <div class="flex-1">
                                <p class="text-gray-900">
                                    <span class="font-semibold">{{ $ticket->user->name }}</span>
                                    created ticket
                                </p>
                                <p class="text-gray-500 text-xs">{{ $ticket->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
        
    </div>
</div>
@endsection