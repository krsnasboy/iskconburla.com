// ISKCON Admin Dashboard - Enhanced JavaScript
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize all admin features
    initializeAnimations();
    initializeFormEnhancements();
    initializeTableEnhancements();
    initializeNotifications();
    initializeLoadingStates();
    initializeKeyboardShortcuts();
    
    // Auto-hide flash messages
    const flashes = document.querySelectorAll('[data-flash]');
    flashes.forEach(flash => {
        setTimeout(() => {
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(-20px)';
            setTimeout(() => flash.remove(), 300);
        }, 5000);
    });
});

// Touch detection
const isTouch = matchMedia('(hover: none) and (pointer: coarse)').matches;

// Override hover-based transforms on touch
if (isTouch) {
	document.addEventListener('DOMContentLoaded', () => {
		const hovered = document.querySelectorAll('.dashboard-card, .table tbody tr, header nav a, .button');
		hovered.forEach(el => {
			el.addEventListener('mouseenter', e => e.stopImmediatePropagation(), { passive: true });
			el.addEventListener('mouseleave', e => e.stopImmediatePropagation(), { passive: true });
		});
	});
}

// On small screens, avoid desktop-style tooltips/popups
function shouldUseCompactUI() {
	return window.innerWidth <= 640 || isTouch;
}

// Patch showRegistrationDetails to no-op on mobile
const _origShowRegistrationDetails = typeof showRegistrationDetails === 'function' ? showRegistrationDetails : null;
if (_origShowRegistrationDetails) {
	window.showRegistrationDetails = function(row, data) {
		if (shouldUseCompactUI()) return;
		return _origShowRegistrationDetails(row, data);
	}
}

// Animation System
function initializeAnimations() {
    // Stagger animations for cards
    const cards = document.querySelectorAll('.card, .dashboard-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe elements that should animate on scroll
    document.querySelectorAll('.table, .img-grid > *').forEach(el => {
        observer.observe(el);
    });
}

// Form Enhancements
function initializeFormEnhancements() {
    // Real-time form validation
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        // Add floating label effect
        if (input.value) {
            input.classList.add('has-value');
        }
        
        input.addEventListener('input', function() {
            if (this.value) {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
            
            // Real-time validation
            validateField(this);
        });
        
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
    
    // Enhanced file upload
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', handleFileUpload);
    });
    
    // Form submission enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                showLoadingState(submitBtn);
            }
        });
    });
}

// Field validation
function validateField(field) {
    const value = field.value.trim();
    const type = field.type;
    const required = field.hasAttribute('required');
    const maxLength = field.getAttribute('maxlength');
    
    // Remove existing validation states
    field.classList.remove('valid', 'invalid');
    
    // Check if required field is empty
    if (required && !value) {
        field.classList.add('invalid');
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Check max length
    if (maxLength && value.length > parseInt(maxLength)) {
        field.classList.add('invalid');
        showFieldError(field, `Maximum ${maxLength} characters allowed`);
        return false;
    }
    
    // Type-specific validation
    if (value) {
        switch (type) {
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    field.classList.add('invalid');
                    showFieldError(field, 'Please enter a valid email');
                    return false;
                }
                break;
            case 'tel':
                const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
                if (!phoneRegex.test(value)) {
                    field.classList.add('invalid');
                    showFieldError(field, 'Please enter a valid phone number');
                    return false;
                }
                break;
        }
    }
    
    // If we get here, field is valid
    if (value) {
        field.classList.add('valid');
        hideFieldError(field);
    }
    
    return true;
}

// Show field error
function showFieldError(field, message) {
    let errorEl = field.parentElement.querySelector('.field-error');
    if (!errorEl) {
        errorEl = document.createElement('div');
        errorEl.className = 'field-error';
        field.parentElement.appendChild(errorEl);
    }
    errorEl.textContent = message;
    errorEl.style.opacity = '1';
}

// Hide field error
function hideFieldError(field) {
    const errorEl = field.parentElement.querySelector('.field-error');
    if (errorEl) {
        errorEl.style.opacity = '0';
        setTimeout(() => errorEl.remove(), 300);
    }
}

