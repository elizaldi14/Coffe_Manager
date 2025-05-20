<?php
/**
 * Barra superior del panel de administración
 * 
 * Variables disponibles:
 * - $usuario: Array con la información del usuario
 */
?>
<!-- Top Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom mb-4">
    <div class="container-fluid">
        <!-- Botón para mostrar/ocultar el sidebar en móviles -->
        <button class="btn btn-link d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Menú de usuario -->
        <div class="dropdown ms-auto">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
               data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle me-2"></i>
                <?= htmlspecialchars($usuario['nombre'] ?? 'Usuario') ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                    <a class="dropdown-item" href="/perfil">
                        <i class="fas fa-user-cog me-2"></i>Mi Perfil
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="/auth/logout">
                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Fin de Top Navigation -->
