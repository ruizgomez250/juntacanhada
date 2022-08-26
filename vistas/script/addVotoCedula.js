cedulaVerif=false;
escuelaVerif=false;
cedulaVerif1=false;
escuelaVerif1=false;
puntero=false;
codDirigente='';

var cedula1 = document.getElementById('cedulaInput');
cedula1.onchange = function(aVo) {
    cedula=document.getElementById("cedulaInput").value;
    if(cedula.length > 0){
            verifSiVoyCargarCedula(cedula);
    }else{
        document.getElementById('voto1').disabled=true;
        document.getElementById('aVotar').innerHTML='';
        document.getElementById('aVotar1').innerHTML='';
        document.getElementById('socioInput').value='';
        Verificar();
    }
    
 }
 var soc1 = document.getElementById('socioInput');
soc1.onchange = function(aVo1) {
    socio=document.getElementById("socioInput").value;
    if(socio.length > 0){
            verifSiVoyCargarSocio(socio);
    }else{
        document.getElementById('voto1').disabled=true;
        document.getElementById('aVotar').innerHTML='';
        document.getElementById('aVotar1').innerHTML='';
        document.getElementById('cedulaInput').value='';
        Verificar();
    }
    
 }

  /*
init();
function init(){
   //cargamos los items al select proveedor
  
   $.ajax({
                url: "../ajax/Padron.php",
                type: "POST",
                data: 'op=selectInicio',
                success: function(res) {
                    var datos = JSON.parse(res);
                    
                    document.getElementById('idDpto').innerHTML=datos[1];
                    document.getElementById('idCiudad').innerHTML=datos[0];
                    document.getElementById('idEsc').innerHTML=datos[2];
                    document.getElementById('idMesa').innerHTML=datos[3];
                }
            });
}

var dp = document.getElementById('idDpto');
dp.onchange = function(p) {
    codigo = document.getElementById('idDpto').value;
    document.getElementById("idCiudad").disabled = true;
    document.getElementById("idEsc").disabled = true;
    document.getElementById("idMesa").disabled = true;
    $.ajax({
                url: "../ajax/Padron.php",
                type: "POST",
                data: 'op=selectDpto&dpto='+codigo,
                success: function(res) {
                    document.getElementById("idCiudad").disabled = false;
                    document.getElementById("idEsc").disabled = false;
                    document.getElementById("idMesa").disabled = false;        
                    var datos = JSON.parse(res);
                    document.getElementById('idCiudad').innerHTML=datos[0];
                    document.getElementById('idEsc').innerHTML=datos[1];
                    document.getElementById('idMesa').innerHTML=datos[2];
                }
            });

}

var ciu = document.getElementById('idCiudad');
ciu.onchange = function(p) {
    codigo = document.getElementById('idCiudad').value;
    codigo1 = document.getElementById('idDpto').value;
    document.getElementById("idEsc").disabled = true;
    document.getElementById("idMesa").disabled = true;
    $.ajax({
                url: "../ajax/Padron.php",
                type: "POST",
                data: 'op=selectCiudad&ciudad='+codigo+'&dpto='+codigo1,
                success: function(res) {
                    document.getElementById("idEsc").disabled = false;
                    document.getElementById("idMesa").disabled = false;
                    var datos = JSON.parse(res);
                    document.getElementById('idEsc').innerHTML=datos[0];
                    document.getElementById('idMesa').innerHTML=datos[1];
                }
            });

}
var esc = document.getElementById('idEsc');
esc.onchange = function(p) {
    codigo = document.getElementById('idEsc').value;
    cargarEsc(codigo);
}
function cargarEsc(cod){
    document.getElementById("idMesa").disabled = true;
    $.ajax({
                url: "../ajax/Padron.php",
                type: "POST",
                data: 'op=selectEsc&esc='+cod,
                success: function(res) {
                    document.getElementById("idMesa").disabled = false;
                    var datos = JSON.parse(res);
                        document.getElementById('idMesa').innerHTML=datos[1]; 
                    }
                    //Verificar();
                    
                    
                
            }); 

}*/
var mes = document.getElementById('mesaInput');
mes.onchange = function(p) {
    mesa=document.getElementById("mesaInput").value;
    if(mesa != 0){
        cargarTabla1();
    }
    Verificar();
}

