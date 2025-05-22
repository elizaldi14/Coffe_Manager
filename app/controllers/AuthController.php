<?php

namespace app\controllers;

use app\models\Usuario as UsuarioModel;
use app\classes\View;

class AuthController extends Controller {

    public function __construct() {
        parent::__construct();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Muestra el formulario de inicio de sesión
     */
    public function login() {
        if (isset($_SESSION['usuario'])) {
            header('Location: ' . URL . 'dashboard');
            exit();
        }

        View::render('auth/login', [
            'title' => 'Iniciar Sesión'
        ]);
    }

    /**
     * Procesa el inicio de sesión (maneja tanto AJAX como formularios tradicionales)
     */
    public function authenticate() {
        // Configuración de cabeceras para CORS
        header('Access-Control-Allow-Origin: ' . URL);
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Credentials: true');

        // Manejar solicitud OPTIONS para CORS preflight
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        // Verificar que sea una solicitud POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJsonResponse(405, false, 'Método no permitido');
            return;
        }

        // Verificar token CSRF
        if (!isset($_POST['_token']) || $_POST['_token'] !== ($_SESSION['csrf_token'] ?? '')) {
            $this->sendJsonResponse(403, false, 'Token de seguridad inválido');
            return;
        }

        // Obtener datos de la solicitud (tanto para JSON como para form-data)
        if (strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
            $data = json_decode(file_get_contents('php://input'), true);
        } else {
            $data = $_POST;
        }

        // Validar campos requeridos
        if (empty($data['email']) || empty($data['password'])) {
            $this->sendJsonResponse(400, false, 'Email y contraseña son requeridos');
            return;
        }

        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $password = $data['password'];

        // Autenticar usuario
        $usuario = new UsuarioModel();
        $autenticado = $usuario->autenticar($email, $password);

        if ($autenticado) {
            // Regenerar ID de sesión para prevenir fijación de sesión
            session_regenerate_id(true);
            
            // Establecer datos de sesión
            $_SESSION['usuario'] = $autenticado;
            
            // Registrar el inicio de sesión
            if (method_exists($usuario, 'registrarInicioSesion')) {
                $usuario->registrarInicioSesion($autenticado['id']);
            }

            $this->sendJsonResponse(200, true, 'Inicio de sesión exitoso', ['redirect' => URL . 'dashboard']);
        } else {
            // Registrar intento fallido
            if (method_exists($usuario, 'registrarIntentoFallido')) {
                $usuario->registrarIntentoFallido($email);
            }
            
            $this->sendJsonResponse(401, false, 'Credenciales inválidas. Por favor, inténtalo de nuevo.');
        }
    }

    /**
     * Cierra la sesión del usuario
     */
    public function logout() {
        session_destroy();

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'redirect' => URL . 'auth/login'
            ]);
        } else {
            header('Location: ' . URL . 'auth/login');
        }

        exit();
    }

    /**
     * Envía una respuesta JSON estandarizada
     */
    private function sendJsonResponse($statusCode, $success, $message, $data = []) {
        http_response_code($statusCode);
        $response = array_merge([
            'success' => $success,
            'message' => $message
        ], $data);
        
        echo json_encode($response);
        exit();
    }

    /**
     * Verifica si el usuario está autenticado (API)
     */
    public function checkAuth() {
        header('Content-Type: application/json');
        
        if (isset($_SESSION['usuario'])) {
            $this->sendJsonResponse(200, true, 'Usuario autenticado', [
                'authenticated' => true,
                'usuario' => $_SESSION['usuario']
            ]);
        } else {
            $this->sendJsonResponse(401, false, 'No autenticado', [
                'authenticated' => false
            ]);
        }
    }
}
