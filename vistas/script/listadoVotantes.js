
dataTable1();
function dataTable1(){
    $('#example').DataTable({
        "destroy": true,
        "responsive": true,
        "processing": true,
        "ajax": {
        "url": "../ajax/Puntero.php?op=traerVotantes"
    },
        "columns":[
            {"data":"numero"},
            {"data":"cedula"},
            {"data":"socio"},
            {"data":"nombre"},
            {"data":"direccion"},
            {"data":"telefono"},
            {"data":"telefono1"},
            {"data":"telefono2"},
            {"data":"situacion"},
            {"data":"sede"},
            {"data":"dosis"}
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
                title: 'Votantes ',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger'
            },
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i> ',
                title: 'Votantes ',
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            },
        ]           
    });
}

