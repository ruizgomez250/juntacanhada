var solicit=true;
	firmant=true;
	motiv= true;
	verFecha = true;
	solicitante = true;
 	oficParlamentaria = document.getElementById('dipFirm').checked;
 

var desd= document.getElementById('fechadesde');
	desd.onchange= function (k) {
			restarFecha();
			
		}
var hast = document.getElementById('fechahasta');
	hast.onchange= function (l) {
			restarFecha();
			
		}

var codF= document.getElementById('codfunc');
	codF.onchange= function (o) {
			//$('#modalFuncionario').modal('show');select ci,nombre,idDependencia from Empleados where codEmp = '1037';
			codigo = document.getElementById('codfunc').value;
			solicitante = true;
			cargaDatosFuncionario(codigo);
			
			
}

var desd1= document.getElementById('codfunc1');
	desd1.onchange= function (s) {
			//$('#modalFuncionario').modal('show');select ci,nombre,idDependencia from Empleados where codEmp = '1037';
			codigo = document.getElementById('codfunc1').value;
			solicitante = false;
			if(oficParlamentaria){
				cargaDatosParlamentario(codigo);
			}else{
				cargaDatosFuncionario(codigo);
			}
			
			
}


var mot= document.getElementById('motivo');
	mot.onchange= function (l) {
		
			//$('#modalFuncionario').modal('show');select ci,nombre,idDependencia from Empleados where codEmp = '1037';
			motivo = document.getElementById('motivo').value;
			cargaDatosMotivo(motivo);
}

$('#botBuscador').click(function(){
		cedula = document.getElementById('cedulaBuscar').value;
		nombre = document.getElementById('nombreBuscar').value;
		apellido = document.getElementById('apellidoBuscar').value;
		parametros='';
		if(cedula.length != 0){
			parametros="cedula="+cedula;
		}
		if(oficParlamentaria & !solicitante){
			parametros='';
		}
		if(nombre.length != 0){
				if(parametros.length == 0){
					parametros="nombre="+nombre;
				}else{
					parametros=parametros+"&nombre="+nombre;
				}
		}
		if(apellido.length != 0){
				if(parametros.length == 0){
					parametros="apellido="+apellido;
				}else{
					parametros=parametros+"&apellido="+apellido;
				}
		}
		if (parametros.length != 0){
			if(oficParlamentaria & !solicitante){
				$.ajax({
					url: "BuscarParlamentarioTabla.php",
					type: "POST",
					data: parametros,
					success: function(res){
						var datos = JSON.parse(res);

								var elmtTable = document.getElementById("tabla_orador");
								var tableRows = elmtTable.getElementsByTagName("tr");
								var rowCount = tableRows.length;
								for (var x=rowCount-1; x>0; x--) {
									document.getElementById("tabla_orador").deleteRow(x);
								}
								for (var y=datos[0]; y>0; y--) {
										document.getElementById("tabla_orador").insertRow(1).innerHTML = datos[y];
								}
								$('#modalFuncionario').modal('show');
								}
				});

			}else{
				$.ajax({
					url: "BuscarFuncionarioTabla.php",
					type: "POST",
					data: parametros,
					success: function(res){
						var datos = JSON.parse(res);

								var elmtTable = document.getElementById("tabla_orador");
								var tableRows = elmtTable.getElementsByTagName("tr");
								var rowCount = tableRows.length;
								for (var x=rowCount-1; x>0; x--) {
									document.getElementById("tabla_orador").deleteRow(x);
								}
								for (var y=datos[0]; y>0; y--) {
										document.getElementById("tabla_orador").insertRow(1).innerHTML = datos[y];
								}
								$('#modalFuncionario').modal('show');				
					}
				});
			}
		}
						
})


$('#botBuscador1').click(function(){
		descripcion = document.getElementById('motivoBuscar').value;
		if (motivo.length != 0){
				$.ajax({
				url: "BuscarMotivoTabla.php",
				type: "POST",
				data: "descripcion="+descripcion,
				success: function(res){
					
					var datos = JSON.parse(res);
							var elmtTable = document.getElementById("tabla_orador1");
							var tableRows = elmtTable.getElementsByTagName("tr");
							var rowCount = tableRows.length;
							for (var x=rowCount-1; x>0; x--) {
								document.getElementById("tabla_orador1").deleteRow(x);
							}
							for (var y=datos[0]; y>0; y--) {
									document.getElementById("tabla_orador1").insertRow(1).innerHTML = datos[y];
							}
							$('#modalMotivo').modal('show');





												
				}
			});
		}
						
})



