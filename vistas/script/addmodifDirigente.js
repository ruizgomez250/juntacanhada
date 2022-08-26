cedulaVerif=false;
equipoVerif=false;



if(document.getElementById('modificarVerif').value != 0){
            cedulaVerif=true;
           equipoVerif=true;
           idEq=document.getElementById('equipoVerif').value;
           cargarTabla1(idEq);
            
}
var punt = document.getElementById('cedulaP');
punt.onchange = function(p) {
    codigo = document.getElementById('cedulaP').value;
    if(codigo.length > 0){
        $.ajax({
                url: "../ajax/Puntero.php",
                type: "POST",
                data: 'op=buscarPuntero&cedula='+codigo,
                success: function(res) {
                    var datos = JSON.parse(res);
                    if(datos[0] == 'false'){
                        document.getElementById("puntmensaje").style.display = 'none';
                        document.getElementById("puntmensaje1").style.display = 'block';
                        document.getElementById('nombre2').value = '';
                        document.getElementById('cedulaP').value = '';
                        document.getElementById('telefono3').value = '';
                        document.getElementById('telefono4').value = '';
                        document.getElementById('telefono5').value = '';
                        cedulaVerif1=false;
                    }else if(datos[0] == 'false1'){
                        document.getElementById("puntmensaje").innerHTML='Ya se guardo un Puntero con esa cedula en: '+datos[1];
                        document.getElementById("puntmensaje").style.display = 'block';
                        document.getElementById("puntmensaje1").style.display = 'none';
                        document.getElementById('nombre2').value = '';
                        document.getElementById('cedulaP').value = '';
                        document.getElementById('telefono3').value = '';
                        document.getElementById('telefono4').value = '';
                        document.getElementById('telefono5').value = '';
                        cedulaVerif1=false;
                    }
                    else{
                        document.getElementById("puntmensaje1").style.display = 'none';
                        document.getElementById("puntmensaje").style.display = 'none';
                        document.getElementById('nombre2').value = datos[0];
                        document.getElementById('telefono3').value = datos[1];
                        document.getElementById('telefono4').value = datos[2];
                        document.getElementById('telefono5').value = datos[3];
                        cedulaVerif1=true;
                    }
                    Verificar1();
                    
                }
            }); 

        
    }else{
        cedulaVerif1=false;
    }
    Verificar1();

}
var codEs = document.getElementById('cedulaD');
codEs.onchange = function(p) {
    codigo = document.getElementById('cedulaD').value;
    if(codigo.length > 0){
        puntero=false;
        cargarDir(codigo);

    }else{
        document.getElementById("cedulaD").value='';
        document.getElementById("nombre1").value='';
        document.getElementById("telefono").value='';
        document.getElementById("telefono1").value='';
        document.getElementById("telefono2").value='';
        cedulaVerif=false;
    }
    Verificar();



}

var codEq = document.getElementById('equipo');
codEq.onchange = function(paa) {

    codigo = document.getElementById('equipo').value;
    if(codigo.length > 0){
        cargarTabla1(codigo);
        equipoVerif=true;           
    }else{
        equipoVerif=false;
    }
    Verificar()

}
/*
$('#botSector').click(function() {
    puntero=false;
    $('#modalEscuela').modal('show');

});
$('#botSelect').click(function() {
    $('#modalEscuela').modal('hide');
    cod=document.getElementById('idEsc').value;
    cargarEsc(cod);
});
$('#botEsc').click(function() {
    puntero=true;
   $('#modalEscuela').modal('show');

});

*/
function cargarDir(cod){
    $.ajax({
                url: "../ajax/Dirigente.php",
                type: "POST",
                data: 'op=traerDelPadron&cedula='+cod,
                success: function(res) { 
                    var datos = JSON.parse(res);

                    document.getElementById("cedulaD").value=datos[0];
                    document.getElementById("nombre1").value=datos[1];
                    document.getElementById("telefono").value=datos[2];
                    document.getElementById("telefono1").value=datos[3];
                    document.getElementById("telefono2").value=datos[4];
                    cedulaVerif=true;
                    if(datos[5] == 1){
                         document.getElementById("funcmensaje").innerHTML='Ya se cargo esa cedula en: '+datos[6]+'!!!';
                         document.getElementById("funcmensaje").style.display = 'block';
                        cedulaVerif=false;
                    }else{
                        document.getElementById("funcmensaje").style.display = 'none';
                    }
                    
                    Verificar();
                    Verificar1();
                    
                }
            }); 

}
$('#guardar1').click(function() {
    dirigente=document.getElementById("idDirigentePunt").value;
    cedula=document.getElementById("cedulaP").value;
    telefono=document.getElementById("telefono3").value;
    telefono1=document.getElementById("telefono4").value;
    telefono2=document.getElementById("telefono5").value;
    equipo=document.getElementById("equipo").value;
    $.ajax({
                url: "../ajax/Puntero.php",
                type: "POST",
                data: 'op=guardar&dirigente='+dirigente+'&cedula='+cedula+'&telefono='+telefono+'&telefono1='+telefono1+'&telefono2='+telefono2+'&equipo='+equipo,
                success: function(res) {
                    //alert(res);
                    cargarTabla2();
                    cargarTabla1(res);
                    document.getElementById("cedulaP").value='';
                    document.getElementById("nombre2").value='';
                    document.getElementById("telefono3").value='';
                    document.getElementById("telefono4").value='';
                    document.getElementById("telefono5").value='';
                    cedulaVerif1=false;
                    Verificar1();
                }
            }); 

});

