<?php
class Pedido {
    private $pdo;

    // Constructor, recibe una instancia de PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para obtener todos los pedidos
    public function obtenerTodos() {
        try {
            $sql = "SELECT id, alumno_mac, bocadillo_nombre, fecha, hora, retirado FROM pedidos ORDER BY fecha DESC, hora ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al obtener los pedidos: ' . $e->getMessage()];
        }
    }

    // Método para marcar un pedido como retirado
    public function marcarRetirado($id) {
        try {
            $sql = "UPDATE pedidos SET retirado = 1 WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return ['success' => true, 'message' => 'Pedido marcado como retirado.'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al marcar el pedido como retirado: ' . $e->getMessage()];
        }
    }
}
?>
