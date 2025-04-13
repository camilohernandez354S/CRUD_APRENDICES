<?php
require_once 'Models/Aprendices.php';
$aprendices = new Aprendices();
$aprendiz = $aprendices->obtenerPorId($_GET['id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Aprendiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Detalle del Aprendiz</h2>

    <?php if ($aprendiz): ?>
        <ul class="list-group">
            <li class="list-group-item"><strong>Documento:</strong> <?= $aprendiz['num_documento'] ?></li>
            <li class="list-group-item"><strong>Nombre:</strong> <?= $aprendiz['primer_nombre'] . ' ' . $aprendiz['segundo_nombre'] ?></li>
            <li class="list-group-item"><strong>Apellidos:</strong> <?= $aprendiz['primer_apellido'] . ' ' . $aprendiz['segundo_apellido'] ?></li>
            <li class="list-group-item"><strong>Fecha de Nacimiento:</strong> <?= $aprendiz['fecha_nacimiento'] ?></li>
        </ul>
    <?php else: ?>
        <div class="alert alert-warning mt-3">Aprendiz no encontrado.</div>
    <?php endif; ?>

    <a href="index.php?page=index" class="btn btn-secondary mt-3">Volver</a>
</div>
</body>
</html>
