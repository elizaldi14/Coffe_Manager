<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Sistema de Gestión de Inventario</title>
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
                            <a class="nav-link active text-white" href="products.php">
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
                            <a class="nav-link text-white" href="suppliers.php">
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
                    <h1 class="h2">Gestión de Productos</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            <i class="bi bi-plus-circle me-1"></i> Añadir Producto
                        </button>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Café Americano</td>
                                <td>Bebidas Calientes</td>
                                <td>Café Especial S.A.</td>
                                <td>120</td>
                                <td>$2.50</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item edit-product" href="#" data-id="1" data-name="Café Americano" data-category="Bebidas Calientes" data-supplier="Café Especial S.A." data-stock="120" data-price="2.50"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                            <li><a class="dropdown-item delete-product" href="#" data-id="1"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Café Latte</td>
                                <td>Bebidas Calientes</td>
                                <td>Café Especial S.A.</td>
                                <td>85</td>
                                <td>$3.25</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <li><a class="dropdown-item edit-product" href="#" data-id="2" data-name="Café Latte" data-category="Bebidas Calientes" data-supplier="Café Especial S.A." data-stock="85" data-price="3.25"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                            <li><a class="dropdown-item delete-product" href="#" data-id="2"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Cappuccino</td>
                                <td>Bebidas Calientes</td>
                                <td>Café Especial S.A.</td>
                                <td>70</td>
                                <td>$3.50</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            <li><a class="dropdown-item edit-product" href="#" data-id="3" data-name="Cappuccino" data-category="Bebidas Calientes" data-supplier="Café Especial S.A." data-stock="70" data-price="3.50"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                            <li><a class="dropdown-item delete-product" href="#" data-id="3"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Muffin de Arándanos</td>
                                <td>Panadería</td>
                                <td>Dulces Delicias</td>
                                <td>45</td>
                                <td>$2.75</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                            <li><a class="dropdown-item edit-product" href="#" data-id="4" data-name="Muffin de Arándanos" data-category="Panadería" data-supplier="Dulces Delicias" data-stock="45" data-price="2.75"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                            <li><a class="dropdown-item delete-product" href="#" data-id="4"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Sandwich de Pollo</td>
                                <td>Alimentos</td>
                                <td>Alimentos Frescos</td>
                                <td>30</td>
                                <td>$4.50</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                            <li><a class="dropdown-item edit-product" href="#" data-id="5" data-name="Sandwich de Pollo" data-category="Alimentos" data-supplier="Alimentos Frescos" data-stock="30" data-price="4.50"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                            <li><a class="dropdown-item delete-product" href="#" data-id="5"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
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

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Añadir Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="productName" required>
                        </div>
                        <div class="mb-3">
                            <label for="productCategory" class="form-label">Categoría</label>
                            <select class="form-select" id="productCategory" required>
                                <option value="">Seleccionar Categoría</option>
                                <option value="1">Bebidas Calientes</option>
                                <option value="2">Bebidas Frías</option>
                                <option value="3">Panadería</option>
                                <option value="4">Alimentos</option>
                                <option value="5">Postres</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productSupplier" class="form-label">Proveedor</label>
                            <select class="form-select" id="productSupplier" required>
                                <option value="">Seleccionar Proveedor</option>
                                <option value="1">Café Especial S.A.</option>
                                <option value="2">Dulces Delicias</option>
                                <option value="3">Alimentos Frescos</option>
                                <option value="4">Lácteos del Valle</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productStock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="productStock" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="productPrice" step="0.01" min="0" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveProductBtn">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" id="editProductId">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="editProductName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductCategory" class="form-label">Categoría</label>
                            <select class="form-select" id="editProductCategory" required>
                                <option value="">Seleccionar Categoría</option>
                                <option value="1">Bebidas Calientes</option>
                                <option value="2">Bebidas Frías</option>
                                <option value="3">Panadería</option>
                                <option value="4">Alimentos</option>
                                <option value="5">Postres</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editProductSupplier" class="form-label">Proveedor</label>
                            <select class="form-select" id="editProductSupplier" required>
                                <option value="">Seleccionar Proveedor</option>
                                <option value="1">Café Especial S.A.</option>
                                <option value="2">Dulces Delicias</option>
                                <option value="3">Alimentos Frescos</option>
                                <option value="4">Lácteos del Valle</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editProductStock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="editProductStock" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="editProductPrice" step="0.01" min="0" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="updateProductBtn">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar este producto? Esta acción no se puede deshacer.</p>
                    <input type="hidden" id="deleteProductId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
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
