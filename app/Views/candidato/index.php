<?php

use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\ColumnChart;;

?>

<!DOCTYPE html>
<html lang="es">

<?php echo view('Layouts/head'); ?>

<body>
    <div class="wrapper">
        <?php echo view('Layouts/sidebar'); ?>
        <div class="main">
            <?php echo view('Layouts/navbar'); ?>
            <main class="content p-4">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Candidatos A Vacantes</h1>
                    <div class="row">
                        <div class="col-14">
                            <div class="card">
                                <div class="card-header">
                                    <button class="btn btn-lg btn-primary" style=""
                                        onclick="window.location.href='<?= base_url('public/candidato/new') ?>'"><i
                                            class="align-middle" data-feather="plus"></i> <span
                                            class="align-middle">Add</span></button>
                                    <hr>
                                </div>
                                <div class="card-body table-responsive"  id="divtable">
                                    <?php
                                        
										// Aquí mostramos la tabla con KoolReport
										Table::create(array(
											"dataSource" => $candidatos, // Aquí están los datos pasados desde el controlador
											"columns" => array(
												"nombre" => array("label" => "Nombre"),
												"identificacion" => array("label" => "Identificacion"),
												"contacto" => array("label" => "Contacto"),
												"estado" => array("label" => "Estado"),
												"fecha_solicitud" => array("label" => "Fecha"),
                                                "vacante" => array("label" => "Vacante"),
                                                "portafolio" => array(
                                                    "coolSpan"=>2,
                                                    "label" => "Archivo",
                                                    "type" => "html",
                                                    "formatValue" => function($value) {
                                                       $dir= base_url('public/empleado');
                                                        return "<a target='_blank' class='btn btn-outline-warning' href='http://localhost/hrm-system/public/uploads/archivos/candidatos/$value' id='$value'  data-url='$dir/$value'>
                                                        <i class='align-middle' data-feather='file'></i>
                                                        </a>";
                                                    }
                                                ),
                                                "editar" => array(
                                                    "coolSpan"=>2,
                                                    "label" => "Editar",
                                                    "type" => "html",
                                                    "formatValue" => function($value,$row) {
                                                        $id= $row['id_candidato'];
                                                        return "<button class='btn  btn-outline-primary' id='{$row['id_candidato']}' data='$id' onclick=\"window.location.href='http://localhost/hrm-system/public/candidato/$id/edit'\" >
                                                            <i class='align-middle' data-feather='edit'></i>
                                                        </button>";
                                                    }
                                                ),
                                                "id_candidato" => array(
                                                    "coolSpan"=>2,
                                                    "label" => "Eliminar",
                                                    "type" => "html",
                                                    "formatValue" => function($value) {
                                                       $dir= base_url('public/candidato');
                                                        return "<button type='button' class='btn-eliminar btn btn-danger' id='$value' data-id='$value' data-url='$dir/$value'>
                                                        <i class='align-middle' data-feather='trash'></i>
                                                        </button>";
                                                    }
                                                ),
											),
											"themeBase" => "bs4", // Optional option to work with Bootsrap 4
											"cssClass" => array("table" => "table table-striped table-bordered table-hover table-sm vertical-align-middle"),
                                                "td" => "p-0", // Reduce el padding de las celdas
                                                "th" => "p-0", // Reduce el padding de las cabeceras
												"options"=>array(
													"id"=> "mitabla",
													"searching"=>true,
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

    <?php echo view('Layouts/script-js'); ?>



</body>

</html>