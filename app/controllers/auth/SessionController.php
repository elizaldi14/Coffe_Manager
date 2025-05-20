<?php

    namespace app\controllers\auth;

    use app\controllers\Controller as Controller;
    use app\classes\Views as View;
    use app\classes\Redirect as Redirect;
    use app\models\usuarios as user;

    class SessionController extends Controller {
        public function __construct(){
            parent::__construct();
        }

        public function iniSession( $params = null){
            $response = [
                'ua'    => ['sv' => 0],
                'title' => 'Iniciar sesión',
                'code'  => 200
            ];
            View::render('auth/inisession',$response);
        }

        public function userAuth(){
            $datos = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $user = new user();

            $result = $user -> where([["email",$datos["email"]],
                                      ["password",sha1($datos["password"])]])
                            ->get();
            if( count( json_decode($result)) > 0){
                //Se registra la sesión
                $response = json_decode($this->sessionRegister($result), true);
                if ($response['r'] === true) {
                    $response['redirect'] = '/dashboard';
                }
                echo json_encode($response);
            } else {
                self::sessionDestroy();
                echo json_encode(["r" => false, "message" => "Credenciales incorrectas"]);
            }
        }

        private function sessionRegister( $r ){
            $datos = json_decode( $r );
            session_start();
            $_SESSION['sv']       = true;
            $_SESSION['IP']       = $_SERVER['REMOTE_ADDR'];
            $_SESSION['id']       = $datos[0]->id;
            $_SESSION['nombre']   = $datos[0]->nombre;
            $_SESSION['password'] = $datos[0]->password;
            $_SESSION['rol']      = $datos[0]->rol;
            session_write_close();
            return json_encode( ["r" => true ]);
        }

        public static function sessionValidate(){
            $user = new user();
            session_start();
            if( isset( $_SESSION['sv']) && $_SESSION['sv'] == true){
                $datos = $_SESSION;
                $result = $user -> where([["email",$datos["email"]],
                                          ["password",$datos["password"]]])
                                ->get();
                if( count( json_decode( $result )) > 0 && $datos['IP'] == $_SERVER['REMOTE_ADDR']){
                    session_write_close();
                    return ['email' => $datos['email'],
                            'sv' => $datos['sv'],
                            'id' => $datos['id'],
                            'rol' => $datos['rol']];
                }else{
                    session_write_close();
                    self::sessionDestroy();
                    return null;
                }
            }
            session_write_close();
            self::sessionDestroy();
            return null;
        }

        public static function sessionDestroy(){
            session_start();
            $_SESSION = ['sv' => false];
            session_destroy();
            session_write_close();
            return;
        }

        public function logout(){
            self::sessionDestroy();
            Redirect::to('/');
            exit();
        }

    }