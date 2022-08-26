	var idVerificado=0;
		sesion = '?vravtbonuquervbbveuqmhcnfdhnqecmrevbxajehrchhypqx='+document.getElementById('sesion').value;
	$('#limpiar').click(function(){
			location.reload();
		})
	
	$('#botBuscador').click(function(){
			codFun= document.getElementById('codFun').value;
			cedula = document.getElementById('cedulaB').value;
		    nombre = document.getElementById('nombreBuscar').value;
		    apellido = document.getElementById('apellidoBuscar').value;
		    parametros = '';
		    if (cedula.length != 0) {
		        parametros = "cedula=" + cedula;
		    }
		    if (nombre.length != 0) {
		        if (parametros.length == 0) {
		            parametros = "nombre=" + nombre;
		        } else {
		            parametros = parametros + "&nombre=" + nombre;
		        }
		    }
		    if (apellido.length != 0) {
		        if (parametros.length == 0) {
		            parametros = "apellido=" + apellido;
		        } else {
		            parametros = parametros + "&apellido=" + apellido;
		        }
		    }
		    if(codFun.length != 0){
					
					parametros = 'codigoFuncionario='+codFun;
						
			}
			cargarTabla(parametros);
		})



$(document).on("click",".ver",function(){
		
		var row=$(this).attr("name");
			$.ajax({
				url: "cargarDetalleFuncionario.php"+sesion,
				type: "POST",
				data: "codFunc="+row,
				success: function(res){
						var datos = JSON.parse(res);
						
						//.attr('src', 'data:image/jpg;base64,' + data[0].foto);
						if(datos[1] != ' '){
							document.getElementById("foto").setAttribute('src', 'data:image/jpg;base64,'+datos[1]);
						}else{
							document.getElementById("foto").src="icon/rrhh.png";
						}
						document.getElementById("codFunc").innerHTML =datos[2];
						document.getElementById("cedula").innerHTML =datos[3];
						document.getElementById("nombAp").innerHTML =datos[4];
						document.getElementById("genero").innerHTML =datos[5];
						document.getElementById("fechNac").innerHTML =datos[6];
						document.getElementById("tipoSangre").innerHTML =datos[7];
						document.getElementById("hijos").innerHTML =datos[8];
						document.getElementById("telefono1").innerHTML =datos[9];
						document.getElementById("telefono2").innerHTML =datos[10];
						document.getElementById("telefono3").innerHTML =datos[11];
						document.getElementById("telefono4").innerHTML =datos[12];
						document.getElementById("email").innerHTML =datos[13];
						document.getElementById("calle").innerHTML =datos[14];
						document.getElementById("numcasa").innerHTML =datos[15];
						document.getElementById("barrio").innerHTML =datos[16];
						document.getElementById("distrito").innerHTML =datos[17];
						document.getElementById("departamento").innerHTML =datos[18];
						document.getElementById("estado").innerHTML =datos[19];
						document.getElementById("relacion").innerHTML =datos[20];
						document.getElementById("dependencia").innerHTML =datos[21];
						document.getElementById("institucion").innerHTML =datos[22];
						document.getElementById("cargo").innerHTML =datos[23];
						document.getElementById("funcion").innerHTML =datos[24];
						document.getElementById("movimiento").innerHTML =datos[25];
						document.getElementById("legajo").innerHTML =datos[26];
						document.getElementById("fechaContrato").innerHTML =datos[27];
						document.getElementById("fechaNombramiento").innerHTML =datos[28];
						$('#modalVer').modal('show');
					}
				});
		})

