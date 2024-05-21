<?php
require_once '../../backend/db.php';

$title = $_GET['title'] ? $_GET['title'] : '';
$year = $_GET['year'] ? $_GET['year'] : '';
$author = $_GET['author'] ? $_GET['author'] : '';
$category = $_GET['category'] ? $_GET['category'] : '';

$sql = "SELECT distinct mv.id, mv.title, mv.year, mv.category, mv.description, mv.author, IF(p.purchase_date is not null, 'comprada', 'sin_comprar') purchase".
    " FROM movies mv LEFT JOIN purchases p on mv.id = p.movie_id WHERE 1=1";

if ($title) {
    $sql .= " AND title LIKE ?";
    $params[] = "%$title%";
}
if ($year) {
    $sql .= " AND year = ?";
    $params[] = $year;
}
if ($author) {
    $sql .= " AND author LIKE ?";
    $params[] = "%$author%";
}
if ($category) {
    $sql .= " AND category = ?";
    $params[] = $category;
}
$conn = conexion();
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$movies = [];
while ($row = $result->fetch_assoc()) {
    $movies[] = $row;
}
header('Content-Type: application/json');
echo json_encode($movies);

$stmt->close();
$conn->close();
?>
