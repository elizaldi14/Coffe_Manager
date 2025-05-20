<?php
    include_once LAYOUTS . 'main_head.php';
    setHeader($d);
?>

<div class="login-container w-100 vh-100 d-flex align-items-center overflow-hidden" style="background-color: #ebe2d8;">
    <div class="container-fluid px-4">
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-sm-10 col-md-8 col-lg-3 p-0">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white text-center py-3">
                        <div class="mb-3">
                            <i class="bi bi-cup-hot-fill text-success" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="mb-0">Coffee Manager</h4>
                        <p class="text-muted small">Ingresa tus credenciales para acceder al sistema</p>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($errors) && !empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach($errors as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <form action="" id="login-form">
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="Ingresa tu correo" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="Ingresa tu contraseña" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Iniciar Sesión</button>
                            </div>
                            <div class="text-center mt-3">
                                <small class="text-danger d-none" id="error">
                                    Usuario o contraseña incorrectos
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.login-container {
    margin: 0;
    padding: 0;
}

body {
    overflow: hidden;
    margin: 0;
    padding: 0;
    height: 100vh;
    width: 100vw;
}
.card {
    border-radius: 10px;
    overflow: hidden;
    border: none;
    max-height: 90vh;
    margin: 2vh auto;
}
.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
}
.form-control:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
}
.btn-success {
    transition: all 0.3s ease;
}
.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>

<?php
    include_once LAYOUTS . 'main_foot.php';

    setFooter($d);

?>
    <script>//Script de la vista Inisession
        $( function (){
            const $lf = $("#login-form")
            $lf.on("submit", function(e){
                e.preventDefault();
                e.stopPropagation();
                const data = new FormData( this )
                fetch( app.routes.login,{
                    method : 'POST',
                    body : data
                })
                .then(resp => resp.json())
                .then(resp => {
                    if (resp.r === true) {
                        // Redirigir a la URL proporcionada o al dashboard por defecto
                        window.location.href = resp.redirect || '/dashboard';
                    } else {
                        // Mostrar mensaje de error
                        const errorMessage = resp.message || 'Error en las credenciales';
                        alert(errorMessage);
                        $("#error").removeClass('d-none');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Ocurrió un error al intentar iniciar sesión');
                })
            })
        })
    </script>

<?php

    closefooter();
