<?php

namespace app\models;

use app\classes\DB;

class Usuario extends Model {
    protected $table = 'usuarios';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function autenticar($email, $password) {
        $usuario = $this->where([['email', '=', $email]])->first();
        
        if ($usuario && password_verify($password, $usuario->password)) {
            unset($usuario->password);
            return $usuario;
        }
        
        return false;
    }
}
