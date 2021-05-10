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
        <h1>Presione el siguiente botón para que le enviemos un correo de confirmación</h1>
        <form action="{{ route('registro.confirmar1') }}" method="post">@csrf<input type="submit" value="Solicitar"></form>

        @if (isset($error) && $error == "confirmacionErronea")
            <h3>El codigo no es correcto.</h3>
        @endif

        @if (isset($valor) && ($valor == true))
            <h3>Bien, ahora introduzca el codigo que recibio en su correo electronico</h3>
            <form action="{{ route('registro.confirmar2') }}" method="POST">
                @csrf
                <p><input type="text" name="codigo" id=""></p>
                <input type="submit" value="Enviar">
            </form>
        @endif
    </div>
</body>
</html>
