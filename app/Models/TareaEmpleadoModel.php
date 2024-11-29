<?php

namespace App\Models;

use CodeIgniter\Model;

class TareaEmpleadoModel extends Model
{
    protected $table = 'tareas_empleado';

    protected $primaryKey = 'id';

    protected $allowedFields = ['tarea_id', 'empleado_id'];

    protected $useTimestamps = false;

    public function obtenerTareasConEmpleados()
{
    // Realizamos la consulta
    $builder = $this->db->table('tareas');
    $builder->select('tareas.id_tarea, tareas.nombre AS nombre_tarea, tareas.descripcion, tareas.estado, tareas.progreso,  empleado.id_empleado, empleado.nombre, empleado.foto_perfil');
    $builder->join('tareas_empleado', 'tareas.id_tarea = tareas_empleado.tarea_id');
    $builder->join('empleado', 'empleado.id_empleado = tareas_empleado.empleado_id');
    
    $query = $builder->get();

    $result = $query->getResult();

    $tareasConEmpleados = [];

    foreach ($result as $row) {
        if (!isset($tareasConEmpleados[$row->id_tarea])) {
            $tareasConEmpleados[$row->id_tarea] = [
                'id_tarea' => $row->id_tarea,
                'nombre' => $row->nombre_tarea,
                'descripcion' => $row->descripcion,
                'estado' => $row->estado,
                'progreso' => $row->progreso,
                'empleados' => []  
            ];
        }

        $tareasConEmpleados[$row->id_tarea]['empleados'][] = [
            'id_empleado' => $row->id_empleado,
            'nombre_empleado' => $row->nombre ,
            'foto_empleado' => $row->foto_perfil,
        ];
    }

    return $tareasConEmpleados;
}

    

    public function obtenerEmpleadoPorTarea($tarea_id)
    {
        // Realizamos una consulta que devuelva todos los empleado asignados a una tarea específica
        $builder = $this->db->table('tareas_empleado');
        $builder->select('empleado.id_empleado, empleado.nombre');
        $builder->join('empleado', 'empleado.id_empleado = tareas_empleado.empleado_id');
        $builder->where('tareas_empleado.tarea_id', $tarea_id);
        $query = $builder->get();

        return $query->getResultArray();  
    }

    // Obtener las tareas asignadas a un empleado
    public function obtenerTareasPorEmpleado($empleado_id)
    {
        // Realizamos una consulta que devuelva todas las tareas asignadas a un empleado específico
        $builder = $this->db->table('tareas_empleado');
        $builder->select('tareas.id_tarea, tareas.nombre');
        $builder->join('tareas', 'tareas.id_tarea = tareas_empleado.tarea_id');
        $builder->where('tareas_empleado.empleado_id', $empleado_id);
        $query = $builder->get();

        return $query->getResult();  
    }

    // Asignar un empleado a una tarea
    public function asignarEmpleadoATarea($tarea_id, $empleado_id)
    {
        $data = [
            'tarea_id' => $tarea_id,
            'empleado_id' => $empleado_id
        ];

        return $this->insert($data);
    }

    // Eliminar la asignación de un empleado a una tarea
    // Eliminar múltiples empleados asignados a una tarea
    public function eliminarEmpleadosDeTarea($tarea_id, $empleados_ids)
    {
        return $this->where('tarea_id', $tarea_id)
                    ->whereIn('empleado_id', $empleados_ids) // Usamos whereIn para eliminar varios empleados a la vez
                    ->delete();
    }

}
