document.addEventListener('DOMContentLoaded', function () {
    
    // 1. Contact Form Validation Logic (contact.html)

    const contactForm = document.getElementById('contactForm');
    const errorMessageDiv = document.getElementById('error-message');

    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent default submission for Phase 2 validation test
            
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
                    errorMessageDiv.style.display = 'block';
                    errorMessageDiv.className = 'alert alert-danger shadow-sm';
                    errorMessageDiv.innerHTML = `<i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Validation Failed:</strong><br>${errors.join('<br>')}`;
                    errorMessageDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    errorMessageDiv.style.display = 'block';
                    errorMessageDiv.className = 'alert alert-success shadow-sm';
                    errorMessageDiv.innerHTML = `<i class="bi bi-check-circle-fill me-2"></i><strong>Success!</strong> Your message has been validated successfully and is ready for PHP processing.`;
                    contactForm.reset();
                }
            }
        });
    }

    // 2. Authentication Forms Validation Logic (login.html & register.html)
    
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();
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

            if (authError) {
                if (errors.length > 0) {
                    authError.style.display = 'block';
                    authError.className = 'alert alert-danger';
                    authError.innerHTML = errors.join('<br>');
                } else {
                    authError.style.display = 'block';
                    authError.className = 'alert alert-success';
                    authError.innerHTML = 'Login credentials format valid! Redirecting...';
                    setTimeout(() => window.location.href = '../recipes.html', 1200);
                }
            }
        });
    }

    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            e.preventDefault();
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

            if (regError) {
                if (errors.length > 0) {
                    regError.style.display = 'block';
                    regError.className = 'alert alert-danger';
                    regError.innerHTML = errors.join('<br>');
                } else {
                    regError.style.display = 'block';
                    regError.className = 'alert alert-success';
                    regError.innerHTML = 'Registration valid! Redirecting to login...';
                    setTimeout(() => window.location.href = 'login.html', 1200);
                }
            }
        });
    }
});
