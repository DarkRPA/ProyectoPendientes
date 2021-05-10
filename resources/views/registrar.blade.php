<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>
</head>
<body>
    <div>
        <h1>Bienvenido al asistente de registro. Primero indique su correo electronico.</h1>
        @if (isset($valor) && $valor == "errorCorreo")
            <div><p>El correo electronico no es valido, debe de tener un correo corporativo</p></div>
        @endif
        <form action="{{ route('registro.verificarCorreo') }}" method="post">
            @csrf
            <p><input type="email" name="email" id="" placeholder="Introduzca su email" required></p>
            <input type="submit" value="Siguiente">
        </form>
    </div>
</body>
</html>
