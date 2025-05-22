<link rel="stylesheet" href="/assets/css/cafe-theme.css">
<div class="container py-4">
    <div class="cafe-header mb-3">
        <h3 class="mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-truck"></i>
            <span>Proveedores</span>
        </h3>
        <button class="btn btn-primary d-flex align-items-center gap-2 rounded-pill" id="btn-add-proveedor">
            <i class="bi bi-plus-circle"></i>
            <span>Agregar nuevo</span>
        </button>
    </div>
    <div class="table-responsive rounded-4 bg-white p-0">
        <table class="table table-borderless align-middle mb-0" id="tabla-proveedores">
            <thead>
                <tr>
                    <th class="fw-semibold">#</th>
                    <th class="fw-semibold">Empresa</th>
                    <th class="fw-semibold">Contacto</th>
                    <th class="fw-semibold">Teléfono</th>
                    <th class="fw-semibold">Activo</th>
                    <th class="fw-semibold text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se cargan los proveedores por JS o PHP -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar/Editar Proveedor -->
<div class="modal fade" id="modal-proveedor" tabindex="-1">
    <div class="modal-dialog">
        <form id="form-proveedor" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-proveedor-title">Agregar Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_proveedor" id="proveedor-id">
                <div class="mb-3">
                    <label for="proveedor-empresa" class="form-label">Empresa</label>
                    <input type="text" class="form-control" name="nombre_empresa" id="proveedor-empresa" required>
                </div>
                <div class="mb-3">
                    <label for="proveedor-contacto" class="form-label">Contacto</label>
                    <input type="text" class="form-control" name="nombre_contacto" id="proveedor-contacto">
                </div>
                <div class="mb-3">
                    <label for="proveedor-telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" name="telefono" id="proveedor-telefono">
                </div>
                <div class="mb-3">
                    <label for="proveedor-activo" class="form-label">Activo</label>
                    <select class="form-select" name="activo" id="proveedor-activo">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    function cargarProveedores() {
        $.getJSON('/proveedor/list', function(data) {
            let proveedores = typeof data === 'string' ? JSON.parse(data) : data;
            let html = '';
            $.each(proveedores, function(i, prov) {
                html += `<tr>
                    <td>${prov.id_proveedor}</td>
                    <td>${prov.nombre_empresa}</td>
                    <td>${prov.nombre_contacto ?? ''}</td>
                    <td>${prov.telefono ?? ''}</td>
                    <td>${prov.activo == 1 ? 'Sí' : 'No'}</td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm btn-edit" data-id="${prov.id_proveedor}" data-empresa="${prov.nombre_empresa}" data-contacto="${prov.nombre_contacto}" data-telefono="${prov.telefono}" data-activo="${prov.activo}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="${prov.id_proveedor}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>`;
            });
            $('#tabla-proveedores tbody').html(html);
        });
    }
    cargarProveedores();

    $('#btn-add-proveedor').click(function() {
        $('#modal-proveedor_title').text('Agregar Proveedor');
        $('#proveedor-id').val('');
        $('#proveedor-empresa').val('');
        $('#proveedor-contacto').val('');
        $('#proveedor-telefono').val('');
        $('#proveedor-activo').val('1');
        $('#modal-proveedor').modal('show');
    });

    $(document).on('click', '.btn-edit', function() {
        $('#modal-proveedor-title').text('Editar Proveedor');
        $('#proveedor-id').val($(this).data('id'));
        $('#proveedor-empresa').val($(this).data('empresa'));
        $('#proveedor-contacto').val($(this).data('contacto'));
        $('#proveedor-telefono').val($(this).data('telefono'));
        $('#proveedor-activo').val($(this).data('activo'));
        $('#modal-proveedor').modal('show');
    });

    $('#form-proveedor').submit(function(e) {
        e.preventDefault();
        let id = $('#proveedor-id').val();
        let url = id ? '/proveedor/update/' + id : '/proveedor/store';
        $.post(url, $(this).serialize(), function(resp) {
            $('#modal-proveedor').modal('hide');
            cargarProveedores();
            Swal.fire('¡Éxito!', 'Proveedor guardado.', 'success');
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
                $.post('/proveedor/delete/' + id, function() {
                    cargarProveedores();
                    Swal.fire('Eliminado', 'Proveedor eliminado.', 'success');
                });
            }
        });
    });
});
</script>
