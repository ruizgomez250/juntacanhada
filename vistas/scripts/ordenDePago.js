var tabla,cont,impuesto,idImpuesto;

//funcion que se ejecuta al inicio

function init(){
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   		guardaryeditar(e);
   });

   //cargamos los items al select proveedor
   $.post("../ajax/ingreso.php?op=selectProveedor", function(r){
   	$("#idproveedor").html(r);
   	$('#idproveedor').selectpicker('refresh');
   });
   
   //ocultar ya que no es factura y no tiene timbrado
   document.getElementById("factCred").style.display = "none";
   document.getElementById("fact").style.display = "none";
   document.getElementById("fact1").style.display = "none";
   //Cargamos los metodos de pagos al contado
   $.post("../ajax/ingreso.php?op=selectMetodoPago", function(r){
   	$("#metodo_pago").html(r);
   	$('#metodo_pago').selectpicker('refresh');
   });
   //Cargamos los impuestos
   $.post("../ajax/ingreso.php?op=selectImpuesto", function(r){
   	data=JSON.parse(r);
   	$("#impuesto").html(data[0]);
   	$('#impuesto').selectpicker('refresh');
   	id=$('#impuesto').prop("selectedIndex",0).val();
   	impuesto=data[2];
   	idImpuesto=data[1];
   });
  /* $.post("../ajax/articulo.php?op=impdefault",
		function(data,status)
		{
			data=JSON.parse(data);
			impuesto=data.porcentaje;
			idImpuesto=data.id;
			
		})*/
		cargarPag();
}


//funcion limpiar
function limpiar(){

	$("#idproveedor").val("");
	$("#proveedor").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#impuesto").val("");

	$("#total_compra").val("");
	$(".filas").remove();
	$("#total").html("0");

	//obtenemos la fecha actual
	var now = new Date();
	var day =("0"+now.getDate()).slice(-2);
	var month=("0"+(now.getMonth()+1)).slice(-2);
	var today=now.getFullYear()+"-"+(month)+"-"+(day);
	$("#fecha_hora").val(today);

	//marcamos el primer tipo_documento
	$("#tipo_comprobante").val("Boleta");
	$("#tipo_comprobante").selectpicker('refresh');

}

