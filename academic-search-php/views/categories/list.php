<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías - Academic Search</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <nav>
        <div class="container">
            <h1>Academic Search</h1>
            <ul>
                <li><a href="index.php">Búsqueda</a></li>
                <li><a href="articles.php">Artículos</a></li>
                <li><a href="categories.php">Categorías</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2>Gestión de Categorías</h2>
                <a href="categories.php?action=create" class="btn btn-primary">+ Nueva Categoría</a>
            </div>

            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-success">
                    <?php
                    if ($_GET['message'] == 'created') echo '✓ Categoría creada exitosamente';
                    if ($_GET['message'] == 'updated') echo '✓ Categoría actualizada exitosamente';
                    if ($_GET['message'] == 'deleted') echo '✓ Categoría eliminada exitosamente';
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <?php
                    if ($_GET['error'] == 'has_articles') {
                        echo '✗ No se puede eliminar la categoría porque tiene artículos asociados';
                    } else {
                        echo '✗ Error al procesar la operación';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <?php if (empty($categories)): ?>
                <div class="alert alert-info">
                    No hay categorías registradas. <a href="categories.php?action=create">Crea la primera aquí</a>.
                </div>
            <?php else: ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
                    <?php foreach ($categories as $category): 
                        $articleCount = $categoryModel->countArticles($category['id']);
                    ?>
                    <div class="card" style="margin: 0;">
                        <h3><?= htmlspecialchars($category['name']) ?></h3>
                        <p style="color: #7f8c8d; margin: 10px 0;">
                            <?= $category['description'] ? htmlspecialchars($category['description']) : 'Sin descripción' ?>
                        </p>
                        <p>
                            <span class="badge badge-info"><?= $articleCount ?> artículo(s)</span>
                        </p>
                        <div class="flex-end" style="margin-top: 15px;">
                            <a href="categories.php?action=view&id=<?= $category['id'] ?>" class="btn btn-primary" style="padding: 8px 12px; font-size: 14px;">Ver</a>
                            <a href="categories.php?action=edit&id=<?= $category['id'] ?>" class="btn btn-warning" style="padding: 8px 12px; font-size: 14px;">Editar</a>
                            <a href="categories.php?action=delete&id=<?= $category['id'] ?>" 
                               class="btn btn-danger" 
                               style="padding: 8px 12px; font-size: 14px;"
                               onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
