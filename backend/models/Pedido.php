<?php
require_once 'inc/Singleton.php';

class Pedido {
    private $pdo;

    public function __construct() {
        $this->pdo = Singleton::getInstance()->getPDO();
    }

    // Obtener todos los pedidos
    public function obtenerPedidos() {
        try {
            // Consulta para obtener todos los pedidos
            $stmt = $this->pdo->prepare("SELECT id, alumno_mac, bocadillo_nombre, fecha, hora, retirado FROM pedidos");
            $stmt->execute();
            
            // Obtener todos los resultados
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Verificar si hay pedidos
            if (count($pedidos) > 0) {
                // Si hay pedidos, devolverlos en formato JSON
                echo json_encode([
                    'success' => true,
                    'pedidos' => $pedidos
                ]);
            } else {
                // Si no hay pedidos, devolver un mensaje adecuado
                echo json_encode([
                    'success' => false,
                    'message' => 'No hay pedidos disponibles'
                ]);
            }
        } catch (PDOException $e) {
            // Si hay un error en la base de datos, devolver el error
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    

    // Actualizar el estado de un pedido
    public function actualizarEstado($id, $estado) {
        $stmt = $this->pdo->prepare("UPDATE pedidos SET retirado = :retirado WHERE id = :id");
        return $stmt->execute([':estado' => $estado, ':id' => $id]);
    }
}
