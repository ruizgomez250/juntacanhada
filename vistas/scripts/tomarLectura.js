var tabla,ultimalectura,ultimafecha,ind;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);

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

	$("#lectura").val("");
	
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
function cargarLecturas(){
	$.post("../ajax/tomarLectura.php?op=cargarLecturas",
		function(data,status)
		{
			bootbox.alert(data);
			listar();
		});
}
function traerDatos(id,i){
	ind=i;
	document.getElementById("hidr").value=id;
	$.post("../ajax/tomarLectura.php?op=mostrarDatos",{idHidro : id},
		function(data,status)
		{
			data=JSON.parse(data);
			document.getElementById("nombUs").innerHTML=data.nombre+' '+data.apellido;
			document.getElementById("cuentaP").innerHTML=data.idCliente;
			document.getElementById("codP").innerHTML=data.num_documento;
			document.getElementById("zon").innerHTML=data.zona;
			document.getElementById("med").innerHTML=data.medidor;
			traerUltimoCiclo(id);
		});
	traerLecturasUsuario(id);
}
function traerLecturasUsuario(idUsu){
	tabla=$('#tablaMedida').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		"bPaginate": false, 
		"bInfo": false, 
		"bFilter": false, 
		"bAutoWidth": false, 
		"aoColumns" : [ 
			{ sWidth: '40px' }, 
			{ sWidth: '20px' }, 
			{ sWidth: '30px' },
			{ sWidth: '20px' } 
			],

		buttons: [

		],
		"ajax":
		{
			url:'../ajax/tomarLectura.php?op=listarLecturas&idusu='+idUsu,
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":5,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}

function traerUltimoCiclo(id){
	$.post("../ajax/tomarLectura.php?op=ultimoCiclo",{idHidro : id},
		function(data,status)
		{
			
			if(data === 'null'){
				ultimalectura=0;
				ultimafecha='01/01/1000'
				document.getElementById("mesperiodo").value=0;
				document.getElementById("anhoperiodo").value=0;
				//document.getElementById("mesperiodo").removeAttribute("readonly");
				//document.getElementById("anhoperiodo").removeAttribute("readonly");
			}else{
			
				data=JSON.parse(data);
				ultimalectura=data.lectura;
				ultimafecha=data.fecha_lectura;
				mesciclo=(data.mesciclo*1)+1;
				anhociclo=data.anhociclo;
				if(mesciclo > 12){
					mesciclo=1;
					anhociclo=(anhociclo*1)+1
				}
				document.getElementById("mesperiodo").value=mesciclo;
				document.getElementById("anhoperiodo").value=anhociclo;
			}
			
		});
}
function verifilec(){
	lecAct=document.getElementById("lectura").value;
	ultimalecturaN=parseInt(ultimalectura);
	if(lecAct < ultimalecturaN){
		document.getElementById('mensajeLectura').innerHTML='La lectura no puede ser inferior a '+ultimalectura;
		document.getElementById('mensajeLectura').style.display='block';
		lect=false;
	}else{
		document.getElementById('mensajeLectura').style.display='none';
		lect=true;
	}
	verificarGuardar();
}
function verififech(){
	if(document.getElementById("fechaLectura").value < ultimafecha){
		document.getElementById('mensajeFecha').innerHTML='La fecha no puede ser inferior a '+ultimafecha;
		document.getElementById('mensajeFecha').style.display='block';
	}else{
		document.getElementById('mensajeFecha').style.display='none';
	}
	verificarGuardar();
}
function verificarGuardar(){
	fe=document.getElementById("fechaLectura").value;
	lec=document.getElementById("lectura").value;
	if(fe >= ultimafecha ){
		document.getElementById("guardarMedida").disabled = false;
      document.getElementById("guardarMedida").focus();
	}else{
		document.getElementById("guardarMedida").disabled = true;
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
			url:'../ajax/tomarLectura.php?op=listar',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":15,//paginacion
		"order":[[5,"asc"],[1,"asc"]]//ordenar (columna, orden)
	}).DataTable();
}
//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);
     $.ajax({
     	url: "../ajax/tomarLectura.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		document.getElementById("lecA"+ind).value=datos;
     		tabla.ajax.reload();
     		traerDatos(document.getElementById("hidr").value,ind);
     	}
     });

     limpiar();
}

function mostrar(idpersona){
	$.post("../ajax/cliente.php?op=mostrar",{idpersona : idpersona},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);
   		$("#idpersona").val(data.idpersona);
			$("#nombre").val(data.nombre);
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
}


//funcion para desactivar
function eliminar(idlectura){
	hidromet=document.getElementById("hidr").value;
	bootbox.confirm("¿Esta seguro de eliminar este dato?", function(result){
		if (result) {

			$.post("../ajax/tomarLectura.php?op=eliminar", {idlectura : idlectura,hidrometro : hidromet }, function(e){
				//bootbox.alert(e);
				document.getElementById("lecA"+ind).value=e;
				traerDatos(hidromet,ind);
				tabla.ajax.reload();
			});
		}
	})

}


init();