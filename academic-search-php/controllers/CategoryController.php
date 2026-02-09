<?php
// Controlador de Categorías - Maneja CRUD de categorías

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Category.php';

$db = getConnection();
$categoryModel = new Category($db);

$action = $_GET['action'] ?? 'list';
$message = '';
$error = '';

// LISTAR categorías
if ($action == 'list') {
    $categories = $categoryModel->getAll();
    require_once __DIR__ . '/../views/categories/list.php';
}

// VER detalle de categoría
elseif ($action == 'view' && isset($_GET['id'])) {
    $category = $categoryModel->getById($_GET['id']);
    if ($category) {
        require_once __DIR__ . '/../views/categories/view.php';
    } else {
        header('Location: categories.php?action=list');
    }
}

// CREAR categoría
elseif ($action == 'create') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        
        if (!empty($name)) {
            if ($categoryModel->create($name, $description)) {
                header('Location: categories.php?action=list&message=created');
                exit;
            } else {
                $error = 'Error al crear la categoría (puede que ya exista)';
            }
        } else {
            $error = 'El nombre de la categoría es requerido';
        }
    }
    
    require_once __DIR__ . '/../views/categories/create.php';
}

// EDITAR categoría
elseif ($action == 'edit' && isset($_GET['id'])) {
    $category = $categoryModel->getById($_GET['id']);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        
        if ($categoryModel->update($_GET['id'], $name, $description)) {
            header('Location: categories.php?action=list&message=updated');
            exit;
        } else {
            $error = 'Error al actualizar la categoría';
        }
    }
    
    require_once __DIR__ . '/../views/categories/edit.php';
}

// ELIMINAR categoría
elseif ($action == 'delete' && isset($_GET['id'])) {
    if ($categoryModel->delete($_GET['id'])) {
        header('Location: categories.php?action=list&message=deleted');
    } else {
        header('Location: categories.php?action=list&error=has_articles');
    }
    exit;
}

else {
    header('Location: categories.php?action=list');
}
?>
