/* =====================================================
   Alert Messages & Notifications JavaScript
   ===================================================== */

document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 8 seconds
    const alerts = document.querySelectorAll('.alert-message, .admin-alert, .dashboard-alert');

    alerts.forEach(alert => {
        // Add auto-hide functionality
        setTimeout(() => {
            if (alert && alert.parentElement) {
                alert.classList.add('closing');
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 400); // Match animation duration
            }
        }, 8000); // 8 seconds
    });

    // Handle manual close buttons
    const closeButtons = document.querySelectorAll('.alert-message button, .admin-alert button, .dashboard-alert button');
    closeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const alertBox = this.closest('.alert-message, .admin-alert, .dashboard-alert');
            if (alertBox) {
                alertBox.classList.add('closing');
                setTimeout(() => {
                    alertBox.style.display = 'none';
                }, 400);
            }
        });
    });

    // Enhanced keyboard support (ESC to close)
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const activeAlert = document.querySelector('.alert-message:not([style*="display: none"]), .admin-alert:not([style*="display: none"]), .dashboard-alert:not([style*="display: none"])');
            if (activeAlert) {
                activeAlert.classList.add('closing');
                setTimeout(() => {
                    activeAlert.style.display = 'none';
                }, 400);
            }
        }
    });
});

/* =====================================================
   Toast Notification Function (Optional)
   ===================================================== */

function showToast(message, type = 'info', duration = 4000) {
    // Create container if it doesn't exist
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;

    // Map type to icon
    const iconMap = {
        'success': 'fas fa-check-circle',
        'error': 'fas fa-exclamation-circle',
        'warning': 'fas fa-exclamation-triangle',
        'info': 'fas fa-info-circle'
    };

    const icon = iconMap[type] || iconMap['info'];

    toast.innerHTML = `
        <i class="${icon}"></i>
        <span>${message}</span>
        <button class="toast-close" type="button">×</button>
    `;

    // Add to container
    container.appendChild(toast);

    // Handle close button
    const closeBtn = toast.querySelector('.toast-close');
    closeBtn.addEventListener('click', () => {
        toast.classList.add('closing');
        setTimeout(() => toast.remove(), 400);
    });

    // Auto-remove after duration
    setTimeout(() => {
        if (toast.parentElement) {
            toast.classList.add('closing');
            setTimeout(() => toast.remove(), 400);
        }
    }, duration);
}

/* =====================================================
   Form Validation Messages
   ===================================================== */

function showFormError(inputElement, message) {
    // Remove existing error if present
    const existingError = inputElement.nextElementSibling;
    if (existingError && existingError.classList.contains('form-error-message')) {
        existingError.remove();
    }

    // Create error message
    const errorMsg = document.createElement('div');
    errorMsg.className = 'form-error-message';
    errorMsg.innerHTML = `<i class="fas fa-times-circle"></i><span>${message}</span>`;

    // Insert after input
    inputElement.parentElement.insertBefore(errorMsg, inputElement.nextSibling);

    // Add error state to input
    inputElement.classList.add('input-error');
    inputElement.style.borderColor = '#dc2626';
}

function clearFormError(inputElement) {
    // Remove error message
    const errorMsg = inputElement.nextElementSibling;
    if (errorMsg && errorMsg.classList.contains('form-error-message')) {
        errorMsg.remove();
    }

    // Remove error state
    inputElement.classList.remove('input-error');
    inputElement.style.borderColor = '';
}

function showFormSuccess(inputElement, message) {
    // Remove existing message if present
    const existingMsg = inputElement.nextElementSibling;
    if (existingMsg && (existingMsg.classList.contains('form-error-message') || existingMsg.classList.contains('form-success-message'))) {
        existingMsg.remove();
    }

    // Create success message
    const successMsg = document.createElement('div');
    successMsg.className = 'form-success-message';
    successMsg.innerHTML = `<i class="fas fa-check-circle"></i><span>${message}</span>`;

    // Insert after input
    inputElement.parentElement.insertBefore(successMsg, inputElement.nextSibling);

    // Add success state to input
    inputElement.classList.add('input-success');
    inputElement.style.borderColor = '#10b981';
}

/* =====================================================
   Form Validation Helper
   ===================================================== */

function validateForm(formElement) {
    let isValid = true;
    const inputs = formElement.querySelectorAll('[required]');

    inputs.forEach(input => {
        if (!input.value.trim()) {
            showFormError(input, 'هذا الحقل مطلوب');
            isValid = false;
        } else {
            clearFormError(input);
        }
    });

    return isValid;
}

// Add real-time validation to required inputs
document.addEventListener('DOMContentLoaded', function() {
    const requiredInputs = document.querySelectorAll('[required]');

    requiredInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                showFormError(this, 'هذا الحقل مطلوب');
            } else {
                clearFormError(this);
                showFormSuccess(this, '✓');
                setTimeout(() => {
                    const msg = this.nextElementSibling;
                    if (msg && msg.classList.contains('form-success-message')) {
                        msg.remove();
                    }
                    this.classList.remove('input-success');
                }, 1500);
            }
        });

        input.addEventListener('input', function() {
            if (this.value.trim()) {
                clearFormError(this);
            }
        });
    });
});

/* =====================================================
   CSS Classes for Input States
   ===================================================== */

const style = document.createElement('style');
style.textContent = `
.input-error {
    border-color: #dc2626 !important;
    background-color: rgba(220, 38, 38, 0.02) !important;
}

.input-error:focus {
    box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1) !important;
}

.input-success {
    border-color: #10b981 !important;
    background-color: rgba(16, 185, 129, 0.02) !important;
}

.input-success:focus {
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1) !important;
}
`;
document.head.appendChild(style);
