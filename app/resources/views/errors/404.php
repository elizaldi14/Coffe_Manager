<?php
/** @var string $title */
/** @var string $message */
?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-8 text-center">
            <div class="error-content">
                <h1 class="display-1 text-danger">404</h1>
                <h2 class="mb-4"><?= $title ?? 'Página no encontrada' ?></h2>
                <p class="lead mb-4">
                    <?= $message ?? 'La página que estás buscando no existe o ha sido movida.' ?>
                </p>
                <a href="<?= URL ?>" class="btn btn-primary">
                    <i class="bi bi-house-door me-2"></i>Volver al inicio
                </a>
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

.display-1 {
    font-size: 8rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 1rem;
}
</style>
