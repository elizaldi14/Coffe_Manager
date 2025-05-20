<?php
/** @var string $title */
use app\classes\View;

// Set the layout and pass data to it
View::setLayout('main', [
    'title' => 'Iniciar Sesión',
    'styles' => ['auth']
]);
?>

<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-card">
            <div class="text-center mb-4">
                <div class="auth-logo mb-3">
                    <i class="bi bi-box-seam text-primary"></i>
                </div>
                <h1 class="h3 mb-1 fw-bold">Bienvenido de nuevo</h1>
                <p class="text-muted">Por favor inicia sesión para continuar</p>
            </div>
            
            <form id="login-form" class="auth-form" method="POST" action="<?= AppConfig::get('base_url') ?>auth/authenticate">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input 
                            type="email" 
                            class="form-control form-control-lg" 
                            id="email" 
                            name="email" 
                            placeholder="usuario@ejemplo.com"
                            required
                        >
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="password" class="form-label mb-0">Contraseña</label>
                        <a href="#" class="text-decoration-none small">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input 
                            type="password" 
                            class="form-control form-control-lg" 
                            id="password" 
                            name="password"
                            placeholder="••••••••"
                            required
                        >
                        <button class="btn btn-outline-secondary toggle-password" type="button" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggle-icon"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Recordar mi sesión</label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span class="btn-text">Iniciar Sesión</span>
                </button>

                <div class="text-center my-4 position-relative">
                    <span class="bg-white px-2 text-muted">O inicia con</span>
                    <hr class="position-absolute w-100" style="top: 50%; z-index: -1;">
                </div>

                <div class="d-flex gap-3 mb-4">
                    <a href="#" class="btn btn-outline-secondary flex-grow-1" aria-label="Google">
                        <i class="bi bi-google"></i>
                    </a>
                    <a href="#" class="btn btn-outline-secondary flex-grow-1" aria-label="Microsoft">
                        <i class="bi bi-microsoft"></i>
                    </a>
                    <a href="#" class="btn btn-outline-secondary flex-grow-1" aria-label="GitHub">
                        <i class="bi bi-github"></i>
                    </a>
                </div>

                <div class="text-center">
                    <p class="mb-0">¿No tienes una cuenta? 
                        <a href="#" class="text-decoration-none">Regístrate</a>
                    </p>
                </div>
            </form>
        </div>

        <div class="text-center mt-4">
            <p class="text-muted small mb-0">
                © <?= date('Y') ?> Gestor de Inventario. Todos los derechos reservados.
            </p>
        </div>
    </div>

    <div class="auth-illustration d-none d-lg-block">
        <div class="illustration-content">
            <h2 class="text-white mb-4">Simplifica la gestión de tu inventario</h2>
            <p class="text-white-50">Controla tus productos, categorías y proveedores en un solo lugar.</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    function togglePassword() {
        const password = document.getElementById("password");
        const icon = document.getElementById("toggle-icon");
        if (password.type === "password") {
            password.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            password.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }

    // Handle form submission
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const spinner = document.createElement('span');
            spinner.className = 'spinner-border spinner-border-sm me-2';
            spinner.setAttribute('role', 'status');
            spinner.setAttribute('aria-hidden', 'true');
            
            // Disable submit button and show spinner
            submitBtn.disabled = true;
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = '';
            submitBtn.appendChild(spinner);
            submitBtn.innerHTML += ' Procesando...';
            
            // Get form data
            const formData = new FormData(this);
            
            // Send AJAX request
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.error || 'Error al iniciar sesión');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    throw new Error(data.error || 'Error al iniciar sesión');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Show error message using SweetAlert2 if available, otherwise use alert
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al iniciar sesión. Verifica tus credenciales e intenta nuevamente.',
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    alert(error.message || 'Error al iniciar sesión. Verifica tus credenciales e intenta nuevamente.');
                }
            })
            .finally(() => {
                // Re-enable submit button and restore original text
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            });
        });
    }
    
    // Attach togglePassword to the button
    const toggleBtn = document.querySelector('.toggle-password');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', togglePassword);
    }
});
</script>
