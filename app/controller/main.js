$(document).ready(() => {
  // Products Page
  // Open Edit Product Modal
  $(document).on("click", ".edit-product", function (e) {
    e.preventDefault()
    const id = $(this).data("id")
    const name = $(this).data("name")
    const category = $(this).data("category")
    const supplier = $(this).data("supplier")
    const stock = $(this).data("stock")
    const price = $(this).data("price")

    $("#editProductId").val(id)
    $("#editProductName").val(name)

    // Set category dropdown value (this is a simplified version)
    $("#editProductCategory option").each(function () {
      if ($(this).text() === category) {
        $(this).prop("selected", true)
      }
    })

    // Set supplier dropdown value (this is a simplified version)
    $("#editProductSupplier option").each(function () {
      if ($(this).text() === supplier) {
        $(this).prop("selected", true)
      }
    })

    $("#editProductStock").val(stock)
    $("#editProductPrice").val(price)

    $("#editProductModal").modal("show")
  })

  // Open Delete Product Modal
  $(document).on("click", ".delete-product", function (e) {
    e.preventDefault()
    const id = $(this).data("id")
    $("#deleteProductId").val(id)
    $("#deleteProductModal").modal("show")
  })

  // Save Product Button Click
  $("#saveProductBtn").click(() => {
    // Validate form
    if ($("#addProductForm")[0].checkValidity()) {
      // In a real application, this would send data to the server
      // For this static prototype, we'll just close the modal
      $("#addProductModal").modal("hide")

      // Show success message
      alert("Producto añadido correctamente (simulación)")
    } else {
      // Trigger HTML5 validation
      $("#addProductForm")[0].reportValidity()
    }
  })

  // Update Product Button Click
  $("#updateProductBtn").click(() => {
    // Validate form
    if ($("#editProductForm")[0].checkValidity()) {
      // In a real application, this would send data to the server
      // For this static prototype, we'll just close the modal
      $("#editProductModal").modal("hide")

      // Show success message
      alert("Producto actualizado correctamente (simulación)")
    } else {
      // Trigger HTML5 validation
      $("#editProductForm")[0].reportValidity()
    }
  })

  // Confirm Delete Product Button Click
  $("#confirmDeleteBtn").click(() => {
    // In a real application, this would send a delete request to the server
    // For this static prototype, we'll just close the modal
    $("#deleteProductModal").modal("hide")

    // Show success message
    alert("Producto eliminado correctamente (simulación)")
  })

  // Categories Page
  // Open Edit Category Modal
  $(document).on("click", ".edit-category", function (e) {
    e.preventDefault()
    const id = $(this).data("id")
    const name = $(this).data("name")
    const description = $(this).data("description")

    $("#editCategoryId").val(id)
    $("#editCategoryName").val(name)
    $("#editCategoryDescription").val(description)

    $("#editCategoryModal").modal("show")
  })

  // Open Delete Category Modal
  $(document).on("click", ".delete-category", function (e) {
    e.preventDefault()
    const id = $(this).data("id")
    $("#deleteCategoryId").val(id)
    $("#deleteCategoryModal").modal("show")
  })

  // Save Category Button Click
  $("#saveCategoryBtn").click(() => {
    // Validate form
    if ($("#addCategoryForm")[0].checkValidity()) {
      // In a real application, this would send data to the server
      // For this static prototype, we'll just close the modal
      $("#addCategoryModal").modal("hide")

      // Show success message
      alert("Categoría añadida correctamente (simulación)")
    } else {
      // Trigger HTML5 validation
      $("#addCategoryForm")[0].reportValidity()
    }
  })

  // Update Category Button Click
  $("#updateCategoryBtn").click(() => {
    // Validate form
    if ($("#editCategoryForm")[0].checkValidity()) {
      // In a real application, this would send data to the server
      // For this static prototype, we'll just close the modal
      $("#editCategoryModal").modal("hide")

      // Show success message
      alert("Categoría actualizada correctamente (simulación)")
    } else {
      // Trigger HTML5 validation
      $("#editCategoryForm")[0].reportValidity()
    }
  })

  // Confirm Delete Category Button Click
  $("#confirmDeleteCategoryBtn").click(() => {
    // In a real application, this would send a delete request to the server
    // For this static prototype, we'll just close the modal
    $("#deleteCategoryModal").modal("hide")

    // Show success message
    alert("Categoría eliminada correctamente (simulación)")
  })

  // Suppliers Page
  // Open Edit Supplier Modal
  $(document).on("click", ".edit-supplier", function (e) {
    e.preventDefault()
    const id = $(this).data("id")
    const name = $(this).data("name")
    const contact = $(this).data("contact")
    const phone = $(this).data("phone")
    const email = $(this).data("email")

    $("#editSupplierId").val(id)
    $("#editSupplierName").val(name)
    $("#editSupplierContact").val(contact)
    $("#editSupplierPhone").val(phone)
    $("#editSupplierEmail").val(email)

    $("#editSupplierModal").modal("show")
  })

  // Open Delete Supplier Modal
  $(document).on("click", ".delete-supplier", function (e) {
    e.preventDefault()
    const id = $(this).data("id")
    $("#deleteSupplierId").val(id)
    $("#deleteSupplierModal").modal("show")
  })

  // Save Supplier Button Click
  $("#saveSupplierBtn").click(() => {
    // Validate form
    if ($("#addSupplierForm")[0].checkValidity()) {
      // In a real application, this would send data to the server
      // For this static prototype, we'll just close the modal
      $("#addSupplierModal").modal("hide")

      // Show success message
      alert("Proveedor añadido correctamente (simulación)")
    } else {
      // Trigger HTML5 validation
      $("#addSupplierForm")[0].reportValidity()
    }
  })

  // Update Supplier Button Click
  $("#updateSupplierBtn").click(() => {
    // Validate form
    if ($("#editSupplierForm")[0].checkValidity()) {
      // In a real application, this would send data to the server
      // For this static prototype, we'll just close the modal
      $("#editSupplierModal").modal("hide")

      // Show success message
      alert("Proveedor actualizado correctamente (simulación)")
    } else {
      // Trigger HTML5 validation
      $("#editSupplierForm")[0].reportValidity()
    }
  })

  // Confirm Delete Supplier Button Click
  $("#confirmDeleteSupplierBtn").click(() => {
    // In a real application, this would send a delete request to the server
    // For this static prototype, we'll just close the modal
    $("#deleteSupplierModal").modal("hide")

    // Show success message
    alert("Proveedor eliminado correctamente (simulación)")
  })
})
