<?php
require_once 'db.php'; // <-- inclut la connexion

$data = json_decode(file_get_contents("php://input"), true);
$code = $data['code_acces'] ?? null;
$nouvelle_date = $data['date_expiration'] ?? null;
$etat = $data['etat'] ?? null; // actif ou bloque

if (!$code) {
  http_response_code(400);
  echo json_encode(["error" => "Code manquant"]);
  exit;
}

$updateParts = [];
$params = [];

if ($nouvelle_date) {
  $updateParts[] = "date_expiration = ?";
  $params[] = $nouvelle_date;
}

if ($etat && in_array($etat, ['actif', 'bloque'])) {
  $updateParts[] = "etat = ?";
  $params[] = $etat;
}

if (empty($updateParts)) {
  http_response_code(400);
  echo json_encode(["error" => "Aucune donnée à mettre à jour"]);
  exit;
}


$params[] = $code;
$sql = "UPDATE clients SET " . implode(', ', $updateParts) . " WHERE code_acces = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(["success" => true, "message" => "Mise à jour effectuée"]);
