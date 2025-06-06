<?php

namespace app\classes;

class DB
{
    //Atributos de configuración de la base de datos
    public $db_host;
    public $db_name;
    private $db_user;
    private $db_passwd;

    public $conex; //Atributo de conexión

    //Atributos de control para las consultas
    public $s = " * ";
    public $c = "";
    public $j = "";
    public $w = " 1 ";
    public $o = "";
    public $l = "";

    // Agrega estas propiedades para evitar el warning de propiedades dinámicas
    public array $fillable = [];
    public array $values = [];

    public function __construct($dbh = DB_HOST, $dbn = DB_NAME, $dbu = DB_USER, $dbp = DB_PASS)
    {
        $this->db_host   = $dbh;
        $this->db_name   = $dbn;
        $this->db_user   = $dbu;
        $this->db_passwd = $dbp;
    }

    public function connect()
    {
        $this->conex = new \mysqli($this->db_host, $this->db_user, $this->db_passwd, $this->db_name);
        if ($this->conex->connect_errno) {
            die("Error al conectarse a la base de datos: " . $this->conex->connect_error);
        }
        $this->conex->set_charset("utf8");
        return $this->conex;
    }

    public function all()
    {
        return $this;
    }

    public function select($cc = [])
    {
        if (count($cc) > 0) {
            $this->s = implode(",", $cc);
        }
        return $this;
    }

    public function count($c = "*")
    {
        $this->c = ", count(" . $c . ") as tt ";
        return $this;
    }

    public function join($join = "", $on = "")
    {
        if ($join != "" && $on != "") {
            $this->j .= ' join ' . $join . ' on ' . $on;
        }
        return $this;
    }

    public function where($ww = [])
    {
        $this->w = "";
        if (count($ww) > 0) {
            foreach ($ww as $wheres) {
                $this->w .= $wheres[0] . " like '" . $wheres[1] . "' and ";
            }
        }
        $this->w .= ' 1 ';
        $this->w = ' (' . $this->w . ') ';
        return $this;
    }

    public function orderBy($ob = [])
    {
        $this->o = "";
        if (count($ob) > 0) {
            foreach ($ob as $orderBy) {
                $this->o .= $orderBy[0] . ' ' . $orderBy[1] . ',';
            }
            $this->o = ' order by ' . trim($this->o, ',');
        }
        return $this;
    }

    public function limit($l = "")
    {
        $this->l = "";
        if ($l != "") {
            $this->l = ' limit ' . $l;
        }
        return $this;
    }

    public function get()
    {
        // Usa alias si está definido
        $from = isset($this->tableAlias) ? $this->table . ' ' . $this->tableAlias : $this->table;
        $sql = "select " .
            $this->s .
            $this->c .
            " from " .  $from .
            ($this->j != "" ? " " . $this->j : "") .
            " where " . $this->w .
            $this->o .
            $this->l;
        $r = $this->conex->query($sql);
        $result = [];
        while ($f = $r->fetch_assoc()) {
            $result[] = $f;
        }
        return json_encode($result);
    }

    public function create()
    {
        // Verifica que haya campos y valores antes de preparar la consulta
        if (empty($this->fillable) || empty($this->values)) {
            throw new \Exception('No hay datos para insertar.');
        }
        $sql = 'insert into ' . $this->table .
            ' (' . implode(',', $this->fillable) . ') values (' .
            trim(str_replace("&", "?,", str_pad("", count($this->fillable), "&")), ",") . ')';
        $stmt = $this->conex->prepare($sql);
        $types = str_repeat("s", count($this->fillable));
        $stmt->bind_param($types, ...$this->values);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function delete($table, $id)
    {
        try {
            // Determinar la clave primaria de la tabla
            $primaryKey = $this->getPrimaryKey($table);

            if (!$primaryKey) {
                throw new \Exception("No se pudo determinar la clave primaria para la tabla '$table'");
            }

            // Preparar la consulta SQL
            $query = "DELETE FROM $table WHERE $primaryKey = ?";
            $stmt = $this->conex->prepare($query);

            if (!$stmt) {
                throw new \Exception('Error al preparar la consulta: ' . $this->conex->error);
            }

            // Vincular el parámetro
            $stmt->bind_param('i', $id);

            // Ejecutar la consulta
            $stmt->execute();

            return $stmt->affected_rows > 0;
        } catch (\Exception $e) {
            error_log('Error en DB@delete: ' . $e->getMessage());
            throw $e;
        }
    }

    // Método para obtener la clave primaria de una tabla
    private function getPrimaryKey($table)
    {
        $query = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";
        $result = $this->conex->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['Column_name'];
        }

        return null;
    }

    public function prepare($query)
    {
        return $this->conex->prepare($query);
    }

    public function query($query)
    {
        return $this->conex->query($query);
    }

    public function insert_id()
    {
        return $this->conex->insert_id;
    }
}
