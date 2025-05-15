<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Resumen Médico</title>
        <!-- Enlace al CSS de Bootstrap desde el CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

    </head>
    <body class="bg-light p-4">

        <div class="container mt-5">
        <h1 class="mb-4 text-center">Resumen de Cotizaciones Médicas</h1>

        <!-- Buscador -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="get" class="mb-3">
                    <div class="input-group">
                        <input type="number" name="buscar" class="form-control"  id="quotationId" placeholder="ID de Cotización" required>
                        <button type="button" class="btn btn-primary me-2" id="loadTable">Buscar</button>
                        <button type="button" class="btn btn-secondary" id="clearBtn">Limpiar</button>
                    </div>
                    <div id="mensaje-error" class="text-danger" style="display: none;"></div>
                </form>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Plantilla oculta -->
                <div id="tarjeta-template" style="display: none;">
                    <div class="card mb-3 shadow-sm tarjeta-cotizacion">
                        <div class="card-body card-primary">
                            <h5 class="card-title">Cotización <span class="q-id"></span></h5>
                            <p class="card-text"><strong>Paciente:</strong> <span class="q-paciente"></span></p>
                            <p class="card-text"><strong>Identificación:</strong> <span class="q-id-paciente"></span></p>
                            <p class="card-text"><strong>Profesional:</strong> <span class="q-profesional"></span></p>
                            <p class="card-text"><strong>Fecha:</strong> <span class="q-fecha"></span></p>
                            <p class="card-text"><strong>Hora:</strong> <span class="q-hora"></span></p>
                        </div>
                    </div>
                </div>

                <!-- Contenedor donde se agregan las tarjetas -->
                <div id="tarjeta-resultado"></div>
                <div id="sin-resultados" class="alert alert-warning" style="display: none;">No se encontraron resultados</div>
            </div>
        </div>

    </br>
    </br>

        <table id="summaryTable" class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#Id Cot.</th>
                    <th>Paciente</th>
                    <th>Identificación</th>
                    <!-- <th>Estado</th> -->
                    <th>Des. Admision</th>
                    <th>Profesional</th>
                    <th>Fecha de Cita</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>ID Orden Médica</th>
                    <th>Medicamentos</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

<!-- Scripts -->
    <!-- Enlace a jQuery desde CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Enlace al JS de DataTables desde CDN -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <!-- Enlace al JS de Bootstrap desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const quotationData = <?= json_encode($data) ?>;

    $(document).ready(function () {
        showDataTable();

        $('#clearBtn').on('click', function () {
            $('#quotationId').val('');           // Limpia el input
            $('#mensaje-error').hide();          // Oculta mensaje de error si hay
            $('#tarjeta-resultado').empty().hide();  // Limpia y oculta resultados
            $('#sin-resultados').hide();         // Oculta mensaje "sin resultados"
        });

        $('#loadTable').on('click', function(e) {
            e.preventDefault(); 
            const id = $('#quotationId').val().trim();

            // Validar campo vacío o inválido
            if (id === '' || isNaN(id) || parseInt(id) <= 0) {
                $('#mensaje-error').text('Por favor ingrese un ID válido.').show();
                return; // Detener ejecución si no es válido
            }

            $('#mensaje-error').hide(); // Oculta mensaje si está bien

            $.ajax({
                url: 'index.php?controller=cotizacion&method=getData',
                method: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('#tarjeta-resultado').empty(); // Limpiar resultados anteriores

                    if (data && data.length > 0) {
                        data.forEach(function (item) {
                            // Clonar la plantilla
                            const tarjeta = $('#tarjeta-template .tarjeta-cotizacion').clone();

                            // Rellenar campos
                            tarjeta.find('.q-id').text(item.quotation_id);
                            tarjeta.find('.q-paciente').text(item.patient_first_name + ' ' + item.patient_last_name);
                            tarjeta.find('.q-id-paciente').text(item.patient_identification);
                            tarjeta.find('.q-profesional').text(item.professional_first_name + ' ' + item.professional_last_name);
                            tarjeta.find('.q-fecha').text(item.quotation_date);
                            tarjeta.find('.q-hora').text(item.appointment_start_time + ' - ' + item.appointment_end_time);

                            // Agregar al DOM
                            $('#tarjeta-resultado').append(tarjeta);
                        });

                        $('#tarjeta-resultado').show();
                        $('#sin-resultados').hide();
                    } else {
                        $('#tarjeta-resultado').hide();
                        $('#sin-resultados').show();
                    }
                },
                error: function() {
                    $('#tarjeta-resultado').hide();
                    $('#sin-resultados').show().text("Error al procesar la solicitud.");
                }
            });
        });
    });

    function showDataTable() {
        $('#summaryTable').DataTable({
            data: quotationData,
            columns: [
                { data: 'quotation_id' },
                {
                    data: null,
                    render: data => `${data.patient_name} ${data.patient_last_name}`
                },
                { data: 'patient_identification' },
                // { data: 'patient_condition' },
                { data: 'admision_flow_step_description' },
                {
                    data: null,
                    render: data => `${data.professional_name} ${data.professional_last_name}`
                },
                { data: 'appointment_date' },
                { data: 'appointment_start_time' },
                { data: 'appointment_end_time' },
                { data: 'medical_order_id' },
                { data: 'medicaments' }
            ],
            language: {
                "decimal":        "",
                "emptyTable":     "No hay datos",
                "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                "infoFiltered":   "(Filtro de _MAX_ total registros)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "search":         "Buscar:",
                "zeroRecords":    "No se encontraron coincidencias",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Ultimo",
                    "next":       "Próximo",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": Activar orden de columna ascendente",
                    "sortDescending": ": Activar orden de columna desendente"
                }
            }
        });
    }
</script>
</body>
</html>

