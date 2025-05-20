<?php
/** @var string $title */
/** @var string $message */
?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-8 text-center">
            <div class="error-content">
                <div class="mb-4">
                    <i class="bi bi-shield-lock text-danger" style="font-size: 5rem;"></i>
                </div>
                <h1 class="mb-4"><?= $title ?? 'Acceso denegado' ?></h1>
                <p class="lead mb-4">
                    <?= $message ?? 'No tienes permiso para acceder a esta página.' ?>
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Volver atrás
                    </a>
                    <a href="<?= URL ?>" class="btn btn-primary">
                        <i class="bi bi-house-door me-2"></i>Ir al inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-content {
    padding: 2rem;
    border-radius: 0.5rem;
    background-color: #fff;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}
</style>
