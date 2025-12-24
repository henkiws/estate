<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/ico-yellow.png') }}">
  <title>@yield('title','plyform')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  @stack('styles')
  
  <style>
    /* Plyform Brand Colors */
    :root {
      --plyform-mint: #DDEECD;
      --plyform-dark: #1E1C1C;
      --plyform-yellow: #E6FF4B;
      --plyform-orange: #FF3600;
      --plyform-purple: #5E17EB;
    }

    /* Custom Animations */
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }

    @keyframes fadeIn {
      from { 
        opacity: 0; 
        transform: translateY(20px); 
      }
      to { 
        opacity: 1; 
        transform: translateY(0); 
      }
    }

    @keyframes slideInRight {
      from { transform: translateX(100%); }
      to { transform: translateX(0); }
    }

    @keyframes pulse-glow {
      0%, 100% { 
        box-shadow: 0 0 20px rgba(230, 255, 75, 0.3);
      }
      50% { 
        box-shadow: 0 0 40px rgba(230, 255, 75, 0.5);
      }
    }

    .animate-float {
      animation: float 3s ease-in-out infinite;
    }

    .animate-float-delay-1 {
      animation: float 3s ease-in-out 0.5s infinite;
    }

    .animate-float-delay-2 {
      animation: float 3s ease-in-out 1s infinite;
    }

    .animate-fadeIn {
      animation: fadeIn 0.6s ease-out;
    }

    .animate-slideInRight {
      animation: slideInRight 0.3s ease-out;
    }

    .fade-in {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .fade-in.visible {
      opacity: 1;
      transform: translateY(0);
    }

    /* Gradient Text */
    .gradient-text {
      background: linear-gradient(135deg, var(--plyform-yellow), var(--plyform-purple));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Button Styles */
    .btn-primary {
      background-color: var(--plyform-yellow);
      color: var(--plyform-dark);
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #d4f039;
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(230, 255, 75, 0.3);
    }

    .btn-secondary {
      background-color: var(--plyform-dark);
      color: var(--plyform-mint);
      transition: all 0.3s ease;
    }

    .btn-secondary:hover {
      background-color: #2d2a2a;
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(30, 28, 28, 0.3);
    }

    .btn-outline {
      border: 2px solid var(--plyform-yellow);
      color: var(--plyform-dark);
      background: transparent;
      transition: all 0.3s ease;
    }

    .btn-outline:hover {
      background-color: var(--plyform-yellow);
      transform: translateY(-2px);
    }

    /* Card Styles */
    .card-plyform {
      background: white;
      border-radius: 1rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .card-plyform:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      transform: translateY(-5px);
    }

    /* Asterisk/Star Element */
    .plyform-star {
      display: inline-block;
      width: 1em;
      height: 1em;
      background-color: var(--plyform-yellow);
      clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
    }

    /* Loading Spinner */
    .plyform-spinner {
      border: 3px solid var(--plyform-mint);
      border-top: 3px solid var(--plyform-yellow);
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Navbar Scroll Effect */
    .navbar-scrolled {
      background-color: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
  </style>
</head>
<body class="bg-plyform-mint text-plyform-dark antialiased">
  @yield('content')

  @stack('scripts')

  <script>
    document.addEventListener('DOMContentLoaded', function() {

        // ==================== Mobile Menu Toggle ====================
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const navMenu = document.getElementById('nav-menu');

        if (mobileMenuToggle && navMenu) {
            mobileMenuToggle.addEventListener('click', () => {
                // Toggle hamburger animation
                const spans = mobileMenuToggle.querySelectorAll('span');
                if (spans.length >= 3) {
                    spans[0].classList.toggle('rotate-45');
                    spans[0].classList.toggle('translate-y-2');
                    spans[1].classList.toggle('opacity-0');
                    spans[2].classList.toggle('-rotate-45');
                    spans[2].classList.toggle('-translate-y-2');
                }
                
                // Toggle menu visibility
                navMenu.classList.toggle('translate-x-full');
                document.body.style.overflow = navMenu.classList.contains('translate-x-full') ? '' : 'hidden';
            });

            // Close menu when clicking nav links
            const navLinks = navMenu.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    const spans = mobileMenuToggle.querySelectorAll('span');
                    if (spans.length >= 3) {
                        spans[0].classList.remove('rotate-45', 'translate-y-2');
                        spans[1].classList.remove('opacity-0');
                        spans[2].classList.remove('-rotate-45', '-translate-y-2');
                    }
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
                    if (spans.length >= 3) {
                        spans[0].classList.remove('rotate-45', 'translate-y-2');
                        spans[1].classList.remove('opacity-0');
                        spans[2].classList.remove('-rotate-45', '-translate-y-2');
                    }
                    navMenu.classList.add('translate-x-full');
                    document.body.style.overflow = '';
                }
            });

            // Close mobile menu on Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !navMenu.classList.contains('translate-x-full')) {
                    const spans = mobileMenuToggle.querySelectorAll('span');
                    if (spans.length >= 3) {
                        spans[0].classList.remove('rotate-45', 'translate-y-2');
                        spans[1].classList.remove('opacity-0');
                        spans[2].classList.remove('-rotate-45', '-translate-y-2');
                    }
                    navMenu.classList.add('translate-x-full');
                    document.body.style.overflow = '';
                }
            });
        }

        // ==================== Navbar Scroll Behavior ====================
        const navbar = document.getElementById('navbar');
        
        if (navbar) {
            let lastScrollY = window.scrollY;
            let ticking = false;

            function updateNavbar() {
                const currentScrollY = window.scrollY;
                
                // Add background and shadow on scroll
                if (currentScrollY > 50) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
                
                // Hide/show navbar on scroll
                if (currentScrollY > lastScrollY && currentScrollY > 200) {
                    navbar.classList.add('-translate-y-full');
                } else {
                    navbar.classList.remove('-translate-y-full');
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
                            dot.classList.remove('bg-plyform-yellow', 'w-8');
                            dot.classList.add('bg-gray-300', 'w-3');
                        });
                    }
                    
                    // Add active classes to current card and dot
                    testimonialCards[index].classList.remove('opacity-0', 'scale-95');
                    testimonialCards[index].classList.add('opacity-100', 'scale-100');
                    
                    if (dots.length > index) {
                        dots[index].classList.remove('bg-gray-300', 'w-3');
                        dots[index].classList.add('bg-plyform-yellow', 'w-8');
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
                    const navbarHeight = navbar ? navbar.offsetHeight : 0;
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
        // Focus trap for mobile menu
        if (mobileMenuToggle && navMenu) {
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
            mobileMenuToggle.addEventListener('click', () => {
                if (!navMenu.classList.contains('translate-x-full') && !focusTrapActive) {
                    trapFocus(navMenu);
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
        
        // Show toast notification with plyform colors
        window.showToast = function(message, type = 'info') {
            const toastContainer = document.getElementById('toast-container') || createToastContainer();
            
            const colors = {
                success: 'bg-plyform-mint border-plyform-yellow text-plyform-dark',
                error: 'bg-red-50 border-plyform-orange text-red-800',
                warning: 'bg-yellow-50 border-plyform-yellow text-yellow-800',
                info: 'bg-white border-plyform-purple text-plyform-dark'
            };
            
            const icons = {
                success: '✓',
                error: '✗',
                warning: '⚠',
                info: 'ℹ'
            };
            
            const toast = document.createElement('div');
            toast.className = `${colors[type]} border-l-4 p-4 rounded-lg shadow-lg mb-2 transition-all duration-300 animate-slideInRight`;
            toast.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="text-xl mr-3">${icons[type]}</span>
                        <span class="font-medium">${message}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-2xl font-bold opacity-50 hover:opacity-100 transition-opacity">×</button>
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

        // Show loading overlay with plyform branding
        window.showLoading = function() {
            let loading = document.getElementById('loading-overlay');
            if (!loading) {
                loading = document.createElement('div');
                loading.id = 'loading-overlay';
                loading.className = 'fixed inset-0 bg-plyform-dark bg-opacity-75 flex items-center justify-center z-50';
                loading.innerHTML = `
                    <div class="bg-white rounded-2xl p-8 flex flex-col items-center shadow-2xl">
                        <div class="plyform-spinner"></div>
                        <p class="mt-4 text-plyform-dark font-semibold">Loading...</p>
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
                console.log('%cplyform', 'font-size: 32px; font-weight: bold; color: #E6FF4B; background: #1E1C1C; padding: 10px 20px; border-radius: 8px;');
                console.log('%cModern Real Estate Platform', 'font-size: 14px; color: #DDEECD; background: #1E1C1C; padding: 5px 10px;');
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