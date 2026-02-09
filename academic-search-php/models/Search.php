<?php
// Modelo de Búsqueda - Registra el historial de búsquedas

class Search {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Registrar una búsqueda
    public function log($query, $type, $count) {
        $sql = "INSERT INTO searches (search_query, search_type, results_count) 
                VALUES (:query, :type, :count)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':query', $query);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':count', $count);
        
        return $stmt->execute();
    }
    
    // Obtener historial de búsquedas
    public function getHistory($limit = 20) {
        $sql = "SELECT * FROM searches ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
