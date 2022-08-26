$('#ingreso').click(function(){
   alert('daf');
            
});/*
$("#frmAcceso").on('submit', function(e)
{
    //alert('entre');
	e.preventDefault();
	logina=$("#logina").val();
	clavea=$("#clavea").val();

    $.ajax({
                url: "../ajax/usuario.php",
                type: "POST",
                data: "op=verificar&logina="+logina+"&clavea="+clavea,
                success: function(res) {
                    alert(res);
                    if (res == 1)
                    {
                        $(location).attr("href","porcentajePuntero.php");
                    }else{
                        opcion='salir';
                        $.post("../ajax/usuario.php",
                                {"op":opcion});
                        document.getElementById("lmensaje").style.display = 'block';
                    }
                }
    });

})*/
