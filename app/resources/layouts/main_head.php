<?php
function setHeader($args){
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?=CSS?>bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title><?= $args->title ?></title>
    <style>
    body {
        color: #222;
        background-color: #f8f9fa;
    }

    .sidebar {
        min-height: 100vh;
        background: #0d6efd;
        color: #fff;
        width: 220px;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1030;
        transition: all 0.3s;
    }

    .sidebar .nav-link {
        color: #fff;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
        background: #0b5ed7;
        color: #fff;
    }

    .sidebar .sidebar-header {
        font-size: 1.3rem;
        font-weight: bold;
        padding: 1.5rem 1rem 1rem 1rem;
        border-bottom: 1px solid #0b5ed7;
    }

    .main-content {
        margin-left: 220px;
        padding: 2rem 1rem 1rem 1rem;
    }

    @media (max-width: 991.98px) {
        .sidebar {
            left: -220px;
        }

        .sidebar.active {
            left: 0;
        }

        .main-content {
            margin-left: 0;
        }
    }

    .sidebar-toggle {
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1040;
        background: #0d6efd;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: none;
    }

    @media (max-width: 991.98px) {
        .sidebar-toggle {
            display: block;
        }
    }
    </style>
</head>

<body>
    <button class="sidebar-toggle d-lg-none" id="sidebarToggle"><i class="bi bi-list"></i></button>
    <div class="sidebar" id="sidebarMenu">
        <div class="sidebar-header text-center">
            <i class="bi bi-box-seam"></i> Inventario Cafetería
        </div>
        <nav class="nav flex-column mt-3">
            <a class="nav-link<?= $_SERVER['REQUEST_URI'] == '/dashboard' ? ' active' : '' ?>" href="/dashboard"><i
                    class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            <a class="nav-link<?= $_SERVER['REQUEST_URI'] == '/producto' ? ' active' : '' ?>" href="/producto"><i
                    class="bi bi-cup-straw me-2"></i>Productos</a>
            <a class="nav-link<?= $_SERVER['REQUEST_URI'] == '/categoria' ? ' active' : '' ?>" href="/categoria"><i
                    class="bi bi-tags me-2"></i>Categorías</a>
            <a class="nav-link<?= $_SERVER['REQUEST_URI'] == '/proveedor' ? ' active' : '' ?>" href="/proveedor"><i
                    class="bi bi-truck me-2"></i>Proveedores</a>
        </nav>
    </div>
    <div class="main-content">
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
        <?php
}