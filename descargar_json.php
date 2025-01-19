<?php
require_once 'api.php';


$query = "SELECT isbn, titulo, autor FROM libros";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();


$libros = [];
while ($row = $result->fetch_assoc()) {
    $libros[] = $row;
}


$fechaHoy = date('d-m-Y');


header('Content-Type: application/json');
header("Content-Disposition: attachment; filename=\"libros_$fechaHoy.json\"");


echo json_encode($libros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;
