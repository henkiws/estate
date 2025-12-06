<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? 'Browse Properties' }} - Sorted</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Navbar -->
    <x-navbar />
    
    <!-- Main Content -->
    <main class="pt-20">
        {{ $slot }}
    </main>
    
    <!-- Footer -->
    <x-footer />

    <!-- Navbar & Mobile Menu Scripts -->
    <script>
        // ==================== Mobile Menu Toggle ====================
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const navMenu = document.getElementById('navMenu');

        if (mobileMenuToggle && navMenu) {
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
            const navLinks = document.querySelectorAll('#navMenu a');
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

            // Close menu on Escape key
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
        }

        // ==================== Navbar Scroll Behavior ====================
        const navbar = document.getElementById('navbar');
        if (navbar) {
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
        }

        // ==================== Smooth Scroll for Anchor Links ====================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                
                if (href === '#' || !href) {
                    e.preventDefault();
                    return;
                }
                
                const target = document.querySelector(href);
                
                if (target && navbar) {
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
    </script>
</body>
</html>