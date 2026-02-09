<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($category['name']) ?> - Academic Search</title>
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
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2><?= htmlspecialchars($category['name']) ?></h2>
                <div>
                    <a href="categories.php?action=edit&id=<?= $category['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="categories.php" class="btn btn-secondary">Volver</a>
                </div>
            </div>

            <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <p><strong>Descripción:</strong></p>
                <p><?= $category['description'] ? htmlspecialchars($category['description']) : 'Sin descripción' ?></p>
            </div>

            <p><strong>Estadísticas:</strong> 
                <span class="badge badge-info">
                    <?php 
                    require_once __DIR__ . '/../../models/Article.php';
                    $articleModel = new Article($db);
                    
                    $query = "SELECT * FROM articles WHERE category_id = :id";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':id', $category['id']);
                    $stmt->execute();
                    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    echo count($articles) . ' artículo(s)';
                    ?>
                </span>
            </p>

            <hr style="margin: 20px 0;">

            <h3>Artículos en esta categoría</h3>

            <?php if (empty($articles)): ?>
                <div class="alert alert-info">
                    No hay artículos en esta categoría todavía.
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autores</th>
                            <th>Año</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article): ?>
                        <tr>
                            <td><?= htmlspecialchars($article['title']) ?></td>
                            <td><?= htmlspecialchars(substr($article['authors'], 0, 40)) ?>...</td>
                            <td><?= $article['publication_year'] ?></td>
                            <td>
                                <a href="articles.php?action=view&id=<?= $article['id'] ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Ver</a>
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
