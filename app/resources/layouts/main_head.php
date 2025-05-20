<?php
    function setHeader($args){
        $ua = as_object($args->ua ?? (object)['sv' => false]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $args->title ?? 'Coffee Manager' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body { 
            background-color: #ffffff;
            color: #333;
        }
        .sidebar {
            background-color: #3f9d63;
            min-height: 100vh;
            color: white;
            padding: 20px 0;
        }
        .top-menu {
            background-color: #3f9d63;
            height: 70px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            padding: 0 25px;
        }
        .nav-link {
            color: white;
            padding: 10px 20px;
            margin: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            background-color: #358a53;
            color: white;
        }
        .nav-link i {
            margin-right: 10px;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="top-menu">
            <h4 class="mb-0">Coffee Manager</h4>
            <div class="ms-auto d-flex align-items-center">
                <?php if(isset($ua->sv) && $ua->sv) : ?>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle text-decoration-none text-dark" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= htmlspecialchars($ua->username ?? 'Usuario') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/Session/logout">Cerrar sesión</a></li>
                        </ul>
                    </div>
                <?php else : ?>
                    <a href="/Session/iniSession" class="btn btn-outline-success btn-sm ms-3 text-decoration-none" style="color: #ffffff; background-color:rgb(45, 118, 73);"  >
                        Iniciar sesión
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <?php if(isset($ua->sv) && $ua->sv) : ?>
            <div class="col-md-2 sidebar">
                <nav class="nav flex-column">
                    <a class="nav-link <?= ($_SERVER['REQUEST_URI'] === '/') ? 'active' : '' ?>" href="/">
                        <i class="bi bi-house-door"></i> Inicio
                    </a>
                    <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/UserPosts') ? 'active' : '' ?>" 
                       href="/UserPosts">
                        <i class="bi bi-file-earmark-text"></i> Mis publicaciones
                    </a>
                </nav>
            </div>
            <div class="col-md-10 content">
            <?php else : ?>
            <div class="col-12 content" style="background-color: #ebe2d8;">
            <?php endif; ?>
<?php
}
