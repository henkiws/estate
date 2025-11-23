<!-- Hero Section -->
    <section class="relative min-h-screen flex items-center pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden bg-gradient-to-b from-gray-50 to-white">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 -right-48 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
            <div class="absolute top-1/3 -left-48 w-96 h-96 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-1/4 left-1/3 w-96 h-96 bg-pink-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <!-- Hero Content -->
                <div class="space-y-8 animate-fadeInUp">
                    <div class="inline-flex items-center px-4 py-2 bg-primary-light rounded-full">
                        <span class="w-2 h-2 bg-primary rounded-full mr-2 animate-pulse"></span>
                        <span class="text-sm font-medium text-primary">Trusted by 10,000+ users</span>
                    </div>
                    
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl xl:text-8xl font-extrabold leading-none tracking-tight">
                        <span class="block text-gray-900">All your home</span>
                        <span class="block text-gray-900">needs in</span>
                        <span class="block">
                            <span class="text-primary">one</span>
                            <span class="bg-gradient-to-r from-primary via-purple-500 to-pink-500 bg-clip-text text-transparent"> place</span>
                        </span>
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-gray-600 leading-relaxed max-w-2xl">
                        Whether you're a tenant, a landlord or an agent, homes can be hard work. 
                        The bills! The maintenance! Contracts! Admin! Sorted is the only digital 
                        platform that streamlines the entire property lifecycle into one, simple platform
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('login') }}" class="group inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-primary hover:bg-primary-dark rounded-full shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-1 transition-all">
                            Get Started
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                        <a href="#learn-more" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-primary bg-white border-2 border-primary rounded-full hover:bg-primary hover:text-white shadow-md hover:shadow-lg hover:-translate-y-1 transition-all">
                            Learn More
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="flex flex-wrap gap-8 pt-8 border-t border-gray-200">
                        <div>
                            <div class="text-3xl font-bold text-gray-900">10K+</div>
                            <div class="text-sm text-gray-600">Active Users</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gray-900">50K+</div>
                            <div class="text-sm text-gray-600">Properties Managed</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-gray-900">99%</div>
                            <div class="text-sm text-gray-600">Satisfaction Rate</div>
                        </div>
                    </div>
                </div>
                
                <!-- Hero Visual -->
                <div class="relative h-[500px] sm:h-[600px] lg:h-[700px] opacity-0 animate-[fadeIn_1s_ease_0.3s_forwards]">
                    <!-- Main illustration placeholder -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="relative w-full h-full max-w-lg">
                            <!-- Central Device Mockup -->
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-[500px] bg-white rounded-3xl shadow-2xl p-4 border-8 border-gray-900">
                                <div class="w-full h-full bg-gradient-to-br from-primary/10 to-purple-500/10 rounded-2xl flex items-center justify-center">
                                    <div class="text-center p-6">
                                        <div class="w-16 h-16 bg-primary rounded-2xl mx-auto mb-4 flex items-center justify-center">
                                            <span class="text-3xl">🏠</span>
                                        </div>
                                        <div class="text-sm font-semibold text-gray-900 mb-2">Your Dashboard</div>
                                        <div class="text-xs text-gray-600">All in one place</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating Card 1 -->
                            <div class="absolute top-[5%] left-[2%] bg-white p-4 rounded-2xl shadow-xl animate-float max-w-[200px] border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">📱</div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-sm text-gray-900">All in One App</div>
                                        <div class="text-xs text-gray-500">Manage everything</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating Card 2 -->
                            <div class="absolute top-[25%] right-[0%] bg-white p-4 rounded-2xl shadow-xl animate-float-delay-1 max-w-[200px] border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">⚡</div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-sm text-gray-900">Fast Setup</div>
                                        <div class="text-xs text-gray-500">In minutes</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating Card 3 -->
                            <div class="absolute bottom-[8%] left-[5%] bg-white p-4 rounded-2xl shadow-xl animate-float-delay-2 max-w-[200px] border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">🔒</div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-sm text-gray-900">Bank-grade</div>
                                        <div class="text-xs text-gray-500">Security</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating Card 4 -->
                            <div class="absolute bottom-[25%] right-[3%] bg-white p-4 rounded-2xl shadow-xl animate-float max-w-[180px] border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">💰</div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-sm text-gray-900">Save Money</div>
                                        <div class="text-xs text-gray-500">Best rates</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>