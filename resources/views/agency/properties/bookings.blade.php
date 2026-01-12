@extends('layouts.admin')

@section('title', 'Property Inspection Bookings')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold text-plyform-dark mb-2">Inspection Bookings</h1>
                <p class="text-gray-600">{{ $property->full_address }}</p>
            </div>
            <a href="{{ route('agency.properties.show', $property) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Property
            </a>
        </div>
    </div>

    @if($bookings->count() > 0)
        <!-- Bookings List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-plyform-purple to-plyform-dark text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Applicant</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Contact</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Inspection Date</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-plyform-purple to-plyform-dark rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($booking->user->profile->first_name ?? 'U', 0, 1) }}{{ substr($booking->user->profile->last_name ?? 'N', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-plyform-dark">
                                                {{ $booking->user->profile->first_name ?? 'Unknown' }} {{ $booking->user->profile->last_name ?? 'User' }}
                                            </div>
                                            <div class="text-sm text-gray-500">ID: #{{ $booking->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <div class="text-plyform-dark">{{ $booking->user->email }}</div>
                                        @if($booking->user->profile && $booking->user->profile->mobile_number)
                                            <div class="text-gray-500">{{ $booking->user->profile->mobile_country_code }} {{ $booking->user->profile->mobile_number }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <div class="font-semibold text-plyform-dark">{{ $booking->inspection_date->format('d M Y') }}</div>
                                        <div class="text-gray-500">{{ $booking->inspection_date->format('h:i A') }}</div>
                                        <div class="text-xs text-gray-400 mt-1">{{ $booking->inspection_date->diffForHumans() }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($booking->status === 'completed')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Completed</span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Confirmed</span>
                                    @elseif($booking->status === 'pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Pending</span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Cancelled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600">
                                        {{ $booking->notes ?? '-' }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Inspection Bookings Yet</h3>
            <p class="text-gray-600">This property hasn't received any inspection bookings yet.</p>
        </div>
    @endif

</div>
@endsection