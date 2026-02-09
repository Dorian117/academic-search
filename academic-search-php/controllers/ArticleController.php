<?php
// Controlador de Artículos

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/Category.php';

$db = getConnection();
$articleModel = new Article($db);
$categoryModel = new Category($db);

$action = $_GET['action'] ?? 'list';
$message = '';
$error = '';

// LISTAR artículos
if ($action == 'list') {
    $articles = $articleModel->getAll();
    require_once __DIR__ . '/../views/articles/list.php';
}

// VER detalle de artículo
elseif ($action == 'view' && isset($_GET['id'])) {
    $article = $articleModel->getById($_GET['id']);
    if ($article) {
        require_once __DIR__ . '/../views/articles/view.php';
    } else {
        header('Location: articles.php?action=list');
    }
}

// CREAR artículo - mostrar formulario
elseif ($action == 'create') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validar datos
        $data = [
            'title' => trim($_POST['title']),
            'authors' => trim($_POST['authors']),
            'publication_year' => intval($_POST['publication_year']),
            'source' => trim($_POST['source']),
            'abstract' => trim($_POST['abstract']),
            'keywords' => trim($_POST['keywords']),
            'category_id' => intval($_POST['category_id'])
        ];
        
        if (!empty($data['title']) && !empty($data['authors'])) {
            if ($articleModel->create($data)) {
                header('Location: articles.php?action=list&message=created');
                exit;
            } else {
                $error = 'Error al crear el artículo';
            }
        } else {
            $error = 'Por favor completa todos los campos requeridos';
        }
    }
    
    $categories = $categoryModel->getAll();
    require_once __DIR__ . '/../views/articles/create.php';
}

// EDITAR artículo
elseif ($action == 'edit' && isset($_GET['id'])) {
    $article = $articleModel->getById($_GET['id']);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = [
            'title' => trim($_POST['title']),
            'authors' => trim($_POST['authors']),
            'publication_year' => intval($_POST['publication_year']),
            'source' => trim($_POST['source']),
            'abstract' => trim($_POST['abstract']),
            'keywords' => trim($_POST['keywords']),
            'category_id' => intval($_POST['category_id'])
        ];
        
        if ($articleModel->update($_GET['id'], $data)) {
            header('Location: articles.php?action=list&message=updated');
            exit;
        } else {
            $error = 'Error al actualizar el artículo';
        }
    }
    
    $categories = $categoryModel->getAll();
    require_once __DIR__ . '/../views/articles/edit.php';
}

// ELIMINAR artículo
elseif ($action == 'delete' && isset($_GET['id'])) {
    if ($articleModel->delete($_GET['id'])) {
        header('Location: articles.php?action=list&message=deleted');
    } else {
        header('Location: articles.php?action=list&error=delete_failed');
    }
    exit;
}

else {
    header('Location: articles.php?action=list');
}
?>
