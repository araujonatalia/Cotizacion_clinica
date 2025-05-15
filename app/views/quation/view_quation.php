
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Cotizaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <input type="number" id="quotationId" placeholder="ID de Cotización">
    <button id="loadTable" class="btn btn-primary">Buscar</button>

    <table id="quotationTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID Cotización</th>
                <th>Paciente</th>
                <th>Identificación</th>
                <th>Profesional</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Fecha Cotización</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        let table;

        $('#loadTable').on('click', function () {
            const id = $('#quotationId').val();
            if (!id) return alert('Por favor ingresa un ID válido');

            if ($.fn.DataTable.isDataTable('#quotationTable')) {
                table.destroy();
                $('#quotationTable tbody').empty(); // limpia contenido anterior
            }
           
            table = $('#quotationTable').DataTable({
                ajax: {
                    url: `index.php?controller=cotizacion&method=getData&id=${id}`,
                    dataSrc: '',
                    error: function (xhr, status, error) {
                        console.log("Error en la petición:", xhr.responseText);
                        alert("Error al cargar datos.");
                    }
                },
                columns: [
                    { data: 'quotation_id' },
                    { data: null, render: data => `${data.patient_first_name} ${data.patient_last_name}` },
                    { data: 'patient_identification' },
                    { data: null, render: data => `${data.professional_first_name} ${data.professional_last_name}` },
                    { data: 'appointment_start_time' },
                    { data: 'appointment_end_time' },
                    { data: 'quotation_date' }
                ]
            });
        });

    </script>
</body>
</html>
