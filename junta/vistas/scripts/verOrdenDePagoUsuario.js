        modalVerifLectura=false;
        modalVerifFecha=true;
        cedulaVerif=false;
        nombresVerif=false;
        apellidosVerif=false;
        sectorVerif=false;
        medidorVerif=false;
        categoriaVerif=false;
        direccionVerif=false;
cargarTabla1();
function cargarTabla1(){
    $('#example').DataTable({
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
        
       
        if(document.getElementById('modificarVerif').value != 0){
            cedulaVerif=true;
            nombresVerif=true;
            apellidosVerif=true;
            sectorVerif=true;
            categoriaVerif=true;
            direccionVerif=true;
            medidorVerif=true;
        }
	$(document).on("click",".selecc",function(){
                idFactura =$(this).attr("name");
                var win = window.open('../reportes/facturaCliente.php?idFactura='+idFactura, '_blank');
                win.focus();
                
        })
    $(document).on("click",".ieditar",function(){
                idEnviado =$(this).attr("name");
                parametro='idCliente='+idEnviado;
                cargarTablaModal(parametro);
                $('#modalTomaMedida').modal('show');

                
        })
   function cargarTablaModal(parametro){
        $.ajax({
                url: "../ajax/verOrdenDePago.php?op=facturasPorFechaCliente&idCliente=",
                type: "POST",
                data: parametro,
                success: function(res){

                    var datos = JSON.parse(res);
                    document.getElementById("tablaModBody").innerHTML=datos;                
                }
            });
        
 }
	$('#limpiar').click(function(){
			location.reload();
		})
	$('#botBusc').click(function(){
            
            codigoBuscar = document.getElementById('medidorBuscar').value;
            cedulaBuscar = document.getElementById('cedBuscar').value;
            nombreBuscar = document.getElementById('nomBuscar').value;
            apBuscar = document.getElementById('apBuscar').value;
			parametro = '';
			if (codigoBuscar.length != 0){
				parametro = 'medidor='+codigoBuscar;
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
$('#guardarMedida').click(function() {
    fecha=document.getElementById('fechaLectura').value;
    lectura=document.getElementById('lectura').value;
    medidor=document.getElementById('medidorModal').value;
    $.ajax({
        url: "../ajax/TomaMedida.php",
        type: "POST",
        data: "op=guardar&fecha="+fecha+"&lectura="+lectura+"&medidor="+medidor,
        success: function(res) {
                document.getElementById('lectura').value='';
                cargarTablaModal(parametro);
                $('#modalTomaMedida').modal('show');
        }
    });

})
var lectura1 = document.getElementById('lectura');
lectura1.onchange = function(p) {
    codigo = document.getElementById('lectura').value;
    medidor=document.getElementById('medidorModal').value;
    if(codigo.length > 0){
        verificarLectura(codigo,medidor);
        verifFech();
    }else{
        modalVerifLectura=false;
        //document.getElementById('medidorCod').value='';
    }


}
var fechLectura1 = document.getElementById('fechaLectura');
fechLectura1.onchange = function(p) {
    verifFech();
}
function verifFech(){
    codigo = document.getElementById('fechaLectura').value;
    medidor=document.getElementById('medidorModal').value;
    if(codigo.length > 0){
        verificarFecha(codigo,medidor);
    }else{
        modalVeriFecha=false;
    }
}
function verificarFecha(fecha,medidor){

     $.ajax({
        url: "../ajax/verOrdenDePago.php",
        type: "POST",
        data: "op=verificarFecha&fecha="+fecha+"&medidor="+medidor,
        success: function(res) {
            if(res==0){
                document.getElementById('mensajeFecha').style.display='block';
                
                modalVerifFecha=false;
            }else{
                document.getElementById('mensajeFecha').style.display='none';
                modalVerifFecha=true;
            }
            Verificar1();
        }
    });
}
function verificarLectura(lectura,medidor){

     $.ajax({
        url: "../ajax/verOrdenDePago.php",
        type: "POST",
        data: "op=verificarLectura&lectura="+lectura+"&medidor="+medidor,
        success: function(res) {
            if(res==0){
                document.getElementById('mensajeMedidor').style.display='block';
                modalVerifLectura=false;
            }else{
                document.getElementById('mensajeMedidor').style.display='none';
                modalVerifLectura=true;

            }
            Verificar1();
        }
    });
}
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

var medidor1 = document.getElementById('medidorCod');
medidor1.onchange = function(p) {
    codigo = document.getElementById('medidorCod').value;
    if(codigo.length > 0){
        medidorVerif=cargaMedidor(codigo);
    }else{
        medidorVerif=false;
        document.getElementById('medidorCod').value='';
    }
    Verificar();


}



var categoria1 = document.getElementById('categoria');
categoria1.onchange = function(p) {
    codigo = document.getElementById('categoria').value;
    if(codigo.length > 0){
        categoriaVerif=cargaCategoria(codigo);
    }else{
        categoriaVerif=false;
        document.getElementById('categoria').value='';
        document.getElementById('categoriaDesc').value='';
    }
    Verificar();


}
var sector1 = document.getElementById('sector');
sector1.onchange = function(p) {
    codigo = document.getElementById('sector').value;
    if(codigo.length > 0){
        sectorVerif=cargaSector(codigo);
    }else{
        sectorVerif=false;
        document.getElementById('sector').value='';
        document.getElementById('sectorDesc').value='';
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


var cedula1 = document.getElementById('cedula1');
cedula1.onchange = function(k) {
    codigo = document.getElementById('cedula1').value;
    if(codigo.length > 0){
        cedulaVerif=true;
    }else{
        cedulaVerif=false;
    }
    Verificar();
}
var nombre1 = document.getElementById('nombre1');
nombre1.onchange = function(k) {
    codigo = document.getElementById('nombre1').value;
    if(codigo.length > 0){
        nombresVerif=true;
    }else{
        nombresVerif=false;
    }
    Verificar();
}
var apellido1 = document.getElementById('apellido1');
apellido1.onchange = function(k) {
    codigo = document.getElementById('apellido1').value;
    if(codigo.length > 0){
        apellidosVerif=true;
    }else{
        apellidosVerif=false;
    }
    Verificar();
}
var direccion = document.getElementById('direccion');
direccion.onchange = function(k) {
    codigo = document.getElementById('direccion').value;
    if(codigo.length > 0){
        direccionVerif=true;
    }else{
        direccionVerif=false;
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
				url: "../php/cliente.php?op=buscarClienteTabla&ver=1",
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





 function Verificar(){
    if(sectorVerif && categoriaVerif && nombresVerif && apellidosVerif && cedulaVerif && direccionVerif && medidorVerif){
        document.getElementById("guardar").disabled = false;
        document.getElementById("guardar").focus();
    }else{
        document.getElementById("guardar").disabled = true;
    }
    
 }
 function Verificar1(){
    if(modalVerifLectura && modalVerifFecha){
        document.getElementById("guardarMedida").disabled = false;
        document.getElementById("guardarMedida").focus();
    }else{
        document.getElementById("guardarMedida").disabled = true;
    }
    
 }





