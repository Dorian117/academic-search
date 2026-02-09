<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría - Academic Search</title>
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
        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <h2>Crear Nueva Categoría</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="categories.php?action=create">
                <div class="form-group">
                    <label>Nombre de la Categoría</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="description" placeholder="Breve descripción de la categoría"></textarea>
                </div>

                <div class="flex-end">
                    <a href="categories.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Categoría</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
