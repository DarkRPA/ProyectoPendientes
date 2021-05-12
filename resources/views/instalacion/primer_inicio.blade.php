<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Instalacion</title>
</head>
<body>
    {{-- Esta pestaña se deberá de cambiar a un mejor diseño pero esta será la pantalla que nos permitirá importar los datos --}}
    <div class="texto">
        <h1>Bienvenido.</h1>
        <h4>Parece que nunca has instalado la aplicacion, importa los datos que te pedimos</h4>
        <form action="{{ route('instalador.verificacion') }}" method="post" enctype="multipart/form-data">
            @csrf
            <p>Introduzca el archivo CSV con los alumnos.<input type="file" name="csvAlumnos" id="" accept=".csv"></p>
            <p>Introduzca el archivo CSV con los cursos<input type="file" name="csvCursos" id="" accept=".csv" required></p>
            <p>Introduzca el archivo CSV con las asignaturas<input type="file" name="csvAsignaturas" id="" accept=".csv"></p>
            <p>No tenemos maestros por lo que lo dejamos sin pedir todavia</p>
            <input type="submit" value="Instalar">
        </form>
    </div>
</body>
</html>
