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

                    <h1 class="h3 mb-3">Departamentos</h1>
                    <div class="row">
                        <div class="col-14">
                            <div class="card">
                                <div class="card-header">
                                    <button class="btn btn-lg btn-primary" style=""
                                        onclick="window.location.href='<?= base_url('public/departamento/new') ?>'"><i
                                            class="align-middle" data-feather="plus"></i> <span
                                            class="align-middle">Add</span></button>
                                    <hr>
                                </div>
                                <div class="card-body div-table table-responsive"  id="divtable">
                                    <?php
                                        
										// Aquí mostramos la tabla con KoolReport
										Table::create(array(
											"dataSource" => $departamentos, // Aquí están los datos pasados desde el controlador
											"columns" => array(
												"nombre" => array("label" => "Nombre"),
                                                "estado" => array(
                                                    "coolSpan"=>2,
                                                    "label" => "Estado",
                                                    "type" => "html",
                                                    "formatValue" => function($value,$row) {
                                                        
                                                        if ($value==='activo') {
                                                            return "<span class='badge badge-success-light'>{$value}</span>";
                                                        } else {
                                                            
                                                            return "<span class='badge badge-danger-light'>{$value}</span>";
                                                        }
                                                        
                                                    }
                                                ),
                                                "editar" => array(
                                                    "coolSpan"=>2,
                                                    "label" => "Editar",
                                                    "type" => "html",
                                                    "formatValue" => function($value,$row) {
                                                        $id= $row['id_departamento'];
                                                        return "<button class='btn  btn-outline-primary' id='{$row['id_departamento']}' data='$id' onclick=\"window.location.href='http://localhost/hrm-system/public/departamento/$id/edit'\" >
                                                            <i class='align-middle' data-feather='edit'></i>
                                                        </button>";
                                                    }
                                                ),
                                                "id_departamento" => array(
                                                    "coolSpan"=>2,
                                                    "label" => "Eliminar",
                                                    "type" => "html",
                                                    "formatValue" => function($value) {
                                                       $dir= base_url('public/departamento');
                                                        return "<button type='button' class='btn-eliminar btn btn-danger' id='$value' data-id='$value' data-url='$dir/$value' >
                                                        <i class='align-middle' data-feather='trash'></i>
                                                        </button>";
                                                    }
                                                ),
											),
											"themeBase" => "bs4", // Optional option to work with Bootsrap 4
											"cssClass" => array("table" => "table table-striped table-bordered table-hover"),
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