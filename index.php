<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Libros</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>

<body>
    <div class="container">
        <h1>Buscador de Libros</h1>


        <form method="GET" action="index.php" onsubmit="ocultarResultadosAnteriores()">
            <input type="text" name="query" placeholder="Buscar en OpenLibrary (ISBN o Autor)" required
                value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>" />
            <button type="submit">Buscar en OpenLibrary</button>
        </form>


        <div>
            <h2>Buscar en Base de Datos</h2>
            <input type="text" onkeyup="buscarEnDB(this.value); ocultarResultadosAnteriores();"
                placeholder="Buscar en base de datos (Título o Autor)" />
            <div id="resultados-db">
                <p>Escribe para buscar en la base de datos.</p>
            </div>
        </div>


        <form method="POST" action="index.php" style="display: inline;" onsubmit="ocultarResultadosAnteriores()">
            <button type="submit" name="mostrar_todos">Mostrar Todos los Libros</button>
        </form>
        <button onclick="ocultarLibrosAlmacenados()">Ocultar Todos los Libros</button>
        <a href="descargar_json.php" class="btn-descargar-json">Descargar JSON</a>


        <div id="resultados-almacenados">
            <?php
            require_once 'api.php';


            if (isset($_GET['query'])) {
                $query = htmlspecialchars($_GET['query']);
                $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
                $limit = 3;

                $resultados = buscarLibros($query, $offset, $limit);

                if (!empty($resultados['docs'])) {
                    echo "<div class='results'>";
                    echo "<h2>Resultados de OpenLibrary:</h2>";
                    foreach ($resultados['docs'] as $book) {
                        $isbn = $book['isbn'][0] ?? 'Sin ISBN';
                        $titulo = $book['title'] ?? 'Sin título';
                        $autor = $book['author_name'][0] ?? 'Autor desconocido';

                        echo "<div class='book'>";
                        echo "<h3>$titulo</h3>";
                        echo "<p><strong>Autor:</strong> $autor</p>";
                        echo "<p><strong>ISBN:</strong> $isbn</p>";
                        echo "<form method='POST' action='index.php'>";
                        echo "<input type='hidden' name='isbn' value='$isbn'>";
                        echo "<input type='hidden' name='titulo' value='$titulo'>";
                        echo "<input type='hidden' name='autor' value='$autor'>";
                        echo "<button type='submit' name='almacenar'>Almacenar</button>";
                        echo "</form>";
                        echo "</div>";
                    }
                    echo "</div>";


                    echo "<div class='pagination'>";
                    if ($offset > 0) {
                        $prevOffset = max($offset - $limit, 0);
                        echo "<a href='index.php?query=$query&offset=$prevOffset'>⬅ Anterior</a>";
                    }
                    if ($offset + $limit < $resultados['numFound']) {
                        $nextOffset = $offset + $limit;
                        echo "<a href='index.php?query=$query&offset=$nextOffset'>Siguiente ➡</a>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>No se encontraron resultados para '$query'.</p>";
                }
            }


            if (isset($_POST['almacenar'])) {
                $isbn = $_POST['isbn'];
                $titulo = $_POST['titulo'];
                $autor = $_POST['autor'];
                echo "<p>" . almacenarLibro($conn, $isbn, $titulo, $autor) . "</p>";
            }

            if (isset($_POST['eliminar'])) {
                $isbn = $_POST['isbn'];
                echo "<p>" . eliminarLibro($conn, $isbn) . "</p>";
            }


            if (isset($_POST['mostrar_todos'])) {
                $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
                $limit = 3;
                $offset = ($page - 1) * $limit;


                $libros = obtenerLibrosAlmacenados($conn, '', $limit, $offset);
                $totalLibros = contarLibrosAlmacenados($conn);

                if (!empty($libros)) {
                    echo "<div class='results'>";
                    echo "<h2>Libros Almacenados:</h2>";
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
                    echo "</div>";


                    echo "<div class='pagination'>";
                    if ($page > 1) {
                        echo "<form method='POST' action='index.php' style='display: inline;'>";
                        echo "<input type='hidden' name='page' value='" . ($page - 1) . "'>";
                        echo "<button type='submit' name='mostrar_todos'>⬅ Anterior</button>";
                        echo "</form>";
                    }
                    if ($offset + $limit < $totalLibros) {
                        echo "<form method='POST' action='index.php' style='display: inline;'>";
                        echo "<input type='hidden' name='page' value='" . ($page + 1) . "'>";
                        echo "<button type='submit' name='mostrar_todos'>Siguiente ➡</button>";
                        echo "</form>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>No hay libros almacenados en la base de datos.</p>";
                }
            }
            ?>
        </div>
    </div>
</body>

</html>