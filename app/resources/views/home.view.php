<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Inventario - Cafetería</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3f9d63;
            --secondary-color: #1cc88a;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
        }
        
        body {
            background-color: var(--light-color);
            font-family: 'Nunito', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .welcome-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .welcome-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .welcome-header i {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .welcome-header h1 {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .welcome-header p {
            color: #858796;
            font-size: 1.1rem;
        }
        
        .feature-card {
            padding: 2rem;
            border-radius: 10px;
            background: #ebe2d8;
            text-align: center;
            height: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #e3e6f0;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.8rem 2rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            transform: translateY(-2px);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-container">
            <div class="welcome-header">
                <i class="fas fa-coffee"></i>
                <h1>Bienvenido al Gestor de Inventario de la Cafetería</h1>
                <p>Gestiona tu cafetería de manera eficiente y profesional</p>
            </div>
            
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h4>Productos</h4>
                        <p>Administra tu inventario de productos de manera eficiente.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h4>Categorías</h4>
                        <p>Organiza tus productos en categorías para un mejor control.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h4>Proveedores</h4>
                        <p>Gestiona tus relaciones con proveedores de manera centralizada.</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <a href="/dashboard" class="btn btn-primary me-3">
                    <i class="fas fa-tachometer-alt me-2"></i>Ir al Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- Google Fonts - Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</body>
</html>