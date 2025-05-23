<?php
    // Iniciar la aplicación
    require_once dirname(__DIR__) . '/bootstrap.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Configuración de la página
    $page_title = 'Gestión de Productos';
    $page_heading = 'Gestión de Productos';

   <?php
// Inicializar variables
$productos = [];
$categorias = [];
$proveedores = [];
$error = null;

try {
    // Crear instancia del modelo (Asegúrate de que $db esté definido en este scope o inyectado)
    // Ejemplo: $db = new PDO('mysql:host=localhost;dbname=your_db', 'user', 'password');
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
<div class="table-responsive">
    <?php if ($error): // Este $error solo se llenaría si la inicialización o las primeras llamadas al modelo fallaran antes del try/catch ?>
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
                    // Asegurarse de que todos los campos requeridos existan con valores predeterminados
                    $producto = array_merge([
                        'id' => '',
                        'nombre' => '',
                        'descripcion' => '',
                        'categoria_nombre' => 'Sin categoría',
                        'proveedor_nombre' => 'Sin proveedor',
                        'stock' => 0,
                        'stock_minimo' => 0,
                        'precio' => 0,
                        'categoria_id' => '', // Asegurarse de que existan para el data-categoria
                        'proveedor_id' => ''  // Asegurarse de que existan para el data-proveedor
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
                                        data-categoria="<?php echo htmlspecialchars($producto['categoria_id']); ?>"
                                        data-proveedor="<?php echo htmlspecialchars($producto['proveedor_id']); ?>"
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
    $error = 'Ha ocurrido un error al cargar los productos: ' . $e->getMessage(); // Establecer el error para mostrarlo en la vista
    // También podrías redirigir o mostrar una página de error más amigable
    die('Ha ocurrido un error. Por favor, inténtalo de nuevo más tarde.');
}
?>

    <?php if (isset($success)): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

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
                            <label for="productDescriptionAdd" class="form-label">Descripción</label>
                            <textarea class="form-control" id="productDescriptionAdd" name="descripcion" rows="3"></textarea>
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button> </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                        <input type="hidden" id="editProductId" name="id"> <div class="mb-3">
                            <label for="editProductName" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="editProductName" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductDescription" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editProductDescription" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editProductCategory" class="form-label">Categoría</label>
                            <select class="form-select" id="editProductCategory" name="categoria_id" required>
                                <option value="">Seleccionar Categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?php echo htmlspecialchars($categoria['id']); ?>">
                                        <?php echo htmlspecialchars($categoria['nombre'] ?? ''); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editProductSupplier" class="form-label">Proveedor</label>
                            <select class="form-select" id="editProductSupplier" name="proveedor_id" required>
                                <option value="">Seleccionar Proveedor</option>
                                <?php foreach ($proveedores as $proveedor): ?>
                                    <option value="<?php echo htmlspecialchars($proveedor['id']); ?>">
                                        <?php echo htmlspecialchars($proveedor['nombre_empresa'] ?? ''); ?>
                                    </option>
                                <?php endforeach; ?>
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="updateProductBtn">Actualizar</button> </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de eliminación -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function() {
    // --- EDITAR PRODUCTO ---
    $(document).on('click', '.edit-product', function(e) {
        e.preventDefault();
        $('#editProductId').val($(this).data('id'));
        $('#editProductName').val($(this).data('nombre'));
        $('#editProductDescription').val($(this).data('descripcion') || '');
        $('#editProductCategory').val(String($(this).data('categoria')));
        $('#editProductSupplier').val(String($(this).data('proveedor')));
        $('#editProductPrice').val($(this).data('precio'));
        $('#editProductStock').val($(this).data('stock'));
        $('#editProductMinStock').val($(this).data('stockMinimo'));
        $('#editProductModal').modal('show');
    });

    $('#editProductForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '../controllers/ProductoController.php?action=actualizar',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(resp) {
                if (resp.success) {
                    $('#editProductModal').modal('hide');
                    location.reload();
                } else {
                    alert(resp.error || 'Error al actualizar el producto');
                }
            },
            error: function(xhr) {
                alert('Error en la comunicación con el servidor al actualizar producto.');
                console.error('Error AJAX al actualizar producto:', xhr.responseText);
            }
        });
    });

    // --- AGREGAR PRODUCTO ---
    $('#addProductForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(resp) {
                if (resp.success) {
                    $('#addProductModal').modal('hide');
                    alert('Producto añadido correctamente');
                    location.reload();
                } else {
                    alert(resp.error || 'Error al añadir el producto');
                }
            },
            error: function(xhr) {
                alert('Error en la comunicación con el servidor al añadir producto.');
                console.error('Error AJAX al añadir producto:', xhr.responseText);
            }
        });
    });

    // --- ELIMINAR PRODUCTO ---
    $(document).on('click', '.delete-product', function(e) {
        e.preventDefault();
        $('#deleteProductId').val($(this).data('id'));
        $('#deleteProductModal').modal('show');
    });

    $('#confirmDeleteBtn').on('click', function() {
        var id = $('#deleteProductId').val();
        $.ajax({
            url: '../controllers/ProductoController.php?action=eliminar',
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(resp) {
                if (resp.success) {
                    $('#deleteProductModal').modal('hide');
                    location.reload();
                } else {
                    alert(resp.error || 'Error al eliminar el producto');
                }
            },
            error: function(xhr) {
                alert('Error en la comunicación con el servidor al eliminar producto.');
                console.error('Error AJAX al eliminar producto:', xhr.responseText);
            }
        });
    });
});
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