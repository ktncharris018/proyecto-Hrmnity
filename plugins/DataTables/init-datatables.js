

if ($.fn.dataTable.isDataTable('#divtable table')) {
  $('#divtable table').DataTable().destroy();  // Destruye la instancia existente
}

$(document).ready(function () {
    $('#divtable table').DataTable({
        'language' : idioma_español,
        dom: 'lfrtipB',
        responsive : false,
        "lengthMenu": [ 5, 10, 15, 20, 25, 50, 75, 100 ],
        buttons: [
          { extend : 'pdfHtml5',
            text: '<i data-feather="file"></i>',
            titleAttr: 'Descargar en pdf ',
            className: 'btn btn-danger',
            orientation: 'landscape',
          },
          { extend : 'excelHtml5',
            text: '<i data-feather="download"></i>',
            titleAttr: 'Descargar en excel ',
            className: 'btn btn-success'
          },
          {extend : 'print',
            text: '<i data-feather="printer"></i>',
            titleAttr: 'Imprimir',
            className: 'btn btn-secondary'
          },
        ],
        drawCallback: function(settings) {
          // Reemplaza los iconos de Feather después de que la tabla se haya redibujado
          feather.replace();
      }


    });
});


var idioma_español =  { 
    "processing": "Procesando...",
    "lengthMenu": "Mostrar _MENU_  registros",
    "zeroRecords": "No se encontraron resultados",
    "emptyTable": "Ningún dato disponible en esta tabla",
    "info" : "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros ",
    "infoEmpty": "Mostrando del 0 al 0 de un total de 0 registros",
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    "search": "Buscar:",
    "infoThousands": ",",
    "loadingRecords": "Cargando...",
    "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    "aria": {
        "sortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}