//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	marcarImpuesto();
	if(flag){
		cont=0;
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarArticulos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles=0;
		$("#btnAgregarArt").show();


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
			url:'../ajax/ingreso.php?op=listarPa',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":10,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}



/********* cargar Fechas datatables*********/


function datosA(num, fecha){
this.num = num;
this.fecha = fecha;
}

function cambiarFecha(fila){
	fechMod=document.getElementsByName("fechP1[]");
	fechMod=fechMod[fila].value;
	fechForm=document.getElementsByName("fechP[]");
	fechForm[fila].value=fechMod;
	//alert(precV);

}
function orden(fila){
	

}
function cargarPag(){
	n =  new Date();

	//Año
	y = n.getFullYear();
	//Mes
	m = n.getMonth() + 1;
	if(m < 10)
		m='0'+m;
	//Día
	d = n.getDate();
	if(d < 10)
		d='0'+d;
	fech=y+ "-" + m + "-" + d;
	cantp=document.getElementById("cant_pago").value;
	contAux=1
	var valor = [];
	var valor1 = [];
	//valor.splice(0,valor.length);
	for (let index = 0; index < cantp; index++) {    
		fecha= '<tr class="filas" id="fila'+index+'">'+
        '<td><input type="date" name="fechP[]" value="'+fech+'"></td>'+
		'</tr>';
		fecha1= '<tr class="filas" id="fila1'+index+'">'+
        '<td><input type="date" name="fechP1[]" onblur="cambiarFecha('+index+')" value="'+fech+'"></td>'+
		'</tr>';
    var book = new datosA(contAux, fecha); 
    var book1 = new datosA(contAux, fecha1); 
    valor.push(book);
    valor1.push(book1);
  //  console.log(obj);
  		contAux++;
	}
	/*var datos=[{
	  	 num: cont,
	    fecha: '<tr class="filas" id="fila'+cantp+'">'+
        '<td><input type="date" name="fechP[]" value="'+fech+'"></td>'+
		'</tr>'
	  }];
	  console.log(datos);
	  datosAux='';
	/*for (var i = 0; i < cantp; i++) {
		
   	datosAux+= 
	  {
	  	 num: cont,
	    fecha: '<tr class="filas" id="fila'+cantp+'">'+
        '<td><input type="date" name="fechP[]" value="'+fech+'"></td>'+
		'</tr>'
	  };
	 cont++;
	 console.log(datosAux);
	};*/
	/*valor.splice(0,valor.length);
	for (let index = 0; index < cantp; index++) {    
		fecha= '<tr class="filas" id="fila'+index+'">'+
        '<td><input type="date" name="fechP[]" value="'+fech+'"></td>'+
		'</tr>';
    var book = new datosA(cont, fecha); 

    valor.push(book);
  //  console.log(obj);
  		cont++;
	}
//obj.data = valor;
//var datos=JSON.stringify(valor);
//console.log(datos);*/
	$('#tblpagare').DataTable({
	  paging: false,
	  searching: false,
	  info: false,
	  data: valor1,
	  "bDestroy":true,
	  columns: [
	  	 { title: "Pago", data: "num" },
	    { title: "Fecha", data: "fecha" }
	  ]
	});
	$('#tblpagare1').DataTable({
	  paging: false,
	  searching: false,
	  info: false,
	  data: valor,
	  "bDestroy":true,
	  columns: [
	  	 { title: "Pago", data: "num" },
	    { title: "Fecha", data: "fecha" }
	  ]
	});

}
function listarArticulos(){
	tabla=$('#tblarticulos').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [

		],
		"ajax":
		{
			url:'../ajax/ingreso.php?op=listarArticulos',
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
function ordenPago(idingreso){
	bootbox.confirm("¿Esta seguro que desea generar la orden de pago?", function(result){
		if (result) {
			$.post("../ajax/ingreso.php?op=generarOrdenPago", {idingreso : idingreso}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}
//funcion para guardaryeditar
function guardaryeditar(e){
	//alert('dd');
     e.preventDefault();//no se activara la accion predeterminada 
     //$("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);
     $.ajax({
     	url: "../ajax/ingreso.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		cont=0;
     		bootbox.alert(datos);
     		mostrarform(false);
     		listar();
     	}
     });

     limpiar();
}

function mostrar(idingreso){
	$.post("../ajax/ingreso.php?op=mostrar",{idingreso : idingreso},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);
			$("#metodo_pago").val(data.metodo_pago);
			$("#metodo_pago").selectpicker('refresh');
			$("#cant_pago").val(data.cantidad_pagos);
			$("#cant_pago").selectpicker('refresh');
			$("#idproveedor").val(data.idproveedor);
			$("#idproveedor").selectpicker('refresh');
			$("#tipo_comprobante").val(data.tipo_comprobante);
			$("#tipo_comprobante").selectpicker('refresh');
			$("#serie_comprobante").val(data.serie_comprobante);
			$("#num_comprobante").val(data.num_comprobante);
			$("#fecha_hora").val(data.fecha);
			$("#impuesto").val(data.impuesto);
			$("#impuesto").selectpicker('refresh');
			$("#idingreso").val(data.idingreso);
			marcarImpuesto();
			//ocultar y mostrar los botones
			$("#btnGuardar").hide();
			$("#btnCancelar").show();
			$("#btnAgregarArt").hide();

		});
	$.post("../ajax/ingreso.php?op=listarDetalle&id="+idingreso,function(r){
		$("#detalles").html(r);
	});

}


//funcion para desactivar
function anular(idingreso){
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			$.post("../ajax/ingreso.php?op=anular", {idingreso : idingreso}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//declaramos variables necesarias para trabajar con las compras y sus detalles
var impuesto=18;
var cont=0;
var detalles=0;

$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto(){
	var tipo_comprobante=$("#tipo_comprobante option:selected").text();
	cantDet = $("#detalles tr").length;
	if(cantDet > 2){
		reload();
	}
	if (tipo_comprobante=='Factura Contado' || tipo_comprobante=='Factura Credito' || tipo_comprobante=='Auto Factura') {
		
		document.getElementById("fact").style.display = "block";
		document.getElementById("fact1").style.display = "block";
		document.getElementById("serie_comprobante").required = true;
		document.getElementById("impuesto").required = true;
		if(tipo_comprobante=='Factura Credito'){
			document.getElementById("cant_pago").required = true;
			$("#metodo_pago").html('<option value=-2>Documentos a pagar</option>');
			$('#metodo_pago').selectpicker('refresh');
			document.getElementById("factCred").style.display = "block";
		}else{
			document.getElementById("cant_pago").required = false;
			document.getElementById("factCred").style.display = "none";
			//Cargamos los metodos de pagos al contado
		   $.post("../ajax/ingreso.php?op=selectMetodoPago", function(r){
		   	$("#metodo_pago").html(r);
		   	$('#metodo_pago').selectpicker('refresh');
		   });
		}
		
	}else{
		document.getElementById("impuesto").required = false;
		document.getElementById("cant_pago").required = false;
		document.getElementById("factCred").style.display = "none";
		document.getElementById("fact").style.display = "none";
		document.getElementById("fact1").style.display = "none";
		document.getElementById("serie_comprobante").required = false;
		//Cargamos los metodos de pagos al contado
		   $.post("../ajax/ingreso.php?op=selectMetodoPago", function(r){
		   	$("#metodo_pago").html(r);
		   	$('#metodo_pago').selectpicker('refresh');
		   });
	}
}

function agregarDetalle(idarticulo,articulo){
	var cantidad=1;
	var precio_compra=0;
	var precio_venta=1;
	/*impuesto=$('#impuesto option:selected').text();
	idimpuesto=$('#impuesto option:selected').val();
	if(impuesto == null || impuesto.length==0){
		impuesto=$("#impuesto").prop("selectedIndex", 0).text();
		impuesto=$("#impuesto").prop("selectedIndex", 0).val();
	}
	//alert(impuesto);
	impuesto=(precio_compra*impuesto)/100;*/
	impuestoA=0;
	if (idarticulo!="") {
		var subtotal=cantidad*precio_compra;
		var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
        '<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
        '<td><input type="number" name="cantidad[]" onchange="calcImpuesto('+cont+')" id="cantidad[]" value="'+cantidad+'"></td>'+
        '<td><input type="number" name="precio_compra[]" onchange="calcImpuesto('+cont+')" id="precio_compra[]" value="'+precio_compra+'"></td>'+
        '<td><input type="hidden" name="imp[]" value="'+impuestoA+'"><input type="hidden" name="idimp[]" value="'+impuestoA+'"><span name="impuest" id="impuest'+cont+'">'+impuestoA+' </span></td>'+
        '<td><span id="subtotal'+cont+'" name="subtotal">'+subtotal+'</span></td>'+
		'</tr>';
		cont++;
		detalles++;
		$('#detalles').append(fila);
		modificarSubtotales();
		
	}else{
		alert("error al ingresar el detalle, revisar las datos del articulo ");
	}
}
function calcPorc(fila){
	precV=document.getElementsByName("precio_venta[]");
	precV=precV[fila].value;
	prec=document.getElementsByName("precio_compra[]");
	precCo=prec[fila].value;
	diferencia=precV-precCo;
	porcMargen=0;
	if(diferencia < 0){
		document.getElementsByName("precio_venta[]")[fila].value=Math.round(precCo);
	}else{
		porcMargen=(diferencia*100)/precCo;

	}
	document.getElementsByName("margen[]")[fila].value=Math.round(porcMargen);
}
function calcMargen(fila){
	marg=document.getElementsByName("margen[]");
	margV=marg[fila].value;
	prec=document.getElementsByName("precio_compra[]");
	precCo=prec[fila].value;
	totConMargen=((precCo*margV)/100)+(precCo*1);
	
	document.getElementsByName("precio_venta[]")[fila].value=Math.round(totConMargen);
}
$("#impuesto").change(function() {
  var valor = $(this).val(); // Capturamos el valor del select
  var texto = $(this).find('option:selected').text(); // Capturamos el texto del option seleccionado
  impuesto=texto;
  idImpuesto=valor;
});
function calcImpuesto(fila){
	impuesto1=0;
	//var tipo_comprobante=$("#tipo_comprobante option:selected").text();
	tipo_comprobante=document.getElementById("tipo_comprobante").value;
	if (tipo_comprobante=='Factura Contado' || tipo_comprobante=='Factura Credito' || tipo_comprobante=='Auto Factura') {
		//document.getElementById("impuesto").required = true;
		prec=document.getElementsByName("precio_compra[]");
		precCo=prec[fila].value;
		comp=document.getElementsByName("cantidad[]");
		cant=comp[fila].value;
		precCo=precCo*cant;
		//document.getElementsByName("idimp[]")[fila].value=idimpuesto;
		impuesto1=(precCo*impuesto)/100;	
		document.getElementsByName("imp[]")[fila].value=impuesto1;
		document.getElementsByName("idimp[]")[fila].value=idImpuesto;
		
	}
	document.getElementById("impuesto").required = false;

	
	document.getElementsByName("impuest")[fila].innerHTML=impuesto1;

	
	modificarTotales();
	
}

function modificarSubtotales(){
	var cant=document.getElementsByName("cantidad[]");
	var prec=document.getElementsByName("precio_compra[]");
	var sub=document.getElementsByName("subtotal");

	for (var i = 0; i < cant.length; i++) {
		var inpC=cant[i];
		var inpP=prec[i];
		var inpS=sub[i];

		inpS.value=inpC.value*inpP.value;
		document.getElementsByName("subtotal")[i].innerHTML=inpS.value;
	}

	calcularTotales();
}
function modificarTotales(){
	var cant=document.getElementsByName("cantidad[]");
	var prec=document.getElementsByName("precio_compra[]");
	//var sub=document.getElementsByName("subtotal");

	for (var i = 0; i < cant.length; i++) {
		var inpC=cant[i];
		var inpP=prec[i];
		var subt=0;

		subt=(inpC.value*inpP.value)+(document.getElementsByName("impuest")[i].innerHTML*1);//+(document.getElementsByName("impuest")[i].value*1);
		//alert();
		document.getElementsByName("subtotal")[i].innerHTML=subt;
	}

	calcularTotales();
}

function calcularTotales(){
	var sub = document.getElementsByName("subtotal");
	var total=0.0;
	for (var i = 0; i < sub.length; i++) {
		
		total =total+ (document.getElementsByName("subtotal")[i].innerHTML*1);
		
	}
	$("#total").html("Gs." + total);
	$("#total_compra").val(total);
	evaluar();
}
function guardPago(id,index,idDeuda){
	fech=document.getElementById('pago'+index).value;
	$.post("../ajax/ingreso.php?op=guardPago",{idingreso : id,fechaPago:fech,iddeuda:idDeuda},
		function(data,status)
		{
			alert(data);
		});
}
function cargarPago(id){
	tabla=$('#pagosrealizados').dataTable({
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
			url:'../ajax/ingreso.php?op=listarDeuda&id='+id,
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":12,//paginacion
		"order":[[0,"asc"]]//ordenar (columna, orden)
	}).DataTable();
}
function evaluar(){

	if (detalles>0) 
	{
		$("#btnGuardar").show();
	}
	else
	{
		$("#btnGuardar").hide();
		cont=0;
	}
}

function eliminarDetalle(indice){
$("#fila"+indice).remove();
calcularTotales();
detalles=detalles-1;

}

init();