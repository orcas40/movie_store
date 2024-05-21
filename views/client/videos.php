<?php
session_start();
if (!isset($_SESSION['token'])) {
    header("Location: /");
    exit();
}

require_once '../../backend/db.php';

// Obtener categorías de películas
$categories = [];
$conexion = conexion();
$result = execute_select_query("SELECT DISTINCT category FROM movies");

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Películas</title>
    <link rel="stylesheet" href="../../assets/css/videos.css">
    <script src="../../assets/js/videos.js"></script>
</head>
<body>
<?php include("../utils/logoutButton.php"); ?>
<div class="container">
    <h2>Listado de Películas</h2>
    <div class="search-bar">
        <input type="text" id="searchTitle" placeholder="Buscar por título">
        <input type="text" id="searchYear" placeholder="Buscar por año">
        <input type="text" id="searchAuthor" placeholder="Buscar por autor">
        <button id="searchButton">Buscar</button>
    </div>
    <div class="category-filter">
        <label for="categorySelect">Categoría:</label>
        <select id="categorySelect">
            <option value="">Todas</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div id="movieList"></div>
</div>

<!-- Popup para pago con tarjeta -->
<div id="paymentPopup" class="popup">
    <div class="popup-content">
        <span class="close" id="closePopup">&times;</span>
        <h2>Pagar con Tarjeta</h2>
        <form id="paymentForm">
            <label for="cardNumber">Número de Tarjeta:</label>
            <input type="text" id="cardNumber" required>
            <label for="cardHolder">Titular:</label>
            <input type="text" id="cardHolder" required>
            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" required>
            <label for="expiryDate">Fecha de Vencimiento:</label>
            <input type="text" id="expiryDate" placeholder="MM/YY" required>
            <button type="submit">Realizar Pago</button>
        </form>
    </div>
</div>

<script src="../../assets/js/videos.js"></script>
</body>
</html>
