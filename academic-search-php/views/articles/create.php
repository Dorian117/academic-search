<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Artículo - Academic Search</title>
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
            <h2>Crear Nuevo Artículo</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="articles.php?action=create">
                <div class="form-group">
                    <label>Título</label>
                    <input type="text" name="title" required>
                </div>

                <div class="form-group">
                    <label>Autores</label>
                    <input type="text" name="authors" placeholder="Separar con comas: Autor1, Autor2" required>
                </div>

                <div class="form-group">
                    <label>Año de Publicación</label>
                    <input type="number" name="publication_year" min="1900" max="2030" value="2024" required>
                </div>

                <div class="form-group">
                    <label>Categoría</label>
                    <select name="category_id" required>
                        <option value="">Seleccionar categoría</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fuente/Revista</label>
                    <input type="text" name="source">
                </div>

                <div class="form-group">
                    <label>Resumen</label>
                    <textarea name="abstract" required></textarea>
                </div>

                <div class="form-group">
                    <label>Palabras Clave</label>
                    <input type="text" name="keywords" placeholder="Separar con comas: Palabra1, Palabra2, Palabra3" required>
                </div>

                <div class="flex-end">
                    <a href="articles.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Artículo</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
