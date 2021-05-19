<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aplicacion pendientes</title>
</head>
<body>



    <h1>Bienvenido a la aplicacion pendientes</h1>
    <h2>Que desea hacer?</h2>
    <a href="/login">Iniciar Sesion</a>
    <a href="/registrar">Registrar</a>
    @if (isset($tieneSesion) && $tieneSesion === true)
        <a href="/home">Home</a>
    @endif
</body>
</html>
