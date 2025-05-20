<?php

namespace app\classes;

use app\controllers\ErrorController as ErrorController;

class Router
{
    private $uri = [];
    private $publicRoutes = [
        'auth/session/inisession',
        'auth/session/userauth',
        'auth/register',
        'error/404',
        'error/methodnotfound',
        'session/inisession',
        'session/userauth'
    ];

    public function __construct() {}

    public function route()
    {
        $this->filterRequest();
        
        // Check if authentication is required for this route
        if ($this->requiresAuth() && !$this->isAuthenticated()) {
            header('Location: /Session/iniSession');
            exit();
        }

        $controller = $this->getController();
        $method     = $this->getMethod();
        $params     = $this->getParams();
        
        // Instanciar el controlador dinámicamente
        if (class_exists($controller)) {
            $controller = new $controller();
        } else {
            $controller = new ErrorController();
            $controller->error404();
            return;
        }
        
        if (!method_exists($controller, $method)) {
            $controller = new ErrorController();
            $controller->errorMNF();
            return;
        }
        
        $controller->$method($params);
        return;
    }

    private function filterRequest()
    {
        $request = filter_input_array(INPUT_GET);
        if (isset($request['uri'])) {
            $this->uri = $request['uri'];
            $this->uri = rtrim($this->uri, '/');
            $this->uri = filter_var($this->uri, FILTER_SANITIZE_URL);
            $this->uri = explode('/', ucfirst(strtolower($this->uri)));
            return;
        }
    }

    private function getController()
    {
        $controller = 'Home';
        if (isset($this->uri[0])) {
            $controller = $this->uri[0];
            unset($this->uri[0]);
        }
        
        // Convertir a formato de controlador (primera letra mayúscula)
        $controller = ucfirst($controller);
        
        // Mapeo de rutas especiales
        $specialControllers = [
            'Session' => 'auth\\Session',
            'Register' => 'auth\\Register',
            'Dashboard' => 'Dashboard',  // Asegura que use el DashboardController
            'Products' => 'Producto',   // Ruta para productos (nota el singular)
            'Categories' => 'Categoria', // Ruta para categorías
            'Suppliers' => 'Proveedor'  // Ruta para proveedores
        ];
        
        if (array_key_exists($controller, $specialControllers)) {
            $controller = $specialControllers[$controller];
        }
        
        return 'app\\controllers\\' . $controller . 'Controller';
    }

    private function getMethod()
    {
        $method = 'index';
        if (isset($this->uri[1])) {
            $method = $this->uri[1];
            unset($this->uri[1]);
        }
        return $method;
    }

    private function getParams()
    {
        $params = [];
        if (!empty($this->uri)) {
            $params = $this->uri;
            $this->uri = "";
        }
        return $params;
    }

    /**
     * Check if the current route requires authentication
     */
    private function requiresAuth()
    {
        $currentRoute = strtolower(implode('/', $this->uri));
        
        // Check if current route is in public routes
        foreach ($this->publicRoutes as $route) {
            if (strpos($currentRoute, $route) === 0) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Check if user is authenticated
     */
    private function isAuthenticated()
    {
        session_start();
        $isAuthenticated = isset($_SESSION['sv']) && $_SESSION['sv'] === true;
        session_write_close();
        
        return $isAuthenticated;
    }
}
