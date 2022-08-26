	var idAborrar=0;
		sesion = '?vravtbonuquervbbveuqmhcnfdhnqecmrevbxajehrchhypqx='+document.getElementById('sesion').value;
		pagina = '&dsafkjlhteruqiyopxb='+document.getElementById('pagina').value;
	$('#agregar').click(function(){
		window.location="addDocs.php"+sesion+pagina;
	})
	$('#limpiar').click(function(){
			location.reload();
		})
	var desd= document.getElementById('fechaFiltro');
	desd.onchange= function (k) {
			fecha = 'fecha='+document.getElementById('fechaFiltro').value;
				cargarTabla(fecha);
			
		}
	$('#botBuscador').click(function(){
			mesaEntrada = document.getElementById('numeroEntradaBuscar').value;
			codFun= document.getElementById('codFun').value;
			parametro = '';
			
			if (mesaEntrada.length != 0){
				parametro = 'mesa='+mesaEntrada;
				cargarTabla(parametro);
			}else if(codFun.length != 0){
					
					parametro = 'codfun='+codFun;
					cargarTabla(parametro);	
			}
		})



$(document).on("click",".ver",function(){
	
		var row=$(this).attr("name");
		$.ajax({
				url: "cargarDetallePermiso.php"+sesion,
				type: "POST",
				data: "id="+row,
				success: function(res){
						var datos = JSON.parse(res);
						document.getElementById("mEntrada").innerHTML =datos[0];
						document.getElementById("fRecep").innerHTML =datos[1];
						document.getElementById("funcSolic").innerHTML =datos[4];
						document.getElementById("motPer").innerHTML =datos[15];
						document.getElementById("supFir").innerHTML =datos[13];
						document.getElementById("obs").innerHTML =datos[18];
						document.getElementById("fDesd").innerHTML =datos[6];
						document.getElementById("fHast").innerHTML =datos[7];
						document.getElementById("tDia").innerHTML =datos[10];
						document.getElementById("hDesd").innerHTML =datos[8];
						document.getElementById("hHast").innerHTML =datos[9];
						$('#modalVer').modal('show');
					}
				});
		})

 function cargarTabla(parametro){
 		$.ajax({
				url: "BuscarRecepcionPermisoTabla.php"+sesion,
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