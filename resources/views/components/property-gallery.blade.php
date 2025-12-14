@props(['images'])

<div class="property-gallery">
    @if($images->count() > 0)
        <!-- Main Image Display -->
        <div class="relative bg-black rounded-xl overflow-hidden" style="height: 500px;">
            <img 
                id="main-gallery-image"
                src="{{ Storage::url($images->first()->image_path) }}" 
                alt="Property Image"
                class="w-full h-full object-contain"
            >
            
            <!-- Navigation Arrows -->
            @if($images->count() > 1)
                <button 
                    onclick="previousImage()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/90 hover:bg-white rounded-full shadow-lg flex items-center justify-center transition"
                >
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                <button 
                    onclick="nextImage()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/90 hover:bg-white rounded-full shadow-lg flex items-center justify-center transition"
                >
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                
                <!-- Image Counter -->
                <div class="absolute bottom-4 right-4 px-4 py-2 bg-black/70 text-white rounded-full text-sm font-medium">
                    <span id="current-image">1</span> / {{ $images->count() }}
                </div>
            @endif
        </div>
        
        <!-- Thumbnail Grid -->
        @if($images->count() > 1)
            <div class="mt-4 grid grid-cols-6 gap-2" id="thumbnail-grid">
                @foreach($images as $index => $image)
                    <button 
                        onclick="showImage({{ $index }})"
                        class="thumbnail-btn aspect-video rounded-lg overflow-hidden border-2 transition {{ $index === 0 ? 'border-teal-500' : 'border-transparent hover:border-gray-300' }}"
                        data-index="{{ $index }}"
                    >
                        <img 
                            src="{{ Storage::url($image->image_path) }}" 
                            alt="Thumbnail {{ $index + 1 }}"
                            class="w-full h-full object-cover"
                        >
                    </button>
                @endforeach
            </div>
        @endif
        
        <script>
        let currentImageIndex = 0;
        const images = @json($images->map(fn($img) => Storage::url($img->image_path)));
        const totalImages = images.length;
        
        function showImage(index) {
            currentImageIndex = index;
            document.getElementById('main-gallery-image').src = images[index];
            document.getElementById('current-image').textContent = index + 1;
            
            // Update thumbnail borders
            document.querySelectorAll('.thumbnail-btn').forEach((btn, i) => {
                if (i === index) {
                    btn.classList.remove('border-transparent');
                    btn.classList.add('border-teal-500');
                } else {
                    btn.classList.remove('border-teal-500');
                    btn.classList.add('border-transparent');
                }
            });
        }
        
        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % totalImages;
            showImage(currentImageIndex);
        }
        
        function previousImage() {
            currentImageIndex = (currentImageIndex - 1 + totalImages) % totalImages;
            showImage(currentImageIndex);
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') previousImage();
        });
        </script>
    @else
        <div class="w-full h-96 bg-gray-200 rounded-xl flex items-center justify-center">
            <div class="text-center">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-500">No images available</p>
            </div>
        </div>
    @endif
</div>