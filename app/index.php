<?php
// Iniciar la aplicación
require_once __DIR__ . '/bootstrap.php';

try {
    // Crear instancia del controlador
    $controller = new DashboardController($db);
    
    // Configuración de la página
    $page_title = 'Dashboard';
    $page_heading = 'Panel de Control';
    
    // Obtener datos del controlador
    $data = $controller->index();
    
    // Iniciar el buffer de salida
    ob_start();
    ?>
    
    <link rel="stylesheet" href="../resource/assets/css/style.css">
    <!-- Contenido principal -->
    <div class="container-fluid">
        <!-- Dashboard Cards -->
        <div class="row">
            <!-- Productos -->
            <div class="col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Productos</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['total_productos']; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-cup-hot fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categorías -->
            <div class="col-md-4 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Categorías</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['total_categorias']; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-tags fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Proveedores -->
            <div class="col-md-4 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Proveedores</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['total_proveedores']; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-truck fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de productos con bajo stock -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Productos con bajo stock</h6>
            </div>
            <div class="card-body">
                <?php if (!empty($data['productos_bajo_stock'])): ?>
                    <?php foreach ($data['productos_bajo_stock'] as $producto): 
                        $porcentaje = ($producto['stock'] / $producto['stock_minimo']) * 100;
                        $clase = $porcentaje < 30 ? 'bg-danger' : ($porcentaje < 60 ? 'bg-warning' : 'bg-success');
                    ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><?php echo htmlspecialchars($producto['nombre_producto']); ?></span>
                            <small class="text-muted"><?php echo $producto['stock']; ?>/<?php echo $producto['stock_minimo']; ?></small>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar <?php echo $clase; ?>" 
                                 role="progressbar" 
                                 style="width: <?php echo min(100, $porcentaje); ?>%;" 
                                 aria-valuenow="<?php echo $producto['stock']; ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="<?php echo $producto['stock_minimo']; ?>">
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted py-3">
                        No hay productos con bajo inventario.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php
    // Obtener el contenido del buffer y limpiarlo
    $content = ob_get_clean();
    
    // Incluir la vista base
    include __DIR__ . '/resource/layout/base.php';
    
} catch (Exception $e) {
    // Manejar el error
    error_log('Error en la aplicación: ' . $e->getMessage());
    die('Ha ocurrido un error. Por favor, inténtalo de nuevo más tarde.');
}
?>
