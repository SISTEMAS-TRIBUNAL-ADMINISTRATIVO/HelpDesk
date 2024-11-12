<!DOCTYPE html>
<html>
<head>
	<title>Bootstrap star rating example</title>
	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
</head>
<body>

    <div class="container">
        <section class="row">
            <div class="col-md-12">
                <h1 class="text-center">Formato de Encuesta de Satisfaccion.</h1>
            </div>
        </section>
        <hr><br />
        <section class="row">
            <section class="col-md-12">
                <h3>Datos basicos</h3>
                <p></p>
            </section>
        </section>
        <section class="row">
            <section class="col-md-12">
                <section class="row">
                    <div class="col-md-4">
                        <label for="tipoAtencion">Tipo de Atencion: *</label>
                        <select class="form-control" id="tipoAtencion">
                            <option value="ce">Consulta Externa</option>
                            <option value="farm">Farmacia</option>
                            <option value="fisi">Fisioterapia</option>
                            <option value="fo">Fo</option>
                            <option value="hosp">Hospitalizació</option>
                            <option value="odon">Odontologia</option>
                            <option value="pyp">Promoción y Prevención</option>
                            <option value="rx">Rayos X</option>
                            <option value="urge">Urgencias</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fechaActual">Fecha Actual: *</label>
                            <input type="date" class="form-control" id="fechaActual" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fechaActencion">Fecha Atencion: *</label>
                            <input type="date" class="form-control" id="fechaAtencion" required>
                        </div>
                    </div>
                </section>
                <section class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="nombreCompleto">Nombre Completo: *</label>
                            <input type="text" class="form-control" id="nombreCompleto" maxlength="128" placeholder="Nombre Completo" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <label for="edadEncuestado">Edad: *</label>
                            <input type="number" class="form-control" id="edadEncuestado" placeholder="Edad" maxlength="3" required />
                        </div>
                    </div>
                </section>
                <section class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="idIdentificacion">Identificacion: *</label>
                            <input type="number" id="idIdentificacion" class="form-control" placeholder="Numero de Identificacion" maxlength="15" required />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="telefono">Telefono: *</label>
                        <input type="text" class="form-control" id="telefono" placeholder="Numero Telefonico" maxlength="12" required />
                    </div>
                    <div class="col-md-4">
                        <label for="epsPaciente">EPS: *</label>
                        <input type="text" class="form-control" id="epsPaciente" placeholder "EPS del Paciente" required />
                    </div>
                </section>
            </section>
        </section>
        <hr />

        <section class="row">
            <div class="col-md-12 text-center">
                <input id="input-3" name="input-3" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="0">
            </div>
        </section>


        <!--  Comentarios  -->
        <section class="row">
            <div class="col-md-12">
                <h3>Comentarios.</h3>
                <p></p>
            </div>
        </section>
        <section class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="comment">Comentarios:</label>
                    <textarea class="form-control" rows="6" id="comentarios"></textarea>
                </div>
            </div>
        </section>

        <section class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-info" id="saveForm" onclick="saveForm">Guardar Encuesta</button>
            </div>
        </section>
    </div>

<script>
    $("#input-3").rating({ 
        showCaption: false
    });


    $('#input-3').on('rating.change', function() {
        console.log($('#input-3').val());
    });
</script>
</body>
</html>