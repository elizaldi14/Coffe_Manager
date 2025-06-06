<?php 

    namespace app\controllers;
    use app\classes\Views as View;
    use app\controllers\auth\SessionController as SC;
    class HomeController extends Controller {

        public function __construct(){
            parent::__construct();
        }

        public function index($params = null){
            $response = [
                        'title' => 'Inicio', // Título para el layout
                        'ua' => SC::sessionValidate() ?? [ 'sv' => 0 ],
                        'code'   => 200,
                        'title'  => 'Foro Fie 2025'
                        ];
            View::render('home', $response); // Renderizar la vista 'home' con los datos
        }

    }