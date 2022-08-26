<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../vistas/bootstrap/css/bootstrap.min.css">
    <script src="../vistas/jquery/jquery-3.3.1.min.js"></script>
    <script src="../vistas/bootstrap/js/bootstrap.min.js"></script>
    <title>Pdf</title>
</head>

<body onload="getModal()">

    <!-- Modal -->
    <div class="modal fade" id="generadorpdfModalPersonal" name="generadorpdfModalPersonal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ciclo</h5>
                </div>
                <div class="modal-body">
                    <form id="formModal" name="formModal">
                        <div class="row" style="margin-left: 5%; margin-right: 5%;">
                        <input type="hidden" id="inputId3" value="<?php echo $_GET['id'] ?>">
                            <div class="col-md-6">
                                <label for="inputMes2">Mes</label>

                                <select class="custom-select d-block w-100 form-control" name="inputMes3" id="inputMes3">

                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="inputAnho2">Año</label>
                                <select class="custom-select d-block w-100 form-control" name="inputAnho3" id="inputAnho3">

                                </select>
                            </div>

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btncerrar">Cerrar</button>
                    <button type="button" id="generarpdf2" name="generarpdf2" class="btn btn-primary">Generar Pdf</button>
                </div>
            </div>
        </div>
    </div>
    <script src="scripts/generar2.js"></script>
</body>

</html>