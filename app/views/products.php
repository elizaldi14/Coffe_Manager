<?php
    // Iniciar la aplicación
    require_once dirname(__DIR__) . '/bootstrap.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Configuración de la página
    $page_title = 'Gestión de Productos';
    $page_heading = 'Gestión de Productos';

    // Inicializar variables
    $productos = [];
    $categorias = [];
    $proveedores = [];
    $error = null;

    try {
        // Crear instancia del modelo
        $model = new ProductoModel($db);
        
        // Obtener datos del modelo
        $productos = $model->obtenerTodos();
        $categorias = $model->obtenerCategorias();
        $proveedores = $model->obtenerProveedores();
        
        // Configurar acciones de la página
        $page_actions = '
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-circle me-1"></i> Añadir Producto
            </button>';
        
        // Iniciar el buffer de salida
        ob_start();
    ?>
<link rel="stylesheet" href="../resource/assets/css/style.css">
<!-- Contenido específico de la página de productos -->
<div class="table-responsive">
    <?php if ($error): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($error); ?>
        <br>
        <small class="text-muted">
            Si este es tu primer uso, necesitas crear las tablas y agregar datos:
            <br>
            1. Crea las tablas categorías y proveedores
            <br>
            2. Agrega al menos una categoría
            <br>
            3. Agrega al menos un proveedor
        </small>
    </div>
    <?php endif; ?>

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
                <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                <?php 
                            // Asegurarse de que todos los campos requeridos existan
                            $producto = array_merge([
                                'id' => '',
                                'nombre' => '',
                                'descripcion' => '',
                                'categoria_nombre' => 'Sin categoría',
                                'proveedor_nombre' => 'Sin proveedor',
                                'stock' => 0,
                                'stock_minimo' => 0,
                                'precio' => 0
                            ], $producto);
                            ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['id']); ?></td>
                    <td>
                        <strong><?php echo htmlspecialchars($producto['nombre']); ?></strong>
                        <?php if (!empty($producto['descripcion'])): ?>
                        <br>
                        <small class="text-muted"><?php echo htmlspecialchars($producto['descripcion']); ?></small>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($producto['categoria_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['proveedor_nombre']); ?></td>
                    <td>
                        <?php 
                                    $stock = (int)($producto['stock'] ?? 0);
                                    $stockMinimo = (int)($producto['stock_minimo'] ?? 0);
                                    $isLowStock = $stock <= $stockMinimo;
                                    ?>
                        <span class="badge <?php echo $isLowStock ? 'bg-danger' : 'bg-success'; ?>">
                            <?php echo $stock; ?>
                        </span>
                        <?php if ($isLowStock && $stockMinimo > 0): ?>
                        <small class="text-danger d-block">Mín: <?php echo $stockMinimo; ?></small>
                        <?php endif; ?>
                    </td>
                    <td>$<?php echo number_format((float)($producto['precio'] ?? 0), 2); ?></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item edit-product" href="#" data-bs-toggle="modal"
                                        data-bs-target="#editProductModal"
                                        data-id="<?php echo htmlspecialchars($producto['id']); ?>"
                                        data-nombre="<?php echo htmlspecialchars($producto['nombre']); ?>"
                                        data-descripcion="<?php echo htmlspecialchars($producto['descripcion']); ?>"
                                        data-categoria="<?php echo htmlspecialchars($producto['categoria_id'] ?? ''); ?>"
                                        data-proveedor="<?php echo htmlspecialchars($producto['proveedor_id'] ?? ''); ?>"
                                        data-precio="<?php echo htmlspecialchars($producto['precio']); ?>"
                                        data-stock="<?php echo htmlspecialchars($producto['stock']); ?>"
                                        data-stock-minimo="<?php echo htmlspecialchars($producto['stock_minimo']); ?>">
                                        <i class="bi bi-pencil me-2"></i>Editar
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger delete-product" href="#" data-bs-toggle="modal"
                                        data-bs-target="#deleteProductModal"
                                        data-id="<?php echo htmlspecialchars($producto['id']); ?>">
                                        <i class="bi bi-trash me-2"></i>Eliminar
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No hay productos registrados</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php
    // Obtener el contenido del búfer
    $page_content = ob_get_clean();
    
    // Incluir la plantilla base que ya contiene el menú
    include __DIR__ . '/../resource/layout/base.php';
    
} catch (Exception $e) {
    // Manejar el error
    error_log('Error en la aplicación: ' . $e->getMessage());
    die('Ha ocurrido un error. Por favor, inténtalo de nuevo más tarde.');
}
?>

    <?php if (isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Añadir Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" action="../controllers/ProductoController.php?action=guardar"
                        method="POST">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="productName" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="productCategory" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria_id" name="categoria_id" required>
                                <option value="">Selecciona una categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo htmlspecialchars($categoria['id']); ?>">
                                    <?php echo htmlspecialchars($categoria['nombre'] ?? ''); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="proveedor" class="form-label">Proveedor:</label>
                            <select class="form-select" id="proveedor_id" name="proveedor_id" required>
                                <option value="">Selecciona un proveedor</option>
                                <?php foreach ($proveedores as $proveedor): ?>
                                <option value="<?php echo htmlspecialchars($proveedor['id']); ?>">
                                    <?php echo htmlspecialchars($proveedor['nombre_empresa'] ?? ''); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="productPrice" class="form-label">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="productPrice" name="precio"
                                        step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="productStock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="productStock" name="stock" min="0"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="productMinStock" class="form-label">Stock Mínimo</label>
                                <input type="number" class="form-control" id="productMinStock" name="stock_minimo"
                                    min="0" required>
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
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editProductStock" class="form-label">Stock Actual</label>
                                <input type="number" class="form-control" id="editProductStock" name="stock" min="0"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editProductMinStock" class="form-label">Stock Mínimo</label>
                                <input type="number" class="form-control" id="editProductMinStock" name="stock_minimo"
                                    min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="editProductPrice" name="precio"
                                    step="0.01" min="0" required>
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
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar este producto? Esta acción no se puede deshacer.</p>
                    <input type="hidden" id="deleteProductId">
                    <div class="btn-group">
                        <a href="/productos/editar/<?php echo $producto['id']; ?>"
                            class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-outline-danger"
                            onclick="confirmarEliminar(<?php echo $producto['id']; ?>)" data-bs-toggle="tooltip"
                            title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
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

    <!-- Script para manejar la edición y eliminación de productos -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configurar el modal de edición con los datos del producto
        const editModal = document.getElementById('editProductModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nombre = button.getAttribute('data-nombre');
                const descripcion = button.getAttribute('data-descripcion');
                const categoria = button.getAttribute('data-categoria');
                const proveedor = button.getAttribute('data-proveedor');
                const stock = button.getAttribute('data-stock');
                const stockMinimo = button.getAttribute('data-stock-minimo') || '0';
                const precio = button.getAttribute('data-precio');

                // Actualizar el formulario de edición
                document.getElementById('editProductId').value = id;
                document.getElementById('editProductName').value = nombre;
                document.getElementById('editProductDescription').value = descripcion || '';
                document.getElementById('editProductCategory').value = categoria;
                document.getElementById('editProductSupplier').value = proveedor || '';
                document.getElementById('editProductStock').value = stock;
                document.getElementById('editProductMinStock').value = stockMinimo;
                document.getElementById('editProductPrice').value = precio;
            });
        }

        // Configurar el modal de eliminación
        const deleteModal = document.getElementById('deleteProductModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                document.getElementById('deleteProductId').value = id;
            });
        }
    });

    // Función para confirmar eliminación
    function confirmarEliminar() {
        const id = document.getElementById('deleteProductId').value;
        if (confirm('¿Estás seguro de eliminar este producto?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/app/controllers/ProductoController.php?action=eliminar&id=${id}`;

            // Agregar token CSRF si es necesario
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]')?.content || '';
            form.appendChild(csrfToken);

            document.body.appendChild(form);
            form.submit();
        }
    }

    // Manejar la actualización de un producto
    const updateProductBtn = document.getElementById('updateProductBtn');
    if (updateProductBtn) {
        updateProductBtn.addEventListener('click', function() {
                // Obtener los valores del formulario
                const id = document.getElementById('editProductId').value;
                const nombre = document.getElementById('editProductName').value;
                const categoria = document.getElementById('editProductCategory').value;
                const proveedor = document.getElementById('editProductSupplier').value;
                const stock = document.getElementById('editProductStock').value;
                const stockMinimo = document.getElementById('editProductMinStock').value;
                const precio = document.getElementById('editProductPrice').value;

                // Validar que todos los campos requeridos estén completos
                if (!nombre || !categoria || !proveedor || stock === '' || stockMinimo === '' || precio === '') {
                    alert('Por favor complete todos los campos obligatorios');
                    return;
                }

                // Validar que el stock mínimo no sea mayor al stock actual
                if (parseInt(stock) < parseInt(stockMinimo)) {
                    alert('El stock no puede ser menor al stock mínimo');
                    return;
                }

                // Crear el objeto con los datos del formulario
                const formData = new FormData();
                formData.append('nombre', nombre);
                formData.append('categoria_id', categoria);
                formData.append('proveedor_id', proveedor);
                formData.append('stock', stock);
                formData.append('stock_minimo', stockMinimo);
                formData.append('precio', precio);

                // Enviar la solicitud al servidor
                const response = await fetch('/app/controllers/ProductoController.php?action=guardar', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then data => {
                        if (data.error) {
                            alert('Error: ' + data.error);
                        } else {
                            alert('Producto actualizado correctamente');
                            // Cerrar el modal y recargar la página
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'editProductModal'));
                            modal.hide();
                            window.location.reload();
                        }
                    })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar el producto');
            });
        });
    }
    </script>
    <!-- Custom JS -->
    <script src="../resource/assets/js/main.js"></script>

    <script>
    // Mostrar SweetAlert de carga
    function showLoading() {
        Swal.fire({
            title: 'Procesando...',
            html: 'Por favor espera un momento.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    // Manejar el envío del formulario de agregar producto
    document.addEventListener('DOMContentLoaded', function() {
        const saveProductBtn = document.getElementById('saveProductBtn');
        if (saveProductBtn) {
            saveProductBtn.addEventListener('click', async function() {
                try {
                    // Obtener los valores del formulario
                    const formData = new FormData(document.getElementById('addProductForm'));

                    // Mostrar loading
                    const loading = Swal.fire({
                        title: 'Guardando...',
                        text: 'Por favor, espere...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Enviar la solicitud al servidor
                    fetch('app/controllers/ProductoController.php?action=guardar', {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Respuesta completa:',
                                data); // Agrega esto para depuración
                            if (data.error) {
                                throw new Error(data.error);
                            }
                            // Resto de tu lógica de éxito...
                        })
                        .catch(error => {
                            console.error('Error en la solicitud:', error);
                            Swal.fire('Error', error.message, 'error');
                        });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    // Cerrar loading
                    Swal.close();

                    if (data.error) {
                        // Mostrar error
                        await Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error,
                            confirmButtonText: 'Entendido'
                        });
                    } else if (data.success) {
                        // Mostrar mensaje de éxito
                        const result = await Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: data.message || 'Producto guardado correctamente',
                            showCancelButton: false,
                            confirmButtonText: 'Aceptar'
                        });

                        // Si se hizo clic en Aceptar, recargar la página
                        if (result.isConfirmed) {
                            // Cerrar el modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'addProductModal'));
                            if (modal) {
                                modal.hide();
                            }
                            // Limpiar el formulario
                            document.getElementById('addProductForm').reset();
                            // Recargar la página
                            window.location.reload();
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    // Cerrar cualquier alerta abierta
                    Swal.close();
                    // Mostrar mensaje de error general
                    await Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message ||
                            'Ocurrió un error al guardar el producto. Por favor, intente de nuevo.',
                        confirmButtonText: 'Entendido'
                    });
                }
            });
        }
    });
    </script>
    </body>

    </html>