var table1='';

function cargarTabla1(equipo){
    table1=$('#example').DataTable({
        "destroy": true,
        "responsive": true,
        "processing": true,
        "ajax": {
        "url": "../ajax/Dirigente.php",
        "type": "POST",
        "data": {
            "op":"traerDirigentesTabla",
            "equipo":equipo
        },
    },
        "columns":[
            {"data":"numero"},
            {"data":"cedula"},
            {"data":"nombre"},
            {"data":"cantPuntero"},
            {"data":"cantVoto"},
            {
            "render": function(data, type, full, meta) {
                    // return data.nombreExtendido;
                    let id = data.id;
                    return '<a href="addModifDirigente.php?moadfnmgvlfjhdif='+id+'"><button class="btn-xs btn-success"><img class="imagen" style="cursor:pointer;"  src="icon/check-circle-fill.svg" width="20" height="20" border ="0" id= "editar" title="Modificar" /></button></a>&nbsp;<button  name="'+id+'" class="borrar  btn-xs btn-danger "><img style="cursor:pointer;"  src="icon/dash-circle-fill.svg" width="20" height="20" border ="0" id= "agregar" title="Borrar" /></button><button  name="'+id+'" class="addPuntero btn-xs btn-info "><img class="imagen" style="cursor:pointer;"  src="icon/plus-circle-fill.svg" width="20" height="20" border ="0" id= "agregar" title="Agregar Puntero" /></button>';
                    
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
/*$(document).ready(function() {    
    cargarTabla1();

        
});*/

 function Verificar(){
    if(cedulaVerif && equipoVerif){

            document.getElementById("guardar").disabled = false;
            document.getElementById("guardar").focus();
        
    }else{
        document.getElementById("guardar").disabled = true;
    }
 }
 function Verificar1(){
    if(cedulaVerif1){
        document.getElementById("guardar1").disabled = false;
        document.getElementById("guardar1").focus();
    }else{
        document.getElementById("guardar1").disabled = true;
    }
    
 }
 $(document).on("click",".borrar",function(){
    codigo=$(this).attr("name");
    document.getElementById("datoBorrar").value=codigo;
    $('#modalSelec').modal('show');

});

$(document).on("click",".act",function(){
    
    location.reload();

});




 

$('#selecDirigente').click(function(){
    document.getElementById("borrarTodo").value=1;
    $('#modalSelec').modal('hide');
    $('#modalBorrar').modal('show');

});
$('#selecPuntVot').click(function(){
    document.getElementById("borrarTodo").value=2;
    $('#modalSelec').modal('hide');
    $('#modalBorrar').modal('show');
});








var miTabla = $(document).on("click",".addPuntero",function(){

    codigo=$(this).attr("name");
    document.getElementById("idDirigentePunt").value=codigo;
    mostrarDirigente(codigo)
    

    $('#modalPuntero').modal({backdrop: 'static', keyboard: false})
    $('#modalPuntero').modal('show');

});


function mostrarDirigente(codigo){
    $.ajax({
                url: "../ajax/Dirigente.php",
                type: "POST",
                data: 'op=traerNombre&id='+codigo,
                success: function(res) {
                    document.getElementById("dirigenteMostrar").innerHTML='Dirigente: '+res;
                    cargarTabla2();
                    
                }
            });
}





var table2='';
function cargarTabla2(){
    codigo=document.getElementById("idDirigentePunt").value;
    dirigente=document.getElementById("dirigenteMostrar").innerHTML;
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
            {"data":"numero"},
            {"data":"cedula"},
            {"data":"nombre"},
            {"data":"cantVotante"}
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
                title: 'Punteros del '+dirigente,
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> ',
                title: 'Punteros del '+dirigente,
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger'
            },
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i> ',
                title: 'Punteros del '+dirigente,
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            },
        ]           
    });
}
//var miTabla = */
