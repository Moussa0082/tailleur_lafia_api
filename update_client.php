
<?php
require_once 'db.php'; // Connexion via db.php

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;

if (!$id) {
  http_response_code(400);
  echo json_encode(["error" => "ID requis pour mettre à jour le client"]);
  exit;
}

// Construire dynamiquement les champs à mettre à jour
$fields = [];
$params = [];

if (isset($data['nom'])) {
  $fields[] = "nom = ?";
  $params[] = $data['nom'];
}
if (isset($data['prenom'])) {
  $fields[] = "prenom = ?";
  $params[] = $data['prenom'];
}
if (isset($data['numero'])) {
  $fields[] = "numero = ?";
  $params[] = $data['numero'];
}
if (isset($data['adresse'])) {
  $fields[] = "adresse = ?";
  $params[] = $data['adresse'];
}
if (isset($data['code_acces'])) {
  $fields[] = "code_acces = ?";
  $params[] = $data['code_acces'];
}
if (isset($data['date_expiration'])) {
  $fields[] = "date_expiration = ?";
  $params[] = $data['date_expiration'];
}

// Si aucun champ à mettre à jour
if (empty($fields)) {
  http_response_code(400);
  echo json_encode(["error" => "Aucune donnée à mettre à jour"]);
  exit;
}

$params[] = $id;
$sql = "UPDATE clients SET " . implode(", ", $fields) . " WHERE id = ?";
$stmt = $pdo->prepare($sql);

try {
  $stmt->execute($params);
  echo json_encode(["success" => true, "message" => "Client mis à jour"]);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["error" => "Erreur lors de la mise à jour : " . $e->getMessage()]);
}
