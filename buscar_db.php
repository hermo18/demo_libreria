<?php
require_once 'api.php';

if (isset($_GET['query'])) {
    $query = htmlspecialchars($_GET['query']);
    $libros = obtenerLibrosAlmacenados($conn, $query);

    if (!empty($libros)) {
        foreach ($libros as $libro) {
            echo "<div class='book'>";
            echo "<h3>{$libro['titulo']}</h3>";
            echo "<p><strong>Autor:</strong> {$libro['autor']}</p>";
            echo "<p><strong>ISBN:</strong> {$libro['isbn']}</p>";
            echo "<form method='POST' action='index.php' onsubmit='return confirmarEliminacion(\"{$libro['isbn']}\")'>";
            echo "<input type='hidden' name='isbn' value='{$libro['isbn']}'>";
            echo "<button type='submit' name='eliminar' class='btn-eliminar'>Eliminar</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<p>No se encontraron libros almacenados para '$query'.</p>";
    }
}
