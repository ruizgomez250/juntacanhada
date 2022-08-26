var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   });
   $("#formulario2").on("submit",function(e){
   	modif(e);
   });
   $("#formulario1").on("submit",function(e){
   	guardarMedidor(e);
   });
   //cargamos los items al celect categoria
   $.post("../ajax/cliente.php?op=selectCategoria", function(r){
   	$("#idcategoria").html(r);
   	$("#idcategoria").selectpicker('refresh');
   });
   //cargamos los items al celect categoria
   $.post("../ajax/cliente.php?op=selectZona", function(r){
   	$("#idzona").html(r);
   	$("#idzona").selectpicker('refresh');
   });
   //cargamos los items al celect categoria
   $.post("../ajax/cliente.php?op=selectSituacion", function(r){
   	$("#idsituacion").html(r);
   	$("#idsituacion").selectpicker('refresh');
   	
   });
}

//funcion limpiar
function limpiar(){
	$("#obs").val("");
	$("#nombre").val("");
	$("#apellido").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#idpersona").val("");
}
function agregarnuevo(){
	$("#idsituacion").prop("disabled",true);
	$("#idsituacion").selectpicker('refresh');
	mostrarform(true);
}
//funcion mostrar formulario 
function mostrarform(flag){
	limpiar();
	if(flag){
		$("#idsituacion").val(2);
   		$("#idsituacion").selectpicker('refresh');


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
			url:'../ajax/cliente.php?op=listarc',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":14,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}

function asignarMedidor(idCli){
	document.getElementById("idusuario").value=idCli;
	$.post("../ajax/cliente.php?op=mostrarDatos",{idCliente : idCli},
		function(data,status)
		{
			data=JSON.parse(data);
			document.getElementById("nombUs").innerHTML=data.nombre;
			document.getElementById("cuentaP").innerHTML=data.id;
			document.getElementById("codP").innerHTML=data.num_documento;
			document.getElementById("zon").innerHTML=data.zona;
			document.getElementById("cat").innerHTML=data.categoria;
			
			traerUltimoCiclo(id);
		});
}
function cambiarMedidor(idCli){
	document.getElementById("idusuario1").value=idCli;
	$.post("../ajax/cliente.php?op=mostrarDatos",{idCliente : idCli},
		function(data,status)
		{
			data=JSON.parse(data);
			document.getElementById("nombUs1").innerHTML=data.nombre;
			document.getElementById("cuentaP1").innerHTML=data.id;
			document.getElementById("codP1").innerHTML=data.num_documento;
			document.getElementById("zon1").innerHTML=data.zona;
			document.getElementById("cat1").innerHTML=data.categoria;
			
			traerUltimoCiclo(id);
		});
}
//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/cliente.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		bootbox.alert(datos);
     		mostrarform(false);
     		tabla.ajax.reload();
     	}
     });

     limpiar();
}
//funcion para guardaryeditar
function guardarMedidor(e){
     e.preventDefault();//no se activara la accion predeterminada 
     var formData=new FormData($("#formulario1")[0]);
     $.ajax({
     	url: "../ajax/cliente.php?op=guardarMedid",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		bootbox.alert(datos);
     		tabla.ajax.reload();
     		//mostrarform(false);
     	}
     });

     limpiar();
}
function modif(e){
     e.preventDefault();//no se activara la accion predeterminada 
     var formData=new FormData($("#formulario2")[0]);
     $.ajax({
     	url: "../ajax/cliente.php?op=cambiarMedid",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		$('#myModal1').modal('hide');
     		bootbox.alert(datos);
     		tabla.ajax.reload();
     		//mostrarform(false);
     	}
     });
}

function mostrar(idpersona){
	$.post("../ajax/cliente.php?op=mostrar",{idpersona : idpersona},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);
   			$("#idpersona").val(data.idpersona);
			$("#nombre").val(data.nombre);
			$("#apellido").val(data.apellido);
			$("#tipo_documento").val(data.tipo_documento);
			$("#tipo_documento").selectpicker('refresh');
			$("#num_documento").val(data.num_documento);
			$("#direccion").val(data.direccion);
			$("#telefono").val(data.telefono);
			$("#email").val(data.email);
			$("#idzona").val(data.id_zona);
			$("#idzona").selectpicker('refresh');
			$("#idsituacion").val(data.id_situacion);
			$("#idsituacion").selectpicker('refresh');
			$("#obs").val(data.obs);
			$("#idcategoria").val(data.id_categoria);
			$("#idcategoria").selectpicker('refresh');
		})
	$.post("../ajax/cliente.php?op=verificarSituacion",{idpersona : idpersona},
		function(data,status)
		{
			//alert(data);
   			if(data == 1){
   				$("#idsituacion").prop("disabled",false);
   				$("#idsituacion").selectpicker('refresh');
   				
   			}else{
   				$("#idsituacion").prop("disabled",true);
   				$("#idsituacion").selectpicker('refresh');
   			}
		})
}


//funcion para desactivar
function eliminar(idpersona){
	bootbox.confirm("¿Esta seguro de eliminar este dato?", function(result){
		if (result) {

			$.post("../ajax/cliente.php?op=eliminar", {idpersona : idpersona }, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}


init();