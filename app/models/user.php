<?php

    namespace app\models;

    class user extends Model {

        protected $table;
        public array $fillable = [ // Declarado como array
            'name',
            'username',
            'email',
            'passwd',
            'tipo',
            'activo',
        ];

        public array $values = []; // Declarado como array

        public function __construct(){
            parent::__construct();
            $this -> table = $this -> connect();
        }

        public function newUser($data) {
            $this -> values = [
                $data['name'],
                $data['username'],
                $data['email'],
                sha1($data['passwd']),
                2,
                1,
            ];
            return $this -> create();
        }

        public function login($username, $password) {
            $hashedPassword = sha1($password);
            $query = "SELECT * FROM {$this->table} WHERE username = ? AND passwd = ?";
            $result = $this->query($query, [$username, $hashedPassword]);
            return $result->fetch(); // Devuelve el usuario si las credenciales son correctas
        }
    }