<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model {
    protected $table = 'usuarios'; // Nombre de tu tabla
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['empleado_id', 'usuario', 'contraseña', 'estado', 'tipo_usuario', 'foto_perfil'];

    // Método para buscar un usuario por usuario y contraseña
    public function buscarUsuarioLogin($usuario) {
        // Realizar la consulta con JOIN para obtener el nombre del empleado
        $query = $this->db->table('usuarios')
            ->select('usuarios.*, empleado.nombre AS empleado')
            ->join('empleado', 'empleado.id_empleado = usuarios.empleado_id')
            ->where('usuarios.usuario', $usuario)
            ->get()
            ->getRowArray();
            #->getResultArray();

            return $query;
    
    }

    public function obtenerUsuarios(){
        $query = $this->db->table($this->table)
            ->select('usuarios.*, empleado.nombre AS empleado')
            ->join('empleado', 'empleado.id_empleado = usuarios.empleado_id') 
            ->get()
            ->limit(1)
            ->getFirstRow('array');

            return $query['0'];
    }

    public function devolverUsuario($id){
        return $this->find($id);
    }

    public function obtenerUsuarioEmpleado($id_usuario) {
        // Realizamos la consulta usando Active Record
        $query = $this->db->table($this->table) // Comienza con la tabla 'usuarios'
        ->select('usuarios.*, empleado.*, departamento.nombre AS nombre_departamento') // Seleccionamos las columnas necesarias
        ->join('empleado', 'empleado.id_empleado = usuarios.empleado_id', 'inner') // Join con la tabla 'empleado'
        ->join('departamento', 'empleado.departamento_id = departamento.id_departamento', 'inner') // Join con la tabla 'departamento'
        ->where('usuarios.id_usuario', $id_usuario) // Filtramos por el 'id_usuario'
        ->get() // Ejecutamos la consulta
        ->getFirstRow('array'); // Recuperamos la primera fila como un array

        return $query;
    }


}

?>
