@props(['post', 'compact' => false])

@if($compact)
    <!-- Compact Blog Card (for sidebar) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition">
        <span class="inline-block px-2 py-1 bg-{{ $post->category_color }}-100 text-{{ $post->category_color }}-700 text-xs font-semibold rounded mb-2">
            {{ $post->category_icon }} {{ $post->category_display }}
        </span>
        <h4 class="font-bold text-gray-900 mb-2">{{ $post->title }}</h4>
        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $post->excerpt }}</p>
        
        @if($post->content)
            <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center text-sm font-semibold text-teal-600 hover:text-teal-700">
                Read More...
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @endif
    </div>
@else
    <!-- Full Blog Card (with image) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition">
        
        <!-- Image -->
        @if($post->image_url)
            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gradient-to-br from-teal-400 to-blue-500 flex items-center justify-center">
                <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        @endif
        
        <div class="p-6">
            <!-- Category Badge -->
            <span class="inline-block px-3 py-1 bg-{{ $post->category_color }}-100 text-{{ $post->category_color }}-700 text-xs font-semibold rounded-full mb-3">
                {{ $post->category_icon }} {{ $post->category_display }}
            </span>
            
            <!-- Title -->
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $post->title }}</h3>
            
            <!-- Excerpt -->
            <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
            
            <!-- Meta Info -->
            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                <div class="flex items-center gap-4">
                    @if($post->author)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            {{ $post->author->name }}
                        </span>
                    @endif
                    
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        {{ $post->reading_time }} min read
                    </span>
                    
                    @if($post->views_count > 0)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $post->views_count }}
                        </span>
                    @endif
                </div>
                
                <span>{{ $post->published_at->format('M j, Y') }}</span>
            </div>
            
            <!-- Read More Button -->
            @if($post->content)
                <a href="{{ route('blog.show', $post->slug) }}" class="inline-block w-full text-center px-6 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition">
                    Read Article
                </a>
            @endif
        </div>
    </div>
@endif