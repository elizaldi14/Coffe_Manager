<?php 
    include_once LAYOUTS . 'header.php';
    $active = 'dashboard';
?>

<div class="container-fluid">
    <div class="row">
        <?php include_once LAYOUTS . 'sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <?php include_once LAYOUTS . 'top_menu.php'; ?>
            
            <div class="container-fluid py-4">
                <h2 class="mb-4">Dashboard</h2>
                
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card card-dashboard h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">Total Productos</h6>
                                        <h3 class="mb-0"><?= $productCount ?></h3>
                                    </div>
                                    <div class="bg-light p-3 rounded">
                                        <i class="fas fa-box text-secondary fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card card-dashboard h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">Total Categorías</h6>
                                        <h3 class="mb-0"><?= $categoryCount ?></h3>
                                    </div>
                                    <div class="bg-light p-3 rounded">
                                        <i class="fas fa-tags text-secondary fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
