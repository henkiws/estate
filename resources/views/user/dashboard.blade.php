@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @php
            // Get user's applications
            $applications = auth()->user()->propertyApplications ?? collect();
            $hasApplications = $applications->count() > 0;
            $submittedApplications = $applications->whereIn('status', ['pending', 'under_review', 'approved'])->count();
        @endphp
        
        @if(!$hasApplications)
            {{-- CONDITION 1: NO APPLICATIONS (0) - ORIGINAL DESIGN --}}
            
            <!-- Greeting -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Hi {{ auth()->user()->name }}, Here's what you need to know</h1>
            </div>
            
            <!-- Main Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column (2/3 width) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Welcome Card -->
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl shadow-sm border border-orange-100 overflow-hidden">
                        <div class="grid md:grid-cols-2 gap-6 p-8">
                            <div class="flex flex-col justify-center">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Welcome to Sorted</h2>
                                <p class="text-gray-700 mb-6">Time to get your roommates together and create your first application!</p>
                                <div>
                                    <a href="{{ route('user.profile.complete') }}" class="inline-block px-6 py-3 bg-[#e6ff4b] font-semibold rounded-lg hover:bg-[#ddeecd] transition shadow-sm">
                                        Get Started
                                    </a>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&h=400&fit=crop" alt="Welcome" class="w-full h-64 object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Start Checklist -->
                    @include('user.partials.quick-start-checklist', [
                        'quickStartItems' => [
                            [
                                'title' => 'Complete profile',
                                'completed' => $profileCompletion >= 100,
                                'link' => route('user.profile.complete')
                            ],
                            [
                                'title' => 'Submit your first application',
                                'completed' => false,
                                'link' => route('user.applications.browse')
                            ]
                        ]
                    ])
                    
                    <!-- Application Drafts -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Application drafts</h2>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                            <div class="mb-4">
                                <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-gray-600 mb-4">No drafts to show.</p>
                            <button class="px-6 py-2 text-teal-600 font-medium hover:bg-teal-50 rounded-lg transition">
                                Create New
                            </button>
                        </div>
                    </div>
                    
                    <!-- Getting Started Cards -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Getting started</h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            
                            <!-- Complete Profile Card -->
                            <div class="bg-purple-50 rounded-2xl p-6 border border-purple-100">
                                <div class="mb-4">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Complete your profile</h3>
                                <p class="text-sm text-gray-700 mb-4">Start your application journey by filling out your personal details, such as your date of birth and emergency contact details.</p>
                                <a href="{{ route('user.profile.complete') }}" class="inline-block px-4 py-2 bg-[#e6ff4b] text-black text-sm font-semibold rounded-lg hover:bg-[#ddeecd] transition">
                                    Complete Profile
                                </a>
                            </div>
                            
                            <!-- Complete Income Card -->
                            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                                <div class="mb-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Complete your details</h3>
                                <p class="text-sm text-gray-700 mb-4">Let the person who is reviewing your application know your primary source of income. Not working full time? There are other options to reflect your situation.</p>
                                <a href="{{ route('user.profile.complete') }}" class="inline-block px-4 py-2 bg-[#e6ff4b] text-black text-sm font-semibold rounded-lg hover:bg-[#ddeecd] transition">
                                    Complete Income
                                </a>
                            </div>
                            
                            <!-- Find Property Card -->
                            <div class="bg-white rounded-2xl p-6 border border-gray-200">
                                <div class="mb-4">
                                    <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Find a property</h3>
                                <p class="text-sm text-gray-700 mb-4">Seen a property you like? Search for the address and apply using your Sorted profile</p>
                            </div>
                            
                            <!-- Applications Card -->
                            <div class="bg-white rounded-2xl p-6 border border-gray-200">
                                <div class="mb-4">
                                    <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Sorted Applications</h3>
                                <p class="text-sm text-gray-700 mb-4">You have no current applications</p>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                
                <!-- Right Sidebar (1/3 width) -->
                <div class="space-y-6">
                    
                    <!-- Profile Completion Widget -->
                    @include('user.partials.profile-completion-widget', [
                        'profileCompletion' => $profileCompletion,
                        'steps' => $steps,
                        'idPoints' => $idPoints
                    ])
                    
                    <!-- Boost Profile Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=400&h=250&fit=crop" alt="Boost Profile" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Boost your profile!</h3>
                            <p class="text-sm text-gray-700 mb-4">Stand out from the crowd with a background check</p>
                            <a href="#" class="inline-block px-4 py-2 bg-[#e6ff4b] text-sm font-semibold rounded-lg hover:bg-[#ddeecd] transition">
                                Learn More
                            </a>
                        </div>
                    </div>
                    
                    <!-- Blog Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">From the blog</h3>
                        
                        <!-- Blog Post 1 -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4">
                            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=400&h=200&fit=crop" alt="Blog" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <span class="inline-block px-2 py-1 bg-teal-100 text-teal-700 text-xs font-semibold rounded mb-2">
                                    💡 Good to know
                                </span>
                                <h4 class="font-bold text-gray-900 mb-2">Top 5 tips from property managers</h4>
                                <p class="text-sm text-gray-600 mb-3">Inside advice from Property Managers to consider for your next application ...</p>
                                <a href="#" class="inline-block px-4 py-2 bg-[#e6ff4b] text-black text-sm font-semibold rounded-lg hover:bg-[#ddeecd] transition">
                                    Read More...
                                </a>
                            </div>
                        </div>
                        
                        <!-- Blog Post 2 -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-4">
                            <span class="inline-block px-2 py-1 bg-teal-100 text-teal-700 text-xs font-semibold rounded mb-2">
                                💡 Good to know
                            </span>
                            <h4 class="font-bold text-gray-900 mb-2">Protecting your data</h4>
                            <p class="text-sm text-gray-600">Your data is important to us, and is securely encrypted on our platform.</p>
                        </div>
                        
                        <!-- Blog Post 3 -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                            <span class="inline-block px-2 py-1 bg-teal-100 text-teal-700 text-xs font-semibold rounded mb-2">
                                💡 Good to know
                            </span>
                            <h4 class="font-bold text-gray-900 mb-2">Can I delete my data?</h4>
                            <p class="text-sm text-gray-600">Yes, your data can be deleted, simply start a chat with our friendly team and they will organise it for you.</p>
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            
        @else
            {{-- CONDITION 2: HAS APPLICATIONS (>0) - NEW DESIGN --}}
            
            <!-- Main Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column (2/3 width) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Application Submitted Banner -->
                    <div class="bg-gradient-to-r from-purple-100 to-purple-50 rounded-2xl shadow-sm border border-purple-200 overflow-hidden">
                        <div class="grid md:grid-cols-2 gap-6 p-8">
                            <div class="flex flex-col justify-center">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Application submitted!</h2>
                                <p class="text-gray-700 mb-2">Congratulations, you've submitted your application! Its with the agent for review.</p>
                                <p class="text-gray-700">Take a look below at some things you can do while you wait</p>
                            </div>
                            <div class="hidden md:flex items-center justify-center">
                                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&h=400&fit=crop" alt="Success" class="w-full h-full object-cover rounded-lg">
                            </div>
                        </div>
                    </div>
                    
                    <!-- What you can do while you wait -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4">What you can do while you wait</h2>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                            
                            <!-- Action Item 1 -->
                            <a href="{{ route('user.applications.index') }}" class="flex items-center justify-between p-5 hover:bg-gray-50 transition border-b border-gray-100">
                                <div class="flex items-center gap-4">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex-shrink-0"></div>
                                    <span class="text-gray-700">View or edit your application anytime in your applications</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            
                            <!-- Action Item 2 -->
                            <a href="#" class="flex items-center justify-between p-5 hover:bg-gray-50 transition border-b border-gray-100">
                                <div class="flex items-center gap-4">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex-shrink-0"></div>
                                    <span class="text-gray-700">Check out other properties with our listed partners</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            
                            <!-- Action Item 3 -->
                            <a href="#" class="flex items-center justify-between p-5 hover:bg-gray-50 transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex-shrink-0"></div>
                                    <span class="text-gray-700">Check the Sorted blog for tips on what makes a great rental application</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            
                        </div>
                    </div>
                    
                    <!-- Getting Started Section -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Getting started</h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            
                            <!-- Find a Property Card -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <div class="mb-4">
                                    <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Find a property</h3>
                                <p class="text-sm text-gray-600 mb-4">Seen a property you like? Search for the address and apply using your Sorted profile</p>
                                <a href="#" class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition">
                                    Search Property
                                </a>
                            </div>
                            
                            <!-- Sorted Applications Card -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <div class="mb-4">
                                    <svg class="w-10 h-10 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-3">Sorted Applications</h3>
                                <p class="text-sm text-gray-600 mb-4">You have {{ $submittedApplications }} submitted {{ Str::plural('application', $submittedApplications) }}</p>
                                <a href="{{ route('user.applications.index') }}" class="inline-flex items-center px-5 py-2.5 bg-[#e6ff4b] text-sm font-semibold rounded-lg hover:bg-[#ddeecd] transition">
                                    View Applications
                                </a>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                
                <!-- Right Sidebar (1/3 width) -->
                <div class="space-y-6">
                    
                    <!-- Profile Completion Widget -->
                    @include('user.partials.profile-completion-widget', [
                        'profileCompletion' => $profileCompletion,
                        'steps' => $steps,
                        'idPoints' => $idPoints
                    ])
                    
                    <!-- Boost Profile Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=400&h=250&fit=crop" alt="Boost Profile" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Boost your profile!</h3>
                            <p class="text-sm text-gray-700 mb-4">Stand out from the crowd with a background check</p>
                            <a href="#" class="inline-block px-4 py-2 bg-[#e6ff4b] text-black text-sm font-semibold rounded-lg hover:bg-[#ddeecd] transition">
                                Learn More
                            </a>
                        </div>
                    </div>
                    
                    <!-- Blog Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">From the blog</h3>
                        
                        <!-- Blog Post 1 -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-4">
                            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=400&h=200&fit=crop" alt="Blog" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <span class="inline-block px-2 py-1 bg-teal-100 text-teal-700 text-xs font-semibold rounded mb-2">
                                    💡 Good to know
                                </span>
                                <h4 class="font-bold text-gray-900 mb-2">Top 5 tips from property managers</h4>
                                <p class="text-sm text-gray-600 mb-3">Inside advice from Property Managers to consider for your next application ...</p>
                                <a href="#" class="inline-block px-4 py-2 bg-[#e6ff4b] text-black text-sm font-semibold rounded-lg hover:bg-[#ddeecd] transition">
                                    Read More...
                                </a>
                            </div>
                        </div>
                        
                        <!-- Blog Post 2 -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-4">
                            <span class="inline-block px-2 py-1 bg-teal-100 text-teal-700 text-xs font-semibold rounded mb-2">
                                💡 Good to know
                            </span>
                            <h4 class="font-bold text-gray-900 mb-2">Protecting your data</h4>
                            <p class="text-sm text-gray-600">Your data is important to us, and is securely encrypted on our platform.</p>
                        </div>
                        
                        <!-- Blog Post 3 -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                            <span class="inline-block px-2 py-1 bg-teal-100 text-teal-700 text-xs font-semibold rounded mb-2">
                                💡 Good to know
                            </span>
                            <h4 class="font-bold text-gray-900 mb-2">Can I delete my data?</h4>
                            <p class="text-sm text-gray-600">Yes, your data can be deleted, simply start a chat with our friendly team and they will organise it for you.</p>
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            
        @endif
        
    </div>
</div>
@endsection