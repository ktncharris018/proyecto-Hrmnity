<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpleadoModel extends Model
{
    protected $table = 'empleado';
    protected $primaryKey = 'id_empleado';
    protected $allowedFields = [
        'nombre', 'identificacion', 'contacto', 'tipo_contrato', 'supervisor', 'titulo', 'departamento_id', 'foto_perfil'
    ];

    public function obtenerEmpleados()
    {
        
        return $this->db->table('empleado')
                ->select('empleado.*, departamento.nombre AS nombre_departamento')
                ->join('departamento', 'departamento.id_departamento = empleado.departamento_id')
                ->get()
                ->getResultArray(); // O getResult() dependiendo de lo que prefieras

        #return $this->findAll(); // Devuelve todos los empleados
    }

    public function devolverEmpleado($id){
        return $this->find($id);
    }

    public function getSalarioPromedioPorDepartamento()
    {
        $result = $this->db->query("
            SELECT d.nombre AS departamento, AVG(s.salario_total) AS promedio
            FROM empleado e
            JOIN salarios s ON e.id_empleado = s.empleado_id
            JOIN departamento d ON e.departamento_id = d.id_departamento
            GROUP BY d.nombre
        ")->getResultArray();
    
        // Formatear el promedio
        // foreach ($result as &$row) {
        //     $row['promedio'] = number_format($row['promedio'], 2, '.', ','); // Formato: 1,872,000.00
        // }
    
        return $result;
    }

    public function getEmpleadosPorDepartamento()
    {
        return $this->db->query("
            SELECT d.nombre AS departamento, COUNT(*) AS total
            FROM empleado e
            JOIN departamento d ON e.departamento_id = d.id_departamento
            GROUP BY d.nombre
        ")->getResultArray();
    }

    public function getEmpleadosPorTipoContrato()
    {
        return $this->db->query("
            SELECT tipo_contrato, COUNT(*) AS total
            FROM empleado
            GROUP BY tipo_contrato
        ")->getResultArray();
    }

    public function getTotalEmpleados() {
        $query = $this->db->query('SELECT COUNT(*) AS total_empleados FROM empleado');
        return $query->getRow()->total_empleados ; 
    }

    
}
