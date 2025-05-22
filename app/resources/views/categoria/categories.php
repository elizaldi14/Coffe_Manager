<link rel="stylesheet" href="/assets/css/cafe-theme.css">
<div class="container py-4">
    <div class="cafe-header mb-3">
        <h3 class="mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-tags"></i>
            <span>Categorías</span>
        </h3>
        <button class="btn btn-primary d-flex align-items-center gap-2 rounded-pill" id="btn-add-categoria">
            <i class="bi bi-plus-circle"></i>
            <span>Agregar nueva</span>
        </button>
    </div>
    <div class="table-responsive rounded-4 bg-white p-0">
        <table class="table table-borderless align-middle mb-0" id="tabla-categorias">
            <thead>
                <tr>
                    <th class="fw-semibold">#</th>
                    <th class="fw-semibold">Nombre</th>
                    <th class="fw-semibold">Descripción</th>
                    <th class="fw-semibold">Activa</th>
                    <th class="fw-semibold text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se cargan las categorías por JS o PHP -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar/Editar Categoría -->
<div class="modal fade" id="modal-categoria" tabindex="-1">
    <div class="modal-dialog">
        <form id="form-categoria" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-categoria-title">Agregar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_categoria" id="categoria-id">
                <div class="mb-3">
                    <label for="categoria-nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre_categoria" id="categoria-nombre" required>
                </div>
                <div class="mb-3">
                    <label for="categoria-descripcion" class="form-label">Descripción</label>
                    <input type="text" class="form-control" name="descripcion" id="categoria-descripcion">
                </div>
                <div class="mb-3">
                    <label for="categoria-activa" class="form-label">Activa</label>
                    <select class="form-select" name="activa" id="categoria-activa">
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
    function cargarCategorias() {
        $.getJSON('/categoria/list', function(data) {
            let categorias = typeof data === 'string' ? JSON.parse(data) : data;
            let html = '';
            $.each(categorias, function(i, cat) {
                html += `<tr>
                    <td>${cat.id_categoria}</td>
                    <td>${cat.nombre_categoria}</td>
                    <td>${cat.descripcion ?? ''}</td>
                    <td>${cat.activa == 1 ? 'Sí' : 'No'}</td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm btn-edit" data-id="${cat.id_categoria}" data-nombre="${cat.nombre_categoria}" data-descripcion="${cat.descripcion}" data-activa="${cat.activa}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="${cat.id_categoria}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>`;
            });
            $('#tabla-categorias tbody').html(html);
        });
    }
    cargarCategorias();

    $('#btn-add-categoria').click(function() {
        $('#modal-categoria-title').text('Agregar Categoría');
        $('#categoria-id').val('');
        $('#categoria-nombre').val('');
        $('#categoria-descripcion').val('');
        $('#categoria-activa').val('1');
        $('#modal-categoria').modal('show');
    });

    $(document).on('click', '.btn-edit', function() {
        $('#modal-categoria-title').text('Editar Categoría');
        $('#categoria-id').val($(this).data('id'));
        $('#categoria-nombre').val($(this).data('nombre'));
        $('#categoria-descripcion').val($(this).data('descripcion'));
        $('#categoria-activa').val($(this).data('activa'));
        $('#modal-categoria').modal('show');
    });

    $('#form-categoria').submit(function(e) {
        e.preventDefault();
        let id = $('#categoria-id').val();
        let url = id ? '/categoria/update/' + id : '/categoria/store';
        $.post(url, $(this).serialize(), function(resp) {
            $('#modal-categoria').modal('hide');
            cargarCategorias();
            Swal.fire('¡Éxito!', 'Categoría guardada.', 'success');
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
                $.post('/categoria/delete/' + id, function() {
                    cargarCategorias();
                    Swal.fire('Eliminado', 'Categoría eliminada.', 'success');
                });
            }
        });
    });
});
</script>
