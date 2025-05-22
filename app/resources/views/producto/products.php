<?php
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
                    <input type="text" class="form-control" name="nombre_producto" id="producto-nombre" required>
                </div>
                <div class="mb-3">
                    <label for="producto-categoria" class="form-label">Categoría</label>
                    <select class="form-select" name="id_categoria" id="producto-categoria" required>
                        <option value="">Seleccione una categoría</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="producto-proveedor" class="form-label">Proveedor</label>
                    <select class="form-select" name="id_proveedor" id="producto-proveedor" required>
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
                html += `<tr>
                    <td>${prod.id_producto}</td>
                    <td>${prod.nombre_producto}</td>
                    <td>${prod.categoria ?? ''}</td>
                    <td>${prod.proveedor ?? ''}</td>
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
                            data-categoria="${prod.id_categoria ?? ''}"
                            data-proveedor="${prod.id_proveedor ?? ''}"
                            data-stock_minimo="${prod.stock_minimo ?? 0}">
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
        $('#modal-producto-title').text('Editar Producto');
        $('#producto-id').val($(this).data('id'));
        $('#producto-nombre').val($(this).data('nombre'));
        $('#producto-precio').val($(this).data('precio'));
        $('#producto-stock').val($(this).data('stock'));
        $('#producto-stock-minimo').val($(this).data('stock_minimo') ?? '0');

        const categoriaId = $(this).data('categoria');
        const proveedorId = $(this).data('proveedor');

        // Esperar que ambos selects se carguen antes de mostrar el modal
        cargarCategoriasSelect(categoriaId, () => {
            cargarProveedoresSelect(proveedorId, () => {
                $('#modal-producto').modal('show');
            });
        });
    });

    $('#form-producto').submit(function(e) {
        e.preventDefault();
        let id = $('#producto-id').val();
        let url = id ? '/producto/update/' + id : '/producto/store';
        $.post(url, $(this).serialize(), function(resp) {
            $('#modal-producto').modal('hide');
            cargarProductos();
            Swal.fire('¡Éxito!', 'Producto guardado.', 'success');
        }, 'json');
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