var solicit = false;
firmant = false;
motiv = false;
verFecha = true;
oficParlamentaria = false;
solicitante = true;
sesion = '?vravtbonuquervbbveuqmhcnfdhnqecmrevbxajehrchhypqx=' + document.getElementById('sesion').value;

$('#agregarf4').click(function() {
    window.location = "addPermisos1.php" + sesion;
})
var desd = document.getElementById('fechadesde');
desd.onchange = function(k) {
    restarFecha();


}
var hast = document.getElementById('fechahasta');
hast.onchange = function(l) {
    restarFecha();

}

var codF = document.getElementById('codfunc');
codF.onchange = function(o) {
    //$('#modalFuncionario').modal('show');select ci,nombre,idDependencia from Empleados where codEmp = '1037';
    codigo = document.getElementById('codfunc').value;
    solicitante = true;
    cargaDatosFuncionario(codigo);




}

var desd1 = document.getElementById('codfunc1');
desd1.onchange = function(s) {
    //$('#modalFuncionario').modal('show');select ci,nombre,idDependencia from Empleados where codEmp = '1037';
    codigo = document.getElementById('codfunc1').value;
    solicitante = false;
    if (oficParlamentaria) {
        cargaDatosParlamentario(codigo);
    } else {
        cargaDatosFuncionario(codigo);
    }


}


var mot = document.getElementById('motivo');
mot.onchange = function(l) {

    //$('#modalFuncionario').modal('show');select ci,nombre,idDependencia from Empleados where codEmp = '1037';
    motivo = document.getElementById('motivo').value;



    cargaDatosMotivo(motivo);
}

