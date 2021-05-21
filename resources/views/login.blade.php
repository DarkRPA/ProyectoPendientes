<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Lineas para añadir bootstrap, se cuenta desde index.php -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/login.css" rel="stylesheet">
</head>
<body class="text-center">
    <main class="form-signin">
        <form action="{{ route('auth.loguear') }}" method="post">
            <h1 class="h3 mb-3 fw-normal">Vamos a iniciar sesión</h1>
            <h2 class="h3 mb-3 fw-normal">Por favor, introduzca sus datos</h2>
            @if (isset($valor) && $valor == true)
                <h3>Contraseña o usuario incorrectos</h3>
            @endif
          <div class="form-floating">
            @csrf
            <input type="email" class="form-control" id="floatingInput" placeholder="nombre@iesantoniogala.es">
            <label for="floatingInput">Correo Corporativo</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Contraseña</label>
          </div>

          <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        </form>
        <a class="btn btn-primary" href="/" role="button">Volver</a>
      </main>

    <!-- lineas para script se añaden al final y tambien se cuentan desde index.php -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
