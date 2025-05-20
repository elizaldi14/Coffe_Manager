<?php
    include_once LAYOUTS . 'main_head.php';
    setHeader($d);
?>

<div class="login-container min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
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
                                <label for="username" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       placeholder="Ingresa tu usuario" required>
                            </div>
                            <div class="mb-4">
                                <label for="passwd" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="passwd" name="passwd" 
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
    background-color: #f8f9fa;
}
.card {
    border-radius: 10px;
    overflow: hidden;
    border: none;
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
                .then( resp  => resp.json())
                .then( resp => {
                    if( resp.r !== false ){
                        location.href = "/"
                    }else{
                        $("#error").removeClass('d-none')
                    }
                }).catch( err => console.error( err ))
            })
        })
    </script>

<?php

    closefooter();
