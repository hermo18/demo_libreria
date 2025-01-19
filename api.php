<?php
require_once 'config.php';


function buscarLibros($query, $offset = 0, $limit = 5)
{
    $baseUrl = "https://openlibrary.org/search.json";

    if (is_numeric($query) && (strlen($query) == 10 || strlen($query) == 13)) {
        $url = "$baseUrl?isbn=$query";
    } else {
        $url = "$baseUrl?author=" . urlencode($query);
    }

    $url .= "&limit=$limit&offset=$offset";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);
    return $data ?? [];
}



function almacenarLibro($conn, $isbn, $titulo, $autor)
{
    $query = "SELECT * FROM libros WHERE isbn = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $isbn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return "El libro ya existe en la base de datos.";
    } else {
        $query = "INSERT INTO libros (isbn, titulo, autor) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $isbn, $titulo, $autor);
        if ($stmt->execute()) {
            return "Libro almacenado con éxito.";
        } else {
            return "Error al almacenar el libro.";
        }
    }
}

function obtenerLibrosAlmacenados($conn, $query = '', $limit = 5, $offset = 0)
{
    $sql = "SELECT * FROM libros";
    if ($query !== '') {
        $sql .= " WHERE titulo LIKE ? OR autor LIKE ?";
    }
    $sql .= " LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($sql);
    if ($query !== '') {
        $searchQuery = "%$query%";
        $stmt->bind_param('ssii', $searchQuery, $searchQuery, $limit, $offset);
    } else {
        $stmt->bind_param('ii', $limit, $offset);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $libros = [];

    while ($row = $result->fetch_assoc()) {
        $libros[] = $row;
    }

    return $libros;
}



function eliminarLibro($conn, $isbn)
{
    $stmt = $conn->prepare("DELETE FROM libros WHERE isbn = ?");
    $stmt->bind_param("s", $isbn);

    if ($stmt->execute()) {
        return "Libro con ISBN $isbn eliminado correctamente.";
    } else {
        return "Error al eliminar el libro: " . $stmt->error;
    }
}

function contarLibrosAlmacenados($conn)
{
    $sql = "SELECT COUNT(*) AS total FROM libros";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'];
}


?>