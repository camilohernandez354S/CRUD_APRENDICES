<?php
require_once 'Models/database.php';
require_once 'Models/Aprendices.php';

$page = $_GET['page'] ?? 'index';
$aprendicesModel = new Aprendices();

switch ($page) {
    case 'crear':
        $db = new Database();
        $conn = $db->getConnection();

        $stmtProgramas = $conn->query("SELECT id, nombre FROM programas ORDER BY nombre ASC");
        $programas = $stmtProgramas->fetchAll(PDO::FETCH_ASSOC);

        $stmtTD = $conn->query("SELECT id, nombre FROM tipos_documento");
        $tiposDocumento = $stmtTD->fetchAll(PDO::FETCH_ASSOC);

        $stmtFichas = $conn->query("SELECT id, numero_ficha FROM fichas ORDER BY numero_ficha ASC");
        $fichas = $stmtFichas->fetchAll(PDO::FETCH_ASSOC);

        $stmtGen = $conn->query("SELECT id, genero FROM generos");
        $generos = $stmtGen->fetchAll(PDO::FETCH_ASSOC);

        $stmtGS = $conn->query("SELECT id, grupo, factor FROM grupos_sanguineos");
        $gruposSanguineos = $stmtGS->fetchAll(PDO::FETCH_ASSOC);

        include 'Views/Crear.php';
        break;

    case 'editar':
        include 'Views/Editar.php';
        break;

    case 'ver':
        include 'Views/ver.php';
        break;

    case 'index':
    default:
        $aprendices = $aprendicesModel->obtenerTodos();
        include 'Views/index.php';
        break;
}
