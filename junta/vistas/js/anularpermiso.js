$('#idrecepcion').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        //  alert('hola mundo');
        var var_idrecepcion = $('#idrecepcion').val();
        getDatosPermiso(var_idrecepcion);
        e.preventDefault();
        return false;
    }
});


$('#btn_anular').on('click', function() {
    var var_idrecepcion = $('#idrecepcion').val();
    //alert("entra"+var_condicion+var_item);
    $.ajax({
        type: "POST",
        url: "anularpermisoconsulta.php",
        dataType: "JSON",
        data: {
            operacion: 'modificar',
            idrecepcion: var_idrecepcion
        },
        success: function(data) {
            $('#Modal_Anular').modal('hide');
            getLimpieza();
        }
    });
    return false;
});


function getDatosPermiso(var_id) {
    //alert('llama'+var_ci);
    $.ajax({
        type: "POST",
        url: "anularpermisoconsulta.php",
        dataType: "JSON",
        data: {
            idrecepcion: var_id,
            operacion: 'consultar'
        },
        success: function(data) {
            // alert('hola mundo2');
            $('[name="codEmp"]').val(data['data'][0].codEmp);
            $('[name="nombre"]').val(data['data'][0].nombre);
            $('[name="fechaentrada"]').val(data['data'][0].fechaentrada);
            $('[name="fechadesde"]').val(data['data'][0].fechadesde);
            $('[name="fechahasta"]').val(data['data'][0].fechahasta);
            $('[name="horadesde"]').val(data['data'][0].horadesde);
            $('[name="horahasta"]').val(data['data'][0].horahasta);
            $('[name="cantdias"]').val(data['data'][0].cant_dias);
            $('[name="motivo"]').val(data['data'][0].motivo);
            $('[name="observacion"]').val(data['data'][0].observacion);
            if (data['data'][0].estado == '1') {
                $('[name="estado"]').val('Recepcionado');
            } else if (data['data'][0].estado == '2') {
                $('[name="estado"]').val('Controlado');
            } else if (data['data'][0].estado == '3') {
                $('[name="estado"]').val('Anulado');
            }

        },
        error: function(request, status, error) {
            /*
            $('[name="funcionario"]').val("");
            $('[name="idfuncionario"]').val("");
            $('[name="oficina"]').val("");*/
        }
    });
}


$('#idrecepcion').keydown(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    // alert(keycode + "presionado");
    if (keycode == '8' || keycode == '46') {
        getLimpieza();
        e.preventDefault();
        return false;
    }
});


function getLimpieza() {

    $('[name="codEmp"]').val("");
    $('[name="nombre"]').val("");
    $('[name="fechaentrada"]').val("");
    $('[name="fechadesde"]').val("");
    $('[name="fechahasta"]').val("");
    $('[name="horadesde"]').val("");
    $('[name="horahasta"]').val("");
    $('[name="cantdias"]').val("");
    $('[name="motivo"]').val("");
    $('[name="observacion"]').val("");
    $('[name="motivo"]').val("");
    $('[name="idrecepcion"]').val("");
    $('[name="idrecepcion"]').focus();
}