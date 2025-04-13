<?php
require_once 'Models/Aprendices.php';

$aprendices = new Aprendices();
$aprendiz = $aprendices->obtenerPorId($_GET['id']);

$tipos   = $aprendices->obtenerTiposDocumento();
$generos = $aprendices->obtenerGeneros();
$grupos  = $aprendices->obtenerGruposSanguineos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Aprendiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Editar Aprendiz</h2>

    <form action="Controllers/aprendices.php?action=actualizar" method="POST">
        <input type="hidden" name="id" value="<?= $aprendiz['id'] ?>">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Tipo de Documento</label>
                <select name="tipo_documento_id" class="form-control" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($tipos as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= $t['id'] == $aprendiz['tipo_documento_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Número de Documento</label>
                <input type="text" name="num_documento" class="form-control" value="<?= htmlspecialchars($aprendiz['num_documento']) ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Primer Nombre</label>
                <input type="text" name="primer_nombre" class="form-control" value="<?= htmlspecialchars($aprendiz['primer_nombre']) ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Segundo Nombre</label>
                <input type="text" name="segundo_nombre" class="form-control" value="<?= htmlspecialchars($aprendiz['segundo_nombre']) ?>">
            </div>

            <div class="col-md-6 mb-3">
                <label>Primer Apellido</label>
                <input type="text" name="primer_apellido" class="form-control" value="<?= htmlspecialchars($aprendiz['primer_apellido']) ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Segundo Apellido</label>
                <input type="text" name="segundo_apellido" class="form-control" value="<?= htmlspecialchars($aprendiz['segundo_apellido']) ?>">
            </div>

            <div class="col-md-6 mb-3">
                <label>Género</label>
                <select name="genero_id" class="form-control" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($generos as $g): ?>
                        <option value="<?= $g['id'] ?>" <?= $g['id'] == $aprendiz['genero_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($g['genero']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 mb-3">

                <label>Grupo Sanguíneo</label>
                <select name="grupo_sanguineo_id" class="form-control" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($grupos as $gs): ?>
                        <option value="<?= $gs['id'] ?>" <?= $gs['id'] == $aprendiz['grupo_sanguineo_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($gs['grupo'] . $gs['factor']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" value="<?= $aprendiz['fecha_nacimiento'] ?>" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
        <a href="index.php?page=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
