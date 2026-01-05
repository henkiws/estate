@extends('layouts.user')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6">Saved Properties</h1>
        
        @if($favorites->count() > 0)
            <div class="grid grid-cols-3 gap-6">
                @foreach($favorites as $favorite)
                    <x-property-card 
                        :property="$favorite->property" 
                        viewMode="grid"
                        :isFavorited="true"
                    />
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $favorites->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Saved Properties</h3>
                <p class="text-gray-500 mb-6">Start browsing to save your favorite properties</p>
                <a href="{{ route('user.applications.browse') }}" class="inline-block px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                    Browse Properties
                </a>
            </div>
        @endif
    </div>
</div>
@endsection