<?php
/** @var string $title */
/** @var string $message */
/** @var mixed $error */
?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-10">
            <div class="error-content p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem;"></i>
                    <h1 class="mt-3"><?= $title ?? '¡Error del servidor!' ?></h1>
                </div>
                
                <div class="alert alert-danger">
                    <p class="mb-0">
                        <?= $message ?? 'Lo sentimos, algo salió mal en nuestro servidor. Por favor, inténtalo de nuevo más tarde.' ?>
                    </p>
                </div>
                
                <?php if (isset($error) && (is_string($error) || (is_object($error) && method_exists($error, '__toString')))): ?>
                    <div class="card mt-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Detalles del error</h5>
                        </div>
                        <div class="card-body">
                            <pre class="mb-0 text-danger" style="white-space: pre-wrap; word-break: break-word;"><?= htmlspecialchars((string) $error) ?></pre>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="text-center mt-5">
                    <a href="<?= URL ?>" class="btn btn-primary me-2">
                        <i class="bi bi-house-door me-2"></i>Ir al inicio
                    </a>
                    <button onclick="window.location.reload()" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reintentar
                    </button>
                </div>
                
                <?php if (isset($_SERVER['HTTP_REFERER'])): ?>
                    <div class="text-center mt-3">
                        <a href="javascript:history.back()" class="text-muted">
                            <i class="bi bi-arrow-left me-1"></i>Volver a la página anterior
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.error-content {
    background-color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

pre {
    font-family: 'Courier New', Courier, monospace;
    font-size: 0.875rem;
    line-height: 1.5;
    margin: 0;
}
</style>
