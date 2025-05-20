<?php 
// Incluir el encabezado principal
include_once LAYOUTS . 'main_head.php';
setHeader(['title' => 'Panel de Control']);

// Establecer la pestaña activa
$active = 'dashboard';
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include_once LAYOUTS . 'sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Barra superior -->
            <?php include_once LAYOUTS . 'top_nav.php'; ?>
            
            <div class="container-fluid py-4">
                <h2 class="mb-4">Panel de Control</h2>
                
                <!-- Tarjetas de resumen -->
                <div class="row">
                    <!-- Tarjeta de Productos -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Productos</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $productCount ?? 0 ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de Categorías -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Categorías</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $categoryCount ?? 0 ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta de Usuarios -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Usuarios</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $userCount ?? 0 ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos y tablas adicionales pueden ir aquí -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Resumen de Actividad</h6>
                            </div>
                            <div class="card-body">
                                <p>Bienvenido al panel de control, <?= $usuario['nombre'] ?? 'Usuario' ?>.</p>
                                <!-- Aquí puedes agregar más contenido como gráficos o tablas -->
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                // Incluir el pie de página
                include_once LAYOUTS . 'main_foot.php';
                setFooter();
                closefooter();
                ?>

                    
                    <div class="col-md-4 mb-4">
                        <div class="card card-dashboard h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">Total Proveedores</h6>
                                        <h3 class="mb-0"><?= $supplierCount ?></h3>
                                    </div>
                                    <div class="bg-light p-3 rounded">
                                        <i class="fas fa-truck text-secondary fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include_once LAYOUTS . 'footer.php'; ?>
