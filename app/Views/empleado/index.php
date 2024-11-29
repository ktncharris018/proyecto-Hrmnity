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

                    <h1 class="h3 mb-3">Empleados</h1>
                    <div class="d-flex justify-content-end p-2 m-2">
                        <button type="button" id="btnVistaTabla" class="btn btn-outline-secondary"><i
                                class="align-middle" data-feather="table"></i></button>
                        <button type="button" id="btnVistaCard" class="btn btn-outline-secondary"><i
                                class="align-middle" data-feather="grid"></i></button>
                    </div>

                    <div class="row" id="vistaCard" style="display:none">

                        <?php foreach ($empleados as $empleado): ?>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="card">
                                <img class="card-img-top"
                                    src="<?= base_url("public/uploads/img/empleados/{$empleado['foto_perfil']}"); ?>"
                                    alt="foto de perfil del empleado" style="height: 150px;">
                                <div class="card-header px-4 pt-4">
                                    <div class="card-actions float-end">
                                    </div>
                                    <h5 class="fw-bold mb-0"><?= $empleado['nombre'] ?></h5>
                                </div>
                                <div class="">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">identificacion: <?= $empleado['identificacion'] ?>
                                        </li>
                                        <li class="list-group-item">departamento:
                                            <?= $empleado['nombre_departamento'] ?></li>
                                        <li class="list-group-item">profesion: <?= $empleado['titulo'] ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endforeach?>
                    </div>

                    <div class="row">
                        <div class="col-14">
                            <div class="card" id="vistaTabla">
                                <div class="card-header ">
                                    <button class="btn btn-lg btn-primary" style=""
                                        onclick="window.location.href='<?= base_url('public/empleado/new') ?>'"><i
                                            class="align-middle" data-feather="plus"></i> <span
                                            class="align-middle">Add</span></button>
                                    <hr>
                                </div>
                                <div class="table-responsive table-bordered">

                                    <div class="card-body" id="divtable">
                                        <?php
                                            
                                            // Aquí mostramos la tabla con KoolReport
                                            Table::create(array(
                                                "dataSource" => $empleados, // Aquí están los datos pasados desde el controlador
                                                "columns" => array(
                                                    "nombre" => array("label" => "Nombre"),
                                                    "identificacion" => array("label" => "Identificacion"),
                                                    "contacto" => array("label" => "Correo"),
                                                    "titulo" => array("label" => "Profesion"),
                                                    "tipo_contrato" => array("label" => "Contrato"),
                                                    "nombre_departamento" => array("label" => "Departamento"),
                                                    "editar" => array(
                                                        "coolSpan"=>2,
                                                        "label" => "Editar",
                                                        "type" => "html",
                                                        "formatValue" => function($value,$row) {
                                                            $id= $row['id_empleado'];
                                                            return "<button class='btn  btn-outline-primary' id='{$row['id_empleado']}' data='$id' onclick=\"window.location.href='http://localhost/hrm-system/public/empleado/$id/edit'\" >
                                                                <i class='align-middle' data-feather='edit'></i>
                                                            </button>";
                                                        }
                                                    ),
                                                    "id_empleado" => array(
                                                        "coolSpan"=>2,
                                                        "label" => "Eliminar",
                                                        "type" => "html",
                                                        "formatValue" => function($value) {
                                                           $dir= base_url('public/empleado');
                                                            return "<button type='button' class='btn-eliminar btn btn-danger' id='$value' data-id='$value' data-url='$dir/$value'>
                                                            <i class='align-middle' data-feather='trash'></i>
                                                            </button>";
                                                        }
                                                    ),
                                                ),
                                                "themeBase" => "bs4", // Optional option to work with Bootsrap 4
                                                "cssClass" => array("table" => "table table-striped table-bordered table-hover vertical-align-middle"),
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

                </div>
            </main>
            <?php echo view('Layouts/footer'); ?>

        </div>
    </div>

    <?php echo view('Layouts/script-js'); ?>

    <script>
    $(document).ready(function() {
        $('#vistaCard').hide(); // Oculta las tarjetas
        $('#btnVistaTabla').click(function() {
            $('#vistaTabla').show(); // Muestra la tabla
            $('#vistaCard').hide(); // Oculta las tarjetas
        });

        $('#btnVistaCard').click(function() {
            $('#vistaCard').show(); // Muestra las tarjetas
            $('#vistaTabla').hide(); // Oculta la tabla
        });
    });
    </script>

    <!-- <script>
        $(document).ready(function() {
            $('#divtable table').DataTable({
                responsive: false,
                lengthChange: 2,
                paging: true,
                searching: true,
                ordering: true,
                // Inicializa DataTables con la integración para Bootstrap 5
                "dom": 'Bfrtip',

                "buttons": [
                    'copy', 'excel', 'pdfHtml5', 'print'
                ],
                "language": {
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Siguiente"
                    }
                }
            });
        });
    </script> -->


</body>

</html>