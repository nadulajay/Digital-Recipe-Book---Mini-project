

document.addEventListener('DOMContentLoaded', function () {
    
    
    const contactForm = document.getElementById('contactForm');
    const errorMessageDiv = document.getElementById('error-message');

    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            
            const fullName = document.getElementById('fullName');
            const email = document.getElementById('emailAddress');
            const message = document.getElementById('userMessage');

            let errors = [];

            // Full Name Validation
            if (!fullName || fullName.value.trim() === '') {
                errors.push('Full Name is required.');
            } else if (fullName.value.trim().length < 3) {
                errors.push('Full Name must be at least 3 characters long.');
            }

            // Email Address Validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email || email.value.trim() === '') {
                errors.push('Email Address is required.');
            } else if (!emailRegex.test(email.value.trim())) {
                errors.push('Please enter a valid email address (e.g. user@example.com).');
            }

            // Message Validation
            if (!message || message.value.trim() === '') {
                errors.push('Message field cannot be empty.');
            } else if (message.value.trim().length < 10) {
                errors.push('Message should contain at least 10 characters.');
            }

            // Display Validation Results in <div id="error-message">
            if (errorMessageDiv) {
                if (errors.length > 0) {
                    e.preventDefault(); // Block PHP submission if client-side validation fails
                    errorMessageDiv.style.display = 'block';
                    errorMessageDiv.className = 'alert alert-danger shadow-sm';
                    errorMessageDiv.innerHTML = `<i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Validation Failed:</strong><br>${errors.join('<br>')}`;
                    errorMessageDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    }

  
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            const loginEmail = document.getElementById('loginEmail');
            const loginPass = document.getElementById('loginPassword');
            const authError = document.getElementById('auth-error-message');

            let errors = [];
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!loginEmail || !emailRegex.test(loginEmail.value.trim())) {
                errors.push('Please enter a valid email address.');
            }

            if (!loginPass || loginPass.value.trim().length < 6) {
                errors.push('Password must be at least 6 characters.');
            }

            if (authError && errors.length > 0) {
                e.preventDefault();
                authError.style.display = 'block';
                authError.className = 'alert alert-danger';
                authError.innerHTML = errors.join('<br>');
            }
        });
    }

    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            const regUsername = document.getElementById('regUsername');
            const regEmail = document.getElementById('regEmail');
            const regPass = document.getElementById('regPassword');
            const regConfirmPass = document.getElementById('regConfirmPassword');
            const regError = document.getElementById('register-error-message');

            let errors = [];
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!regUsername || regUsername.value.trim().length < 3) {
                errors.push('Username must be at least 3 characters.');
            }

            if (!regEmail || !emailRegex.test(regEmail.value.trim())) {
                errors.push('Valid email address is required.');
            }

            if (!regPass || regPass.value.length < 6) {
                errors.push('Password must be at least 6 characters.');
            }

            if (regPass && regConfirmPass && regPass.value !== regConfirmPass.value) {
                errors.push('Passwords do not match.');
            }

            if (regError && errors.length > 0) {
                e.preventDefault();
                regError.style.display = 'block';
                regError.className = 'alert alert-danger';
                regError.innerHTML = errors.join('<br>');
            }
        });
    }
});
