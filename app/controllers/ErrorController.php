<?php

    namespace app\controllers;

    class ErrorController extends Controller {

        public function error404(){
            echo "<h1>Error 404</h1><p>Página no encontrada.</p>";
            die;
        }
        public function errorMNF(){
            echo "<h1>Error</h1><p>El método solicitado no se encontró.</p>";
            die;
        }
    }