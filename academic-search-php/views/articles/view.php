<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']) ?> - Academic Search</title>
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
                <h2>Detalle del Artículo</h2>
                <div>
                    <a href="articles.php?action=edit&id=<?= $article['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="articles.php" class="btn btn-secondary">Volver</a>
                </div>
            </div>

            <h1 style="color: #2c3e50; margin-bottom: 20px;"><?= htmlspecialchars($article['title']) ?></h1>

            <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <p><strong>Autores:</strong> <?= htmlspecialchars($article['authors']) ?></p>
                <p><strong>Año:</strong> <span class="badge badge-primary"><?= $article['publication_year'] ?></span></p>
                <p><strong>Fuente:</strong> <?= htmlspecialchars($article['source']) ?></p>
                <p><strong>Categoría:</strong> <span class="badge badge-info"><?= htmlspecialchars($article['category_name']) ?></span></p>
            </div>

            <div style="margin-bottom: 20px;">
                <h3>Resumen (Abstract)</h3>
                <p style="text-align: justify; line-height: 1.8; color: #555;">
                    <?= htmlspecialchars($article['abstract']) ?>
                </p>
            </div>

            <div>
                <h3>Palabras Clave</h3>
                <p>
                    <?php 
                    $keywords = explode(',', $article['keywords']);
                    foreach ($keywords as $keyword): 
                    ?>
                        <span class="badge badge-success"><?= htmlspecialchars(trim($keyword)) ?></span>
                    <?php endforeach; ?>
                </p>
            </div>

            <hr style="margin: 30px 0;">

            <div class="flex-end">
                <a href="articles.php" class="btn btn-secondary">Volver al listado</a>
                <a href="articles.php?action=edit&id=<?= $article['id'] ?>" class="btn btn-warning">Editar</a>
                <a href="articles.php?action=delete&id=<?= $article['id'] ?>" 
                   class="btn btn-danger"
                   onclick="return confirm('¿Estás seguro de eliminar este artículo?')">Eliminar</a>
            </div>
        </div>
    </div>
</body>
</html>
