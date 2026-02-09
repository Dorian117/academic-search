<?php
// Modelo de Artículo - Representa un artículo académico en la base de datos

class Article {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Obtener todos los artículos con información de categoría
    public function getAll() {
        $query = "SELECT a.*, c.name as category_name 
                  FROM articles a 
                  LEFT JOIN categories c ON a.category_id = c.id 
                  ORDER BY a.publication_year DESC, a.title";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Obtener un artículo por ID
    public function getById($id) {
        $query = "SELECT a.*, c.name as category_name 
                  FROM articles a 
                  LEFT JOIN categories c ON a.category_id = c.id 
                  WHERE a.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Crear nuevo artículo
    public function create($data) {
        $query = "INSERT INTO articles (title, authors, publication_year, source, abstract, keywords, category_id) 
                  VALUES (:title, :authors, :year, :source, :abstract, :keywords, :category_id)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':authors', $data['authors']);
        $stmt->bindParam(':year', $data['publication_year']);
        $stmt->bindParam(':source', $data['source']);
        $stmt->bindParam(':abstract', $data['abstract']);
        $stmt->bindParam(':keywords', $data['keywords']);
        $stmt->bindParam(':category_id', $data['category_id']);
        
        return $stmt->execute();
    }
    
    // Actualizar artículo
    public function update($id, $data) {
        $query = "UPDATE articles 
                  SET title = :title, authors = :authors, publication_year = :year, 
                      source = :source, abstract = :abstract, keywords = :keywords, 
                      category_id = :category_id 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':authors', $data['authors']);
        $stmt->bindParam(':year', $data['publication_year']);
        $stmt->bindParam(':source', $data['source']);
        $stmt->bindParam(':abstract', $data['abstract']);
        $stmt->bindParam(':keywords', $data['keywords']);
        $stmt->bindParam(':category_id', $data['category_id']);
        
        return $stmt->execute();
    }
    
    // Eliminar artículo
    public function delete($id) {
        $query = "DELETE FROM articles WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Búsqueda simple
    public function searchSimple($term) {
        $searchTerm = "%$term%";
        $query = "SELECT a.*, c.name as category_name 
                  FROM articles a 
                  LEFT JOIN categories c ON a.category_id = c.id 
                  WHERE a.title LIKE :term 
                     OR a.authors LIKE :term 
                     OR a.abstract LIKE :term 
                     OR a.keywords LIKE :term 
                  ORDER BY a.publication_year DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':term', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Búsqueda avanzada
    public function searchAdvanced($filters) {
        $query = "SELECT a.*, c.name as category_name 
                  FROM articles a 
                  LEFT JOIN categories c ON a.category_id = c.id 
                  WHERE 1=1";
        
        $params = [];
        
        if (!empty($filters['query'])) {
            $query .= " AND (a.title LIKE :query 
                        OR a.authors LIKE :query 
                        OR a.abstract LIKE :query 
                        OR a.keywords LIKE :query)";
            $params[':query'] = "%" . $filters['query'] . "%";
        }
        
        if (!empty($filters['year'])) {
            $query .= " AND a.publication_year = :year";
            $params[':year'] = $filters['year'];
        }
        
        if (!empty($filters['category_id'])) {
            $query .= " AND a.category_id = :category_id";
            $params[':category_id'] = $filters['category_id'];
        }
        
        if (!empty($filters['source'])) {
            $query .= " AND a.source LIKE :source";
            $params[':source'] = "%" . $filters['source'] . "%";
        }
        
        $query .= " ORDER BY a.publication_year DESC";
        
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Búsqueda booleana
    public function searchBoolean($query) {
        $query = strtoupper($query);
        
        // Búsqueda con AND
        if (strpos($query, ' AND ') !== false) {
            $terms = explode(' AND ', $query);
            $sql = "SELECT a.*, c.name as category_name 
                    FROM articles a 
                    LEFT JOIN categories c ON a.category_id = c.id 
                    WHERE 1=1";
            
            foreach ($terms as $index => $term) {
                $term = trim($term);
                $sql .= " AND (a.title LIKE :term$index 
                         OR a.abstract LIKE :term$index 
                         OR a.keywords LIKE :term$index)";
            }
            
            $stmt = $this->conn->prepare($sql);
            foreach ($terms as $index => $term) {
                $term = trim($term);
                $stmt->bindValue(":term$index", "%$term%");
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        // Búsqueda con OR
        if (strpos($query, ' OR ') !== false) {
            $terms = explode(' OR ', $query);
            $sql = "SELECT a.*, c.name as category_name 
                    FROM articles a 
                    LEFT JOIN categories c ON a.category_id = c.id 
                    WHERE ";
            
            $conditions = [];
            foreach ($terms as $index => $term) {
                $conditions[] = "(a.title LIKE :term$index 
                                OR a.abstract LIKE :term$index 
                                OR a.keywords LIKE :term$index)";
            }
            
            $sql .= implode(' OR ', $conditions);
            
            $stmt = $this->conn->prepare($sql);
            foreach ($terms as $index => $term) {
                $term = trim($term);
                $stmt->bindValue(":term$index", "%$term%");
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        // Si no hay operadores, búsqueda simple
        return $this->searchSimple($query);
    }
}
?>
