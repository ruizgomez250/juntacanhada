cedulaVerif=false;
escuelaVerif=false;
cedulaVerif1=false;
escuelaVerif1=false;
puntero=false;
codDirigente='';




var eq = document.getElementById('equipo');
eq.onchange = function(p) {
    cargarTabla();

}

function cargarTabla(){
   equipo = document.getElementById('equipo').value;
   if(equipo != 0){
    $('#example').DataTable({
        "destroy": true,
        "responsive": true,
        "processing": true,
        "ajax": {
        "url": "../ajax/ControlVotaciones.php",
        "type": "POST",
        "data": {
            "op":"resumen",
            "equipo":equipo
        },
    },
        "columns":[
            {"data":"porcentaje"},
             {
            "render": function(data, type, full, meta) {
                // return data.nombreExtendido;
                let actual = data.votoActual;
                let puntero= data.idPuntero;
                return '<button  name="'+puntero+'" class=" actual  btn-redondo">'+actual+'</button>';
                },
            "bSortable": false,
            "bSearchable": false,
            "data": null
            },
            {"data":"votoTotal"},
            {
            "render": function(data, type, full, meta) {
                // return data.nombreExtendido;
                let faltante = data.faltante;
                let puntero= data.idPuntero;
                return '<button  name="'+puntero+'" class=" faltante  btn-redondo">'+faltante+'</button>';
                },
            "bSortable": false,
            "bSearchable": false,
            "data": null
            },
            {"data":"votoAgregado"},
            {"data":"actualYAgregado"},
            {"data":"nombre"},
            {"data":"telefono"},
            {"data":"telefono1"},
            {"data":"telefono2"}
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
        ]           
    });
    } 
}
var table2 = '';
function cargarTabla2(codigo){
 table2=   $('#addPunteroTabla').DataTable({
        "destroy": true,
        "responsive": true,
        "processing": true,
        "ajax": {
        "url": "../ajax/Puntero.php?op=traerVotantesFaltantes",
        "type": "POST",
        "data": {
            "codigo": codigo
        },
    },
        "columns":[
            {"data":"numero"},
            {"data":"cedula"},
            {"data":"socio"},
            {"data":"nombre"},
            {"data":"mesa"},
            {"data":"orden"}
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
                title: 'Votantes',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> ',
                title: 'Votantes',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger'
            },
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i> ',
                title: 'Votantes',
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            },
        ]           
    });
}
function cargarTabla3(codigo){
 table2=   $('#addPunteroTabla').DataTable({
        "destroy": true,
        "responsive": true,
        "processing": true,
        "ajax": {
        "url": "../ajax/Puntero.php?op=traerVotantesActuales",
        "type": "POST",
        "data": {
            "codigo": codigo
        },
    },
        "columns":[
            {"data":"numero"},
            {"data":"cedula"},
            {"data":"socio"},
            {"data":"nombre"},
            {"data":"mesa"},
            {"data":"orden"}
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
                title: 'Votantes',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> ',
                title: 'Votantes',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger'
            },
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i> ',
                title: 'Votantes',
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            },
        ]           
    });
}
function Verificar(){
   
}
$('#voto1').click(function(){
   cargarTabla();
            
});
$(document).on("click",".actual",function(){
    puntero=$(this).attr("name");
    cargarTabla3(puntero);
    $('#modalPuntero').modal({backdrop: 'static', keyboard: false})
    $('#modalPuntero').modal('show');
});

$(document).on("click",".faltante",function(){
    puntero=$(this).attr("name");
    cargarTabla2(puntero);
    $('#modalPuntero').modal({backdrop: 'static', keyboard: false})
    $('#modalPuntero').modal('show');
});