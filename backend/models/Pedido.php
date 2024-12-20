<?php
class Pedido {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

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

    public function marcarRetirado($id) {
        try {
            $sql = "UPDATE pedidos SET retirado = 1 WHERE id = ?";
            echo $sql;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return ['success' => true, 'message' => 'Pedido marcado como retirado.'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al marcar el pedido como retirado: ' . $e->getMessage()];
        }
    }

    public function quitarRetirado($id) {
        try {
            $sql = "UPDATE pedidos SET retirado = 0 WHERE id = ?";
            echo $sql;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return ['success' => true, 'message' => 'Pedido marcado como retirado.'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al marcar el pedido como retirado: ' . $e->getMessage()];
        }
    }
}
?>
