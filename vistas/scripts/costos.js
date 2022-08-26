var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   })
    //cargamos las Cuentas
   $.post("../ajax/planCuentas.php?op=selectCuenta", function(r){
   	$("#idcuenta").html(r);
   	$("#idcuenta").selectpicker('refresh');
   });
    
   
   $("#imagenmuestra").hide();
}

//funcion limpiar
function limpiar(){
	$("#nombre").val("");
	$("#descripcion").val("");
	//$("#stock").val("");
	$("#imagenmuestra").attr("src","");
	$("#print").hide();
	$("#idarticulo").val("");
}

//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}
//funcion mostrar formulario
function agregar(id,descripcion,monto){
	$("#descC").html(descripcion);
	$("#montoC").html(monto);
	$("#codas").val(id);
}
//funcion mostrar formulario
function asignar(id){
	codCosto=$("#codas").val();
	$.ajax({
     	url: "../ajax/costos.php?op=asignar",
     	type: "POST",
     	data: {codCosto : codCosto,codUs : id},
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		bootbox.alert(datos);
     	}
     });
}

//cancelar form

function cancelarform(){
	limpiar();
	mostrarform(false);
}
//funcion listar
function listar(){
	tabla=$('#tbllistado').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdf'
		],
		"ajax":
		{
			url:'../ajax/costos.php?op=listar',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":13,//paginacion
		"order":[[0,"id"]]//ordenar (columna, orden)
	}).DataTable();


	/*****Se cargan todos los usuarios de la Junta******/
	tabla=$('#tbllistado1').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdf'
		],
		"ajax":
		{
			url:'../ajax/cliente.php?op=listarAsig',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":5,//paginacion
		"order":[[0,"id"]]//ordenar (columna, orden)
	}).DataTable();
}
//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/costos.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		tabla.ajax.reload();
     		bootbox.alert(datos);
     		mostrarform(false);
     		
     	}
     });

     limpiar();
}

function mostrar(idarticulo){
	$.post("../ajax/costos.php?op=mostrar",{idarticulo : idarticulo},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);
			$("#descripcion").val(data.descripcion);
			$("#idarticulo").val(data.id);
			$("#monto").val(data.monto);
			$("#idcuenta").val(data.id_cuenta);
			$("#idcuenta").selectpicker('refresh');
		})	
}


//funcion para desactivar
function desactivar(idarticulo){
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			$.post("../ajax/costos.php?op=desactivar", {idarticulo : idarticulo}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}
//funcion para activar
function activar(idarticulo){
	bootbox.confirm("¿Esta seguro de activar este dato?", function(result){
		if (result) {
			$.post("../ajax/costos.php?op=activar", {idarticulo : idarticulo}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}


function generarbarcode(){
	

}

function imprimir(){
	$("#print").printArea();
}

init();