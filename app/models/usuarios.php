<?php

    namespace app\models;

    class usuarios extends Model {

        protected $table;
        protected $fillable = [
            'id',
            'nombre',
            'email',
            'password',
            'rol',
            'creado_en',
        ];

        public $values = [];

        public function __construct(){
            parent::__construct();
            $this -> table = $this -> connect();
        }

        public function newUser($data) {
            $this -> values = [
                $data['nombre'],
                $data['email'],
                sha1($data['password']),
                $data['rol'],
                date('Y-m-d H:i:s'),
            ];
            return $this -> create();
        }

    }