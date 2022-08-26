

var table1='';

function cargarTabla1(){
    rol=document.getElementById("rol").value;
    table1=$('#example').DataTable({

        "destroy": true,
        "responsive": true,
        "processing": true,
        "ajax": {
        "url": "../ajax/Equipo.php",
        "type": "POST",
        "data": {
            "op":"traerEquiposTabla",
            "rol":rol
        },
    },
        "columns":[
            {"data":"descripcion"},
            {
            "render": function(data, type, full, meta) {
                // return data.nombreExtendido;
                let id = data.id;
                return '<a href="addModifEquipo.php?moadfnmgvlfjhdif='+id+'"><button class="btn-xs btn-success "><img class="imagen" style="cursor:pointer;"  src="icon/check-circle-fill.svg" width="20" height="20" border ="0" id= "editar" title="Modificar" /></button></a>&nbsp;<button  name="'+id+'" class="borrar  btn-xs btn-danger "><img style="cursor:pointer;"  src="icon/dash-circle-fill.svg" width="20" height="20" border ="0" id= "agregar" title="Borrar" /></button>&nbsp;';
                },
            "bSortable": false,
            "bSearchable": false,
            "data": null
            }
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
                title: 'Dirigentes',
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
$(document).ready(function() {    
    cargarTabla1();

        
});
/*
 function Verificar(){
    if(cedulaVerif && escuelaVerif){
        document.getElementById("guardar").disabled = false;
        document.getElementById("guardar").focus();
    }else{
        document.getElementById("guardar").disabled = true;
    }
 }
 function Verificar1(){
    if(cedulaVerif1 && escuelaVerif1){
        document.getElementById("guardar1").disabled = false;
        document.getElementById("guardar1").focus();
    }else{
        document.getElementById("guardar1").disabled = true;
    }
    
 }*/
 $(document).on("click",".borrar",function(){
    codigo=$(this).attr("name");
    document.getElementById("datoBorrar").value=codigo;
    $('#modalBorrar').modal('show');

});
/*
$(document).on("click",".act",function(){
    
    location.reload();

});




 

$('#selecDirigente').click(function(){
    document.getElementById("borrarTodo").value=1;
    $('#modalSelec').modal('hide');
    $('#modalBorrar').modal('show');

});
$('#selecPuntVot').click(function(){
    alert('llega');
    $('#modalSelec').modal('hide');
    $('#modalBorrar').modal('show');
});








var miTabla = $(document).on("click",".addPuntero",function(){

    codigo=$(this).attr("name");
    document.getElementById("idDirigentePunt").value=codigo;
    mostrarDirigente(codigo)
    //miTabla.ajax.reload();
    //alert(dirigNombre);
    cargarTabla2();

    $('#modalPuntero').modal({backdrop: 'static', keyboard: false})
    $('#modalPuntero').modal('show');

});


function mostrarDirigente(codigo){

    $.ajax({
                url: "../ajax/Dirigente.php",
                type: "POST",
                data: 'op=traerNombre&id='+codigo,
                success: function(res) {
                    //dirigNombre=res;
                    document.getElementById("dirigenteMostrar").innerHTML='Dirigente: '+res;
                    
                    
                }
            }); 
}





var table2='';
function cargarTabla2(){
    codigo=document.getElementById("idDirigentePunt").value;
    //alert(dirigNombre);
    table2=$('#addPunteroTabla').DataTable({
        "destroy": true,
        "responsive": true,
        "processing": true,
        "ajax": {
        "url": "../ajax/Dirigente.php?op=traerPunteros",
        "type": "POST",
        "data": {
            "cedula": codigo
        },
    },
        "columns":[
            {"data":"padron"},
            {"data":"nombre"},
            {"data":"apellido"}
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
                title: 'Punteros del Dirigente:',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> ',
                title: 'Punteros del Dirigente:',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger'
            },
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i> ',
                title: 'Punteros del Dirigente:',
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            },
        ]           
    });
}
//var miTabla = */
