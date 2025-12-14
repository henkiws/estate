/**
 * Dashboard Interactions
 * Handles interactive features on the user dashboard
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // Profile Completion Widget Toggle
    // ============================================
    const profileToggleBtn = document.getElementById('profile-toggle-btn');
    const profileDetails = document.getElementById('profile-details');
    const profileToggleIcon = document.getElementById('profile-toggle-icon');
    const profileToggleText = document.getElementById('profile-toggle-text');
    
    if (profileToggleBtn) {
        profileToggleBtn.addEventListener('click', function() {
            if (profileDetails.classList.contains('hidden')) {
                // Show details
                profileDetails.classList.remove('hidden');
                profileToggleIcon.classList.add('rotate-180');
                profileToggleText.textContent = 'Hide progress';
            } else {
                // Hide details
                profileDetails.classList.add('hidden');
                profileToggleIcon.classList.remove('rotate-180');
                profileToggleText.textContent = 'Show progress';
            }
        });
    }
    
    // ============================================
    // Draft Auto-Delete Confirmation
    // ============================================
    const deleteDraftForms = document.querySelectorAll('[data-delete-draft]');
    deleteDraftForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this draft? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
    
    // ============================================
    // Property Search (Quick Search)
    // ============================================
    const searchInput = document.getElementById('quick-property-search');
    const searchResults = document.getElementById('search-results');
    let searchTimeout = null;
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            
            // Clear previous timeout
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }
            
            // Hide results if query is too short
            if (query.length < 2) {
                if (searchResults) searchResults.classList.add('hidden');
                return;
            }
            
            // Debounce search
            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        });
        
        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (searchResults && !searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    }
    
    function performSearch(query) {
        // Show loading state
        if (searchResults) {
            searchResults.classList.remove('hidden');
            searchResults.innerHTML = '<div class="p-4 text-center text-gray-600">Searching...</div>';
        }
        
        // Perform AJAX search
        fetch(`/api/properties/search?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data.properties);
            })
            .catch(error => {
                console.error('Search error:', error);
                if (searchResults) {
                    searchResults.innerHTML = '<div class="p-4 text-center text-red-600">Search failed. Please try again.</div>';
                }
            });
    }
    
    function displaySearchResults(properties) {
        if (!searchResults) return;
        
        if (properties.length === 0) {
            searchResults.innerHTML = '<div class="p-4 text-center text-gray-600">No properties found</div>';
            return;
        }
        
        let html = '<div class="max-h-96 overflow-y-auto">';
        properties.forEach(property => {
            html += `
                <a href="/properties/${property.slug}" class="block p-4 hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                    <div class="flex items-start gap-3">
                        ${property.image_url ? `
                            <img src="${property.image_url}" alt="${property.address}" class="w-16 h-16 object-cover rounded">
                        ` : `
                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                        `}
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">${property.address}</h4>
                            <p class="text-sm text-gray-600">${property.bedrooms} bed • ${property.bathrooms} bath</p>
                            <p class="text-sm font-semibold text-teal-600 mt-1">${property.price_display}</p>
                        </div>
                    </div>
                </a>
            `;
        });
        html += '</div>';
        
        searchResults.innerHTML = html;
    }
    
    // ============================================
    // Quick Start Checklist Animations
    // ============================================
    const checklistItems = document.querySelectorAll('[data-checklist-item]');
    checklistItems.forEach(item => {
        item.addEventListener('click', function() {
            // Add ripple effect
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 100);
        });
    });
    
    // ============================================
    // Blog Post View Tracking
    // ============================================
    const blogReadButtons = document.querySelectorAll('[data-blog-post]');
    blogReadButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const postId = this.dataset.blogPost;
            
            // Track view
            fetch(`/api/blog/${postId}/view`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).catch(error => console.error('View tracking failed:', error));
        });
    });
    
    // ============================================
    // Draft Progress Animation
    // ============================================
    const progressBars = document.querySelectorAll('[data-progress-bar]');
    progressBars.forEach(bar => {
        const targetWidth = bar.dataset.progressBar;
        let currentWidth = 0;
        
        const interval = setInterval(() => {
            if (currentWidth >= targetWidth) {
                clearInterval(interval);
            } else {
                currentWidth += 2;
                bar.style.width = currentWidth + '%';
            }
        }, 10);
    });
    
    // ============================================
    // Initialize Tooltips (if using a tooltip library)
    // ============================================
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(tooltip => {
        tooltip.addEventListener('mouseenter', function() {
            // Show tooltip
            const text = this.dataset.tooltip;
            // Implement your tooltip logic here
        });
    });
    
    // ============================================
    // Smooth Scroll for Anchor Links
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
});

// ============================================
// Utility Functions
// ============================================

/**
 * Format currency
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-AU', {
        style: 'currency',
        currency: 'AUD',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
}

/**
 * Format date
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-AU', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

/**
 * Debounce function
 */
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