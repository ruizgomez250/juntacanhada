var verNomb=false;
	verAp = false;

	

var nombre = document.getElementById('nombre');
	nombre.onblur = function (k) {
			nomb = document.getElementById('nombre').value;
			if(nomb.length == 0){
				document.getElementById("nombremensaje").style.display = 'block';
				
				verNomb=false;
			}else{

				
				document.getElementById("nombremensaje").style.display = 'none';
				verNomb=true;
				verificar();
				
			}
		}

	
var apellido = document.getElementById('apellido');
	 apellido.onblur = function (p) {
		 apell = document.getElementById('apellido').value;
			if(apell.length == 0){
				document.getElementById("apellidomensaje").style.display = 'block';	
				verAp = false;
				verificar();
			}else{
				document.getElementById("apellidomensaje").style.display = 'none';
				verAp = true;
				verificar();
			}
	 	
	 }

function verificar(){
	if(verNomb && verAp)	{
		document.getElementById("guardar").disabled=false;
	}else{
		document.getElementById("guardar").disabled=true;
	}
}