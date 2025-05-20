<?php
/**
 * Main layout template
 * 
 * @var string $title Page title
 * @var array $styles Additional stylesheets to include
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Gestión de Inventario">
    <meta name="author" content="">
    
    <title><?= htmlspecialchars($title ?? 'Gestor de Inventario') ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= URL ?>favicon.ico">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom styles -->
    <?php if (isset($styles) && is_array($styles)): ?>
        <?php foreach ($styles as $style): ?>
            <link rel="stylesheet" href="<?= URL ?>css/<?= $style ?>.css">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <script>
        // Global configuration
        window.AppConfig = {
            baseUrl: '<?= URL ?>',
            csrfToken: '<?= csrf_token() ?>'
        };
    </script>
</head>
<body class="bg-light">
    <!-- Content from the view will be injected here -->
    <?= $content ?? '' ?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom scripts -->
    <script>
        // Base URL helper
        const baseUrl = '<?= URL ?>';
        
        // CSRF token for AJAX requests
        const csrfToken = '<?= csrf_token() ?>';
        
        // Set up AJAX headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    </script>
</body>
</html>
