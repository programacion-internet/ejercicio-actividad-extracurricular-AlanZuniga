<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de la inscripción</title>
</head>
<body>
    <h1>Inscripción ccompletada</h1>
    <p>Bienvenido {{ $user->nombre }},</p>
    <p>Te has inscrito correctamente al evento:</p>
    
    <h2>{{ $evento->nombre }}</h2>
    <p><strong>Fecha:</strong> {{ $evento->fecha->format('d/m/Y') }}</p>
    <p><strong>Descripción:</strong> {{ $evento->descripcion }}</p>

    <p>¡Gracias por participar!</p>
</body>
</html>