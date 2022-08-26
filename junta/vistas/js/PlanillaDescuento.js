var codF = document.getElementById('codfunc');

funcionario = false;

codF.onchange = function(o) {

    //$('#modalFuncionario').modal('show');select ci,nombre,idDependencia from Empleados where codEmp = '1037';

    codigo = document.getElementById('codfunc').value;

    solicitante = true;

    cargaDatosFuncionario(codigo);

}

$('#buscFunc').click(function() {

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

$('#guardar').click(function() {

    fechaDesde = 'fechadesde=' + document.getElementById('fechaDesde').value;

    fechaHasta = '&fechahasta=' + document.getElementById('fechaHasta').value;

    codFunc = '&codigo=' + document.getElementById('codfunc').value;

    nombre = '&nombapellido=' + document.getElementById('nombre').value;

    cedula = '&cedfuncionario=' + document.getElementById('cedula').value;

    var win = window.open('descuentobk.php?' + fechaDesde + fechaHasta + codFunc + nombre + cedula, '_blank');

    // Cambiar el foco al nuevo tab (punto opcional)

    win.focus()

})



function cargaDatosFuncionario(codigo) {

    document.getElementById("cedulaBuscar").style.display = 'block';

    document.getElementById("cedTit").style.display = 'block'



    $.ajax({

        url: "BuscarFuncionario.php",

        type: "POST",

        data: "codigo=" + codigo,

        success: function(res) {

            if (!res) {



                $('#modalNoExiste').modal('show');

                document.getElementById("cedula").value = '';

                document.getElementById("nombre").value = '';

                document.getElementById("oficina").value = '';

                document.getElementById("codfunc").value = '';



                funcionario = false;

                verificar();



            } else {



                var datos = JSON.parse(res);

                document.getElementById("funcmensaje").style.display = 'none';

                document.getElementById("cedula").value = datos[0];

                document.getElementById("nombre").value = datos[1];



                if (datos[2].length < 1) {

                    document.getElementById("oficina").value = 'Oficina Parlamentaria';

                } else {

                    document.getElementById("oficina").value = datos[2];

                }

                document.getElementById("codfunc").value = codigo;

                codigo = codigo;

                cargo = datos[6];

                oficina = datos[2];

                funcionario = true;

                verificar();

            }





        }

    });



}



function verificar() {

    //alert('e'+verificar);

    if (funcionario) {

        document.getElementById("guardar").disabled = false;

        document.getElementById("guardar").focus();

    } else {

        document.getElementById("guardar").disabled = true;

    }

}







$('#botBuscador').click(function() {

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

$(document).on("click", ".elegir", function() {

    var cod = $(this).attr("name");



    cargaDatosFuncionario(cod);



    $('#modalFuncionario').modal('hide');



})