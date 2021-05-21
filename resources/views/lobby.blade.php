<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aplicacion pendientes</title>
    <!-- Lineas para añadir bootstrap, se cuenta desde index.php -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Bienvenido a la aplicacion de seguimiento de materias pendientes</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>¿Que deseas hacer?</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-7">
                <a class="btn btn-primary" href="/login" role="button">Iniciar Sesion</a>
            </div>
            <div class="col-2">
                <a class="btn btn-primary" href="/registrar" role="button">Registrar una cuenta</a>
            </div>
        </div>
    @if (isset($tieneSesion) && $tieneSesion === true)
        <a href="/home">Home</a>
    @endif

    <!-- lineas para script se añaden al final y tambien se cuentan desde index.php -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
