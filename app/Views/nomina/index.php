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

                    <h1 class="h3 mb-3">Nominas de los Empleados</h1>
                    <div class="row">
                        <div class="col-14">

                            <div class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                <div class="alert-icon">
                                    <i class="align-middle" data-feather="bell"></i>
                                </div>
                                <div class="alert-message">
                                    Las fecha de pago son los <strong>Dias 25 de cada Mes</strong> 
                                </div>
                            </div>
                            <div class="card">

                                <div class="card-header">

                                </div>
                                <div class="card-body table-responsive" id="divtable">
                                    <?php
                                        
										// Aquí mostramos la tabla con KoolReport
										Table::create(array(
											"dataSource" => $nominas, // Aquí están los datos pasados desde el controlador
											"columns" => array(
												"empleado" => array("label" => "Empleado"),
												"salario_id" => array("label" => "id salario"),
												"fecha_anterior" => array("label" => "Fecha Anterior"),
												"fecha_proxima" => array("label" => "Fecha Proxima"),
                                                "estado" => array(
                                                    "coolSpan"=>2,
                                                    "label" => "Estado",
                                                    "type" => "html",
                                                    "formatValue" => function($value,$row) {
                                                        
                                                        if ($value==='pendiente') {

                                                            return "<span class='badge bg-primary my-2'>{$value}</span>";
                                                        } else if ($value==='pagado') {
                                                            
                                                            return "<span class='badge bg-success'>{$value}</span>";

                                                        }else {
                                                            
                                                            return "<span class='badge bg-danger'>{$value}</span>";
                                                        }
                                                        
                                                    }
                                                ),
                                                "nomina_total" => array(
                                                    "coolSpan"=>2,
                                                    "label" => "Nomina Total",
                                                    "type" => "html",
                                                    "formatValue" => function($value,$row) {

                                                        return number_format($value, 0, ',', '.');

                                                    }
                                                ),
                                                "editar" => array(
                                                    "coolSpan"=>2,
                                                    "label" => "Editar",
                                                    "type" => "html",
                                                    "formatValue" => function($value, $row) {
                                                        $nominas = $row;
                                                        $data = ['nomina'=>$row];
                                                        // $id = $row['id_nomina'];
                                                        // echo print_r($row);                                                        
                                                        // echo print_r($data);
                                                        
                                                        echo view('nomina/edit', $row);
                                                  
                                                        return "<button class='btn  btn-outline-primary' data-bs-toggle='modal' data-bs-target='#modalEditNomina{$row['id_nomina']}' id='{$row['id_nomina']}' data='var_dump({$row['nomina_total']})' onclickok=\"window.location.href='http://localhost/hrm-system/public/nomina//edit'\" >
                                                            <i class='align-middle' data-feather='edit'></i>
                                                        </button>";
                                                    }
                                                ),
                                                "id_nomina" => array(
                                                    "coolSpan"=>2,
                                                    "label" => "Pago",
                                                    "type" => "html",
                                                    "formatValue" => function($value) {
                                                       $dir= base_url("public/nomina/$value");
                                                    //    $data=['id_nomina' => $value];
                                                    //    view('nomina/edit' ,$data);
                                                        return "<button type='button' class='btn btn-warning' id='$value' data-id='$value' onclick=\"window.location.href='$dir'\">
                                                        <i class='align-middle' data-feather='eye'></i>
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

    <script>
        $(document).ready(function() {
            // Función para formatear el número
            function formatearNumero(valor) {
                // Quitar caracteres no numéricos, excepto el punto y la coma
                valor = valor.replace(/[^0-9]/g, ''); // Solo mantener dígitos
                // Formatear la parte entera con puntos
                return valor.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Evento para formatear el número al escribir en inputs con la clase "formatear-numero"
            $(document).on('input', '.formatear-numero', function() {
                const valorFormateado = formatearNumero($(this).val());
                $(this).val(valorFormateado);
            });

            // Limpiar los inputs antes de enviar el formulario
            $('form').on('submit', function() {
                $('.formatear-numero').each(function() {
                    // Eliminar puntos y cambiar la coma por un punto
                    const valorLimpio = $(this).val().replace(/\./g, '');
                    $(this).val(valorLimpio); // Actualiza el input para el envío
                });
            });
        });
    </script>


</body>

</html>