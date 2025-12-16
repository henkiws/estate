<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Sorted')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900">
  @yield('content')

  @stack('scripts')

  <script>
    document.addEventListener('DOMContentLoaded', function() {

        // ==================== Mobile Menu Toggle ====================
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const navMenu = document.getElementById('navMenu');

        mobileMenuToggle.addEventListener('click', () => {
            // Toggle hamburger animation
            const spans = mobileMenuToggle.querySelectorAll('span');
            spans[0].classList.toggle('rotate-45');
            spans[0].classList.toggle('translate-y-2');
            spans[1].classList.toggle('opacity-0');
            spans[2].classList.toggle('-rotate-45');
            spans[2].classList.toggle('-translate-y-2');
            
            // Toggle menu visibility
            navMenu.classList.toggle('translate-x-full');
            document.body.style.overflow = navMenu.classList.contains('translate-x-full') ? '' : 'hidden';
        });

        // Close menu when clicking nav links
        const navLinks = document.querySelectorAll('.nav-links a, #navMenu a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                const spans = mobileMenuToggle.querySelectorAll('span');
                spans[0].classList.remove('rotate-45', 'translate-y-2');
                spans[1].classList.remove('opacity-0');
                spans[2].classList.remove('-rotate-45', '-translate-y-2');
                navMenu.classList.add('translate-x-full');
                document.body.style.overflow = '';
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navMenu.contains(e.target) && 
                !mobileMenuToggle.contains(e.target) && 
                !navMenu.classList.contains('translate-x-full')) {
                const spans = mobileMenuToggle.querySelectorAll('span');
                spans[0].classList.remove('rotate-45', 'translate-y-2');
                spans[1].classList.remove('opacity-0');
                spans[2].classList.remove('-rotate-45', '-translate-y-2');
                navMenu.classList.add('translate-x-full');
                document.body.style.overflow = '';
            }
        });

        
        // ==================== Global Element References ====================
        const layoutMobileMenuToggle = document.getElementById('mobileMenuToggle');
        const layoutNavMenu = document.getElementById('nav-menu');
        const layoutNavbar = document.getElementById('navbar');
        
        // ==================== Mobile Menu Toggle ====================
        if (layoutMobileMenuToggle && layoutNavMenu) {
            layoutMobileMenuToggle.addEventListener('click', () => {
                // Toggle hamburger animation
                const spans = layoutMobileMenuToggle.querySelectorAll('span');
                if (spans.length >= 3) {
                    spans[0].classList.toggle('rotate-45');
                    spans[0].classList.toggle('translate-y-2');
                    spans[1].classList.toggle('opacity-0');
                    spans[2].classList.toggle('-rotate-45');
                    spans[2].classList.toggle('-translate-y-2');
                }
                
                // Toggle menu visibility
                layoutNavMenu.classList.toggle('translate-x-full');
                document.body.style.overflow = layoutNavMenu.classList.contains('translate-x-full') ? '' : 'hidden';
            });

            // Close menu when clicking nav links
            const navLinks = layoutNavMenu.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    const spans = layoutMobileMenuToggle.querySelectorAll('span');
                    if (spans.length >= 3) {
                        spans[0].classList.remove('rotate-45', 'translate-y-2');
                        spans[1].classList.remove('opacity-0');
                        spans[2].classList.remove('-rotate-45', '-translate-y-2');
                    }
                    layoutNavMenu.classList.add('translate-x-full');
                    document.body.style.overflow = '';
                });
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!layoutNavMenu.contains(e.target) && 
                    !layoutMobileMenuToggle.contains(e.target) && 
                    !layoutNavMenu.classList.contains('translate-x-full')) {
                    const spans = layoutMobileMenuToggle.querySelectorAll('span');
                    if (spans.length >= 3) {
                        spans[0].classList.remove('rotate-45', 'translate-y-2');
                        spans[1].classList.remove('opacity-0');
                        spans[2].classList.remove('-rotate-45', '-translate-y-2');
                    }
                    layoutNavMenu.classList.add('translate-x-full');
                    document.body.style.overflow = '';
                }
            });

            // Close mobile menu on Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !layoutNavMenu.classList.contains('translate-x-full')) {
                    const spans = layoutMobileMenuToggle.querySelectorAll('span');
                    if (spans.length >= 3) {
                        spans[0].classList.remove('rotate-45', 'translate-y-2');
                        spans[1].classList.remove('opacity-0');
                        spans[2].classList.remove('-rotate-45', '-translate-y-2');
                    }
                    layoutNavMenu.classList.add('translate-x-full');
                    document.body.style.overflow = '';
                }
            });
        }

        // ==================== Navbar Scroll Behavior ====================
        if (layoutNavbar) {
            let lastScrollY = window.scrollY;
            let ticking = false;

            function updateNavbar() {
                const currentScrollY = window.scrollY;
                
                // Add shadow on scroll
                if (currentScrollY > 50) {
                    layoutNavbar.classList.add('shadow-md');
                } else {
                    layoutNavbar.classList.remove('shadow-md');
                }
                
                // Hide/show navbar on scroll
                if (currentScrollY > lastScrollY && currentScrollY > 200) {
                    layoutNavbar.classList.add('-translate-y-full');
                } else {
                    layoutNavbar.classList.remove('-translate-y-full');
                }
                
                lastScrollY = currentScrollY;
                ticking = false;
            }

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    window.requestAnimationFrame(updateNavbar);
                    ticking = true;
                }
            });
        }

        // ==================== Intersection Observer for Fade-in Animations ====================
        const fadeInElements = document.querySelectorAll('.fade-in');
        
        if (fadeInElements.length > 0) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
            };

            const fadeInObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            fadeInElements.forEach(el => fadeInObserver.observe(el));
        }

        // ==================== Testimonials Slider ====================
        const testimonialsSlider = document.getElementById('testimonialsSlider');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const sliderDots = document.getElementById('sliderDots');
        
        if (testimonialsSlider && prevBtn && nextBtn) {
            const testimonialCards = testimonialsSlider.querySelectorAll('.testimonial-card');
            const dots = sliderDots ? sliderDots.querySelectorAll('.dot') : [];

            if (testimonialCards.length > 0) {
                let currentSlide = 0;
                const totalSlides = testimonialCards.length;
                let autoPlayInterval;

                function updateSlider(index) {
                    // Remove active classes from all cards and dots
                    testimonialCards.forEach(card => {
                        card.classList.remove('opacity-100', 'scale-100');
                        card.classList.add('opacity-0', 'scale-95');
                    });
                    
                    if (dots.length > 0) {
                        dots.forEach(dot => {
                            dot.classList.remove('bg-primary', 'w-8');
                            dot.classList.add('bg-gray-300', 'w-3');
                        });
                    }
                    
                    // Add active classes to current card and dot
                    testimonialCards[index].classList.remove('opacity-0', 'scale-95');
                    testimonialCards[index].classList.add('opacity-100', 'scale-100');
                    
                    if (dots.length > index) {
                        dots[index].classList.remove('bg-gray-300', 'w-3');
                        dots[index].classList.add('bg-primary', 'w-8');
                    }
                    
                    currentSlide = index;
                }

                function nextSlide() {
                    const next = (currentSlide + 1) % totalSlides;
                    updateSlider(next);
                }

                function prevSlide() {
                    const prev = (currentSlide - 1 + totalSlides) % totalSlides;
                    updateSlider(prev);
                }

                // Button event listeners
                nextBtn.addEventListener('click', () => {
                    nextSlide();
                    resetAutoPlay();
                });

                prevBtn.addEventListener('click', () => {
                    prevSlide();
                    resetAutoPlay();
                });

                // Dot navigation
                if (dots.length > 0) {
                    dots.forEach((dot, index) => {
                        dot.addEventListener('click', () => {
                            updateSlider(index);
                            resetAutoPlay();
                        });
                    });
                }

                // Auto-play functionality
                function startAutoPlay() {
                    autoPlayInterval = setInterval(nextSlide, 5000);
                }

                function resetAutoPlay() {
                    if (autoPlayInterval) {
                        clearInterval(autoPlayInterval);
                    }
                    startAutoPlay();
                }

                // Pause auto-play on hover
                testimonialsSlider.addEventListener('mouseenter', () => {
                    if (autoPlayInterval) {
                        clearInterval(autoPlayInterval);
                    }
                });

                testimonialsSlider.addEventListener('mouseleave', () => {
                    startAutoPlay();
                });

                // Keyboard navigation
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') {
                        prevSlide();
                        resetAutoPlay();
                    } else if (e.key === 'ArrowRight') {
                        nextSlide();
                        resetAutoPlay();
                    }
                });

                // Touch/swipe support for mobile
                let touchStartX = 0;
                let touchEndX = 0;

                testimonialsSlider.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX;
                }, { passive: true });

                testimonialsSlider.addEventListener('touchend', (e) => {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                }, { passive: true });

                function handleSwipe() {
                    const swipeThreshold = 50;
                    const diff = touchStartX - touchEndX;
                    
                    if (Math.abs(diff) > swipeThreshold) {
                        if (diff > 0) {
                            nextSlide();
                        } else {
                            prevSlide();
                        }
                        resetAutoPlay();
                    }
                }

                // Initialize first slide as active
                updateSlider(0);

                // Start auto-play on page load
                startAutoPlay();
            }
        }

        // ==================== Smooth Scroll for Anchor Links ====================
        // Use navbar variable from earlier (line 87)
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                
                // Ignore empty hash links
                if (href === '#' || !href || href === '#0') {
                    e.preventDefault();
                    return;
                }
                
                const target = document.querySelector(href);
                
                if (target) {
                    e.preventDefault();
                    const navbarHeight = layoutNavbar ? layoutNavbar.offsetHeight : 0;
                    const targetPosition = target.offsetTop - navbarHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // ==================== Floating Cards Animation Enhancement ====================
        const floatingCards = document.querySelectorAll('.animate-float, .animate-float-delay-1, .animate-float-delay-2');

        // Only add parallax effect on desktop
        if (floatingCards.length > 0 && window.innerWidth > 1024) {
            document.addEventListener('mousemove', (e) => {
                const { clientX, clientY } = e;
                const x = (clientX / window.innerWidth - 0.5) * 20;
                const y = (clientY / window.innerHeight - 0.5) * 20;
                
                floatingCards.forEach((card, index) => {
                    const multiplier = (index + 1) * 0.5;
                    card.style.transform = `translate(${x * multiplier}px, ${y * multiplier}px)`;
                });
            });
        }

        // ==================== Lazy Load Images ====================
        const lazyImages = document.querySelectorAll('img[data-src]');
        
        if (lazyImages.length > 0 && 'IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            observer.unobserve(img);
                        }
                    }
                });
            });

            lazyImages.forEach(img => imageObserver.observe(img));
        } else if (lazyImages.length > 0) {
            // Fallback for browsers without IntersectionObserver
            lazyImages.forEach(img => {
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
            });
        }

        // ==================== Accessibility Enhancements ====================
        // Use layoutMobileMenuToggle and layoutNavMenu variables from top
        
        // Focus trap for mobile menu
        if (layoutMobileMenuToggle && layoutNavMenu) {
            function trapFocus(element) {
                const focusableElements = element.querySelectorAll(
                    'a[href], button, textarea, input, select, [tabindex]:not([tabindex="-1"])'
                );
                
                if (focusableElements.length === 0) return;
                
                const firstFocusable = focusableElements[0];
                const lastFocusable = focusableElements[focusableElements.length - 1];

                element.addEventListener('keydown', (e) => {
                    if (e.key !== 'Tab') return;

                    if (e.shiftKey) {
                        if (document.activeElement === firstFocusable) {
                            lastFocusable.focus();
                            e.preventDefault();
                        }
                    } else {
                        if (document.activeElement === lastFocusable) {
                            firstFocusable.focus();
                            e.preventDefault();
                        }
                    }
                });
            }

            // Apply focus trap when mobile menu is open
            let focusTrapActive = false;
            layoutMobileMenuToggle.addEventListener('click', () => {
                if (!layoutNavMenu.classList.contains('translate-x-full') && !focusTrapActive) {
                    trapFocus(layoutNavMenu);
                    focusTrapActive = true;
                }
            });
        }

        // ==================== Animation on Load ====================
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
            
            // Trigger animations for visible elements on page load
            const initialFadeElements = document.querySelectorAll('.fade-in');
            initialFadeElements.forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight) {
                    el.classList.add('visible');
                }
            });
        });

        // ==================== Global Utility Functions ====================
        
        // Show toast notification
        window.showToast = function(message, type = 'info') {
            const toastContainer = document.getElementById('toast-container') || createToastContainer();
            
            const colors = {
                success: 'bg-green-50 border-green-500 text-green-800',
                error: 'bg-red-50 border-red-500 text-red-800',
                warning: 'bg-yellow-50 border-yellow-500 text-yellow-800',
                info: 'bg-blue-50 border-blue-500 text-blue-800'
            };
            
            const icons = {
                success: '✓',
                error: '✗',
                warning: '⚠',
                info: 'ℹ'
            };
            
            const toast = document.createElement('div');
            toast.className = `${colors[type]} border-l-4 p-4 rounded-lg shadow-lg mb-2 transition-all duration-300`;
            toast.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="text-xl mr-3">${icons[type]}</span>
                        <span>${message}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-2xl font-bold opacity-50 hover:opacity-100">×</button>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Auto dismiss after 5 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        };

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'fixed top-4 right-4 z-50 max-w-sm';
            document.body.appendChild(container);
            return container;
        }

        // Show loading overlay
        window.showLoading = function() {
            let loading = document.getElementById('loading-overlay');
            if (!loading) {
                loading = document.createElement('div');
                loading.id = 'loading-overlay';
                loading.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                loading.innerHTML = `
                    <div class="bg-white rounded-lg p-6 flex flex-col items-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                        <p class="mt-4 text-gray-700">Loading...</p>
                    </div>
                `;
                document.body.appendChild(loading);
            }
            loading.classList.remove('hidden');
        };

        // Hide loading overlay
        window.hideLoading = function() {
            const loading = document.getElementById('loading-overlay');
            if (loading) {
                loading.classList.add('hidden');
            }
        };

        // ==================== Console Message ====================
        if (console && console.log) {
            try {
                console.log('%cSorted Services', 'font-size: 24px; font-weight: bold; color: #0066FF;');
                console.log('%cBuilt with Tailwind CSS and vanilla JavaScript', 'font-size: 14px; color: #6B7280;');
            } catch (e) {
                // Suppress console errors in production
            }
        }

        // ==================== Analytics Placeholder ====================
        function trackEvent(eventName, eventData) {
            // Example: gtag('event', eventName, eventData);
            if (console && console.log) {
                console.log('Event tracked:', eventName, eventData);
            }
        }

        // Track button clicks
        const trackableLinks = document.querySelectorAll('a[data-track]');
        trackableLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                trackEvent('button_click', {
                    button_text: e.target.textContent,
                    button_href: e.target.getAttribute('href')
                });
            });
        });

    }); // End DOMContentLoaded
  </script>
</body>
</html>