// Inicializar tooltips de Bootstrap
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Inicializar popovers de Bootstrap
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl);
});

// Inicializar tooltips de Bootstrap
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

// Inicializar popovers de Bootstrap
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl);
});

$(document).ready(function() {
  // Lógica del Dashboard
  if (window.location.pathname.endsWith('/app/') || window.location.pathname.endsWith('/app/index.php')) {
    initDashboard();
  }

  // Inicializar el dashboard
  function initDashboard() {
    const data = window.dashboardData;
    
    if (!data) return;
    
    // Actualizar contadores
    updateCounter('#totalProductos', data.total_productos);
    updateCounter('#totalCategorias', data.total_categorias);
    updateCounter('#totalProveedores', data.total_proveedores);
    
    // Renderizar productos con bajo stock
    renderLowStockProducts(data.productos_bajo_stock);
  }
  
  // Función para animar contadores
  function updateCounter(selector, target) {
    const element = $(selector);
    if (!element.length) return;
    
    $({ count: 0 }).animate({ count: target }, {
      duration: 1000,
      step: function() {
        element.text(Math.ceil(this.count));
      }
    });
  }
  
  // Función para renderizar productos con bajo stock
  function renderLowStockProducts(products) {
    const $container = $('#lowStockProducts');
    if (!products || !products.length) {
      $container.html('<div class="text-center text-muted py-3">No hay productos con bajo inventario.</div>');
      return;
    }
    
    let html = '';
    products.forEach(product => {
      const porcentaje = (product.stock / product.stock_minimo) * 100;
      let clase = 'bg-success';
      
      if (porcentaje < 30) {
        clase = 'bg-danger';
      } else if (porcentaje < 60) {
        clase = 'bg-warning';
      }
      
      html += `
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-1">
            <span>${product.nombre_producto}</span>
            <small class="text-muted">${product.stock}/${product.stock_minimo}</small>
          </div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar ${clase}" 
                 role="progressbar" 
                 style="width: ${Math.min(100, porcentaje)}%;" 
                 aria-valuenow="${product.stock}" 
                 aria-valuemin="0" 
                 aria-valuemax="${product.stock_minimo}">
            </div>
          </div>
        </div>`;
    });
    
    $container.html(html);
  }

  // Manejo del modal de editar producto
  $(document).on('click', '.edit-product', function(e) {
    e.preventDefault();
    
    // Obtener datos del producto
    const id = $(this).data('id');
    const nombre = $(this).data('nombre');
    const descripcion = $(this).data('descripcion') || '';
    const categoria = $(this).data('categoria');
    const proveedor = $(this).data('proveedor');
    const precio = $(this).data('precio');
    const stock = $(this).data('stock');
    const stockMinimo = $(this).data('stock-minimo');

    // Llenar el formulario de edición
    $('#editProductId').val(id);
    $('#editProductName').val(nombre);
    $('#editProductDescription').val(descripcion);
    $('#editProductCategory').val(categoria);
    $('#editProductSupplier').val(proveedor);
    $('#editProductPrice').val(precio);
    $('#editProductStock').val(stock);
    $('#editProductMinStock').val(stockMinimo);

    // Mostrar el modal
    $('#editProductModal').modal('show');
  });

  // Manejo del modal de eliminar producto
  $(document).on('click', '.delete-product', function(e) {
    e.preventDefault();
    const id = $(this).data('id');
    $('#deleteProductId').val(id);
    $('#deleteProductModal').modal('show');
  });

  // Validación de formulario de agregar producto
  $('#addProductForm').on('submit', function(e) {
    if (!this.checkValidity()) {
      e.preventDefault();
      e.stopPropagation();
    }
    this.classList.add('was-validated');
  });

  // Validación de formulario de editar producto
  $('#editProductForm').on('submit', function(e) {
    if (!this.checkValidity()) {
      e.preventDefault();
      e.stopPropagation();
    }
    this.classList.add('was-validated');
  });
});
