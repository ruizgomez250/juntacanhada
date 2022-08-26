	var idAborrar=0;
		sesion = '?vravtbonuquervbbveuqmhcnfdhnqecmrevbxajehrchhypqx='+document.getElementById('sesion').value;
		pagina = '&dsafkjlhteruqiyopxb='+document.getElementById('pagina').value;
		funcionario = true;
		solicitante=true;
        solicitanteVerif=false;
        firmanteVerif=false;
        funcSolicitanteVerif=false;
        funcFirmanteVerif=false;
        tipoDocVerif=false;
        detallesDocsVerif=false;
        destinoVerif=false;
        esFuncionario=true;
        idEnviado='';
       
        if(document.getElementById('modificarVerif').value != 0){
            
            if(document.getElementById('esfuncVerif') == 1){
                funcSolicitanteVerif=true;
                funcFirmanteVerif=true;
            }else{
                solicitanteVerif=true;
                firmanteVerif=true;
                esFuncionario=false;
            }
            
            
            tipoDocVerif=true;
            detallesDocsVerif=true;
            destinoVerif=true;
        }
 var fileUpload = document.getElementById('foto');
     fileUpload.onclick = function (f) {
        document.getElementById("lmensaje").style.display = 'none';
        verificar();
     }
    fileUpload.onchange = function (e) {
        verUrl = true;
        document.getElementById("lmensaje").style.display = 'block';
        verificar();
    }
	
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
				url: "cargarDetalleMesaEntradaRRHH.php"+sesion,
				type: "POST",
				data: "id="+row,
				success: function(res){
						var datos = JSON.parse(res);
                        document.getElementById("mEntrada").innerHTML =datos[0];
						document.getElementById("fRecep").innerHTML =datos[1];
						document.getElementById("fDoc").innerHTML =datos[2];
                        document.getElementById("Solic").innerHTML =datos[3];
                        document.getElementById("Firm").innerHTML =datos[4];
                        document.getElementById("funcSolic").innerHTML =datos[5];
                        document.getElementById("supFir").innerHTML =datos[6];
                        document.getElementById("motPer").innerHTML =datos[7];
                        document.getElementById("destinoDoc").innerHTML =datos[8];
                        document.getElementById("obs").innerHTML =datos[9];
                        estado='Recepcionado';
                        if(datos[10] == 2){
                           estado='Enviado'; 
                        }
                        document.getElementById("estadoDoc").innerHTML = estado;
                        document.getElementById("recep").innerHTML =datos[12];
						$('#modalVer').modal('show');
					}
				});
		})
