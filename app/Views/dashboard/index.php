<?php
    use KoolReport\Charts\LineChart;
    #use \koolreport\chartjs\ColumnChart;
    use \koolreport\widgets\google\ColumnChart;
    use \koolreport\widgets\google\DonutChart;
    use \koolreport\widgets\google\PieChart;
    use \koolreport\widgets\google\Timeline;
    use \koolreport\widgets\google\AreaChart;
    use \koolreport\widgets\google\SteppedAreaChart
?>
<!DOCTYPE html>
<html lang="es">

<?php echo view('Layouts/head'); ?>

<body>
    <div class="wrapper">
        <?php echo view('Layouts/sidebar'); ?>
        <div class="main">
            <?php echo view('Layouts/navbar'); ?>
            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Reportes Graficos</h1>

                    <div class="row">
						<div class="col-sm-6 col-xl-3">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Total Empleados Activos</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i class="align-middle" data-feather="user-check"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?= $reportes['totalEmpleados']?></h1>
									<div class="mb-0">
										<span class="badge badge-success-light">100%</span>
										<span class="text-muted">De los datos actuales</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-xl-3">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Departamentos Activos</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i class="align-middle" data-feather="table"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?= $reportes['totalDepartamentosActivos'] ?></h1>
									<div class="mb-0">
										<span class="badge badge-success-light">100%</span>
										<span class="text-muted">De los datos actuales</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-xl-3">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Total Tareas Asignadas</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i class="align-middle" data-feather="activity"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?= $reportes['totalTareasActivas'] ?></h1>
									<div class="mb-0">
										<span class="badge badge-success-light">100%</span>
										<span class="text-muted">De los datos actuales</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-xl-3">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Total Licencias Aprobadas</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i class="align-middle" data-feather="file-text"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3"><?= $reportes['totalLicenciasActivas'] ?></h1>
									<div class="mb-0">
										<span class="badge badge-success-light">100%</span>
										<span class="text-muted">De los datod actuales</span>
									</div>
								</div>
							</div>
						</div>
					</div>
                    <div class="row">
                        <div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Grafica de empleado</h5>
								</div>
								<div class="card-body py-3">
									<div id="grafico-empleados">
                                        <?php

                                            ColumnChart::create(array(
                                                "title"=>"Número de Empleados por Departamento",
                                                "dataSource"=>$reportes['empleadosPorDepartamento'],
                                                "columns"=>array(
                                                    "departamento",
                                                    "total"=>array("label"=>"Total Empleados", "type"=>"number"),
                                                ),
                                                "options" => array(
                                                    "legend" => array("position" => "top"),

                                                    "animation" => array(
                                                        "type" => "bounce", // Tipo de animación
                                                        "duration" => 500, // Duración en milisegundos
                                                    ),
                                                    
                                                ),
                                            ));
                                        ?>                                    
                                    </div>
								</div>
							</div>
						</div>
                        <div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Grafica de salario</h5>
								</div>
								<div class="card-body py-3">
									<div id="grafico-salario">
                                        <?php
                                            // Usar los datos de salarioPromedioPorDepartamento
                                            ColumnChart::create(array(
                                                "title" => "Salario Promedio por Departamento",
                                                "dataSource" => $reportes['salarioPromedioPorDepartamento'], // Pasando el array directamente
                                                "columns" => array(
                                                    "departamento",
                                                    "promedio" => array("label" => "Salario Promedio", "type" => "number", "prefix" => "$"),
                                                ),
                                                "options" => array(
                                                    "legend" => array("position" => "top"),

                                                    "colors" => ['orange'],
                                                    
                                                )
                                            ));
                                        ?>
                                    </div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill h-40">
								<div class="card-header">

									<h5 class="card-title mb-0">Grafica de Empleado</h5>
								</div>
								<div class="card-body d-flex py-3">
									<div class="align-self-center w-100 h-100">
                                        <?php
                                            DonutChart::create(array(
                                                "title"=>"Porcentaje de Empleados por Tipo de Contrato",
                                                "dataSource"=>$reportes['empleadosPorTipoContrato'],
                                                "columns"=>array(
                                                    "tipo_contrato",
                                                    "total"=>array("label"=>"Total Empleados","type"=>"number"),
                                                ),
                                                "options" => array(
                                                    "legend" => array("visible" => true),
                                                    "legend" => array("position" => "top"),

                                                    "animation" => array(
                                                        "type" => "fade", // Tipo de animación
                                                        "duration" => 300, // Duración en milisegundos
                                                    ),
                                                    
                                                ),
                                            ));
                                        ?>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-xl-6 col-xxl-7">
                            <div class="card flex-fill w-100">
                                <div class="card-header">

                                    <h5 class="card-title mb-0">Grafica de Nomina</h5>
                                </div>
                                <div class="card-body py-3">
                                    <div class="chart chart-sm">
                                        <?php

                                            PieChart::create(array(
                                                "title"=>"Porcentaje de Nómina por Estado",
                                                "dataSource"=>$reportes['nominasPorEstado'],
                                                "columns"=>array(
                                                    "estado",
                                                    "total"=>array("label"=>"Total Nómina","type"=>"number"),
                                                ),
                                                "options" => array(
                                                    "legend" => array("position" => "top"),

                                                    "legend" => array("visible" => true),
                                                )
                                            ));
                                        ?>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Grafica de Candidato-Vacante</h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
                                        <?php
                                            ColumnChart::create(array(
                                                "title" => "Cantidad de Candidatos por Vacante",
                                                "dataSource" => $reportes['candidatosPorVacante'], // Aquí están los datos pasados desde el controlador
                                                "columns" => array(
                                                    "vacante",
                                                    "total" => array("label" => "Total de Candidatos", "type" => "number"),
                                                ),
                                                "options" => array(
                                                    "isStacked" => false,
                                                    "legend" => array("position" => "top"),
                                                    "hAxis" => array("title" => "Vacantes"),
                                                    "vAxis" => array("title" => "Cantidad de Candidatos"),
                                                    "colors" => ['#fabb3d'],
                                                ),
                                            ));
                                        ?>
									</div>
								</div>
							</div>
						</div> 
                        
                        <div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Grafica de Entrevistas</h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
                                        <?php
                                            AreaChart::create(array(
                                                "title" => "Entrevistas por Estado a lo Largo del Tiempo",
                                                "dataSource" => $reportes['entrevistasPorEstado'], // Aquí están los datos pasados desde el controlador
                                                "columns" => array(
                                                    "mes",
                                                    "seleccionado" => array("label" => "Seleccionado", "type" => "number"),
                                                    "rechazado" => array("label" => "Rechazado", "type" => "number"),
                                                    "contratado" => array("label" => "Contratado", "type" => "number"),
                                                ),
                                                "options" => array(
                                                    "isStacked" => false,
                                                    "legend" => array("position" => "top"),
                                                    "hAxis" => array("title" => "Mes"),
                                                    "vAxis" => array("title" => "Número de Entrevistados"),
                                                ),
                                            ));

                                        ?>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-12 col-md-12 col-xxl-6 d-flex order-3 order-xxl-2">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Grafico de Licencias por Fecha</h5>
								</div>
								<div class="card-body px-4">
									<div id="world_map" style="height:350px;">
                                    <?php
                                            // Usar los datos de salarioPromedioPorDepartamento
                                            Timeline::create(array(
                                                "title" => "Licencias de Empleados",
                                                "dataSource" => $reportes['licenciasPorFecha'],
                                                "columns" => array(
                                                    "empleado",
                                                    "fecha_inicio"  => array("label" => "Salario Promedio", "type" => "date"),
                                                    "fecha_final"  => array("label" => "Salario Promedio", "type" => "date"),
                                                ),
                                                "options" => array(
                                                    "hAxis" => array(
                                                        "title" => "Fechas",
                                                    ),
                                                    "vAxis" => array(
                                                        "title" => "Empleados",
                                                    ),
                                                    "legend" => array("position" => "none"),
                                                ),
                                            ));
                                        ?>

                                    </div>
								</div>
							</div>
						</div>

                </div>

			</main>
			<?php echo view('Layouts/footer'); ?>
        </div>
    </div>
    </div>
    <?php echo view('Layouts/script-js'); ?>
</body>

</html>