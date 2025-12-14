@extends('layouts.user')

@section('title', 'Complete Your Profile')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Complete Your Profile</h1>
            <p class="mt-2 text-gray-600">Help property managers get to know you better by completing your profile</p>
        </div>
        
        <!-- Step Indicator -->
        <x-step-indicator :currentStep="$currentStep" :totalSteps="10" />
        
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
        
        <!-- Form -->
        <form method="POST" action="{{ route('user.profile.update-step') }}" enctype="multipart/form-data" id="profile-form">
            @csrf
            <input type="hidden" name="current_step" value="{{ $currentStep }}">
            
            <!-- Step Content -->
            <div class="step-content">
                @switch($currentStep)
                    @case(1)
                        @include('user.profile.steps.step-1-personal-details')
                        @break
                    @case(2)
                        @include('user.profile.steps.step-2-introduction')
                        @break
                    @case(3)
                        @include('user.profile.steps.step-3-income')
                        @break
                    @case(4)
                        @include('user.profile.steps.step-4-employment')
                        @break
                    @case(5)
                        @include('user.profile.steps.step-5-pets')
                        @break
                    @case(6)
                        @include('user.profile.steps.step-6-vehicles')
                        @break
                    @case(7)
                        @include('user.profile.steps.step-7-address-history')
                        @break
                    @case(8)
                        @include('user.profile.steps.step-8-references')
                        @break
                    @case(9)
                        @include('user.profile.steps.step-9-identification')
                        @break
                    @case(10)
                        @include('user.profile.steps.step-10-terms')
                        @break
                @endswitch
            </div>
            
        </form>
        
        <!-- Help Card -->
        <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-xl">
            <div class="flex items-start gap-4">
                <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="font-semibold text-blue-900 mb-2">Need Help?</h4>
                    <p class="text-sm text-blue-800 mb-3">
                        Your profile information helps property managers make informed decisions. 
                        All information is securely stored and encrypted.
                    </p>
                    <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700">
                        View FAQs →
                    </a>
                </div>
            </div>
        </div>
        
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/profile-form-interactions.js') }}"></script>
@endpush
@endsection