$(document).on("click", ".elegir", function() {
    var cod = $(this).attr("name");
    
        cargaDatosFuncionario(cod);

    $('#modalFuncionario').modal('hide');

})
$(document).on("click", ".elegir1", function() {
    var cod = $(this).attr("name");
    
        cargaDatosTipoDoc(cod);

    $('#modalTipoDocumento').modal('hide');

})
$(document).on("click", ".elegir2", function() {
    var cod = $(this).attr("name");
        cargaDestino(cod);

    $('#modalDestino').modal('hide');

})
$(document).on("click", ".borrarDestino", function() {
    var id = $(this).attr("name");
        $.ajax({
        url: "BorrarDestino.php",
        type: "POST",
        data: "id=" + id,
        success: function(res) {
        	cargarModalDestino();
        }
    });
    $('#modalDestino').modal('show');

})
$(document).on("click", ".borrarTipo", function() {
    var id = $(this).attr("name");
        $.ajax({
        url: "BorrarDestino.php",
        type: "POST",
        data: "id=" + id,
        success: function(res) {
        	cargarModalTipoDoc();
        }
    });
    $('#modalTipoDocumento').modal('show');

})
var tipoDoc1 = document.getElementById('tipoDoc');
tipoDoc1.onchange = function(p) {
    //$('#modalFuncionario').modal('show');select ci,nombre,idDependencia from Empleados where codEmp = '1037';
    codigo = document.getElementById('tipoDoc').value;
    if(codigo.length > 0){
        cargaDatosTipoDoc(codigo);
    }else{
        tipoDocVerif=false;
        document.getElementById('tipoDocDescripcion').value='';
        Verificar();
    }
    


}
var destino1 = document.getElementById('destino');
destino1.onchange = function(p) {
    //$('#modalFuncionario').modal('show');select ci,nombre,idDependencia from Empleados where codEmp = '1037';
    codigo = document.getElementById('destino').value;
    if(codigo.length > 0){
        cargaDestino(codigo);
    }else{
        destinoVerif=false;
        document.getElementById('destinoDesc').value='';
        Verificar();
    }
    


}
function cargaDatosTipoDoc(codigo) {
    $.ajax({
        url: "BuscarTipoDoc.php",
        type: "POST",
        data: "codigo=" + codigo,
        success: function(res) {
            if (!res) {
                	document.getElementById("tipoDoc").value = '';
                    document.getElementById("tipoDocDescripcion").value = '';
                    tipoDocVerif=false;

            } else {
                var datos = JSON.parse(res);
                 document.getElementById("tipoDoc").value = datos[0];
                 document.getElementById("tipoDocDescripcion").value = datos[1];
                 tipoDocVerif=true;
            }
            Verificar();

        }
    });

}
function cargaDestino(codigo) {
    $.ajax({
        url: "BuscarDestino.php",
        type: "POST",
        data: "codigo=" + codigo,
        success: function(res) {
            if (!res) {
                	document.getElementById("destino").value = '';
                    document.getElementById("destinoDesc").value = '';
                    destinoVerif=false;

            } else {
                var datos = JSON.parse(res);
                 document.getElementById("destino").value = datos[0];
                 document.getElementById("destinoDesc").value = datos[1];
                 destinoVerif=true;
            }
            Verificar();
        }
    });

}

var det = document.getElementById('observacion');
det.onchange = function(t) {
    if(document.getElementById('observacion').value.length > 0){
        detallesDocsVerif=true;
    }else{
        detallesDocsVerif=false;
    }
    Verificar();
}
var solicit = document.getElementById('solicitante');
solicit.onchange = function(w) {
    if(document.getElementById('solicitante').value.length > 0){
        solicitanteVerif=true;
    }else{
        solicitanteVerif=false;
    }
    Verificar();
}
var firm = document.getElementById('firmante');
firm.onchange = function(q) {
    if(document.getElementById('firmante').value.length > 0){
        firmanteVerif=true;
    }else{
        firmanteVerif=false;
    }
    Verificar();
}
var solicitante1 = document.getElementById('codfunc1');
solicitante1.onchange = function(s) {
    //$('#modalFuncionario').modal('show');select ci,nombre,idDependencia from Empleados where codEmp = '1037';
    codigo = document.getElementById('codfunc1').value;
    solicitante=true;
        cargaDatosFuncionario(codigo);
    


}
var solicitante2 = document.getElementById('codfunc2');
solicitante2.onchange = function(k) {
    //$('#modalFuncionario').modal('show');select ci,nombre,idDependencia from Empleados where codEmp = '1037';
    codigo = document.getElementById('codfunc2').value;
    solicitante=false;
    cargaDatosFuncionario(codigo);
    


}
function separadorMil(num) {
    if (!num || num == 'NaN') return '-';
    if (num == 'Infinity') return '&#x221e;';
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num);
}
function cargaDatosFuncionario(codigo) {

    $.ajax({
        url: "BuscarFuncionario.php",
        type: "POST",
        data: "codigo=" + codigo,
        success: function(res) {
            if (!res) {
                if (solicitante) {
                	document.getElementById("codfunc1").value = '';
                    document.getElementById("cedula1").value = '';
                    document.getElementById("nombre1").value = '';
                    document.getElementById("oficina1").value = '';
                    funcSolicitanteVerif=false;


                } else {
                	document.getElementById("codfunc2").value = '';
                    document.getElementById("cedula2").value = '';
                    document.getElementById("nombre2").value = '';
                    document.getElementById("oficina2").value = '';
                    funcFirmanteVerif=false;
                }

            } else {
                var datos = JSON.parse(res);
                if (solicitante) {
                    document.getElementById("codfunc1").value = codigo;
		            document.getElementById("cedula1").value = separadorMil(datos[0]);
		            document.getElementById("nombre1").value = datos[1];
		            document.getElementById("oficina1").value = datos[2];
                    if (datos[2].length < 1) {
                        document.getElementById("oficina1").value = 'Oficina';
                    }
                    funcSolicitanteVerif=true;
                } else {
                	document.getElementById("codfunc2").value = codigo;
                    document.getElementById("cedula2").value = separadorMil(datos[0]);
                    document.getElementById("nombre2").value = datos[1];
                    document.getElementById("oficina2").value = datos[2];
                    if (datos[2].length < 1) {
                        document.getElementById("oficina2").value = 'Oficina';
                    }
                    funcFirmanteVerif=true;
                }
            }
            Verificar();
        }
    });

}

