<?php
/**
 * Sidebar principal del panel de administración
 * 
 * Variables disponibles:
 * - $active: Indica qué elemento del menú está activo
 */
?>
<!-- Sidebar -->
<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse" style="background-color: #2c3e50;">
    <div class="position-sticky pt-3">
        <!-- Logo y nombre de la aplicación -->
        <div class="text-center mb-4 p-3">
            <h4 class="text-white">
                <i class="fas fa-coffee me-2"></i>
                Coffee Manager
            </h4>
        </div>

        <!-- Menú de navegación -->
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white <?= ($active ?? '') === 'dashboard' ? 'bg-primary' : 'hover-bg-dark' ?>" 
                   href="/dashboard">
                    <i class="fas fa-home me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= ($active ?? '') === 'products' ? 'bg-primary' : 'hover-bg-dark' ?>" 
                   href="/Products">
                    <i class="fas fa-box me-2"></i>
                    Productos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= ($active ?? '') === 'categories' ? 'bg-primary' : 'hover-bg-dark' ?>" 
                   href="/Categories">
                    <i class="fas fa-tags me-2"></i>
                    Categorías
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= ($active ?? '') === 'suppliers' ? 'bg-primary' : 'hover-bg-dark' ?>" 
                   href="/Suppliers">
                    <i class="fas fa-truck me-2"></i>
                    Proveedores
                </a>
            </li>
            <li class="nav-item mt-4 border-top border-secondary">
                <a class="nav-link text-white hover-bg-dark" href="/auth/logout">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Cerrar Sesión
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
    .sidebar {
        min-height: 100vh;
        transition: all 0.3s;
    }
    .nav-link {
        border-radius: 0.25rem;
        margin: 0.25rem 0.5rem;
        padding: 0.75rem 1rem;
        transition: all 0.3s;
    }
    .nav-link i {
        width: 20px;
        text-align: center;
    }
    .hover-bg-dark:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
    }
    .bg-primary {
        background-color: #3498db !important;
    }
</style>
<!-- Fin del Sidebar -->
