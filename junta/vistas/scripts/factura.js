/*
$('#guardar').click(function(){
        fecha = 'fecha='+document.getElementById('fechaFiltro').value;
                 
    })
*/
datoBorrar='';
cargarTabla1();
function cargarTabla1(){
    $('#example').DataTable({
        "order": [[ 1, "desc" ]],
        "destroy": true,
        "responsive": true,
        "processing": true,
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
emision=true;
vencimiento=true;
if(document.getElementById('fechaVerif').value != 0){
            if(document.getElementById('fechaVerif').value >= document.getElementById('fechaEmision').value){
                emision=false;
                vencimiento=false;
                document.getElementById('emisionMensaje').style.display = 'block';
            }
            else{
                emision=true;
                vencimiento=true;
            }
            Verificar();
}
var fechEm= document.getElementById('fechaEmision');
fechEm.onchange = function(feEm) {
    if(document.getElementById('fechaVerif').value > document.getElementById('fechaEmision').value){
        emision=false;
        document.getElementById('emisionMensaje').style.display = 'block';
    }
    else{
        document.getElementById('emisionMensaje').style.display = 'none';
        emision=true;
    }
    verifVencimiento();


}
var fechVen= document.getElementById('fechaVencimiento');
fechVen.onchange = function(feVe) {
    verifVencimiento();


}
function verifVencimiento(){
    if(document.getElementById('fechaVencimiento').value < document.getElementById('fechaEmision').value){
        vencimiento=false;
        document.getElementById('vencimientoMensaje').style.display = 'block';
    }
    else{
        document.getElementById('vencimientoMensaje').style.display = 'none';
        vencimiento=true;
    }
    Verificar();

}
 function Verificar(){
    
    if(emision && vencimiento){
        document.getElementById("guardar").disabled = false;
        document.getElementById("guardar").focus();
    }else{
        document.getElementById("guardar").disabled = true;
    }
 }


 $(document).on("click",".ieditar",function(){

    fecha =$(this).attr("name");

    var win = window.open('../reportes/facturas.php?fecha='+fecha, '_blank');
        // Cambiar el foco al nuevo tab (punto opcional)
        win.focus()
})
 $(document).on("click",".borrar",function(){

    datoBorrar =$(this).attr("name");
    $('#modalBorrar').modal('show');
})


$('#borrAsunt').click(function() {
    $('#modalBorrar').modal('hide'); 
    $.ajax({
                url: "../php/factura.php?op=borrar",
                type: "POST",
                data: "fecha="+datoBorrar,
                success: function(res){
                    
                     location.reload();
                    /*parametro='medidor='+res;
                    cargarTablaModal(parametro);
                    $('#modalTomaMedida').modal('show');*/
                                       
                }
            });

})
/*
$('#botBuscador1').click(function() {    nombreBusc=document.getElementById("nombreBuscar").value;
            cedulaBuscar = document.getElementById("cedulaBuscar").value;
            nombreBuscar = document.getElementById('nombreBuscar').value;
            apBuscar = document.getElementById("apellidoBuscar").value;
            parametro = '';
            if(cedulaBuscar.length != 0){
                parametro = 'cedula='+cedulaBuscar;
                    
            }else if (nombreBuscar.length != 0){
                if(apBuscar.length != 0){
                    parametro = 'nombre='+nombreBuscar+'&apellido='+apBuscar;
                }else{
                    parametro = 'nombre='+nombreBuscar;
                }
                
            }else{
                parametro = 'apellido='+apBuscar;
            }





  // if(cedulaBusc.length > 0 || nombreBusc.length > 0 || apBusc.length > 0){
    
        buscarUsuarioTabla(parametro);
   //}
    $('#modalUsuario').modal('show');

})


$(document).on("click",".ieditar1",function(){

    categoriaId =$(this).attr("name");
    parametro='id='+categoriaId;
    cargaDatosUsuario(parametro);

})
function cargaDatosUsuario(parametro){
    $.ajax({
        url: "../ajax/addModifGastosPorCliente.php?op=traeDatosUsuario",
        type: "POST",
        data: parametro,
        success: function(res) {
            if(res ==0){
                document.getElementById('codUsuario').value='';
                document.getElementById('nombre').value='';
                document.getElementById('cedula').value='';
            }else{
                var datos = JSON.parse(res);
                document.getElementById('codUsuario').value=datos[0];
                document.getElementById('nombre').value=datos[1];
                document.getElementById('cedula').value=datos[2];
                $('#modalUsuario').modal('hide');
            }
        }
    });
}
var codUsuar= document.getElementById('codUsuario');
codUsuar.onchange = function(codUs) {
    id = document.getElementById('codUsuario').value;
    if(id.length > 0){
        parametro='id='+id;
        cargaDatosUsuario(parametro);
    }


}

function buscarUsuarioTabla(parametro){
    tablaDominio='tabla_usuario';
    $.ajax({
        url: "../ajax/addModifGastosPorCliente.php?op=buscarUsuarioTabla",
        type: "POST",
        data: parametro,
        success: function(res) {
            var datos = JSON.parse(res);
            var elmtTable = document.getElementById(tablaDominio);
            var tableRows = elmtTable.getElementsByTagName("tr");
            var rowCount = tableRows.length;
            for (var x = rowCount - 1; x > 0; x--) {
                document.getElementById(tablaDominio).deleteRow(x);
            }
            for (var y = datos[0]; y > 0; y--) {
                document.getElementById(tablaDominio).insertRow(1).innerHTML = datos[y];
            }
        }
    });
}



/*        porcentajeVerif=false;
        descCostoFijoVerificar=false;
        costoGuaraniesVerificar=false;
        porcCostoAguaVerif=false;
        costoPorcentajeVerificar=false;
    
        
        
       
        if(document.getElementById('modificarVerif').value != 0){
            if(document.getElementById('modificarVerif').value == 1){
                porcentajeVerif=true;
            }
            
            descCostoFijoVerificar=true;
            costoGuaraniesVerificar=true;
            porcCostoAguaVerif=true;
            costoPorcentajeVerificar=true;
        }
	
var costoPorc= document.getElementById('porcentajeCosto');
costoPorc.onchange = function(costoP) {
    desc = document.getElementById('porcentajeCosto').value;
    if(desc.length > 0){
        costoPorcentajeVerificar=true;
    }else{
        costoPorcentajeVerificar=false;
    }
    Verificar();


}

var costoGuar= document.getElementById('costoGuaranies');
costoGuar.onchange = function(costoG) {
    desc = document.getElementById('costoGuaranies').value;
    if(desc.length > 0){
        costoGuaraniesVerificar=true;
    }else{
        costoGuaraniesVerificar=false;
    }
    Verificar();


}
var descripcion = document.getElementById('descCostoFijo');
descripcion.onchange = function(descCFijo) {
    desc = document.getElementById('descCostoFijo').value;
    if(desc.length > 0){
        descCostoFijoVerificar=true;
    }else{
        descCostoFijoVerificar=false;
    }
    Verificar();


}
	$('#limpiar').click(function(){
			location.reload(); 
		})

    $('#esPorcentaje').change(function() {
    if(porcentajeVerif){
        porcentajeVerif=false;
    }else{
        porcentajeVerif=true;
    }
    document.getElementById('costoGuaranies').value = '';
    document.getElementById('porcentajeCosto').value = '';
    if(porcentajeVerif){
        document.getElementById('costoGuaranies').disabled = true;
        document.getElementById('porcentajeCosto').disabled = false;
    }else{
        document.getElementById('costoGuaranies').disabled = false;
        document.getElementById('porcentajeCosto').disabled = true;
        
    }
    costoGuaraniesVerificar=false;
    costoPorcentajeVerificar=false;
    Verificar();

});
	$('#botBusc').click(function(){
            codigoBuscar = document.getElementById('codBuscar').value;
            cedulaBuscar = document.getElementById('cedBuscar').value;
            nombreBuscar = document.getElementById('nomBuscar').value;
            apBuscar = document.getElementById('apBuscar').value;
			parametro = '';
			if (codigoBuscar.length != 0){
				parametro = 'codigo='+codigoBuscar;
			}else if(cedulaBuscar.length != 0){
				parametro = 'cedula='+cedulaBuscar;
					
			}else if (nombreBuscar.length != 0){
                if(apBuscar.length != 0){
                    parametro = 'nombre='+nombreBuscar+'&apellido='+apBuscar;
                }else{
                    parametro = 'nombre='+nombreBuscar;
                }
                
            }else{
                parametro = 'apellido='+apBuscar;
            }
            cargarTabla(parametro); 
		})
$(document).on("click", ".elegirCategoria", function() {
    var cod = $(this).attr("name");
        
    categoriaVerif=cargaCategoria(cod);
    Verificar();   
    $('#modalCategoria').modal('hide');

})
$(document).on("click", ".elegirMedidor", function() {
    var cod = $(this).attr("name");
        
    medidorVerif=cargaMedidor(cod);
    Verificar();   
    $('#modalMedidor').modal('hide');

})
$(document).on("click", ".elegir1", function() {
    var cod = $(this).attr("name");
    sectorVerif=cargaSector(cod);
    Verificar();
    $('#modalSector').modal('hide');

})
$(document).on("click", ".borrar1", function() {
    var id = $(this).attr("name");
    borrarOpcion(id);
    cargarModalSector();
    $('#modalSector').modal('show');

})
$(document).on("click", ".borrarCategoria", function() {
    var id = $(this).attr("name");
    borrarCategoria(id);
    cargarModalCategoria();
    $('#modalCategoria').modal('show');

})
$(document).on("click", ".borrarMedidor", function() {
    var id = $(this).attr("name");
    borrarMedidor(id);
    cargarModalMedidor();
    $('#modalMedidor').modal('show');

})
function borrarMedidor(id){

     $.ajax({
        url: "../ajax/Medidor.php",
        type: "POST",
        data: "op=borrar&id=" + id,
        success: function(res) {
            
        }
    });
}
function borrarCategoria(id){
     $.ajax({
        url: "../ajax/Categoria.php",
        type: "POST",
        data: "op=borrar&id=" + id,
        success: function(res) {
            
        }
    });
}
function borrarOpcion(id){
     $.ajax({
        url: "../ajax/opcion.php",
        type: "POST",
        data: "op=borrar&id=" + id,
        success: function(res) {
            
        }
    });
}

var descripcion = document.getElementById('descCategoria');
descripcion.onchange = function(p) {
    codigo = document.getElementById('descCategoria').value;
    if(codigo.length > 0){
        descCategoriaVerif=true;
    }else{
        descCategoriaVerif=false;
    }
    Verificar();


}


        
        
var costoConsumoMinimo = document.getElementById('costoConsumoMinimo');
costoConsumoMinimo.onchange = function(p) {
    codigo = document.getElementById('costoConsumoMinimo').value;
    if(codigo.length > 0){
        costoConsumoMinimoVerif=true;
    }else{
        costoConsumoMinimoVerif=false;
    }
    Verificar();


}

        
var litrosConsumoMinimo = document.getElementById('litrosConsumoMinimo');
litrosConsumoMinimo.onchange = function(p) {
    codigo = document.getElementById('litrosConsumoMinimo').value;
    if(codigo.length > 0){
        litrosConsumoMinimoVerif=true;
    }else{
        litrosConsumoMinimoVerif=false;
    }
    Verificar();


}
function cargaMedidor(codigo) {
    existe=true;
    $.ajax({
        url: "../ajax/Medidor.php",
        type: "POST",
        data: "op=buscarOpcion&codigo=" + codigo,
        success: function(res) {
            if (!res) {
                    document.getElementById('medidorCod').value = '';
                    existe=false;
            } else {
                var datos = JSON.parse(res);
                 document.getElementById('medidorCod').value = datos[2];
                 
            }
        }
    });
    return existe;
}
function cargaCategoria(codigo) {
    existe=true;
    $.ajax({
        url: "../ajax/Categoria.php",
        type: "POST",
        data: "op=buscarOpcion&codigo=" + codigo,
        success: function(res) {
            if (!res) {
                    document.getElementById('categoria').value = '';
                    document.getElementById('categoriaDesc').value = '';
                    existe=false;
            } else {
                var datos = JSON.parse(res);
                 document.getElementById('categoria').value = datos[0];
                 document.getElementById('categoriaDesc').value = datos[1];
                 
            }
        }
    });
    return existe;
}

function cargaSector(codigo) {
    return(cargaOpcion(codigo,'sector','sectorDesc'));
}
function cargaOpcion(codigo,codCampo,descCampo){
    existe=true;
    $.ajax({
        url: "../ajax/opcion.php",
        type: "POST",
        data: "op=buscarOpcion&codigo=" + codigo,
        success: function(res) {
            if (!res) {
                    document.getElementById(codCampo).value = '';
                    document.getElementById(descCampo).value = '';
                    existe=false;
            } else {
                var datos = JSON.parse(res);
                 document.getElementById(codCampo).value = datos[0];
                 document.getElementById(descCampo).value = datos[1];
                 
            }
        }
    });
    return existe;
}


var costoLitrosPorExceso = document.getElementById('costoLitrosPorExceso');
costoLitrosPorExceso.onchange = function(k) {
    codigo = document.getElementById('costoLitrosPorExceso').value;
    if(codigo.length > 0){
        costoLitrosPorExcesoVerif=true;
    }else{
        costoLitrosPorExcesoVerif=false;
    }
    Verificar();
}




$('#botTipo').click(function() {
	cargarModalCategoria();
	 $('#modalCategoria').modal('show');
	 

})
$('#agregarMedidor').click(function() {
    descripcion = document.getElementById("descripcionMedidor").value;
    if(descripcion.length > 0){
        $.ajax({
                url: "../ajax/Medidor.php",
                type: "POST",
                data: 'op=guardar&descrip='+descripcion,
                success: function(res) {
                    alert(res);
                    if(res == 0){
                        document.getElementById('medidormensaje').style.display = 'block';
                    }
                    else{
                        document.getElementById('medidormensaje').style.display = 'none';
                        cargarModalMedidor()
                        $('#modalMedidor').modal('show');
                    }
                    
                }
            }); 
    }

})
$('#agregar1').click(function() {
    descripcion = document.getElementById("descripcionCategoria").value;
    monto = document.getElementById("montoCategoria").value;
    if(descripcion.length > 0 && monto.length > 0){
        $.ajax({
                url: "../ajax/Categoria.php",
                type: "POST",
                data: 'op=guardar&descrip='+descripcion+'&monto='+monto,
                success: function(res) {

                    cargarModalCategoria()
                     $('#modalCategoria').modal('show');
                }
            }); 
    }

})
$('#agregar2').click(function() {
    descripcion = document.getElementById("descripcionSector").value;
    if(descripcion.length > 0){
        $.ajax({
                url: "../ajax/opcion.php",
                type: "POST",
                data: 'op=guardar&descrip='+descripcion+'&dominio=1',
                success: function(res) {
                    cargarModalSector()
                     $('#modalSector').modal('show');
                }
            }); 
    }
})
$('#botSector').click(function() {
	cargarModalSector();
	 $('#modalSector').modal('show');
	 

})
$('#botMedidor').click(function() {
    cargarModalMedidor();
     $('#modalMedidor').modal('show');
     

})
function cargarModalMedidor(){
    parametros='op=BuscarOpcionTabla';
    $tablaDominio='tabla_medidor';
    $.ajax({
                url: "../ajax/Medidor.php",
                type: "POST",
                data: parametros,
                success: function(res) {
                    var datos = JSON.parse(res);

                    var elmtTable = document.getElementById($tablaDominio);
                    var tableRows = elmtTable.getElementsByTagName("tr");
                    var rowCount = tableRows.length;
                    for (var x = rowCount - 1; x > 0; x--) {
                        document.getElementById($tablaDominio).deleteRow(x);
                    }
                    for (var y = datos[0]; y > 0; y--) {
                        document.getElementById($tablaDominio).insertRow(1).innerHTML = datos[y];
                    }
                }
            });

}
function cargarModalCategoria(){
    parametros='op=BuscarOpcionTabla';
    $tablaDominio='tabla_categoria';
    $.ajax({
                url: "../ajax/Categoria.php",
                type: "POST",
                data: parametros,
                success: function(res) {

                    var datos = JSON.parse(res);

                    var elmtTable = document.getElementById($tablaDominio);
                    var tableRows = elmtTable.getElementsByTagName("tr");
                    var rowCount = tableRows.length;
                    for (var x = rowCount - 1; x > 0; x--) {
                        document.getElementById($tablaDominio).deleteRow(x);
                    }
                    for (var y = datos[0]; y > 0; y--) {
                        document.getElementById($tablaDominio).insertRow(1).innerHTML = datos[y];
                    }
                }
            });

}
function cargarModalSector(){
	cargarModalOpcion(1,'tabla_sector');

}
function cargarModalOpcion($dominio,$tablaNombre){
    $tablaDominio=$tablaNombre;
    parametros='codigo='+$dominio+'&op=BuscarOpcionTabla';
    $.ajax({
                url: "../ajax/Opcion.php",
                type: "POST",
                data: parametros,
                success: function(res) {
                    var datos = JSON.parse(res);

                    var elmtTable = document.getElementById($tablaDominio);
                    var tableRows = elmtTable.getElementsByTagName("tr");
                    var rowCount = tableRows.length;
                    for (var x = rowCount - 1; x > 0; x--) {
                        document.getElementById($tablaDominio).deleteRow(x);
                    }
                    for (var y = datos[0]; y > 0; y--) {
                        document.getElementById($tablaDominio).insertRow(1).innerHTML = datos[y];
                    }
                }
            });

}
 function cargarTabla(parametro){
 		$.ajax({
				url: "../php/cliente.php?op=buscarClienteTabla",
				type: "POST",
				data: parametro,
				success: function(res){
					var datos = JSON.parse(res);
					var elmtTable = document.getElementById("tabla");
							var tableRows = elmtTable.getElementsByTagName("tr");
							var rowCount = tableRows.length;
							for (var x=rowCount-1; x>0; x--) {
								document.getElementById("tabla").deleteRow(x);
							}
							for (var y=datos[0]; y>0; y--) {
									document.getElementById("tabla").insertRow(1).innerHTML = datos[y];
							}					
				}
			});
 		
 }
 */
