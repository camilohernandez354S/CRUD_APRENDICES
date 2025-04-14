<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Aprendices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 d-flex align-items-center">
        <img src="img/logo-sena-verde.png" alt="Logo SENA" width="40" height="40" class="me-2">
        Listado de Aprendices
    </h2>

    <a href="index.php?page=crear" class="btn btn-success mb-3">
        <i class="fas fa-user-plus"></i> Nuevo Aprendiz
    </a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Número Documento</th>
                <th>Nombre Completo</th>
                <th>Edad</th>
                <th>Programa</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($aprendices)): ?>
            <?php foreach ($aprendices as $i => $a): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($a['num_documento']) ?></td>
                    <td>
                        <?php
                        $nombre = trim(
                            ($a['primer_nombre'] ?? '') . ' ' .
                            ($a['segundo_nombre'] ?? '') . ' ' .
                            ($a['primer_apellido'] ?? '') . ' ' .
                            ($a['segundo_apellido'] ?? '')
                        );
                        echo htmlspecialchars($nombre);
                        ?>
                    </td>
                    <td>
                        <?php
                        if (!empty($a['fecha_nacimiento'])) {
                            $nacimiento = new DateTime($a['fecha_nacimiento']);
                            $hoy = new DateTime();
                            $edad = $nacimiento->diff($hoy)->y;
                            echo $edad . ' años';
                        } else {
                            echo 'No definida';
                        }
                        ?>
                    </td>
                    <td><?= htmlspecialchars($a['programa'] ?? 'No asignado') ?></td>
                    <td>
                        <a href="index.php?page=ver&id=<?= $a['id'] ?>" class="btn btn-info btn-sm" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="index.php?page=editar&id=<?= $a['id'] ?>" class="btn btn-warning btn-sm" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="confirmarEliminacion(<?= $a['id'] ?>)" class="btn btn-danger btn-sm" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">No hay aprendices registrados.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- SweetAlert2 según acción -->
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
<script>
Swal.fire({
    icon: 'success',
    title: '¡Aprendiz registrado!',
    text: 'El aprendiz fue creado exitosamente.',
    timer: 2000,
    showConfirmButton: false
});

// Eliminar ?success=1 de la URL
if (window.history.replaceState) {
    const url = new URL(window.location);
    url.searchParams.delete('success');
    window.history.replaceState({}, document.title, url);
}
</script>
<?php endif; ?>

<?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
<script>
Swal.fire({
    icon: 'success',
    title: '¡Aprendiz actualizado!',
    text: 'Los datos del aprendiz han sido actualizados.',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php endif; ?>

<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
<script>
Swal.fire({
    icon: 'success',
    title: '¡Aprendiz eliminado!',
    text: 'El aprendiz ha sido eliminado correctamente.',
    timer: 2000,
    showConfirmButton: false
});
</script>
<?php endif; ?>

<script>
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará permanentemente al aprendiz.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'Controllers/aprendices.php?action=eliminar';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id';
            input.value = id;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

</body>
</html>
