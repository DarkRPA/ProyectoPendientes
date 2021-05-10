<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <div>
            <h1>Bienvenido al login</h1>
            <h2>Por favor, introduzca sus datos</h2>

            @if (isset($valor) && $valor == true)
                <h3>Contraseña incorrecta</h3>
            @endif

            <form action="{{ route('auth.loguear') }}" method="post">
                @csrf
                <p>Email: <input type="email" name="email" id=""></p>
                <p>Contraseña: <input type="password" name="password" id=""></p>
                <input type="submit" value="Entrar">
            </form>
            <a href="/">Volver</a>
        </div>
    </div>
</body>
</html>
