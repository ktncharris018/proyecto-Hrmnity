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

                    <h1 class="h3 placeholder-glow mb-3">Salarios de los Empleados</h1>
                    <div class="row">
                        <div class="col-14">
                            <div class="card">
                                <div class="card-header">
                                    <button class="btn btn-lg btn-primary" style=""
                                        onclick="window.location.href='<?= base_url('public/salario/new') ?>'"><i
                                            class="align-middle" data-feather="plus"></i> <span
                                            class="align-middle">Add</span></button>
                                    <hr>
                                </div>
                                <div class="card-body table-responsive table-bordered"  id="divtable">
                                    <?php
                                        
										// Aquí mostramos la tabla con KoolReport
										Table::create(array(
											"dataSource" => $salarios, // Aquí están los datos pasados desde el controlador
											"columns" => array(
												"empleado" => array("label" => "Empleado"),
												"salario_base" => array("label" => "Salario Base"),
												"aux_transporte" => array("label" => "Aux Transporte"),
												"bonificacion" => array("label" => "Bonificacion"),
												"deduccion_salud" => array("label" => "Salud"),
                                                "deduccion_pension" => array("label" => "Pension"),
                                                "salario_total" => array("label" => "Total"),
                                                "editar" => array(
                                                    "coolSpan"=>2,
                                                    "label" => "Editar",
                                                    "type" => "html",
                                                    "formatValue" => function($value,$row) {
                                                        $id= $row['id_salario'];
                                                        return "<button class='btn  btn-outline-primary' id='{$row['id_salario']}' data='$id' onclick=\"window.location.href='http://localhost/hrm-system/public/salario/$id/edit'\" >
                                                            <i class='align-middle' data-feather='edit'></i>
                                                        </button>";
                                                    }
                                                ),
                                                "id_salario" => array(
                                                    "coolSpan"=>2,
                                                    "label" => "Eliminar",
                                                    "type" => "html",
                                                    "formatValue" => function($value) {
                                                       $dir= base_url('public/salario');
                                                        return "<button type='button' class='btn-eliminar btn btn-danger' id='$value' data-id='$value' data-url='$dir/$value'>
                                                        <i class='align-middle' data-feather='trash'></i>
                                                        </button>";
                                                    }
                                                ),
											),
											"themeBase" => "bs4", // Optional option to work with Bootsrap 4
											"cssClass" => array("table" => "table table-striped table-bordered border-primary table-hover  vertical-align-middle"),
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
    <script>
        setTimeout(function() {
    // Solo hacemos un log para indicar que pasó el retraso
            console.log("Simulación de carga completada, pero no se cambia el contenido.");
        }, 5000);

    </script>



</body>

</html>