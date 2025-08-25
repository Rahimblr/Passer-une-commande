<?php
// Paramètres de connexion
$host = "localhost";
$user = "root"; // ⚠️ Change si tu as un autre utilisateur
$pass = "";     // ⚠️ Mets ton mot de passe MySQL ici
$db   = "commande_db";

// Connexion à MySQL
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Erreur connexion : " . $conn->connect_error]);
    exit;
}

// Lire les données envoyées en JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Aucune donnée reçue"]);
    exit;
}

// Préparer et exécuter l'insertion
$stmt = $conn->prepare("
    INSERT INTO commandes (customer, product, quantity, phone, address, payment)
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
    "ssisss",
    $data['customer'],
    $data['product'],
    $data['quantity'],
    $data['phone'],
    $data['address'],
    $data['payment']
);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$stmt->close();
$conn->close();
?>
