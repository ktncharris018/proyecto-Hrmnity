<div id="divtable">
<?php

     use \koolreport\widgets\koolphp\Table;
     use \koolreport\widgets\google\ColumnChart;;
                                        
    // Aquí mostramos la tabla con KoolReport
    Table::create(array(
        "dataSource" => $empleados, // Aquí están los datos pasados desde el controlador
        "columns" => array(
            "nombre" => array("label" => "Nombre"),
            "identificacion" => array("label" => "Identificacion"),
            "contacto" => array("label" => "Contacto"),
            "tipo_contrato" => array("label" => "Contrato"),
            "supervisor" => array("label" => "Supervisor"),
            "titulo" => array("label" => "Profesion"),
            "edit" => array(
                "coolSpan"=>2,
                "label" => "Editar",
                "type" => "html",
                "formatValue" => function($row) {
                    return "<button class='btn  btn-outline-primary'>
                    <i class='align-middle' data-feather='edit'></i>
                    </button>";
                }
            ),
            "id_empleado" => array(
                "coolSpan"=>2,
                "label" => "Eliminar",
                "type" => "html",
                "formatValue" => function($row) {
                    $dir= base_url('public/empleado');
                    return "<button type='button' class='btn-eliminar btn btn-danger' id='$row' data-id='$row' data-url='$dir/$row'>
                    <i class='align-middle' data-feather='trash'></i>
                    </button>";
                }
            ),
        ),
        "themeBase" => "bs4", // Optional option to work with Bootsrap 4
        "cssClass" => array(
            "table" => "table table-striped table-bordered table-hover"),
            "td" => "p-0", // Reduce el padding de las celdas
            "th" => "p-0", // Reduce el padding de las cabeceras
            "options"=>array(
                "id"=> "mitabla",
                "searching"=>true,
            ),
            "searchOnEnter" => true,
            "searchMode" => "or",
            "headerCallback" => function($header){
                // Definir encabezado para la columna combinada "Acciones"
                echo "<th colspan='2'>Acciones</th>";
            }
    ));
?>
</div>
<script>



$(document).ready(function() {
        var table;

        // Función para inicializar DataTables
        function initializeDataTable() {
            // Si ya hay una instancia de DataTables, destrúyela
            if ($.fn.DataTable.isDataTable('#divtable table')) {
                $('#divtable table').DataTable().destroy();
            }

            // Inicializa DataTables
            table = $('#divtable table').DataTable({
                responsive: true,
                lengthChange: false,
                paging: true,
                searching: true,
                ordering: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdfHtml5', 'print'
                ],
                language: {
                    paginate: {
                        previous: "Anterior",
                        next: "Siguiente"
                    }
                }
            });
        }

        
        initializeDataTable();
        //loadTable();

    });

</script>