$('#botBuscador1').click(function() {

    cedula = document.getElementById('cedulaBuscar').value;
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
    if (parametros.length != 0) {
            $.ajax({
                url: "BuscarFuncionarioTabla.php",
                type: "POST",
                data: parametros,
                success: function(res) {
                    var datos = JSON.parse(res);

                    var elmtTable = document.getElementById("tabla_orador");
                    var tableRows = elmtTable.getElementsByTagName("tr");
                    var rowCount = tableRows.length;
                    for (var x = rowCount - 1; x > 0; x--) {
                        document.getElementById("tabla_orador").deleteRow(x);
                    }
                    for (var y = datos[0]; y > 0; y--) {
                        document.getElementById("tabla_orador").insertRow(1).innerHTML = datos[y];
                    }
                    $('#modalFuncionario').modal('show');
                }
            });
        
    }

})
$('#botTipo').click(function() {
	cargarModalTipoDoc();
	 $('#modalTipoDocumento').modal('show');
	 

})
$('#agregar1').click(function() {
	descripcion = document.getElementById("descripcionTipo").value;
	if(descripcion.length > 0){
		$.ajax({
                url: "guardarTipoDoc.php",
                type: "POST",
                data: 'descrip='+descripcion,
                success: function(res) {
                	cargarModalTipoDoc()
                     $('#modalTipoDocumento').modal('show');
                }
            });	
	}

})
$('#agregar2').click(function() {
	descripcion = document.getElementById("descripcionDestino").value;
	if(descripcion.length > 0){
		$.ajax({
                url: "guardarDestino.php",
                type: "POST",
                data: 'descrip='+descripcion,
                success: function(res) {
                	cargarModalDestino()
                     $('#modalDestino').modal('show');
                }
            });	
	}

})
$('#botDestino').click(function() {
	cargarModalDestino();
	 $('#modalDestino').modal('show');
	 

})
function cargarModalTipoDoc(){
	parametros=' ';
	$.ajax({
                url: "BuscarTipoDocumentoTabla.php",
                type: "POST",
                data: parametros,
                success: function(res) {
                    var datos = JSON.parse(res);

                    var elmtTable = document.getElementById("tabla_tipo");
                    var tableRows = elmtTable.getElementsByTagName("tr");
                    var rowCount = tableRows.length;
                    for (var x = rowCount - 1; x > 0; x--) {
                        document.getElementById("tabla_tipo").deleteRow(x);
                    }
                    for (var y = datos[0]; y > 0; y--) {
                        document.getElementById("tabla_tipo").insertRow(1).innerHTML = datos[y];
                    }
                }
            });

}
function cargarModalDestino(){
	parametros=' ';
	$.ajax({
                url: "BuscarDestinoTabla.php",
                type: "POST",
                data: parametros,
                success: function(res) {
                    var datos = JSON.parse(res);

                    var elmtTable = document.getElementById("tabla_destino");
                    var tableRows = elmtTable.getElementsByTagName("tr");
                    var rowCount = tableRows.length;
                    for (var x = rowCount - 1; x > 0; x--) {
                        document.getElementById("tabla_destino").deleteRow(x);
                    }
                    for (var y = datos[0]; y > 0; y--) {
                        document.getElementById("tabla_destino").insertRow(1).innerHTML = datos[y];
                    }
                }
            });

}
$('#buscFuncSolicitante').click(function() {

    /*if (oficParlamentaria) {

        cargaTablaParlamentario();
    } else {
        document.getElementById("cedulaBuscar").style.display = 'block';
        document.getElementById("cedTit").style.display = 'block'
    }*/
    solicitante=true;
    $('#modalFuncionario').modal('show');


})
$('#buscFuncFirmante').click(function() {
    /*if (oficParlamentaria) {

        cargaTablaParlamentario();
    } else {
        document.getElementById("cedulaBuscar").style.display = 'block';
        document.getElementById("cedTit").style.display = 'block'
    }*/
    
    solicitante=false;
    $('#modalFuncionario').modal('show');


})

