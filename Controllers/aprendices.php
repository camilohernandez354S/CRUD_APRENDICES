<?php
require_once '../Models/Aprendices.php';

$aprendices = new Aprendices();
$action = $_GET['action'] ?? null;

switch ($action) {
    case 'crear':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $errores = [];

            if (!ctype_digit($data['num_documento'])) {
                $errores[] = 'El número de documento debe contener solo números.';
            }

            // Validar ficha obligatoria
            if (empty($data['ficha_id'])) {
                $errores[] = 'Debe seleccionar una ficha de formación.';
            }

            // Normalización de datos
            $data['primer_nombre']     = ucwords(strtolower(trim($data['primer_nombre'])));
            $data['segundo_nombre']    = ucwords(strtolower(trim($data['segundo_nombre'])));
            $data['primer_apellido']   = ucwords(strtolower(trim($data['primer_apellido'])));
            $data['segundo_apellido']  = ucwords(strtolower(trim($data['segundo_apellido'])));

            if ($aprendices->existeDocumento($data['num_documento'])) {
                $errores[] = 'Ya existe un aprendiz con este número de documento.';
            }

            if (!empty($errores)) {
                $queryString = http_build_query(['page' => 'crear', 'error' => implode('|', $errores)]);
                header("Location: ../index.php?$queryString");
                exit;
            }

            $aprendices->crearAprendizCompleto($data);
            header('Location: ../index.php?page=index&success=1');
            exit;
        }
        break;

    case 'actualizar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $data = $_POST;
            $aprendices->actualizar($id, $data);
            header('Location: ../index.php?page=index&updated=1');
            exit;
        }
        break;

    case 'eliminar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $aprendices->eliminar($id);
            }
            header('Location: ../index.php?page=index&deleted=1');
            exit;
        }
        break;

    default:
        header('Location: ../index.php?page=index');
        exit;
}
