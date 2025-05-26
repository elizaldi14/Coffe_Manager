 -<?php
// ...no incluir bootstrap.php aquí, el layout lo hace...
?>
<link rel="stylesheet" href="/assets/css/cafe-theme.css">
<div class="container py-4">
    <div class="cafe-header mb-3">
        <h3 class="mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-cup-hot"></i>
            <span>Productos</span>
        </h3>
        <button class="btn btn-primary d-flex align-items-center gap-2 rounded-pill" id="btn-add-producto">
            <i class="bi bi-plus-circle"></i>
            <span>Agregar nuevo</span>
        </button>
    </div>
    <div class="table-responsive rounded-4 bg-white p-0">
        <table class="table table-borderless align-middle mb-0" id="tabla-productos">
            <thead>
                <tr>
                    <th class="fw-semibold">#</th>
                    <th class="fw-semibold">Nombre</th>
                    <th class="fw-semibold">Categoría</th>
                    <th class="fw-semibold">Proveedor</th>
                    <th class="fw-semibold">Stock</th>
                    <th class="fw-semibold">Precio</th>
                    <th class="fw-semibold text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se cargan los productos por JS o PHP -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar/Editar Producto -->
<div class="modal fade" id="modal-producto" tabindex="-1">
    <div class="modal-dialog">
        <form id="form-producto" class="modal-content border-0 rounded-4">
            <div class="modal-header border-0" style="background: var(--primary-color); color: #fff;">
                <h5 class="modal-title" id="modal-producto-title">Agregar Producto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_producto" id="producto-id">
                <div class="mb-3">
                    <label for="producto-nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="producto-nombre" required>
                </div>
                <div class="mb-3">
                    <label for="producto-categoria" class="form-label">Categoría</label>
                    <select class="form-select" name="categoria" id="producto-categoria" required>
                        <option value="">Seleccione una categoría</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="producto-proveedor" class="form-label">Proveedor</label>
                    <select class="form-select" name="proveedor" id="producto-proveedor" required>
                        <option value="">Seleccione un proveedor</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="producto-precio" class="form-label">Precio</label>
                    <input type="number" class="form-control" name="precio" id="producto-precio" min="0" step="0.01"
                        required>
                </div>
                <div class="mb-3">
                    <label for="producto-stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" name="stock" id="producto-stock" min="0" required>
                </div>
                <div class="mb-3">
                    <label for="producto-stock-minimo" class="form-label">Stock mínimo</label>
                    <input type="number" class="form-control" name="stock_minimo" id="producto-stock-minimo" min="0"
                        value="0">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-success rounded-pill px-4">Guardar</button>
                <button type="button" class="btn btn-secondary rounded-pill px-4"
                    data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    function cargarProductos() {
        $.getJSON('/producto/list', function(data) {
            let productos = typeof data === 'string' ? JSON.parse(data) : data;
            let html = '';
            $.each(productos, function(i, prod) {
                // Asegurarse de que los IDs de categoría y proveedor estén definidos
                const idCategoria = prod.id_categoria || '';
                const idProveedor = prod.id_proveedor || '';
                const nombreCategoria = prod.categoria || 'Sin categoría';
                const nombreProveedor = prod.proveedor || 'Sin proveedor';

                html += `<tr>
                    <td>${prod.id_producto}</td>
                    <td>${prod.nombre_producto}</td>
                    <td>${nombreCategoria}</td>
                    <td>${nombreProveedor}</td>
                    <td>
                        <span class="badge rounded-pill px-3 py-2" style="background: var(--primary-color); color: #fff;">
                            ${prod.stock}
                        </span>
                    </td>
                    <td>
                        <span class="fw-semibold" style="color: var(--dark-color);">
                            $${parseFloat(prod.precio).toFixed(2)}
                        </span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm btn-edit rounded-pill me-1"
                            data-id="${prod.id_producto}"
                            data-nombre="${prod.nombre_producto}"
                            data-precio="${prod.precio}"
                            data-stock="${prod.stock}"
                            data-categoria="${idCategoria}"
                            data-proveedor="${idProveedor}"
                            data-stock_minimo="${prod.stock_minimo || 0}"
                            data-nombre_producto="${prod.nombre_producto}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete rounded-pill" data-id="${prod.id_producto}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>`;
            });
            $('#tabla-productos tbody').html(html);
        });
    }

    function cargarCategoriasSelect(selectedId = '', callback = null) {
        $.getJSON('/categoria/list', function(data) {
            let categorias = typeof data === 'string' ? JSON.parse(data) : data;
            let options = '<option value="">Seleccione una categoría</option>';
            $.each(categorias, function(i, cat) {
                let selected = (cat.id_categoria == selectedId) ? 'selected' : '';
                options +=
                    `<option value="${cat.id_categoria}" ${selected}>${cat.nombre_categoria}</option>`;
            });
            $('#producto-categoria').html(options);
            if (typeof callback === 'function') callback();
        });
    }

    function cargarProveedoresSelect(selectedId = '', callback = null) {
        $.getJSON('/proveedor/list', function(data) {
            let proveedores = typeof data === 'string' ? JSON.parse(data) : data;
            let options = '<option value="">Seleccione un proveedor</option>';
            $.each(proveedores, function(i, prov) {
                let selected = (prov.id_proveedor == selectedId) ? 'selected' : '';
                options +=
                    `<option value="${prov.id_proveedor}" ${selected}>${prov.nombre_empresa}</option>`;
            });
            $('#producto-proveedor').html(options);
            if (typeof callback === 'function') callback();
        });
    }

    cargarProductos();

    $('#btn-add-producto').click(function() {
        $('#modal-producto-title').text('Agregar Producto');
        $('#producto-id').val('');
        $('#producto-nombre').val('');
        $('#producto-precio').val('');
        $('#producto-stock').val('');
        $('#producto-stock-minimo').val('0');
        cargarCategoriasSelect();
        cargarProveedoresSelect();
        $('#modal-producto').modal('show');
    });

    $(document).on('click', '.btn-edit', function() {
        const $btn = $(this);
        const categoriaId = $btn.data('categoria');
        const proveedorId = $btn.data('proveedor');
        
        // Mostrar loading
        const $modal = $('#modal-producto');
        $modal.modal('show');
        
        // Limpiar el modal
        $modal.find('input').val('');
        $modal.find('select').val('');
        
        // Agregar loading
        $modal.find('.modal-content').append('<div class="modal-loading" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); display: flex; justify-content: center; align-items: center; z-index: 1050;"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
        
        // Primero cargamos las categorías
        cargarCategoriasSelect(categoriaId, function() {
            console.log('Categorías cargadas, ID seleccionado:', categoriaId);
            
            // Luego cargamos los proveedores
            cargarProveedoresSelect(proveedorId, function() {
                console.log('Proveedores cargados, ID seleccionado:', proveedorId);
                
                // Llenamos el formulario con los datos del producto
                $('#modal-producto-title').text('Editar Producto');
                $('#producto-id').val($btn.data('id'));
                $('#producto-nombre').val($btn.data('nombre_producto'));
                $('#producto-precio').val($btn.data('precio'));
                $('#producto-stock').val($btn.data('stock'));
                $('#producto-stock-minimo').val($btn.data('stock_minimo') || '0');
                
                // Forzar la actualización de los selects
                if (categoriaId) {
                    $('#producto-categoria').val(categoriaId).trigger('change');
                }
                if (proveedorId) {
                    $('#producto-proveedor').val(proveedorId).trigger('change');
                }
                
                // Ocultar loading
                $('.modal-loading').remove();
                
                // Debug: verificar valores seleccionados
                console.log('Valor seleccionado en categoría:', $('#producto-categoria').val());
                console.log('Valor seleccionado en proveedor:', $('#producto-proveedor').val());
            });
        });
    });

    $('#form-producto').submit(function(e) {
        e.preventDefault();
        
        // Crear un objeto FormData a partir del formulario
        const formData = new FormData(this);
        
        // Si hay un ID, agregar el método _method=POST para simular PUT
        const id = $('#producto-id').val();
        if (id) {
            formData.append('_method', 'PUT');
        }
        
        // Mostrar los datos del formulario en la consola para depuración
        console.log('Datos del formulario a enviar:', Object.fromEntries(formData));
        
        const url = id ? '/producto/update/' + id : '/producto/store';
        
        // Mostrar loading
        const $submitBtn = $(this).find('button[type="submit"]');
        const originalBtnText = $submitBtn.html();
        $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');
        
        // Configurar la URL para incluir el ID como parámetro en lugar de en la ruta
        let requestUrl = '/producto/update';
        if (id) {
            requestUrl += '?id=' + id;
        } else {
            requestUrl = '/producto/store';
        }
        
        $.ajax({
            url: requestUrl,
            type: 'POST',
            data: formData,
            processData: false,  // Importante para FormData
            contentType: false,   // Importante para FormData
            success: function(response) {
                try {
                    // Si la respuesta es un string, intentar parsearla como JSON
                    let data = response;
                    if (typeof response === 'string') {
                        try {
                            data = JSON.parse(response);
                        } catch (e) {
                            console.error('Error al parsear la respuesta como JSON:', e);
                            // Si hay un error al parsear, mostrar un mensaje de error
                            Swal.fire({
                                title: 'Error',
                                text: 'Error al procesar la respuesta del servidor',
                                icon: 'error',
                                confirmButtonText: 'Entendido'
                            });
                            return;
                        }
                    }
                    
                    if (data.success) {
                        // Cerrar el modal y recargar la tabla
                        $('#modal-producto').modal('hide');
                        cargarProductos();
                        
                        // Mostrar mensaje de éxito
                        Swal.fire({
                            title: '¡Éxito!',
                            text: data.message || (id ? 'Producto actualizado correctamente' : 'Producto creado correctamente'),
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        // Mostrar mensaje de error del servidor
                        Swal.fire({
                            title: 'Error',
                            text: data.error || 'Ocurrió un error al procesar la solicitud',
                            icon: 'error',
                            confirmButtonText: 'Entendido'
                        });
                    }
                } catch (e) {
                    console.error('Error al procesar la respuesta del servidor:', e, response);
                    Swal.fire({
                        title: 'Error',
                        text: 'Error inesperado al procesar la respuesta del servidor',
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error al procesar la solicitud';
                try {
                    const response = JSON.parse(xhr.responseText);
                    errorMsg = response.error || errorMsg;
                } catch (e) {
                    console.error('Error parsing error response:', e);
                }
                Swal.fire('Error', errorMsg, 'error');
            },
            complete: function() {
                $submitBtn.prop('disabled', false).html(originalBtnText);
            }
        });
    });

    $(document).on('click', '.btn-delete', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: '¿Eliminar?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('/producto/delete/' + id, function() {
                    cargarProductos();
                    Swal.fire('Eliminado', 'Producto eliminado.', 'success');
                });
            }
        });
    });
});
</script>