$('#funcionarioFirm').change(function() {
    funcionario = $(this).prop('checked');
    if (!funcionario) {
        esFuncionario=false;
        document.getElementById("Funcionario").style.display = 'none';
        document.getElementById("Funcionario1").style.display = 'none';
        document.getElementById("Funcionario2").style.display = 'none';
        document.getElementById("Funcionario3").style.display = 'none';
        document.getElementById("Funcionario4").style.display = 'none';
        document.getElementById("Funcionario5").style.display = 'none';
        document.getElementById("Funcionario6").style.display = 'none';
        document.getElementById("Funcionario7").style.display = 'none';
        document.getElementById("noFuncionario").style.display = 'block';
        document.getElementById("noFunc").style.display = 'block';
    }else{
        esFuncionario=true;
    	document.getElementById("Funcionario").style.display = 'block';
    	document.getElementById("Funcionario1").style.display = 'block';
    	document.getElementById("Funcionario2").style.display = 'block';
    	document.getElementById("Funcionario3").style.display = 'block';
    	document.getElementById("Funcionario4").style.display = 'block';
    	document.getElementById("Funcionario5").style.display = 'block';
    	document.getElementById("Funcionario6").style.display = 'block';
    	document.getElementById("Funcionario7").style.display = 'block';
        document.getElementById("noFuncionario").style.display = 'none';
        document.getElementById("noFunc").style.display = 'none';
    }
    Verificar();

});
$(document).on("click",".ieditar",function(){

    idEnviado =$(this).attr("name");
                $('#modalCheck').modal('show');
        })
$('#verifForm').click(function(){
            $.ajax({
                url: "docEnviado.php"+sesion,
                type: "POST",
                data: "id="+idEnviado,
                success: function(res){
                        $('#modalCheck').modal('hide');
                        location.reload();
                    }
                });
        })
 function cargarTabla(parametro){
 		$.ajax({
				url: "BuscarRecepcionMentradaTabla.php"+sesion,
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
    if(tipoDocVerif && detallesDocsVerif && destinoVerif){
        firmas=false;
        if(esFuncionario){
            if(funcSolicitanteVerif && funcFirmanteVerif){
                firmas=true;
            }
            else{
                firmas=false;
            }

        }else{
            if(solicitanteVerif && firmanteVerif){
                firmas=true;
            }else{
                firmas=false;
            }
        }
        if(firmas){
            document.getElementById("guardar").disabled = false;
            document.getElementById("guardar").focus();
        }else{
            document.getElementById("guardar").disabled = true;
        }

    }else{
        document.getElementById("guardar").disabled = true;
    }
    
 }