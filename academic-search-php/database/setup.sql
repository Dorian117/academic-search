-- Crear base de datos
CREATE DATABASE IF NOT EXISTS academic_search CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE academic_search;

-- Tabla de categorías
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de artículos
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    authors TEXT NOT NULL,
    publication_year INT NOT NULL,
    source VARCHAR(200) NOT NULL,
    abstract TEXT NOT NULL,
    keywords TEXT NOT NULL,
    category_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_year (publication_year),
    INDEX idx_category (category_id)
);

-- Tabla de búsquedas (historial)
CREATE TABLE IF NOT EXISTS searches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    search_query TEXT NOT NULL,
    search_type ENUM('simple', 'advanced', 'boolean') NOT NULL,
    results_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar categorías de ejemplo
INSERT INTO categories (name, description) VALUES
('Inteligencia Artificial', 'Artículos sobre IA, Machine Learning y Deep Learning'),
('Redes de Computadoras', 'Protocolos, arquitecturas y seguridad en redes'),
('Bases de Datos', 'Sistemas de gestión de bases de datos SQL y NoSQL');

/* Insertar artículos de ejemplo
INSERT INTO articles (title, authors, publication_year, source, abstract, keywords, category_id) VALUES
(
    'Deep Learning en Medicina',
    'Juan Pérez, María García',
    2024,
    'IEEE Medical Journal',
    'Este artículo explora el uso de redes neuronales profundas para el diagnóstico médico automatizado.',
    'deep learning, medicina, redes neuronales, diagnóstico',
    1
),
(
    'Protocolos de Seguridad en 5G',
    'Carlos López, Ana Martínez',
    2023,
    'ACM Network Security',
    'Análisis de protocolos de seguridad implementados en redes 5G para proteger la comunicación.',
    '5G, seguridad, protocolos, encriptación',
    2
),
(
    'Optimización de Consultas SQL',
    'Roberto Silva, Laura Torres',
    2024,
    'Database Systems Journal',
    'Técnicas avanzadas para optimizar consultas SQL en grandes bases de datos relacionales.',
    'SQL, optimización, índices, rendimiento',
    3
);*/
