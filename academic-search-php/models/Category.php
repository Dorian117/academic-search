<?php
// Modelo de Categoría - Representa una categoría en la base de datos

class Category {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Obtener todas las categorías
    public function getAll() {
        $query = "SELECT * FROM categories ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Obtener una categoría por ID
    public function getById($id) {
        $query = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Crear nueva categoría
    public function create($name, $description) {
        $query = "INSERT INTO categories (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }
    
    // Actualizar categoría
    public function update($id, $name, $description) {
        $query = "UPDATE categories SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }
    
    // Eliminar categoría
    public function delete($id) {
        // Verificar que no tenga artículos asociados
        $query = "SELECT COUNT(*) as count FROM articles WHERE category_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            return false; // No se puede eliminar si tiene artículos
        }
        
        $query = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Contar artículos en una categoría
    public function countArticles($id) {
        $query = "SELECT COUNT(*) as count FROM articles WHERE category_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?>
