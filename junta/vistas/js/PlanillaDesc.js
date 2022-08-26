
$('#guardar').click(function() {
    fechaDesde = 'fechadesde=' + document.getElementById('fechaDesde').value;
    fechaHasta = '&fechahasta=' + document.getElementById('fechaHasta').value;
    var win = window.open('descuentooptimizado.php?' + fechaDesde + fechaHasta, '_blank');
    // Cambiar el foco al nuevo tab (punto opcional)
    win.focus()
})


