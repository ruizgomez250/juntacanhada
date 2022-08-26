
        descCategoriaVerif=false;
        
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
            descCategoriaVerif=true;
        }
	
	$('#limpiar').click(function(){
			location.reload(); 
		})
/*	$('#botBusc').click(function(){
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
*/
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


}/*
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
}*/
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
 function Verificar(){
    if(descCategoriaVerif ){
        document.getElementById("guardar").disabled = false;
        document.getElementById("guardar").focus();
    }else{
        document.getElementById("guardar").disabled = true;
    }
    
 }