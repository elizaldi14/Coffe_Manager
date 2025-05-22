<?php

namespace app\classes;

class View {
    /**
     * @var array Almacena los datos de la vista
     */
    protected static $data = [];

    /**
     * @var string Almacena el nombre del layout a utilizar
     */
    protected static $layout = 'main';

    /**
     * Establece el layout a utilizar para la vista
     *
     * @param string $layout Nombre del layout (sin extensión)
     * @param array $data Datos adicionales para el layout
     * @return void
     */
    public static function setLayout($layout, $data = []) {
        self::$layout = $layout;
        self::$data = array_merge(self::$data, $data);
    }

    /**
     * Renderiza una vista con los datos proporcionados
     *
     * @param string $view Nombre del archivo de vista (sin extensión .php)
     * @param array $data Datos a pasar a la vista
     * @return void
     */
    public static function render($view, $data = []) {
        // Fusionar los datos estáticos con los proporcionados
        $data = array_merge(self::$data, $data);
        
        // Extraer los datos a variables
        extract($data);
        
        // Definir la ruta base de las vistas
        $viewPath = dirname(__DIR__) . '/resources/views/' . $view . '.php';
        
        // Verificar si el archivo de vista existe
        if (!file_exists($viewPath)) {
            throw new \Exception("La vista '{$view}.php' no se encuentra en el directorio de vistas.");
        }
        
        // Iniciar el buffer de salida para el contenido de la vista
        ob_start();
        
        // Incluir la vista solicitada
        include $viewPath;
        
        // Obtener el contenido de la vista
        $content = ob_get_clean();
        
        // Incluir el layout si existe
        $layoutPath = dirname(__DIR__) . '/resources/layouts/' . self::$layout . '.php';
        
        if (file_exists($layoutPath)) {
            // Incluir el layout que a su vez incluirá el contenido de la vista
            include $layoutPath;
        } else {
            // Si no hay layout, mostrar solo el contenido de la vista
            echo $content;
        }
        
        // Limpiar los datos estáticos para la próxima solicitud
        self::$data = [];
        self::$layout = 'main';
    }
    
    /**
     * Escapa el HTML para prevenir XSS
     *
     * @param string $string Cadena a escapar
     * @return string
     */
    public static function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Muestra un valor escapado si existe, o un valor por defecto si no
     *
     * @param mixed $value Valor a mostrar
     * @param mixed $default Valor por defecto si $value está vacío
     * @return mixed
     */
    public static function show($value, $default = '') {
        if (empty($value) && $value !== '0' && $value !== 0) {
            return $default;
        }
        return self::e($value);
    }
    
    /**
     * Incluye una vista parcial
     *
     * @param string $view Nombre de la vista parcial
     * @param array $data Datos para la vista
     * @return void
     */
    public static function partial($view, $data = []) {
        $viewPath = dirname(__DIR__) . '/resources/views/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            extract($data);
            include $viewPath;
        }
    }
    
    /**
     * Obtiene el contenido de una vista como cadena
     *
     * @param string $view Nombre de la vista
     * @param array $data Datos para la vista
     * @return string
     */
    public static function getContent($view, $data = []) {
        ob_start();
        self::render($view, $data);
        return ob_get_clean();
    }
    
    /**
     * Incluye un componente reutilizable
     * 
     * @param string $component Nombre del componente (sin extensión .php)
     * @param array $data Datos para el componente
     * @return void
     */
    public static function component($component, $data = []) {
        extract($data);
        $componentPath = dirname(__DIR__) . '/resources/components/' . $component . '.php';
        
        if (file_exists($componentPath)) {
            include $componentPath;
        } else {
            throw new \Exception("El componente '{$component}.php' no se encuentra en el directorio de componentes.");
        }
    }
}