// File upload handler
function handleFileUpload(e) {
    const file = e.target.files[0];
    if (!file) return;
    
    const input = e.target;
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    
    // Validate file size
    if (file.size > maxSize) {
        showNotification('File size must be less than 5MB', 'error');
        input.value = '';
        return;
    }
    
    // Validate file type
    if (!allowedTypes.includes(file.type)) {
        showNotification('Only JPG, PNG, and WEBP files are allowed', 'error');
        input.value = '';
        return;
    }
    
    // Show file preview for images
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            showImagePreview(input, e.target.result, file.name);
        };
        reader.readAsDataURL(file);
    }
    
    showNotification(`Selected: ${file.name}`, 'success');
}

// Show image preview
function showImagePreview(input, src, filename) {
    let preview = input.parentElement.querySelector('.image-preview');
    if (!preview) {
        preview = document.createElement('div');
        preview.className = 'image-preview';
        input.parentElement.appendChild(preview);
    }
    
    preview.innerHTML = `
        <div style="margin-top: 1rem; padding: 1rem; border: 2px solid var(--admin-gray-200); border-radius: var(--admin-radius); background: var(--admin-gray-50);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <img src="${src}" alt="Preview" style="width: 60px; height: 60px; object-fit: cover; border-radius: var(--admin-radius-sm);">
                <div>
                    <p style="font-weight: 600; margin: 0;">${filename}</p>
                    <p style="font-size: 0.75rem; color: var(--admin-gray-500); margin: 0;">Ready to upload</p>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.parentElement.remove(); document.querySelector('#${input.id}').value = '';" style="margin-left: auto; background: none; border: none; color: var(--admin-danger); cursor: pointer; font-size: 1.2rem;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
}

// Table Enhancements
function initializeTableEnhancements() {
    const tables = document.querySelectorAll('.table');
    tables.forEach(table => {
        // Add row hover effects
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.01)';
                this.style.zIndex = '10';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.zIndex = '1';
            });
        });
        
        // Add sorting capability (if needed)
        addTableSorting(table);
    });
}

// Simple table sorting
function addTableSorting(table) {
    const headers = table.querySelectorAll('thead th');
    headers.forEach((header, index) => {
        if (header.textContent.trim()) {
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => sortTable(table, index));
            
            // Add sort icon
            const icon = document.createElement('i');
            icon.className = 'fas fa-sort';
            icon.style.marginLeft = '0.5rem';
            icon.style.opacity = '0.5';
            header.appendChild(icon);
        }
    });
}

// Sort table function
function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const header = table.querySelectorAll('thead th')[columnIndex];
    const icon = header.querySelector('i');
    
    // Determine sort direction
    const isAscending = !header.classList.contains('sort-desc');
    
    // Reset all headers
    table.querySelectorAll('thead th').forEach(h => {
        h.classList.remove('sort-asc', 'sort-desc');
        const i = h.querySelector('i');
        if (i) i.className = 'fas fa-sort';
    });
    
    // Sort rows
    rows.sort((a, b) => {
        const aVal = a.cells[columnIndex].textContent.trim();
        const bVal = b.cells[columnIndex].textContent.trim();
        
        // Try to compare as numbers first
        const aNum = parseFloat(aVal);
        const bNum = parseFloat(bVal);
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        }
        
        // Compare as strings
        return isAscending ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
    });
    
    // Update header classes and icon
    header.classList.add(isAscending ? 'sort-asc' : 'sort-desc');
    icon.className = `fas fa-sort-${isAscending ? 'up' : 'down'}`;
    
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
}

// Notification System
function initializeNotifications() {
    // Create notification container if it doesn't exist
    if (!document.querySelector('.notification-container')) {
        const container = document.createElement('div');
        container.className = 'notification-container';
        container.style.cssText = `
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 9999;
            pointer-events: none;
        `;
        document.body.appendChild(container);
    }
}

// Show notification
function showNotification(message, type = 'info', duration = 4000) {
    const container = document.querySelector('.notification-container');
    const notification = document.createElement('div');
    
    const icons = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-circle',
        warning: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    };
    
    const colors = {
        success: 'var(--admin-success)',
        error: 'var(--admin-danger)',
        warning: 'var(--admin-warning)',
        info: 'var(--admin-info)'
    };
    
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        background: white;
        border-left: 4px solid ${colors[type]};
        border-radius: var(--admin-radius);
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        box-shadow: var(--admin-shadow-lg);
        pointer-events: auto;
        transform: translateX(100%);
        transition: var(--admin-transition);
        max-width: 400px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    `;
    
    notification.innerHTML = `
        <i class="${icons[type]}" style="color: ${colors[type]}; font-size: 1.2rem;"></i>
        <span style="flex: 1; color: var(--admin-gray-800);">${message}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; color: var(--admin-gray-400); cursor: pointer; font-size: 1.1rem;">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    container.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 10);
    
    // Auto remove
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, duration);
}

// Loading States
function initializeLoadingStates() {
    // Add loading styles
    const style = document.createElement('style');
    style.textContent = `
        .button.loading {
            position: relative;
            color: transparent !important;
        }
        
        .button.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        
        .field-error {
            color: var(--admin-danger);
            font-size: 0.75rem;
            margin-top: 0.25rem;
            opacity: 0;
            transition: var(--admin-transition);
        }
        
        .form-row.focused label {
            color: var(--admin-primary);
        }
        
        input.valid, textarea.valid {
            border-color: var(--admin-success);
            box-shadow: 0 0 0 3px rgba(var(--admin-success-rgb), 0.15);
        }
        
        input.invalid, textarea.invalid {
            border-color: var(--admin-danger);
            box-shadow: 0 0 0 3px rgba(var(--admin-danger-rgb), 0.15);
        }
        
        .animate-in {
            animation: fadeInUp 0.6s ease-out;
        }
        
        thead th.sort-asc,
        thead th.sort-desc {
            background: rgba(var(--admin-primary-rgb), 0.1);
            color: var(--admin-primary);
        }
    `;
    document.head.appendChild(style);
}

// Show loading state on button
function showLoadingState(button) {
    button.classList.add('loading');
    button.disabled = true;
}

// Hide loading state on button
function hideLoadingState(button) {
    button.classList.remove('loading');
    button.disabled = false;
}

// Keyboard Shortcuts
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S to save form
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            const submitBtn = document.querySelector('form button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.click();
            }
        }
        
        // Escape to close modals or cancel actions
        if (e.key === 'Escape') {
            const modal = document.querySelector('.modal.active');
            if (modal) {
                modal.classList.remove('active');
            }
        }
        
        // Ctrl/Cmd + Enter to quick submit
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            const activeElement = document.activeElement;
            if (activeElement.tagName === 'TEXTAREA') {
                const form = activeElement.closest('form');
                if (form) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        submitBtn.click();
                    }
                }
            }
        }
    });
}

// Utility Functions
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

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Global error handler
window.addEventListener('error', function(e) {
    console.error('Admin Dashboard Error:', e.error);
    showNotification('An unexpected error occurred. Please try again.', 'error');
});

// Service worker registration (for offline support)
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js').catch(() => {
        // Silently fail if no service worker
    });
}

// Export functions for global use
window.adminUtils = {
    showNotification,
    showLoadingState,
    hideLoadingState,
    validateField,
    debounce,
    throttle
};

// Admin responsive header toggle
(function() {
	function initAdminHeaderToggle() {
		const toggle = document.querySelector('header nav .admin-nav-toggle');
		const links = document.getElementById('adminNavLinks');
		if (!toggle || !links) return;
		toggle.addEventListener('click', function() {
			const isOpen = links.classList.toggle('open');
			toggle.setAttribute('aria-expanded', String(isOpen));
		});
		// Close when clicking outside
		document.addEventListener('click', function(e) {
			if (!links.contains(e.target) && !toggle.contains(e.target)) {
				links.classList.remove('open');
				toggle.setAttribute('aria-expanded', 'false');
			}
		});
		// Close on resize to desktop
		window.addEventListener('resize', function() {
			if (window.innerWidth > 768) {
				links.classList.remove('open');
				toggle.setAttribute('aria-expanded', 'false');
			}
		});
	}
	document.addEventListener('DOMContentLoaded', initAdminHeaderToggle);
})();
