<?php
require_once __DIR__ . '/database.php';

class Aprendices {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function existeDocumento($numeroDocumento) {
        $sql = "SELECT COUNT(*) FROM personas WHERE num_documento = :documento";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':documento', $numeroDocumento, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                    personas.id,
                    personas.num_documento,
                    personas.primer_nombre,
                    personas.segundo_nombre,
                    personas.primer_apellido,
                    personas.segundo_apellido,
                    personas.fecha_nacimiento,
                    programas.nombre AS programa_formacion
                FROM aprendices
                INNER JOIN personas ON personas.id = aprendices.persona_id
                INNER JOIN aprendiz_ficha ON aprendices.id = aprendiz_ficha.aprendiz_id
                INNER JOIN fichas ON fichas.id = aprendiz_ficha.ficha_id
                INNER JOIN programas ON programas.id = fichas.programa_id";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function obtenerPorId($id) {
        $sql = "SELECT 
                    personas.id,
                    personas.tipo_documento_id,
                    personas.genero_id,
                    personas.grupo_sanguineo_id,
                    personas.num_documento,
                    personas.primer_nombre,
                    personas.segundo_nombre,
                    personas.primer_apellido,
                    personas.segundo_apellido,
                    personas.fecha_nacimiento
                FROM aprendices
                INNER JOIN personas ON personas.id = aprendices.persona_id
                WHERE personas.id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearAprendizCompleto($data) {
        try {
            $this->conn->beginTransaction();

            // 1. personas
            $sql1 = "INSERT INTO personas (
                        tipo_documento_id, genero_id, grupo_sanguineo_id, fecha_nacimiento,
                        num_documento, primer_nombre, segundo_nombre,
                        primer_apellido, segundo_apellido
                    ) VALUES (
                        :tipo_documento_id, :genero_id, :grupo_sanguineo_id, :fecha_nacimiento,
                        :num_documento, :primer_nombre, :segundo_nombre,
                        :primer_apellido, :segundo_apellido
                    )";
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->execute([
                ':tipo_documento_id'   => $data['tipo_documento_id'],
                ':genero_id'           => $data['genero_id'],
                ':grupo_sanguineo_id'  => $data['grupo_sanguineo_id'],
                ':fecha_nacimiento'    => $data['fecha_nacimiento'],
                ':num_documento'       => $data['num_documento'],
                ':primer_nombre'       => ucwords(strtolower(trim($data['primer_nombre']))),
                ':segundo_nombre'      => ucwords(strtolower(trim($data['segundo_nombre']))),
                ':primer_apellido'     => ucwords(strtolower(trim($data['primer_apellido']))),
                ':segundo_apellido'    => ucwords(strtolower(trim($data['segundo_apellido']))),
            ]);

            $personaId = $this->conn->lastInsertId();

            // 2. aprendices
            $sql2 = "INSERT INTO aprendices (persona_id) VALUES (:persona_id)";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute([':persona_id' => $personaId]);

            $aprendizId = $this->conn->lastInsertId();

            // 3. aprendiz_ficha
            if (!isset($data['ficha_id']) || empty($data['ficha_id'])) {
                throw new Exception("Ficha de formación no seleccionada.");
            }

            $sql3 = "INSERT INTO aprendiz_ficha (aprendiz_id, ficha_id, fecha_inscripcion)
                     VALUES (:aprendiz_id, :ficha_id, CURDATE())";
            $stmt3 = $this->conn->prepare($sql3);
            $stmt3->execute([
                ':aprendiz_id' => $aprendizId,
                ':ficha_id'    => $data['ficha_id']
            ]);

            $this->conn->commit();
            return true;

        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function actualizar($id, $data) {
        $sql = "UPDATE personas SET
            tipo_documento_id = ?,
            genero_id = ?,
            grupo_sanguineo_id = ?,
            fecha_nacimiento = ?,
            num_documento = ?,
            primer_nombre = ?,
            segundo_nombre = ?,
            primer_apellido = ?,
            segundo_apellido = ?
            WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['tipo_documento_id'],
            $data['genero_id'],
            $data['grupo_sanguineo_id'],
            $data['fecha_nacimiento'],
            $data['num_documento'],
            $data['primer_nombre'],
            $data['segundo_nombre'],
            $data['primer_apellido'],
            $data['segundo_apellido'],
            $id
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM personas WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    public function obtenerTiposDocumento() {
        $stmt = $this->conn->query("SELECT * FROM tipos_documento");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerGeneros() {
        $stmt = $this->conn->query("SELECT * FROM generos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerGruposSanguineos() {
        $stmt = $this->conn->query("SELECT * FROM grupos_sanguineos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProgramas() {
        $stmt = $this->conn->query("SELECT * FROM programas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerFichas() {
        $stmt = $this->conn->query("SELECT id, numero_ficha FROM fichas ORDER BY numero_ficha ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