$('#dipFirm').change(function(){
			oficParlamentaria=$(this).prop('checked');
			if(!oficParlamentaria){
				document.getElementById("cedula1").value ='';
				document.getElementById("nombre1").value ='';
				document.getElementById("oficina1").value ='';
				document.getElementById("codfunc1").value ='';
				var elmtTable = document.getElementById("tabla_orador");
				var tableRows = elmtTable.getElementsByTagName("tr");
				var rowCount = tableRows.length;
				for (var x=rowCount-1; x>0; x--) {
					document.getElementById("tabla_orador").deleteRow(x);
				}
			}

		});
$(document).on("click",".elegir",function(){
	var cod=$(this).attr("name");
	if(oficParlamentaria & !solicitante){
		cargaDatosParlamentario(cod);
	}else{
		cargaDatosFuncionario(cod);
	}
  	
  	$('#modalFuncionario').modal('hide');

})
$(document).on("click",".elegir1",function(){
	var cod=$(this).attr("name");
	//var total = $(this).find("td:first-child").text();
  	cargaDatosMotivo(cod);
  	$('#modalMotivo').modal('hide');

})

$('#buscFunc').click(function(){
		solicitante= true;
		document.getElementById("cedulaBuscar").style.display = 'block';
		document.getElementById("cedTit").style.display = 'block'
		$('#modalFuncionario').modal('show');
						
	})
$('#buscFunc1').click(function(){
		solicitante= false;
		if(oficParlamentaria){

			cargaTablaParlamentario();
		}else{
			document.getElementById("cedulaBuscar").style.display = 'block';
			document.getElementById("cedTit").style.display = 'block'
		}
		$('#modalFuncionario').modal('show');
		
						
	})

$('#limpiar').click(function(){
		document.getElementById("cedulaBuscar").value ="";
		document.getElementById("nombreBuscar").value ="";	
		document.getElementById("apellidoBuscar").value ="";			
	})
$('#botMotivo').click(function(){
		$('#modalMotivo').modal('show');
						
	})	
	function restarFecha(){
		var fechaD = new Date($('#fechadesde').val());
		var fechaH = new Date($('#fechahasta').val());
		fechaD.setHours(0,0,0,0);
		fechaH.setHours(0,0,0,0);
		fechaH.setDate(fechaH.getDate() + 1);
		
		if(fechaD.getTime() == fechaH.getTime()){
			if(fechaD.getDay() == 5 || fechaD.getDay() == 6){
				document.getElementById("cantDias").value = 0;
			}
			else{
				document.getElementById("cantDias").value = 1;
			}
			
		}else if (fechaD < fechaH){
			var sumarDias =  true;
			var cont = 0;
			while(sumarDias){
				fechaD.setDate(fechaD.getDate() + 1);
				if(fechaD.getTime() == fechaH.getTime()){
					sumarDias = false;
				}
				if(fechaD.getDay() == 6 || fechaD.getDay() == 0){
					
							
				}else{
					cont++;
				}
				if(cont == 365 ){
					sumarDias = false;
				}
				// Número de días a agregar
				document.getElementById("cantDias").value = cont;
			}
			
			 
			
		}else{
			document.getElementById("cantDias").value = 0;
		}

}

