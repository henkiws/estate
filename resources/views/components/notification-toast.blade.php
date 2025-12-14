<!-- Toast Notification Container -->
<div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2" style="max-width: 400px;">
    <!-- Toast notifications will be inserted here by JavaScript -->
</div>

<!-- Toast Template (Hidden) -->
<template id="toast-template">
    <div class="toast-notification bg-white rounded-lg shadow-lg border border-gray-200 p-4 flex items-start gap-3 animate-slide-up">
        <!-- Icon -->
        <div class="flex-shrink-0 toast-icon">
            <!-- Will be replaced by JavaScript -->
        </div>
        
        <!-- Content -->
        <div class="flex-1 min-w-0">
            <p class="toast-message font-medium text-gray-900"></p>
            <p class="toast-detail text-sm text-gray-600 mt-0.5"></p>
        </div>
        
        <!-- Close Button -->
        <button class="flex-shrink-0 text-gray-400 hover:text-gray-600 toast-close">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>
</template>

<script>
// Toast Notification System
const Toast = {
    container: null,
    template: null,
    
    init() {
        this.container = document.getElementById('toast-container');
        this.template = document.getElementById('toast-template');
        
        // Check for session flash messages
        this.checkFlashMessages();
    },
    
    show(message, type = 'info', detail = null, duration = 5000) {
        if (!this.container || !this.template) return;
        
        // Clone template
        const clone = this.template.content.cloneNode(true);
        const toast = clone.querySelector('.toast-notification');
        const icon = clone.querySelector('.toast-icon');
        const messageEl = clone.querySelector('.toast-message');
        const detailEl = clone.querySelector('.toast-detail');
        const closeBtn = clone.querySelector('.toast-close');
        
        // Set content
        messageEl.textContent = message;
        if (detail) {
            detailEl.textContent = detail;
        } else {
            detailEl.remove();
        }
        
        // Set icon and color based on type
        icon.innerHTML = this.getIcon(type);
        toast.classList.add(this.getBorderClass(type));
        
        // Add to container
        this.container.appendChild(toast);
        
        // Close button handler
        closeBtn.addEventListener('click', () => {
            this.remove(toast);
        });
        
        // Auto remove after duration
        if (duration > 0) {
            setTimeout(() => {
                this.remove(toast);
            }, duration);
        }
    },
    
    remove(toast) {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => {
            toast.remove();
        }, 300);
    },
    
    getIcon(type) {
        const icons = {
            success: `<svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>`,
            error: `<svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>`,
            warning: `<svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>`,
            info: `<svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>`
        };
        return icons[type] || icons.info;
    },
    
    getBorderClass(type) {
        const classes = {
            success: 'border-l-4 border-l-green-500',
            error: 'border-l-4 border-l-red-500',
            warning: 'border-l-4 border-l-yellow-500',
            info: 'border-l-4 border-l-blue-500'
        };
        return classes[type] || classes.info;
    },
    
    checkFlashMessages() {
        // Check for Laravel flash messages
        const successMsg = document.querySelector('[data-flash-success]');
        const errorMsg = document.querySelector('[data-flash-error]');
        const warningMsg = document.querySelector('[data-flash-warning]');
        const infoMsg = document.querySelector('[data-flash-info]');
        
        if (successMsg) {
            this.show(successMsg.dataset.flashSuccess, 'success');
        }
        if (errorMsg) {
            this.show(errorMsg.dataset.flashError, 'error');
        }
        if (warningMsg) {
            this.show(warningMsg.dataset.flashWarning, 'warning');
        }
        if (infoMsg) {
            this.show(infoMsg.dataset.flashInfo, 'info');
        }
    },
    
    // Convenience methods
    success(message, detail) {
        this.show(message, 'success', detail);
    },
    
    error(message, detail) {
        this.show(message, 'error', detail);
    },
    
    warning(message, detail) {
        this.show(message, 'warning', detail);
    },
    
    info(message, detail) {
        this.show(message, 'info', detail);
    }
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    Toast.init();
});

// Make Toast globally available
window.Toast = Toast;
</script>

<!-- Flash Message Data (Hidden) -->
@if(session('success'))
    <div data-flash-success="{{ session('success') }}" style="display: none;"></div>
@endif

@if(session('error'))
    <div data-flash-error="{{ session('error') }}" style="display: none;"></div>
@endif

@if(session('warning'))
    <div data-flash-warning="{{ session('warning') }}" style="display: none;"></div>
@endif

@if(session('info'))
    <div data-flash-info="{{ session('info') }}" style="display: none;"></div>
@endif

<style>
.toast-notification {
    transition: all 0.3s ease-out;
}

.animate-slide-up {
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>