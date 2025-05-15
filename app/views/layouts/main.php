<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi App MVC</title>
    <link href="/assets/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h1 class="text-primary">¡Hola desde MVC!</h1>
        <button id="boton" class="btn btn-success">Haz clic</button>
    </div>

    <script src="/assets/jquery.min.js"></script>
    <script>
        $('#boton').on('click', function() {
            alert('¡Has hecho clic!');
        });
    </script>
</body>
</html>
