@extends('layouts.user')

@section('title', 'Your Applications')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Your applications</h1>
            <p class="mt-2 text-gray-600">Manage and track your property applications</p>
        </div>
        
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="mb-6">
                <svg class="w-20 h-20 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No applications yet</h3>
            <p class="text-gray-600 mb-6">You haven't submitted any property applications. Start by completing your profile!</p>
            <div class="flex items-center justify-center gap-4">
                <a href="{{ route('user.profile.complete') }}" class="px-6 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition">
                    Complete Profile
                </a>
                <a href="#" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                    Browse Properties
                </a>
            </div>
        </div>
        
    </div>
</div>
@endsection