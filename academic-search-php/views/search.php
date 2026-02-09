<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda - Academic Search</title>
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
    <div class="search-grid">
        
        <div>
            <div class="card">
                <h2>Búsqueda Simple</h2>
                <form method="GET" action="index.php">
                    <input type="hidden" name="action" value="search_simple">
                    <div class="form-group">
                        <label>Término</label>
                        <input type="text" name="query" placeholder="Ej: redes neuronales" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>

            <div class="card">
                <h2>Búsqueda Avanzada</h2>
                <form method="GET" action="index.php">
                    <input type="hidden" name="action" value="search_advanced">
                    <button type="submit" class="btn btn-success">Aplicar Filtros</button>
                </form>
            </div>

            <div class="card">
                <h2>Búsqueda Booleana</h2>
                <form method="GET" action="index.php">
                    <input type="hidden" name="action" value="search_boolean">
                    <div class="form-group">
                        <label>Consulta (AND / OR)</label>
                        <input type="text" name="boolean_query" placeholder="machine AND learning" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Ejecutar</button>
                </form>
            </div>
        </div> <div>
            <div class="card text-center">
                <h2>Bienvenido</h2>
                <p style="color: #7f8c8d; margin: 15px 0; font-size: 14px;">
                    Sistema de búsqueda de artículos académicos.
                </p>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <a href="articles.php" class="btn btn-primary" style="font-size: 12px;">Artículos</a>
                    <a href="categories.php" class="btn btn-success" style="font-size: 12px;">Categorías</a>
                </div>
            </div>

            <?php if ($articles !== null): ?>
                <div class="card">
                    <h2>Resultados</h2>
                    <div class="alert alert-info" style="font-size: 13px;">
                        Filtrado por: <strong><?= htmlspecialchars($searchQuery) ?></strong> (<?= $resultsCount ?> encontrados)
                    </div>

                    <?php if (empty($articles)): ?>
                        <div class="alert alert-error">No se hallaron registros.</div>
                    <?php else: ?>
                        <?php foreach ($articles as $article): ?>
                            <div class="search-result">
                                <h3><?= htmlspecialchars($article['title']) ?></h3>
                                <div class="meta">
                                    <?= htmlspecialchars($article['authors']) ?> | <?= $article['publication_year'] ?>
                                </div>
                                <p><?= htmlspecialchars(substr($article['abstract'], 0, 180)) ?>...</p>
                                <a href="articles.php?action=view&id=<?= $article['id'] ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Ver detalles</a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="card text-center" style="border: 2px dashed #ddd; background: transparent; box-shadow: none;">
                    <p style="color: #95a5a6; padding: 60px 0;">Los resultados de su búsqueda aparecerán en este panel.</p>
                </div>
            <?php endif; ?>
        </div> </div> </div>
</body>
</html>