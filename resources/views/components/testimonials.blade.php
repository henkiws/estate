    <!-- Testimonials Section -->
    <section class="py-24 bg-gradient-to-br from-primary-light to-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 fade-in">What our users say</h2>
            </div>

            <div id="testimonialsSlider" class="relative max-w-4xl mx-auto">
                <!-- Previous Button -->
                <button id="prevBtn" class="absolute left-0 lg:-left-6 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center bg-white rounded-full shadow-md text-primary hover:bg-primary hover:text-white hover:shadow-lg transition-all z-10" aria-label="Previous testimonial">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <!-- Testimonials Track -->
                <div class="overflow-hidden">
                    <div class="testimonials-track flex transition-transform duration-500 ease-out">
                        <!-- Testimonial 1 -->
                        <div class="testimonial-card min-w-full opacity-0 scale-95 transition-all duration-500">
                            <div class="bg-white p-8 lg:p-12 rounded-2xl shadow-lg">
                                <div class="flex gap-1 text-2xl mb-6">
                                    <span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span>
                                </div>
                                <p class="text-xl text-gray-900 mb-8 leading-relaxed">
                                    "Sorted has completely changed how I manage my rental properties. Everything is in one place and so easy to use!"
                                </p>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-primary to-secondary text-white rounded-full font-bold">SJ</div>
                                    <div>
                                        <div class="font-semibold">Sarah Johnson</div>
                                        <div class="text-gray-600 text-sm">Landlord</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 2 -->
                        <div class="testimonial-card min-w-full opacity-0 scale-95 transition-all duration-500">
                            <div class="bg-white p-8 lg:p-12 rounded-2xl shadow-lg">
                                <div class="flex gap-1 text-2xl mb-6">
                                    <span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span>
                                </div>
                                <p class="text-xl text-gray-900 mb-8 leading-relaxed">
                                    "As a tenant, I love being able to report maintenance issues and track them instantly. No more chasing landlords!"
                                </p>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-primary to-secondary text-white rounded-full font-bold">MP</div>
                                    <div>
                                        <div class="font-semibold">Michael Peters</div>
                                        <div class="text-gray-600 text-sm">Tenant</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 3 -->
                        <div class="testimonial-card min-w-full opacity-0 scale-95 transition-all duration-500">
                            <div class="bg-white p-8 lg:p-12 rounded-2xl shadow-lg">
                                <div class="flex gap-1 text-2xl mb-6">
                                    <span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span>
                                </div>
                                <p class="text-xl text-gray-900 mb-8 leading-relaxed">
                                    "Our agency has saved countless hours using Sorted. The platform is intuitive and our clients love it too."
                                </p>
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-primary to-secondary text-white rounded-full font-bold">EW</div>
                                    <div>
                                        <div class="font-semibold">Emma Williams</div>
                                        <div class="text-gray-600 text-sm">Estate Agent</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Next Button -->
                <button id="nextBtn" class="absolute right-0 lg:-right-6 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center bg-white rounded-full shadow-md text-primary hover:bg-primary hover:text-white hover:shadow-lg transition-all z-10" aria-label="Next testimonial">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

            <!-- Slider Dots -->
            <div id="sliderDots" class="flex justify-center gap-2 mt-8">
                <button class="dot w-3 h-3 rounded-full bg-gray-300 transition-all" data-index="0" aria-label="Go to testimonial 1"></button>
                <button class="dot w-3 h-3 rounded-full bg-gray-300 transition-all" data-index="1" aria-label="Go to testimonial 2"></button>
                <button class="dot w-3 h-3 rounded-full bg-gray-300 transition-all" data-index="2" aria-label="Go to testimonial 3"></button>
            </div>
        </div>
    </section>