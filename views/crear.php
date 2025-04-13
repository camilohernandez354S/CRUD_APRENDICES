<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Aprendiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 d-flex align-items-center">
        <img src="img/logo-sena-verde.png" alt="Logo SENA" width="40" height="40" class="me-2">
        Registrar Aprendiz
    </h2>

    <form action="Controllers/aprendices.php?action=crear" method="POST">
        <div class="row">
            
            <!-- Tipo de documento -->
            <div class="col-md-6 mb-3">
                <label>Tipo de Documento</label>
                <select name="tipo_documento_id" class="form-control" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($tiposDocumento as $td): ?>
                        <option value="<?= $td['id'] ?>"><?= htmlspecialchars($td['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Número de documento -->
            <div class="col-md-6 mb-3">
                <label>Número de Documento</label>
                <input type="text" name="num_documento" class="form-control" pattern="\d+" required>
            </div>

            <!-- Primer y segundo nombre -->
            <div class="col-md-6 mb-3">
                <label>Primer Nombre</label>
                <input type="text" name="primer_nombre" class="form-control text-capitalize" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Segundo Nombre</label>
                <input type="text" name="segundo_nombre" class="form-control text-capitalize">
            </div>

            <!-- Apellidos -->
            <div class="col-md-6 mb-3">
                <label>Primer Apellido</label>
                <input type="text" name="primer_apellido" class="form-control text-capitalize" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Segundo Apellido</label>
                <input type="text" name="segundo_apellido" class="form-control text-capitalize">
            </div>

            <!-- Género -->
            <div class="col-md-6 mb-3">
                <label>Género</label>
                <select name="genero_id" class="form-control" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($generos as $g): ?>
                        <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['genero']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Grupo sanguíneo -->
            <div class="col-md-6 mb-3">
                <label>Grupo Sanguíneo</label>
                <select name="grupo_sanguineo_id" class="form-control" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($gruposSanguineos as $gs): ?>
                        <option value="<?= $gs['id'] ?>">
                            <?= htmlspecialchars($gs['grupo'] . $gs['factor'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Fecha nacimiento -->
            <div class="col-md-6 mb-3">
                <label>Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-control" required>
            </div>

            <!-- Ficha de formación -->
            <div class="col-md-6 mb-3">
                <label>Ficha de Formación</label>
                <select name="ficha_id" class="form-control" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($fichas as $ficha): ?>
                        <option value="<?= $ficha['id'] ?>"><?= htmlspecialchars($ficha['numero_ficha']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-start gap-2 mt-4">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="index.php?page=index" class="btn btn-secondary btn-sm">
                Volver
            </a>
        </div>
    </form>
</div>

<?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
<script>
Swal.fire({
    title: '¡Registrado!',
    text: 'El aprendiz fue creado correctamente.',
    icon: 'success',
    confirmButtonText: 'OK'
});
</script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'documento_duplicado'): ?>
<script>
Swal.fire({
    icon: 'error',
    title: '¡Documento ya registrado!',
    text: 'Ya existe un aprendiz con este número de documento.',
    confirmButtonText: 'Aceptar'
});
</script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] !== 'documento_duplicado'): ?>
<?php $mensajes = explode('|', $_GET['error']); ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Error al registrar aprendiz',
    html: `<ul style="text-align: left;">
        <?php foreach ($mensajes as $msg): ?>
            <li><?= htmlspecialchars($msg) ?></li>
        <?php endforeach; ?>
    </ul>`,
    confirmButtonText: 'Corregir'
});
</script>
<?php endif; ?>

</body>
</html>
