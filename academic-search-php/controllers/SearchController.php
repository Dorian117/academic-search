<?php
// Controlador Principal, maneja la página de inicio y búsquedas

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Search.php';

$db = getConnection();
$articleModel = new Article($db);
$categoryModel = new Category($db);
$searchModel = new Search($db);

// Obtener categorías para los filtros
$categories = $categoryModel->getAll();

// Variables para resultados
$articles = null;
$searchQuery = '';
$searchType = '';
$resultsCount = 0;

// Procesar búsquedas
if (isset($_GET['action'])) {
    
    // Búsqueda simple
    if ($_GET['action'] == 'search_simple' && !empty($_GET['query'])) {
        $searchQuery = htmlspecialchars($_GET['query']);
        $searchType = 'simple';
        $articles = $articleModel->searchSimple($searchQuery);
        $resultsCount = count($articles);
        $searchModel->log($searchQuery, $searchType, $resultsCount);
    }
    
    // Búsqueda avanzada
    if ($_GET['action'] == 'search_advanced') {
        $filters = [
            'query' => $_GET['query'] ?? '',
            'year' => $_GET['year'] ?? '',
            'category_id' => $_GET['category_id'] ?? '',
            'source' => $_GET['source'] ?? ''
        ];
        
        $searchQuery = 'Búsqueda Avanzada';
        $searchType = 'advanced';
        $articles = $articleModel->searchAdvanced($filters);
        $resultsCount = count($articles);
        $searchModel->log($searchQuery, $searchType, $resultsCount);
    }
    
    // Búsqueda booleana
    if ($_GET['action'] == 'search_boolean' && !empty($_GET['boolean_query'])) {
        $searchQuery = htmlspecialchars($_GET['boolean_query']);
        $searchType = 'boolean';
        $articles = $articleModel->searchBoolean($searchQuery);
        $resultsCount = count($articles);
        $searchModel->log($searchQuery, $searchType, $resultsCount);
    }
}

// Obtener búsquedas recientes


// Cargar vista
require_once __DIR__ . '/../views/search.php';
?>
