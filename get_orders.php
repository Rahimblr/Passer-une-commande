<?php
// Paramètres de connexion
$host = "localhost";
$user = "root"; // ⚠️ Change si besoin
$pass = "";     // ⚠️ Mets ton mot de passe
$db   = "commande_db";

// Connexion à MySQL
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Erreur connexion : " . $conn->connect_error]);
    exit;
}

// Lire les commandes
$result = $conn->query("SELECT * FROM commandes ORDER BY id DESC");
$orders = [];

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);

$conn->close();
?>
