var tabla;

init();

//funcion que se ejecuta al inicio
function init() {
  //alert("La resolución de tu pantalla es: " + screen.width + " x " + screen.height);

  listar();
}

//función suma dias a la fecha seleccionada
function sumarDias(fecha, dias) {
  fecha.setDate(fecha.getDate() + dias);
  return fecha;
}

//función formato de fecha 'yyyy-mm-dd'
function formatDate(date) {
  var d = new Date(date),
    month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();

  if (month.length < 2) month = "0" + month;
  if (day.length < 2) day = "0" + day;
  return [year, month, day].join("-");
}

//acción fecha desde evento change
const fechaDesde = document.getElementById("inputInicio");
fechaDesde.addEventListener("change", () => {
  var d = new Date(fechaDesde.value);
  dd = sumarDias(d, 30);
  fechaHasta.value = formatDate(dd);
});

//acción fecha hasta evento change
const fechaHasta = document.getElementById("inputFin");
fechaHasta.addEventListener("change", () => {
  if (
    fechaDesde.value == "" ||
    Comparar(fechaHasta.value) < Comparar(fechaDesde.value)
  ) {
    fechaDesde.value = fechaHasta.value;
  }
});

//acción fecha Vencimiento evento change
const fechaVen = document.getElementById("inputVencimiento");
fechaVen.addEventListener("change", () => {
  /*    if (
        fechaVen.value == "" ||
        Comparar(fechaVen.value) < Comparar(fechaHasta.value)
    ) {
        fechaVen.value = fechaHasta.value;
    }*/
});

//acción fecha Emisión evento change
const fechaEmision = document.getElementById("inputEmision");
fechaEmision.addEventListener("change", () => {
  let date = new Date();
  // console.log(date.toISOString().split('T')[0]);
  /*  if (
        fechaEmision.value == "" ||
        Comparar(fechaEmision.value) < Comparar(fechaHasta.value)
    ) {
        fechaVen.value = fechaHasta.value;
    }*/
});

function Comparar(fecha) {
  const f = new Date(fecha);
  var y = f.getYear();
  var m = f.getMonth();
  var d = f.getDay();
  var f1 = new Date(y, m, d);
  return f1;
}


function getMes(){
    $("#inputMes").empty();
    getData("SELECT `mesciclo`nombre,`id` FROM `lectura` where mesciclo <> 0 group by `mesciclo` asc;","#inputMes");
}


function getAnho(){
    $("#inputAnho").empty();
    getData("SELECT `anhociclo` nombre,`id` FROM `lectura` where `anhociclo` <> 0 group by `anhociclo` asc;","#inputAnho");
}

function getMes2(){
    $("#inputMes2").empty();
    getData("SELECT va.id, l.mesciclo nombre FROM `venta_agua` va inner join lectura l on l.id = va.idlectura where l.mesciclo <> 0  group by l.mesciclo  order by l.mesciclo asc;","#inputMes2");
}


function getAnho2(){
    $("#inputAnho2").empty();
    getData("SELECT va.id, l.anhociclo nombre FROM `venta_agua` va inner join lectura l on l.id = va.idlectura  where l.anhociclo <> 0    group by l.anhociclo     order by l.anhociclo asc ","#inputAnho2");
}

const btnCli = document.getElementById("generador");
btnCli.addEventListener("click", () => {

  $("#generadorModal").modal();
  getMes();
  getAnho();
});

const btnPDF = document.getElementById("generador2");
btnPDF.addEventListener("click", () => {
    getMes2();
    getAnho2();
    $("#generadorpdfModal").modal();
});

//funcion listar
function listar() {
  switch (screen.height) {
    case 1080:
      alto = 17;
      break;
    default:
      alto = 9;
      //Declaraciones ejecutadas cuando ninguno de los valores coincide con el valor de la expresión
      break;
  }

  tabla = $("#tbllistado")
    .dataTable({
      responsive: true,
      aProcessing: true, //activamos el procedimiento del datatable
      aServerSide: true, //paginacion y filrado realizados por el server
      dom: "Bfrtip", //definimos los elementos del control de la tabla
      buttons: ["pdf"],
      ajax: {
        url: "../controllers/generar.php?op=listar",
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: alto, //paginacion
      order: [[0, "asc"]], //ordenar (columna, orden)
    })
    .DataTable();
}

const generarExt = document.getElementById("generardoc");
generarExt.addEventListener("click", () => {
  // alert('listo');
  $("#generadorModal").modal("hide");  
  guardar();
});


const generarPDF = document.getElementById("generarpdf");
generarPDF.addEventListener("click", () => {
  // alert('listo');
  $("#generadorpdfModal").modal("hide");  
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

//funcion para guardaryeditar
function guardar() {
  resetear();
  timer();
  $("#loadingModal").modal("show");
  $("#content").html(
    '<div class="loading"><div class="alert alert-primary" role="alert"><img src="images/loader.gif"/><br/>Procesando, por favor espere...</div></div>'
  );

  var formData = new FormData();
  formData.append("inicio", document.getElementById("inputInicio").value);
  formData.append("cierre", document.getElementById("inputFin").value);
  formData.append("vencimiento",document.getElementById("inputVencimiento").value);
  formData.append("emision", document.getElementById("inputEmision").value);
  formData.append("mes",document.getElementById("inputMes").value);
  formData.append("anho", document.getElementById("inputAnho").value);
  
  $.ajax({
    url: "../controllers/generar.php?op=crearextracto",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (datos) {
      $("#loadingModal").modal("hide");
       alert(datos);
       console.log(datos);
     
      stocktime();
    },
  });

  //limpiar();
}


function getPdf(){
    var mes = document.getElementById("inputMes2").value;
    var anho = document.getElementById("inputAnho2").value;
    abrirNuevoTab('pdfgeneral.php?mes='+mes+'&anho='+anho);
}


var h1 = document.getElementsByTagName("h1")[0];
var sec = 0;
var min = 0;
var hrs = 0;
var t;

function tick() {
  sec++;
  if (sec >= 60) {
    sec = 0;
    min++;
    if (min >= 60) {
      min = 0;
      hrs++;
    }
  }
}
function add() {
  tick();
  h1.textContent =
    (hrs > 9 ? hrs : "0" + hrs) +
    ":" +
    (min > 9 ? min : "0" + min) +
    ":" +
    (sec > 9 ? sec : "0" + sec);
  timer();
}
function timer() {
  t = setTimeout(add, 1000);
}

function stocktime() {
  clearTimeout(t);
}
function resetear() {
  h1.textContent = "00:00:00";
  seconds = 0;
  minutes = 0;
  hours = 0;
}
