document.addEventListener('DOMContentLoaded', () => {
    const loginBtn = document.getElementById('openLoginBtn');
    const registerBtn = document.getElementById('openRegisterBtn');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');
    const closeLogin = document.getElementById('closeLoginModal');
    const closeRegister = document.getElementById('closeRegisterModal');
    const overlay = document.querySelector('.modal-overlay');
   
    function toggleModal(modal, show) {
        const allModals = document.querySelectorAll('.modal');
        allModals.forEach(m => {
            m.classList.add('hidden');
            m.classList.remove('active');
        });
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('active');
        }
    }

    loginBtn?.addEventListener('click', () => {
        toggleModal(loginModal, true);
        overlay.classList.remove('hidden');
        overlay.classList.add('active');
    });
    registerBtn?.addEventListener('click', () => {
        toggleModal(registerModal, true);
        overlay.classList.remove('hidden');
        overlay.classList.add('active');
    });
    closeLogin?.addEventListener('click', () => {
        toggleModal(loginModal, false);
        overlay.classList.add('hidden');
        overlay.classList.remove('active')
        loginForm.reset();
    });
    closeRegister?.addEventListener('click', () => {
        toggleModal(registerModal, false);
        overlay.classList.add('hidden');
        overlay.classList.remove('active')
        registerForm.reset();
    });

    document.addEventListener('click', (e) => {
        if(e.target.classList.contains('modal-overlay')) {
            toggleModal(e.target, false);
            if (e.target === loginModal) loginForm.reset();
            if (e.target === registerModal) registerForm.reset();
            overlay.classList.add('hidden');
            overlay.classList.remove('active')
        }
    });

    function clearErrors(form) {
        const errorDivs = form.querySelectorAll('.form-error');
        errorDivs.forEach(div => div.remove());
    }
    
    function displayError(form, message) {
        let errorDiv = form.parentNode.querySelector('.form-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'form-error';
            errorDiv.style.color = 'var(--red)';
            form.parentNode.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
    }

    async function submitRegistrationForm(event, form, url) {
        event.preventDefault();
        clearErrors(form);
        const formData = new FormData(form);

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            } else {
                if (result.errors.name) {
                    displayError(registerForm.querySelector('[name="name"]'), result.errors.name);
                }
                if (result.errors.email) {
                    displayError(registerForm.querySelector('[name="email"]'), result.errors.email);
                }
                if (result.errors.password) {
                    displayError(registerForm.querySelector('[name="password"]'), result.errors.password);
                }
                if (result.errors.form) {
                    alert(result.errors.form);
                }
            }
        } catch (error) {
            console.error('Error submitting form:', error);
            alert('An error occurred. Please try again later.');
        }
    }

    async function submitLoginForm(event, form, url) {
        event.preventDefault();
        clearErrors(form);
        const formData = new FormData(form);

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                setTimeout(() => {
                    window.location.reload();
                }, 500);                
            } else {
                if (result.errors.email) {
                    displayError(loginForm.querySelector('[name="email"]'), result.errors.email);
                }
                if (result.errors.password) {
                    displayError(loginForm.querySelector('[name="password"]'), result.errors.password);
                }
                if (result.errors.form) {
                    alert(result.errors.form);
                }
            }
        } catch (error) {
            console.error('Error submitting form:', error);
            alert('An error occurred. Please try again later.');
        }
    }

    loginForm?.addEventListener('submit', (e) => submitLoginForm(e, loginForm, 'login.php'));
    registerForm?.addEventListener('submit', (e) => submitRegistrationForm(e, registerForm, 'register.php'));
});