$(document).on("click",".modificar",function(){

	row =$(this).attr("name");
				$.ajax({
				url: "cargarDetalleFuncionario.php"+sesion,
				type: "POST",
				data: "codFunc="+row,
				success: function(res){
						var datos = JSON.parse(res);
						//.attr('src', 'data:image/jpg;base64,' + data[0].foto);
						if(datos[1] != ' '){
							document.getElementById("foto1").setAttribute('src', 'data:image/jpg;base64,'+datos[1]);
						}else{
							document.getElementById("foto1").src="icon/rrhh.png";
						}
						document.getElementById("codigo1").value =datos[2];
						document.getElementById("cedula1").value =datos[3];
						document.getElementById("nombre1").value =datos[4];
						if(datos[5] == 'F'){
							document.getElementById("sexo").innerHTML = '<option>Femenino</option><option>Masculino</option>';
							
						} else{
							document.getElementById("sexo").innerHTML = '<option>Masculino</option><option>Femenino</option>';
						}
						
						document.getElementById("fechnac1").value =datos[6];
						TraeOpcionesPorIdPrimero('TipoSanguineo',datos[7],'tiposangre1');
						//document.getElementById("tiposangre1").innerHTML = '<option>'+datos[7]+'</option>';
						TraeOpcionesPorIdPrimero('Distritos',datos[17],'distrito1');
						document.getElementById("hijos1").value =datos[8];
						document.getElementById("tel1").value =datos[9];
						document.getElementById("tel2").value =datos[10];
						document.getElementById("tel3").value =datos[11];
						document.getElementById("tel4").value =datos[12];
						document.getElementById("email1").value =datos[13];
						document.getElementById("calle1").value =datos[14];
						document.getElementById("casa1").value =datos[15];
						document.getElementById("barrio1").value =datos[16];
						TraeDistritos(datos[17],datos[18],'distrito1');
						TraeOpcionesPorIdPrimero('Departamentos',datos[18],'dpto1');
						TraeOpcionesPorIdPrimero('EstadoLaboral',datos[19],'estado1');
						TraeOpcionesPorIdPrimero('RelacionLaboral',datos[21],'relacion1');
						//document.getElementById("relacion1").value =datos[20];
						TraeOpcionesPorIdPrimero('Dependencias',datos[21],'depen1');
						//document.getElementById("depen1").value =datos[21];
						document.getElementById("inst1").value =datos[22];
						TraeOpcionesPorIdPrimero('InstitucionesPublicas',datos[22],'inst1');
						TraeOpcionesPorIdPrimero('Cargos',datos[23],'cargo1');
						//document.getElementById("cargo1").value =datos[23];
						//document.getElementById("funcion1").value =datos[24];
						TraeOpcionesPorIdPrimero('Funciones',datos[24],'funcion1');
						document.getElementById("mov1").value =datos[25];
						document.getElementById("legajo1").value =datos[26];
						document.getElementById("fechcont1").value =datos[27];
						document.getElementById("fechnomb1").value =datos[28];
						TraeOpcionesPorIdPrimero('Horarios',datos[29],'horario1');
						//document.getElementById("horario1").value =datos[29];
						if(datos[30] == 0)
							document.getElementById("prof1").value ='No';
						else
							document.getElementById("prof1").value ='Si';
						TraeOpcionesPorIdPrimero('Discapacidad',datos[31],'disc1');	
						//document.getElementById("disc1").value =datos[31];
						
						$('#modalModificar').modal('show');
					}
				});
				
		})
$('#verifForm').click(function(){
			$.ajax({
				url: "verificarForm.php"+sesion,
				type: "POST",
				data: "id="+idVerificado,
				success: function(res){
						$('#modalCheck').modal('hide');
						location.reload();
					}
				});
		})
function TraeOpcionesPorIdPrimero(TablaTraer,id,cargaVentana){ 
 	$.ajax({
				url: "CargarItems.php"+sesion,
				type: "POST",
				data: 'tabla='+TablaTraer+'&id='+id,
				success: function(res){
					//var datos = JSON.parse(res);.
					document.getElementById(cargaVentana).innerHTML =res;	
							
											
				}
			});
 		
 }
 function TraeDistritos(id,idDpto,cargaVentana){ 
 	$.ajax({
				url: "CargarDistrito.php"+sesion,
				type: "POST",
				data: 'idDpto='+idDpto+'&id='+id,
				success: function(res){
					//var datos = JSON.parse(res);
					document.getElementById(cargaVentana).innerHTML =res;	
							
											
				}
			});
 		
 }
 function cargarTabla(parametro){ 
 	$.ajax({
				url: "CargarDetalleFuncionario.php"+sesion,
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