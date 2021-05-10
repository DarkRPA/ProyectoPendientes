<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>
</head>
<body>
    <h1>Bien, ahora introduzca y confirme la contraseña que va a utilizar</h1>

    @if (isset($valor) && $valor = "errorPassword")
        <h1>Las contraseñas no son iguales</h1>
    @endif

    <form action="{{ route('registro.verificarContrasena') }}" method="post">
        @csrf
        <p>Contraseña: <input type="password" name="password" id="" required></p>
        <p>Confirmar contraseña: <input type="password" name="passwordConfirmar" id="" required></p>
        <input type="submit" value="Siguiente">
    </form>
</body>
</html>
