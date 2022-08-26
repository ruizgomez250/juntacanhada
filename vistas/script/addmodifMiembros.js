cedulaVerif=false;



if(document.getElementById('modificarVerif').value != 0){
            cedulaVerif=true;
           cargarTabla1();
            
}
var punt = document.getElementById('cedulaP');
punt.onchange = function(p) {
    codigo = document.getElementById('cedulaP').value;
    if(codigo.length > 0){
        $.ajax({
                url: "../ajax/MiembrosMesa.php",
                type: "POST",
                data: 'op=buscarMiembros&cedula='+codigo,
                success: function(res) {
                    var datos = JSON.parse(res);
                    if(datos[0] == 'false'){
                        document.getElementById("puntmensaje").style.display = 'none';
                        document.getElementById("puntmensaje1").style.display = 'block';
                        document.getElementById('nombre2').value = '';
                        document.getElementById('cedulaP').value = '';
                        document.getElementById('mesa2').value = '';
                        document.getElementById('orden2').value = '';
                        document.getElementById('socioN').value = '';
                        cedulaVerif1=false;
                    }else if(datos[0] == 'false1'){
                        document.getElementById('existeAviso').innerHTML='Ya se guardo un Miembro de Mesa con esos datos';
                        $('#modalAviso').modal('show');
                        //document.getElementById("puntmensaje").innerHTML='Ya se guardo un Puntero con esa cedula en: '+datos[1];
                        //document.getElementById("puntmensaje").style.display = 'block';
                        document.getElementById("puntmensaje1").style.display = 'none';
                        document.getElementById('nombre2').value = '';
                        document.getElementById('cedulaP').value = '';
                        document.getElementById('mesa2').value = '';
                        document.getElementById('orden2').value = '';
                        document.getElementById('socioN').value = '';
                        cedulaVerif1=false;
                    }
                    else{
                        document.getElementById("puntmensaje1").style.display = 'none';
                        document.getElementById("puntmensaje").style.display = 'none';
                        document.getElementById('nombre2').value = datos[0];
                        document.getElementById('mesa2').value = datos[1];
                        document.getElementById('orden2').value = datos[2];
                        document.getElementById('socioN').value = datos[3];
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

function cargarDir(cod){
    $.ajax({
                url: "../ajax/MiembrosMesa.php",
                type: "POST",
                data: 'op=traerDelPadron&cedula='+cod,
                success: function(res) {
                    var datos = JSON.parse(res);

                    document.getElementById("cedulaD").value=cod;
                    document.getElementById("nombre1").value=datos[1];
                    document.getElementById("nombreMiembro").value=datos[1];
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
    $.ajax({
                url: "../ajax/Votantes.php",
                type: "POST",
                data: 'op=guardar&dirigente='+dirigente+'&cedula='+cedula,
                success: function(res) {
                    //alert(res);
                    cargarTabla2();
                    cargarTabla1(res);
                    document.getElementById("cedulaP").value='';
                    document.getElementById("socioN").value='';
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
cargarTabla1()
function cargarTabla1(){
    table1=$('#example').DataTable({
        "destroy": true,
        "responsive": true,
        "processing": true,
        "ajax": {
        "url": "../ajax/MiembrosMesa.php",
        "type": "POST",
        "data": {
            "op":"traerMiembrosTabla"
        },
    },
        "columns":[
            {"data":"cont"},
            {"data":"cedula"},
            {"data":"nombre"},
             {"data":"link"},
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
$(document).on("click",".copiar",function(){
    codigo=$(this).attr("name");
    codigo="www.votacion-py.com/vistas/addVotoCed.php?adfajjvjopbkmerhnhhfeomcpoemchghhcmerttayuupxcvbbmxhnljpq="+codigo;
    //codigo.select();
    //document.execCommand('copy');
    navigator.clipboard.writeText(codigo)
        .then(() => {
        console.log("Link copiado...")
    })
        .catch(err => {
        console.log('No se pudo copiar el Link', err);
    })
    alert(codigo);

});
 function Verificar(){
    if(cedulaVerif){
        longCed=document.getElementById("cedulaD").value;
        if(longCed.length != 0){
            document.getElementById("guardar").disabled = false;
            document.getElementById("guardar").focus();
        }
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
    document.getElementById("tablaBorrar").value=1;
    
    $('#modalBorrar').modal('show');

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
    //miTabla.ajax.reload();
    //alert(dirigNombre);
    

    //$('#modalPuntero').modal({backdrop: 'static', keyboard: false})
    $('#modalPuntero').modal('show');

});


function mostrarDirigente(codigo){

    $.ajax({
                url: "../ajax/Puntero.php",
                type: "POST",
                data: 'op=traerNombre&id='+codigo,
                success: function(res) {
                    //dirigNombre=res;
                    document.getElementById("dirigenteMostrar").innerHTML='Puntero: '+res;
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
        "url": "../ajax/Puntero.php?op=traerVotantes",
        "type": "POST",
        "data": {
            "cedula": codigo
        },
    },
        "columns":[
            {"data":"numero"},
            {"data":"cedula"},
            {"data":"socio"},
            {"data":"nombre"},
            {"data":"direccion"},
            {"data":"estado"},
            {"data":"situacion"},
            {
            "render": function(data, type, full, meta) {
                // return data.nombreExtendido;
                let id = data.id;
                let nombre = data.nombreExtendido;
                return '<button type="button" onclick="getEliminar(\'' + nombre + '\',' + id + ');" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar Registro"><i class="fas fa-trash-alt"></i></button>';
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
                title: 'Votantes del '+dirigente,
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> ',
                title: 'Votantes del '+dirigente,
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger'
            },
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i> ',
                title: 'Votantes del '+dirigente,
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            },
        ]           
    });
}
function getEliminar(dpto, id) {
     //alert(id);
     document.getElementById("datoBorrar").value=id;
     document.getElementById("tablaBorrar").value=2;
    
    $('#modalBorrar').modal('show');
}
//var miTabla = */
$('#borrarOpcion').click(function(){
    codigo=document.getElementById("datoBorrar").value;
    if(document.getElementById("tablaBorrar").value == 2){
        $.ajax({
                url: "../ajax/Votantes.php",
                type: "POST",
                data: 'op=borrar&datoBorrar='+codigo,
                success: function(res) {
                    cargarTabla2();
                    cargarTabla1(res);
                }
            });
    }else if(document.getElementById("tablaBorrar").value == 1){
        $.ajax({
                url: "../ajax/Puntero.php",
                type: "POST",
                data: 'op=borrar&datoBorrar='+codigo,
                success: function(res) {
                   location.reload(); 
                }
            });

    }
    $('#modalBorrar').modal('hide');
});