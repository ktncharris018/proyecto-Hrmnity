<?php
namespace App\Reports;

#use  \koolReport\KoolReport;

class DepartamentoReport extends \koolreport\KoolReport
{
    protected function settings()
    {
        return array(
            "dataSources" => array(
                "MySQL" => array(
                    "connection" => array(
                        "dsn" => "mysql:host=localhost;dbname=hrmsystem", // DSN correcto
                        "username" => "root",
                        "password" => "", // Contraseña vacía por defecto en XAMPP
                    )
                )
            )
        );
    }


    protected function setup()
    {
        // Reporte: Número de Empleados por Departamento
        $this->src("MySQL")
             ->query("SELECT departamento, COUNT(*) AS total FROM empleados GROUP BY departamento")
             ->pipe($this->dataStore("empleadosPorDepartamento"));

        // Reporte: Salario Promedio por Departamento
        $this->src("MySQL")
             ->query("SELECT departamento, AVG(salario) AS promedio FROM empleados GROUP BY departamento")
             ->pipe($this->dataStore("salarioPromedioPorDepartamento"));
        
        // Puedes agregar más consultas aquí según sea necesario
    }
}
