<link rel="stylesheet" href="/assets/css/cafe-theme.css">
<div class="container py-4">
    <div class="cafe-header mb-4">
        <h3 class="mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
        </h3>
    </div>
    <div class="row g-4" id="dashboard-cards">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-5 fw-bold mb-2" style="color: var(--dark-color);" id="total-productos">0</div>
                    <div class="mb-2"><i class="bi bi-cup-hot"></i> Productos</div>
                    <a href="/producto" class="btn btn-primary btn-sm rounded-pill">Ver productos</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-5 fw-bold mb-2" style="color: var(--dark-color);" id="total-categorias">0</div>
                    <div class="mb-2"><i class="bi bi-tags"></i> Categorías</div>
                    <a href="/categoria" class="btn btn-primary btn-sm rounded-pill">Ver categorías</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-5 fw-bold mb-2" style="color: var(--dark-color);" id="total-proveedores">0</div>
                    <div class="mb-2"><i class="bi bi-truck"></i> Proveedores</div>
                    <a href="/proveedor" class="btn btn-primary btn-sm rounded-pill">Ver proveedores</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Asegúrate de cargar jQuery antes de este script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    $.getJSON('/dashboard/getData', function(data) {
        $('#total-productos').text(data.productos ?? 0);
        $('#total-categorias').text(data.categorias ?? 0);
        $('#total-proveedores').text(data.proveedores ?? 0);
    });
});
</script>