/*cedulaVerif=false;
escuelaVerif=false;
cedulaVerif1=false;
escuelaVerif1=false;
puntero=false;
codDirigente='';

init();
function init(){
   //cargamos los items al select proveedor
  
   $.ajax({
                url: "../ajax/Padron.php",
                type: "POST",
                data: 'op=selectInicio',
                success: function(res) {
                    //alert(res);
                    var datos = JSON.parse(res);
                    
                    document.getElementById('idDpto').innerHTML=datos[1];
                }
            });
}

*/
dataTable1();
function dataTable1(){
    $('#example').DataTable({
        "destroy": true,
        "responsive": true,
        "processing": true,
        "ajax": {
        "url": "../ajax/ControlVotaciones.php",
        "type": "POST",
        "data": {
            "op":"resumenTotal"
        },
    },
        "columns":[
            {"data":"totalVotos"},
            {"data":"votoEquipo"},
            {"data":"porcentajeEquipo"},
            {"data":"equipo"}
        ],       
        language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
                 },
                 "sProcessing":"Procesando...",
            },
        //para usar los botones   
        responsive: "true",
        dom: 'Bfrtilp',       
        buttons:[ 
            {
                extend:    'excelHtml5',
                text:      '<i class="fas fa-file-excel"></i> ',
                title: 'Votos Faltantes',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> ',
                title: 'Dirigentes',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger'
            },
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i> ',
                title: 'Dirigentes',
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            },
        ], 
            
            /*{
            /*"render": function(data, type, full, meta) {
                // return data.nombreExtendido;
                let totalVotos = data.totalVotos;
            };*/
                "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            porcentaje= api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over all pages
            total = api
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            //totalVotos=0;
            // Total over this page
            pageTotal = api
                .column( 1, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 1 ).footer() ).html(
                'Total: '+ total
            );
            $( api.column( 2 ).footer() ).html(
                'Total:'  +porcentaje + ' %'
            );
        }          
    }); 
}
/*function Verificar(){
   
}*/
$('#voto1').click(function(){
   dataTable1();
            
});
