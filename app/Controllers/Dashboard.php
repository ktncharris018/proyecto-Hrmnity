<?php
namespace App\Controllers;

#use App\Reports\DepartamentoReport;

use App\Models\EmpleadoModel;
use App\Models\DepartamentoModel;

use App\Models\NominaModel;
use App\Models\LicenciaModel;
use App\Models\CandidatoModel;
use App\Models\TareaModel;
use App\Models\EntrevistaModel;




class Dashboard extends BaseController
{
    protected $departamentoReport;
    protected $empleadoModel;
    protected $departamentoModel;
    protected $nominaModel;
    protected $licenciaModel;
    protected $candidatoModel;
    protected $entrevistaModel;
    protected $tareaModel;

    public function __construct() {
        #$this->departamentoReport = new DepartamentoReport();
        $this->empleadoModel = new EmpleadoModel();
        $this->nominaModel = new NominaModel();
        $this->licenciaModel = new LicenciaModel();
        $this->candidatoModel = new CandidatoModel();
        $this->entrevistaModel = new EntrevistaModel();
        $this->tareaModel = new TareaModel();
        $this->departamentoModel = new DepartamentoModel();


    }

    public function getIndex()
    {
        $reportes = $this->initReports();

        return view('dashboard/index', ['reportes' => $reportes]);
    }

    protected function initRep(){

        $this->DepartamentoReport->run();
        
        $reporteGeneral = [
            'empleadosPorDepartamento' => $this->departamentoReport->dataStore("empleadosPorDepartamento")->toArray(),
            'salarioPromedioPorDepartamento' => $this->departamentoReport->dataStore("salarioPromedioPorDepartamento")->toArray(),
        ];


    }

    protected function initReports(){
        $empleadosPorDepartamento = $this->empleadoModel->getEmpleadosPorDepartamento();
        $totalEmpleados = $this->empleadoModel->getTotalEmpleados();
        $totalDepartamentosActivos = $this->departamentoModel->getTotalDepartamentosActivos();
        $salarioPromedioPorDepartamento = $this->empleadoModel->getSalarioPromedioPorDepartamento();
        $empleadosPorTipoContrato = $this->empleadoModel->getEmpleadosPorTipoContrato();
        $nominasPorEstado = $this->nominaModel->getNominasPorEstado();
        $licenciasPorFecha = $this->licenciaModel->getLicenciasPorFecha();
        $totalLicenciasActivas = $this->licenciaModel->getTotalLicenciasActivas();
        $candidatosPorVacante = $this->candidatoModel->getCandidatosPorVacante();
        $entrevistasPorEstado = $this->entrevistaModel->getEntrevistasPorEstado(); 
        $totalTareasActivas = $this->tareaModel->getTotalTareasActivas();

        $reporteGeneral = [
            'empleadosPorDepartamento' => $empleadosPorDepartamento,
            'totalDepartamentosActivos' => $totalDepartamentosActivos,
            'totalEmpleados' => $totalEmpleados,
            'salarioPromedioPorDepartamento' => $salarioPromedioPorDepartamento,
            'empleadosPorTipoContrato' => $empleadosPorTipoContrato,
            'nominasPorEstado' => $nominasPorEstado,
            'licenciasPorFecha' => $licenciasPorFecha,
            'totalLicenciasActivas' => $totalLicenciasActivas,
            'candidatosPorVacante' => $candidatosPorVacante,
            'entrevistasPorEstado' => $entrevistasPorEstado,
            'totalTareasActivas' => $totalTareasActivas,

        ];

        return $reporteGeneral;
    }
}
