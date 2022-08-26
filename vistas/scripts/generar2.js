function getModal(){ 
  getMes2();
  getAnho2();
  $("#generadorpdfModalPersonal").modal({backdrop: 'static', keyboard: false});

}

function getMes2(){
    $("#inputMes3").empty();
    getData("SELECT va.id, l.mesciclo nombre FROM `venta_agua` va inner join lectura l on l.id = va.idlectura where l.mesciclo <> 0  group by l.mesciclo  order by l.mesciclo asc;","#inputMes3");
}


function getAnho2(){
    $("#inputAnho3").empty();
    getData("SELECT va.id, l.anhociclo nombre FROM `venta_agua` va inner join lectura l on l.id = va.idlectura  where l.anhociclo <> 0    group by l.anhociclo     order by l.anhociclo asc ","#inputAnho3");
}


const btnCERRAR = document.getElementById("btncerrar");
btnCERRAR.addEventListener("click", () => {
  window.close(); 
});

const btnPDF = document.getElementById("generarpdf2");
btnPDF.addEventListener("click", () => {
  getPdf();
});


function getData(var_query, var_sele) {
  $.ajax({
    type: "POST",
    url: "../controllers/generar.php?op=llenarcombo",
    dataType: "json",
    data: { sql: var_query },
    success: function (data) {
      $(var_sele).append("<option value=''>Seleccionar</option>");
      $.each(data, function (key, registro) {
        $(var_sele).append(
          "<option value=" + registro.id + ">" + registro.nombre + "</option>"
        );
      });
    },
    error: function (data) {
      alert("error");
    },
  });
}

function abrirNuevoTab(url) {
  // Abrir nuevo tab
  var win = window.open(url, "_blank");
  // Cambiar el foco al nuevo tab (punto opcional)
  win.focus();
}



function getPdf(){
  var id = document.getElementById("inputId3").value;
    var mes = document.getElementById("inputMes3").value;
    var anho = document.getElementById("inputAnho3").value;
    abrirNuevoTab('pdfpersonal.php?mes='+mes+'&anho='+anho+'&id='+id);
    window.close(); 
}

