<!-- Sidebar -->
<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4">
            <h5 class="text-white">Café Inventario</h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/index.php') !== false ? 'active' : ''; ?> text-white" href="../../index.php">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/products.php') !== false ? 'active' : ''; ?> text-white" href="../../views/products.php">
                    <i class="bi bi-cup-hot me-2"></i>
                    Productos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/categories.php') !== false ? 'active' : ''; ?> text-white" href="../../views/categories.php">
                    <i class="bi bi-tags me-2"></i>
                    Categorías
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], '/suppliers.php') !== false ? 'active' : ''; ?> text-white" href="../../views/suppliers.php">
                    <i class="bi bi-truck me-2"></i>
                    Proveedores
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Script para manejar el cierre de sesión -->
<script>
document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault();
    if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        window.location.href = 'logout.php';
    }
});
</script>
