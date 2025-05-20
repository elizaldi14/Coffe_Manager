<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores - Sistema de Gestión de Inventario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h5 class="text-white">Café Inventario</h5>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../index.php">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="products.php">
                                <i class="bi bi-cup-hot me-2"></i>
                                Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="categories.php">
                                <i class="bi bi-tags me-2"></i>
                                Categorías
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="suppliers.php">
                                <i class="bi bi-truck me-2"></i>
                                Proveedores
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Gestión de Proveedores</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                            <i class="bi bi-plus-circle me-1"></i> Añadir Proveedor
                        </button>
                    </div>
                </div>

                <!-- Suppliers Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Contacto</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Email</th>
                                <th scope="col">Productos</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Café Especial S.A.</td>
                                <td>Juan Pérez</td>
                                <td>+1 234-567-8901</td>
                                <td>juan@cafeespecial.com</td>
                                <td>15</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item edit-supplier" href="#" data-id="1" data-name="Café Especial S.A." data-contact="Juan Pérez" data-phone="+1 234-567-8901" data-email="juan@cafeespecial.com"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                            <li><a class="dropdown-item delete-supplier" href="#" data-id="1"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Dulces Delicias</td>
                                <td>María Rodríguez</td>
                                <td>+1 234-567-8902</td>
                                <td>maria@dulcesdelicias.com</td>
                                <td>8</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <li><a class="dropdown-item edit-supplier" href="#" data-id="2" data-name="Dulces Delicias" data-contact="María Rodríguez" data-phone="+1 234-567-8902" data-email="maria@dulcesdelicias.com"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                            <li><a class="dropdown-item delete-supplier" href="#" data-id="2"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Alimentos Frescos</td>
                                <td>Carlos Gómez</td>
                                <td>+1 234-567-8903</td>
                                <td>carlos@alimentosfrescos.com</td>
                                <td>6</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            <li><a class="dropdown-item edit-supplier" href="#" data-id="3" data-name="Alimentos Frescos" data-contact="Carlos Gómez" data-phone="+1 234-567-8903" data-email="carlos@alimentosfrescos.com"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                            <li><a class="dropdown-item delete-supplier" href="#" data-id="3"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Lácteos del Valle</td>
                                <td>Ana Martínez</td>
                                <td>+1 234-567-8904</td>
                                <td>ana@lacteosdelvalle.com</td>
                                <td>4</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                            <li><a class="dropdown-item edit-supplier" href="#" data-id="4" data-name="Lácteos del Valle" data-contact="Ana Martínez" data-phone="+1 234-567-8904" data-email="ana@lacteosdelvalle.com"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                            <li><a class="dropdown-item delete-supplier" href="#" data-id="4"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Orgánicos Premium</td>
                                <td>Roberto Sánchez</td>
                                <td>+1 234-567-8905</td>
                                <td>roberto@organicospremium.com</td>
                                <td>3</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                            <li><a class="dropdown-item edit-supplier" href="#" data-id="5" data-name="Orgánicos Premium" data-contact="Roberto Sánchez" data-phone="+1 234-567-8905" data-email="roberto@organicospremium.com"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                            <li><a class="dropdown-item delete-supplier" href="#" data-id="5"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Supplier Modal -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplierModalLabel">Añadir Nuevo Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSupplierForm">
                        <div class="mb-3">
                            <label for="supplierName" class="form-label">Nombre del Proveedor</label>
                            <input type="text" class="form-control" id="supplierName" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplierContact" class="form-label">Persona de Contacto</label>
                            <input type="text" class="form-control" id="supplierContact" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplierPhone" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="supplierPhone" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplierEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="supplierEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplierAddress" class="form-label">Dirección</label>
                            <textarea class="form-control" id="supplierAddress" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveSupplierBtn">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Supplier Modal -->
    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSupplierModalLabel">Editar Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSupplierForm">
                        <input type="hidden" id="editSupplierId">
                        <div class="mb-3">
                            <label for="editSupplierName" class="form-label">Nombre del Proveedor</label>
                            <input type="text" class="form-control" id="editSupplierName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierContact" class="form-label">Persona de Contacto</label>
                            <input type="text" class="form-control" id="editSupplierContact" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierPhone" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="editSupplierPhone" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editSupplierEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSupplierAddress" class="form-label">Dirección</label>
                            <textarea class="form-control" id="editSupplierAddress" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="updateSupplierBtn">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteSupplierModal" tabindex="-1" aria-labelledby="deleteSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSupplierModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar este proveedor? Esta acción no se puede deshacer y podría afectar a los productos asociados.</p>
                    <input type="hidden" id="deleteSupplierId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteSupplierBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JS -->
    <script src="../controller/main.js"></script>
</body>
</html>