$('#botBuscador').click(function() {
    cedula = document.getElementById('cedulaBuscar').value;
    nombre = document.getElementById('nombreBuscar').value;
    apellido = document.getElementById('apellidoBuscar').value;
    parametros = '';
    if (cedula.length != 0) {
        parametros = "cedula=" + cedula;
    }
    if (oficParlamentaria & !solicitante) {
        parametros = '';
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
        if (oficParlamentaria & !solicitante) {
            $.ajax({
                url: "BuscarParlamentarioTabla.php",
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

        } else {
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
    }

})


$('#botBuscador1').click(function() {
    descripcion = document.getElementById('motivoBuscar').value;
    if (motivo.length != 0) {
        $.ajax({
            url: "BuscarMotivoTabla.php",
            type: "POST",
            data: "descripcion=" + descripcion,
            success: function(res) {

                var datos = JSON.parse(res);
                var elmtTable = document.getElementById("tabla_orador1");
                var tableRows = elmtTable.getElementsByTagName("tr");
                var rowCount = tableRows.length;
                for (var x = rowCount - 1; x > 0; x--) {
                    document.getElementById("tabla_orador1").deleteRow(x);
                }
                for (var y = datos[0]; y > 0; y--) {
                    document.getElementById("tabla_orador1").insertRow(1).innerHTML = datos[y];
                }
                $('#modalMotivo').modal('show');

            }
        });
    }

})
$('#dipFirm').change(function() {
    oficParlamentaria = $(this).prop('checked');
    if (!oficParlamentaria) {
        document.getElementById("cedula1").value = '';
        document.getElementById("nombre1").value = '';
        document.getElementById("oficina1").value = '';
        document.getElementById("codfunc1").value = '';
        var elmtTable = document.getElementById("tabla_orador");
        var tableRows = elmtTable.getElementsByTagName("tr");
        var rowCount = tableRows.length;
        for (var x = rowCount - 1; x > 0; x--) {
            document.getElementById("tabla_orador").deleteRow(x);
        }
    }

});
$(document).on("click", ".repFecha", function() {
    var cod = $(this).attr("name");
    //var total = $(this).find("td:first-child").text();
    cargaDatosFuncionario(cod);
    $('#modalreporteFecha').modal('hide');

})

$(document).on("click", ".elegir", function() {
    var cod = $(this).attr("name");
    if (oficParlamentaria & !solicitante) {
        cargaDatosParlamentario(cod);
    } else {
        cargaDatosFuncionario(cod);
    }

    $('#modalFuncionario').modal('hide');

})
$(document).on("click", ".elegir1", function() {
    var cod = $(this).attr("name");
    //var total = $(this).find("td:first-child").text();
    cargaDatosMotivo(cod);
    $('#modalMotivo').modal('hide');

})

$('#buscFunc').click(function() {
    solicitante = true;
    document.getElementById("cedulaBuscar").style.display = 'block';
    document.getElementById("cedTit").style.display = 'block'
    var elmtTable = document.getElementById("tabla_orador");
    var tableRows = elmtTable.getElementsByTagName("tr");
    var rowCount = tableRows.length;
    for (var x = rowCount - 1; x > 0; x--) {
        document.getElementById("tabla_orador").deleteRow(x);
    }
    $('#modalFuncionario').modal('show');

})
$('#buscFunc1').click(function() {
    solicitante = false;
    if (oficParlamentaria) {

        cargaTablaParlamentario();
    } else {
        document.getElementById("cedulaBuscar").style.display = 'block';
        document.getElementById("cedTit").style.display = 'block'
    }
    $('#modalFuncionario').modal('show');


})

$('#limpiar').click(function() {
    document.getElementById("cedulaBuscar").value = "";
    document.getElementById("nombreBuscar").value = "";
    document.getElementById("apellidoBuscar").value = "";
})
$('#botMotivo').click(function() {
    $('#modalMotivo').modal('show');

})

function restarFecha() {
    var fechaD = new Date($('#fechadesde').val());
    var fechaH = new Date($('#fechahasta').val());
    //alert(fechaD+' '+fechaH);
    fechaD.setHours(0, 0, 0, 0);
    fechaH.setHours(0, 0, 0, 0);
    fechaH.setDate(fechaH.getDate() + 1);

    if (fechaD.getTime() == fechaH.getTime()) {
        if (fechaD.getDay() == 5 || fechaD.getDay() == 6) {
            document.getElementById("cantDias").value = 0;
        } else {
            document.getElementById("cantDias").value = 1;
        }

    } else if (fechaD < fechaH) {
        var sumarDias = true;
        var cont = 0;
        while (sumarDias) {
            fechaD.setDate(fechaD.getDate() + 1);
            if (fechaD.getTime() == fechaH.getTime()) {
                sumarDias = false;
            }
            if (fechaD.getDay() == 6 || fechaD.getDay() == 0) {


            } else {
                cont++;
            }

            // Número de días a agregar
            document.getElementById("cantDias").value = cont;
            if (cont == 365) {
                sumarDias = false;
            }
        }



    } else {
        document.getElementById("cantDias").value = 0;
    }

}

function cargaDatosFuncionario(codigo) {

    document.getElementById("cedulaBuscar").style.display = 'block';
    document.getElementById("cedTit").style.display = 'block'

    $.ajax({
        url: "BuscarFuncionario.php",
        type: "POST",
        data: "codigo=" + codigo,
        success: function(res) {
            if (!res) {
                if (solicitante) {
                    //document.getElementById("fechamensaje").style.display = 'none';
                    solicit = false;
                    verificar();
                } else {
                    firmant = false;
                    verificar();
                }

                $('#modalNoExiste').modal('show');
                if (solicitante) {
                    document.getElementById("cedula").value = '';
                    document.getElementById("nombre").value = '';
                    document.getElementById("oficina").value = '';
                    document.getElementById("codfunc").value = '';
                    document.getElementById("cantmotivo").style.display = 'none';
                    document.getElementById("cantmotivo1").style.display = 'none';
                    document.getElementById("cantmotivo2").style.display = 'none';



                } else {
                    document.getElementById("cedula1").value = '';
                    document.getElementById("nombre1").value = '';
                    document.getElementById("oficina1").value = '';
                    document.getElementById("codfunc1").value = '';
                }

            } else {
                var datos = JSON.parse(res);

                if (solicitante) {
                    document.getElementById("funcmensaje").style.display = 'none';
                    document.getElementById("cedula").value = separadorMil(datos[0]);
                    document.getElementById("nombre").value = datos[1];
                    if (datos[2].length < 1) {
                        document.getElementById("oficina").value = 'Oficina Parlamentaria';
                    } else {
                        document.getElementById("oficina").value = datos[2];
                    }
                    document.getElementById("codfunc").value = codigo;
                    obtenerHorario(codigo); //carga el horario




                    codigo = codigo;
                    cargo = datos[6];
                    oficina = datos[2];
                    solicit = true;
                    $.ajax({
                        url: "BuscarFuncionarioTablaSuperiores.php",
                        type: "POST",
                        data: "codigo=" + codigo + "&cargo=" + cargo + "&oficina=" + oficina,
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
                            solicitante = false;

                        }
                    });
                    //    document.getElementById("permisomes").innerHTML = datos[3];
                    //  document.getElementById("permisoanho").innerHTML = datos[4];
                    // document.getElementById("permisoanho1").innerHTML = datos[5];
                    mot = document.getElementById("motivo").value;

                    if (mot == 10) {
                        document.getElementById("cantmotivo").style.display = 'block';

                    } else {
                        document.getElementById("cantmotivo").style.display = 'none';
                    }

                    if (mot == 8) {
                        document.getElementById("cantmotivo1").style.display = 'block';

                    } else {
                        document.getElementById("cantmotivo1").style.display = 'none';
                    }

                    if (mot == 4) {
                        document.getElementById("cantmotivo2").style.display = 'block';

                    } else {
                        document.getElementById("cantmotivo2").style.display = 'none';
                    }

                    verificar()
                } else {
                    document.getElementById("funcmensaje1").style.display = 'none';
                    document.getElementById("cedula1").value = separadorMil(datos[0]);
                    document.getElementById("nombre1").value = datos[1];
                    document.getElementById("oficina1").value = datos[2];
                    document.getElementById("codfunc1").value = codigo;
                    firmant = true;
                    verificar()
                }
            }

        }
    });

}

function cargaDatosParlamentario(codigo) {
    $.ajax({
        url: "BuscarParlamentario.php",
        type: "POST",
        data: "codigo=" + codigo,
        success: function(res) {
            if (!res) {
                $('#modalNoExiste').modal('show');

                document.getElementById("cedula1").value = '';
                document.getElementById("nombre1").value = '';
                document.getElementById("oficina1").value = '';
                document.getElementById("codfunc1").value = '';


            } else {
                var datos = JSON.parse(res);
                document.getElementById("funcmensaje1").style.display = 'none';
                document.getElementById("cedula1").value = 'Diputado';
                document.getElementById("nombre1").value = datos[0];
                document.getElementById("oficina1").value = 'Oficina Parlamentaria';
                document.getElementById("codfunc1").value = datos[1];
                firmant = true;
                verificar()

            }

        }
    });

}

function cargaTablaParlamentario() {
    document.getElementById("cedulaBuscar").style.display = 'none';
    document.getElementById("cedTit").style.display = 'none'

    $.ajax({
        url: "BuscarParlamentarioTabla.php",
        type: "POST",
        data: "codigo=123",
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
            solicitante = false;

        }

    });

}

function cargaDatosMotivo(motivo) {
    // alert(motivo);
    codEmp = document.getElementById('codfunc').value;


    if (motivo.length == 0) {
        document.getElementById("motivomensaje").style.display = 'block';
        document.getElementById("motivoDesc").value = '';
        motiv = false;
        verificar();
    } else {
        if (motivo == 18) {
            document.getElementById('motivo').value = '';
            $('#modalNoExiste').modal('show');
        } else {
            $.ajax({
                url: "BuscarMotivo.php",
                type: "POST",
                data: "motivo=" + motivo,
                success: function(res) {
                    if (!res) {
                        motiv = false;
                        verificar();
                        document.getElementById('motivo').value = '';
                        document.getElementById('motivoDesc').value = '';
                        $('#modalNoExiste').modal('show');

                    } else {
                        document.getElementById("motivomensaje").style.display = 'none';
                        var datos = JSON.parse(res);
                        document.getElementById("motivoDesc").value = datos[0];
                        document.getElementById("motivo").value = motivo;
                        if (motivo == 10) {
                            codigo = document.getElementById("cedula").value;
                            //contador de dias particulares
                            document.getElementById("permisomes").innerHTML = contadorPermiso(codEmp, motivo, 'mes');
                            document.getElementById("permisoanho").innerHTML = contadorPermiso(codEmp, motivo, 'anho');
                            if (codigo.length > 0) {
                                document.getElementById("cantmotivo").style.display = 'block';
                            }
                        } else {
                            document.getElementById("cantmotivo").style.display = 'none';
                        }
                        if (motivo == 8) {
                            //contador de dias anuales
                            document.getElementById("permisoanho1").innerHTML = contadorPermiso(codEmp, motivo, 'anho');
                            //contadorPermiso(codEmp, motivo);
                            codigo = document.getElementById("cedula").value;
                            if (codigo.length > 0) {
                                document.getElementById("cantmotivo1").style.display = 'block';
                            }
                        } else {
                            document.getElementById("cantmotivo1").style.display = 'none';
                        }

                        if (motivo == 4) {
                            //contador de dias anuales
                            document.getElementById("permisosa").innerHTML = contadorPermiso(codEmp, motivo, 'mes');
                            //contadorPermiso(codEmp, motivo);
                            codigo = document.getElementById("cedula").value;
                            if (codigo.length > 0) {
                                document.getElementById("cantmotivo2").style.display = 'block';
                            }
                        } else {
                            document.getElementById("cantmotivo2").style.display = 'none';
                        }

                        motiv = true;
                        //document.getElementById("nombre").value = 0;
                        verificar();
                    }

                }
            });
        }
    }
}



function verificar() {
    if (solicit && firmant && motiv) {
        document.getElementById("guardar").disabled = false;
        document.getElementById("guardar").focus();
    } else {
        document.getElementById("guardar").disabled = true;
    }
}



function contadorPermiso(MiCod, MiMot, MiTipo) {
    var respuesta = 0;
    $.ajax({
        type: "POST",
        async: false,
        url: "addPermisoContador.php",
        dataType: "JSON",
        data: {
            codEmp: MiCod,
            codMotivo: MiMot,
            tipoConsulta: MiTipo
        },
        success: function(data) {
            respuesta = data['data'][0].total;
        }
    });
    return respuesta;
}
// JavaScript Document

function obtenerHorario(MiCod) {
    var respuesta = 0;
    $.ajax({
        type: "POST",
        async: false,
        url: "addPermisoConsultaHorario.php",
        dataType: "JSON",
        data: {
            codEmp: MiCod
        },
        success: function(data) {
            respuesta = data[0].hentrada;
            document.getElementById("horadesde").value = data[0].hentrada;
            document.getElementById("horahasta").value = data[0].hsalida;
        }
    });
    return respuesta;
}


//separador de miles
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