function cargaDatosFuncionario(codigo){
	
		$.ajax({
					url: "BuscarFuncionario.php",
					type: "POST",
					data: "codigo="+codigo,
					success: function(res){
							if(!res){
								if(solicitante){
									document.getElementById("fechamensaje").style.display = 'none';
									solicit = false;
								}else{
									firmant = false;
								}
								
								$('#modalNoExiste').modal('show');
								if(solicitante){
									document.getElementById("codfunc").value ='';
									document.getElementById("cedula").value ='';
									document.getElementById("nombre").value ='';
									document.getElementById("oficina").value ='';
									document.getElementById("fechamensaje").style.display = 'none';

								}
								else{
									document.getElementById("codfunc1").value ='';
									document.getElementById("cedula1").value ='';
									document.getElementById("nombre1").value ='';
									document.getElementById("oficina1").value ='';
								}
								
							}
							else{
								var datos = JSON.parse(res);
								
								if(solicitante){
									document.getElementById("funcmensaje").style.display = 'none';
									document.getElementById("cedula").value =datos[0];
									document.getElementById("nombre").value =datos[1];
									if(datos[2].length < 1){
										document.getElementById("oficina").value ='Oficina Parlamentaria';
									}else{
										document.getElementById("oficina").value =datos[2];
									}
									document.getElementById("codfunc").value =codigo;
									document.getElementById("permisomes").innerHTML = datos[3];
									document.getElementById("permisoanho").innerHTML= datos[4];
									document.getElementById("fechamensaje").style.display = 'block';
									

								}
								else{
									document.getElementById("funcmensaje1").style.display = 'none';
									document.getElementById("cedula1").value =datos[0];
									document.getElementById("nombre1").value =datos[1];
									document.getElementById("oficina1").value =datos[2];
									document.getElementById("codfunc1").value =codigo;
								}
								if(solicitante){
									solicit = true;
								}else{
									firmant = true;
								}

								verificar();
							}
							
					}
				});
	
}
function cargaDatosParlamentario(codigo){
		$.ajax({
					url: "BuscarParlamentario.php",
					type: "POST",
					data: "codigo="+codigo,
						success: function(res){
							if(! res){
								$('#modalNoExiste').modal('show');
								
									document.getElementById("cedula1").value ='';
									document.getElementById("nombre1").value ='';
									document.getElementById("oficina1").value ='';
									document.getElementById("codfunc1").value ='';
								
								
							}
							else{
								var datos = JSON.parse(res);
									document.getElementById("funcmensaje1").style.display = 'none';
									document.getElementById("cedula1").value ='Diputado';
									document.getElementById("nombre1").value =datos[0];
									document.getElementById("oficina1").value ='Oficina Parlamentaria';
									document.getElementById("codfunc1").value =datos[1];
									firmant = true;
									verificar()
								
						}
							
					}
				});
	
}
function cargaTablaParlamentario(){
		document.getElementById("cedulaBuscar").style.display = 'none';
		document.getElementById("cedTit").style.display = 'none'
		
		$.ajax({
		url: "BuscarParlamentarioTabla.php",
		type: "POST",
		data: "codigo=123",
		success: function(res){
				
				var datos = JSON.parse(res);
				var elmtTable = document.getElementById("tabla_orador");
				var tableRows = elmtTable.getElementsByTagName("tr");
				var rowCount = tableRows.length;
				for (var x=rowCount-1; x>0; x--) {
					document.getElementById("tabla_orador").deleteRow(x);
				}
				for (var y=datos[0]; y>0; y--) {
					document.getElementById("tabla_orador").insertRow(1).innerHTML = datos[y];
				}
					solicitante =false;
																			
				}
				
		});
	
}
function cargaDatosMotivo(motivo){
	if(motivo.length == 0){
				document.getElementById("motivomensaje").style.display = 'block';	
				motiv=false;
				//verificar();
			}else{
				$.ajax({
				url: "BuscarMotivo.php",
				type: "POST",
				data: "motivo="+motivo,
				success: function(res){
						if(!res){
							motiv = false;
							$('#modalNoExiste').modal('show');
							
						}
						else{
							document.getElementById("motivomensaje").style.display = 'none';
							var datos = JSON.parse(res);
							document.getElementById("motivoDesc").value =datos[0];
							document.getElementById("motivo").value =motivo;
							motiv=true;
							//document.getElementById("nombre").value = 0;
							verificar();
						}
						
				}
			});
				
			}
}


function verificar(){
	if(solicit && firmant  && motiv )	{
		document.getElementById("guardar").disabled=false;
		document.getElementById("guardar").focus();
	}else{
		document.getElementById("guardar").disabled=true;
	}
}

 // JavaScript Document