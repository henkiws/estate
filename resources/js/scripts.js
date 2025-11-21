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

// ==================== Navbar Scroll Behavior ====================
const navbar = document.getElementById('navbar');
let lastScrollY = window.scrollY;
let ticking = false;

function updateNavbar() {
    const currentScrollY = window.scrollY;
    
    // Add shadow on scroll
    if (currentScrollY > 50) {
        navbar.classList.add('shadow-md');
    } else {
        navbar.classList.remove('shadow-md');
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

// ==================== Intersection Observer for Fade-in Animations ====================
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

// Observe all fade-in elements
const fadeInElements = document.querySelectorAll('.fade-in');
fadeInElements.forEach(el => fadeInObserver.observe(el));

// ==================== Testimonials Slider ====================
const testimonialsSlider = document.getElementById('testimonialsSlider');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const sliderDots = document.getElementById('sliderDots');
const testimonialCards = document.querySelectorAll('.testimonial-card');
const dots = document.querySelectorAll('.dot');

let currentSlide = 0;
const totalSlides = testimonialCards.length;
let autoPlayInterval;

function updateSlider(index) {
    // Remove active classes from all cards and dots
    testimonialCards.forEach(card => {
        card.classList.remove('opacity-100', 'scale-100');
        card.classList.add('opacity-0', 'scale-95');
    });
    dots.forEach(dot => {
        dot.classList.remove('bg-primary', 'w-8');
        dot.classList.add('bg-gray-300', 'w-3');
    });
    
    // Add active classes to current card and dot
    testimonialCards[index].classList.remove('opacity-0', 'scale-95');
    testimonialCards[index].classList.add('opacity-100', 'scale-100');
    dots[index].classList.remove('bg-gray-300', 'w-3');
    dots[index].classList.add('bg-primary', 'w-8');
    
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
dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        updateSlider(index);
        resetAutoPlay();
    });
});

// Auto-play functionality
function startAutoPlay() {
    autoPlayInterval = setInterval(nextSlide, 5000);
}

function resetAutoPlay() {
    clearInterval(autoPlayInterval);
    startAutoPlay();
}

// Pause auto-play on hover
testimonialsSlider.addEventListener('mouseenter', () => {
    clearInterval(autoPlayInterval);
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

// ==================== Smooth Scroll for Anchor Links ====================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        
        // Ignore empty hash links
        if (href === '#' || !href) {
            e.preventDefault();
            return;
        }
        
        const target = document.querySelector(href);
        
        if (target) {
            e.preventDefault();
            const navbarHeight = navbar.offsetHeight;
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
if (window.innerWidth > 1024) {
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

// ==================== Performance Optimization ====================
// Debounce function for scroll and resize events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Lazy load images when they're about to enter viewport
const lazyImages = document.querySelectorAll('img[data-src]');
const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
            observer.unobserve(img);
        }
    });
});

lazyImages.forEach(img => imageObserver.observe(img));

// ==================== Accessibility Enhancements ====================
// Focus trap for mobile menu
function trapFocus(element) {
    const focusableElements = element.querySelectorAll(
        'a[href], button, textarea, input, select, [tabindex]:not([tabindex="-1"])'
    );
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

// Close mobile menu on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !navMenu.classList.contains('translate-x-full')) {
        const spans = mobileMenuToggle.querySelectorAll('span');
        spans[0].classList.remove('rotate-45', 'translate-y-2');
        spans[1].classList.remove('opacity-0');
        spans[2].classList.remove('-rotate-45', '-translate-y-2');
        navMenu.classList.add('translate-x-full');
        document.body.style.overflow = '';
    }
});

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

// ==================== Console Message ====================
console.log('%cSorted Services', 'font-size: 24px; font-weight: bold; color: #0066FF;');
console.log('%cBuilt with Tailwind CSS and vanilla JavaScript', 'font-size: 14px; color: #6B7280;');

// ==================== Analytics Placeholder ====================
// This is where you would add analytics tracking code
function trackEvent(eventName, eventData) {
    // Example: gtag('event', eventName, eventData);
    console.log('Event tracked:', eventName, eventData);
}

// Track button clicks
document.querySelectorAll('a[href^="#"]').forEach(btn => {
    btn.addEventListener('click', (e) => {
        trackEvent('button_click', {
            button_text: e.target.textContent,
            button_href: e.target.getAttribute('href')
        });
    });
});