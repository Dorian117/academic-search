<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artículos - Academic Search</title>
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
                <h2>Gestión de Artículos</h2>
                <a href="articles.php?action=create" class="btn btn-primary">+ Nuevo Artículo</a>
            </div>

            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-success">
                    <?php
                    if ($_GET['message'] == 'created') echo 'Artículo creado exitosamente';
                    if ($_GET['message'] == 'updated') echo 'Artículo actualizado exitosamente';
                    if ($_GET['message'] == 'deleted') echo 'Artículo eliminado exitosamente';
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    ✗ Error al procesar la operación
                </div>
            <?php endif; ?>

            <?php if (empty($articles)): ?>
                <div class="alert alert-info">
                    No hay artículos registrados. <a href="articles.php?action=create">Crea el primero aquí</a>.
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autores</th>
                            <th>Año</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?= $article['id'] ?></td>
                            <td><?= htmlspecialchars($article['title']) ?></td>
                            <td><?= htmlspecialchars(substr($article['authors'], 0, 40)) ?>...</td>
                            <td><?= $article['publication_year'] ?></td>
                            <td><span class="badge badge-info"><?= htmlspecialchars($article['category_name']) ?></span></td>
                            <td>
                                <a href="articles.php?action=view&id=<?= $article['id'] ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Ver</a>
                                <a href="articles.php?action=edit&id=<?= $article['id'] ?>" class="btn btn-warning" style="padding: 5px 10px; font-size: 12px;">Editar</a>
                                <a href="articles.php?action=delete&id=<?= $article['id'] ?>" 
                                   class="btn btn-danger" 
                                   style="padding: 5px 10px; font-size: 12px;"
                                   onclick="return confirm('¿Estás seguro de eliminar este artículo?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