function cargarTabla1(){
    mesa=document.getElementById("mesaInput").value;
    $('#example').DataTable({
        "destroy": true,
        "responsive": true,
        "processing": true,
        "ajax": {
        "url": "../ajax/Voto.php?op=traerVotantesPorMesa",
        "type": "POST",
        "data": {
            "mesa": mesa
        },
    },
        "columns":[
            {
            "render": function(data, type, full, meta) {
                // return data.nombreExtendido;
                let cedula = data.cedula;
                return '<button type="button" onclick="getEliminar(' + cedula + ');" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Eliminar Registro"><i class="fas fa-trash-alt"></i></button>';
                },
            "bSortable": false,
            "bSearchable": false,
            "data": null
            },
            {"data":"nombre"},
            {"data":"cedula"},
            {"data":"numero_socio"}
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
                
    }); 
}


function getEliminar(cedula) {

    
     document.getElementById("datoBorrar").value=cedula;
     //document.getElementById("tablaBorrar").value=2;
    
    $('#modalBorrar').modal('show');
}
$('#borrarOpcion').click(function(){
    codigo=document.getElementById("datoBorrar").value;
    $.ajax({
            url: "../ajax/Voto.php",
            type: "POST",
            data: 'op=borrar&datoBorrar='+codigo,
            success: function(res) {
            //document.getElementById("dirigenteMostrar").innerHTML='Puntero: '+res;
            cargarTabla1();
                    
                    

        }
    });
    
    $('#modalBorrar').modal('hide');
});

/*
var ord = document.getElementById('idOrden');
ord.oninput = function(idor) {

    Verificar();
}*/
function verifSiVoyCargarCedula(cedula){
        $.ajax({
                url: "../ajax/Voto.php",
                type: "POST",
                data: 'op=verificarGuardadoCedula&cedula='+cedula,
                success: function(res) {
                     var datos = JSON.parse(res);
                     if(datos[0] ==0 ){
                        texto1=datos[1]+' C.I. '+datos[2];
                        document.getElementById('aVotar').innerHTML=texto1;
                        document.getElementById('aVotar1').innerHTML='<strong class="btn-warning"> Aun no Voto</strong>';  
                        document.getElementById('socioInput').value=datos[3];
                     }else if(datos[0] < 0){
                        document.getElementById('aVotar').innerHTML='';
                        document.getElementById('aVotar1').innerHTML='<strong class="btn-warning"> No existe la cedula ingresada</strong>';  
                        document.getElementById('socioInput').value='';
                     }
                     else{
                        texto=datos[1]+' C.I. '+datos[2]+' Socio: '+datos[3]+' <strong class="btn-danger"> Ya voto </strong>';
                        document.getElementById('aVotar1').innerHTML='';
                        document.getElementById('aVotar').innerHTML=texto;
                        document.getElementById('socioInput').value=''; 
                     }
                       Verificar();  
                }
                     
            }); 

        
    
}
function verifSiVoyCargarSocio(socio){
        $.ajax({
                url: "../ajax/Voto.php",
                type: "POST",
                data: 'op=verificarGuardadoSocio&socio='+socio,
                success: function(res) {
                     var datos = JSON.parse(res);

                     if(datos[0] ==0 ){
                        texto1=datos[1]+' C.I. '+datos[2];
                        document.getElementById('aVotar').innerHTML=texto1;
                        document.getElementById('aVotar1').innerHTML='<strong class="btn-warning"> Aun no Voto</strong>';  
                        document.getElementById('cedulaInput').value=datos[2];
                     }else if(datos[0] < 0){
                        document.getElementById('aVotar').innerHTML='';
                        document.getElementById('aVotar1').innerHTML='<strong class="btn-warning"> No existe el Numero de socio Ingresado</strong>';  
                        document.getElementById('cedulaInput').value='';
                     }
                     else{
                        texto=datos[1]+' C.I. '+datos[2]+' Socio: '+datos[3]+' <strong class="btn-danger"> Ya voto </strong>';
                        document.getElementById('aVotar1').innerHTML='';
                        document.getElementById('aVotar').innerHTML=texto; 
                        document.getElementById('cedulaInput').value='';
                        document.getElementById('cedulaInput').value=datos[2];
                        document.getElementById('cedulaInput').value='';
                     }
                        Verificar(); 
                }
                     
            }); 

        
    
}

function Verificar(){
    cedula= document.getElementById('cedulaInput').value;
    mesa= document.getElementById('mesaInput').value;
    if(mesa > 0 & cedula > 0){
            document.getElementById('voto1').disabled=false;
    }else{
        document.getElementById('voto1').disabled=true;

    }

}
$('#voto1').click(function(){
    mesa = document.getElementById('mesaInput').value;
    cedula=document.getElementById('cedulaInput').value;
        $.ajax({
                url: "../ajax/Voto.php",
                type: "POST",
                data: 'op=guardarCedula&mesa='+mesa+'&cedula='+cedula,
                success: function(res) {
                    cargarTabla1();
                    if(res == 1){
                        document.getElementById('aVotar1').innerHTML='<strong class="btn-success"> Votacion Exitosa</strong>';
                    }
                }
            });
    
   
});