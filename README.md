# Coffee Management System

## 1. Descripción del Proyecto
Sistema de gestión para una cafetería que permite administrar productos, categorías y realizar un seguimiento de inventario. El objetivo principal es facilitar la gestión diaria de una cafetería, permitiendo el control de productos, categorías y el seguimiento de existencias de manera eficiente.

## 2. Instalación y Ejecución

### Requisitos Previos
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- Composer (para gestión de dependencias)

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
     mysql -u [usuario] -p [nombre_base_datos] < database.sql
     ```
   - Configurar las credenciales en `app/config.php`

3. **Configurar el servidor web**
   - Configurar el directorio público como raíz del servidor web (`/public`)
   - Asegurarse de que el archivo `public/.htaccess` esté correctamente configurado para Apache

4. **Permisos**
   Asegúrate de que los directorios necesarios tengan permisos de escritura:
   ```bash
   chmod -R 755 app/storage
   ```

### Ejecución

1. Inicia tu servidor web y base de datos
2. Accede a la aplicación a través de tu navegador:
   ```
   http://localhost/coffeManage/public
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
│   └── helpers/             # Funciones de ayuda
├── .htaccess                # Configuración de Apache
└── README.md                # Este archivo
```

## Características Principales
- Gestión de productos
- Administración de categorías
- Control de inventario
- Interfaz intuitiva y responsiva

## Soporte
Para soporte técnico, por favor contacte al equipo de desarrollo o abra un issue en el repositorio del proyecto.
