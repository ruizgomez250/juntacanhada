$('#guardar').click(function(){
		fecha = 'fecha='+document.getElementById('fechaFiltro').value;
		var win = window.open('reporteporfecha.php?'+fecha, '_blank');
        // Cambiar el foco al nuevo tab (punto opcional)
        win.focus()			
	})