<?php 
    include_once LAYOUTS . 'header.php';
    $active = 'suppliers';
?>

<div class="container-fluid">
    <div class="row">
        <?php include_once LAYOUTS . 'sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <?php include_once LAYOUTS . 'top_menu.php'; ?>
            
            <div class="container-fluid py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Proveedores</h2>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                        <i class="fas fa-plus me-1"></i> Añadir Proveedor
                    </button>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Contacto</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Productos</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($suppliers)): ?>
                                        <?php foreach ($suppliers as $supplier): ?>
                                            <tr>
                                                <td><?= $supplier->id ?></td>
                                                <td><?= $supplier->name ?></td>
                                                <td><?= $supplier->contact ?></td>
                                                <td><?= $supplier->email ?></td>
                                                <td><?= $supplier->phone ?></td>
                                                <td><?= $supplier->product_count ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary edit-supplier" 
                                                            data-id="<?= $supplier->id ?>"
                                                            data-name="<?= $supplier->name ?>"
                                                            data-contact="<?= $supplier->contact ?>"
                                                            data-email="<?= $supplier->email ?>"
                                                            data-phone="<?= $supplier->phone ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('supplier/delete') ?>', <?= $supplier->id ?>, this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No hay proveedores registrados</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal Añadir Proveedor -->
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
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contacto</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="saveSupplierBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Proveedor -->
<div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSupplierModalLabel">Editar Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSupplierForm">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_contact" class="form-label">Contacto</label>
                        <input type="text" class="form-control" id="edit_contact" name="contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="edit_phone" name="phone" required>
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

<?php include_once LAYOUTS . 'footer.php'; ?>

<script>
    $(document).ready(function() {
        // Guardar nuevo proveedor
        $('#saveSupplierBtn').click(function() {
            var formData = $('#addSupplierForm').serialize();
            
            $.ajax({
                url: '<?= base_url('supplier/add') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        showNotification('success', response.message);
                        $('#addSupplierModal').modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showNotification('error', response.message);
                    }
                },
                error: function() {
                    showNotification('error', 'Error en la solicitud');
                }
            });
        });
        
        // Abrir modal de edición
        $('.edit-supplier').click(function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var contact = $(this).data('contact');
            var email = $(this).data('email');
            var phone = $(this).data('phone');
            
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_contact').val(contact);
            $('#edit_email').val(email);
            $('#edit_phone').val(phone);
            
            $('#editSupplierModal').modal('show');
        });
        
        // Actualizar proveedor
        $('#updateSupplierBtn').click(function() {
            var formData = $('#editSupplierForm').serialize();
            
            $.ajax({
                url: '<?= base_url('supplier/update') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        showNotification('success', response.message);
                        $('#editSupplierModal').modal('hide');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showNotification('error', response.message);
                    }
                },
                error: function() {
                    showNotification('error', 'Error en la solicitud');
                }
            });
        });
    });
</script>
