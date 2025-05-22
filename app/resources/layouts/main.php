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
    <link rel="stylesheet" href="/assets/css/cafe-theme.css">
    <link rel="stylesheet" href="/assets/css/cafe-sidebar.css">
</head>

<body>
    <button class="sidebar-toggle d-lg-none" id="sidebarToggle"><i class="bi bi-list"></i></button>
    <div class="sidebar" id="sidebarMenu">
        <div class="sidebar-header text-center">
            <i class="bi bi-box-seam"></i>
            <span class="fw-bold ms-2">Inventario Cafetería</span>
        </div>
        <nav class="nav flex-column mt-3">
            <a class="nav-link<?= $_SERVER['REQUEST_URI'] == '/dashboard' ? ' active' : '' ?>" href="/dashboard">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link<?= $_SERVER['REQUEST_URI'] == '/producto' ? ' active' : '' ?>" href="/producto">
                <i class="bi bi-cup-hot"></i>
                <span>Productos</span>
            </a>
            <a class="nav-link<?= $_SERVER['REQUEST_URI'] == '/categoria' ? ' active' : '' ?>" href="/categoria">
                <i class="bi bi-tags"></i>
                <span>Categorías</span>
            </a>
            <a class="nav-link<?= $_SERVER['REQUEST_URI'] == '/proveedor' ? ' active' : '' ?>" href="/proveedor">
                <i class="bi bi-truck"></i>
                <span>Proveedores</span>
            </a>
        </nav>
    </div>
    <div class="main-content <?= $_SERVER['REQUEST_URI'] == '/' ? 'home-page' : '' ?>">
        <?= $content ?? '' ?>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom scripts -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var sidebar = document.getElementById('sidebarMenu');
        var toggle = document.getElementById('sidebarToggle');
        if (toggle) {
            toggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        }
    });
    </script>
</body>

</html>