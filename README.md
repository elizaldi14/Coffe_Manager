# Coffee Management System

## 1. Descripción del Proyecto
Sistema de gestión para una cafetería que permite administrar productos, categorías y realizar un seguimiento de inventario. El objetivo principal es facilitar la gestión diaria de una cafetería, permitiendo el control de productos, categorías y el seguimiento de existencias de manera eficiente.

## 2. Instalación y Ejecución

### Requisitos Previos
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache)


### Instalación

1. **Clonar el repositorio**
   ```bash
   git clone [url-del-repositorio]
   cd coffeManage
   ```

2. **Configurar la base de datos**
   - Crear una base de datos MySQL
   - Importar la estructura inicial:
     ```bash
     Importa la base de datos phpmyadmin coffeManage.sql
     ```
   - Configurar las credenciales en `app/config.php`

### Ejecución

1. Inicia los servicios de Apache y MySQL
2. Accede a la aplicación a través de tu navegador:
   ```
   127.0.0.6
   ```

## 3. Estructura de Archivos

```
coffeManage/
├── app/                      # Código fuente de la aplicación
│   ├── classes/              # Clases base y utilidades
│   ├── config.php            # Configuración de la aplicación
│   ├── controllers/          # Controladores
│   ├── database.sql          # Estructura de la base de datos
│   ├── models/               # Modelos de datos
│   ├── public/               # Archivos públicos
│   │   ├── css/             # Hojas de estilo
│   │   ├── js/              # Scripts JavaScript
│   │   └── index.php        # Punto de entrada
│   ├── resources/            # Vistas y recursos
│   │   └── views/           # Plantillas de vistas
│   │   └── layouts/         # Plantillas de layout
│   │   └── functions/       # Funciones
│   └── helpers/             # Funciones de ayuda
├── .htaccess                # Configuración de Apache
└── README.md                # Este archivo
```

## Características Principales
- Gestión de productos
- Administración de categorías
- Control de inventario

