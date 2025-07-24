<?php
require_once 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
if (!$id) {
  http_response_code(400);
  echo json_encode(["error" => "ID requis"]);
  exit;
}

$fields = [];
$params = [];

if (isset($data['montant'])) {
  $fields[] = "montant = ?";
  $params[] = $data['montant'];
}
if (isset($data['date_paiement'])) {
  $fields[] = "date_paiement = ?";
  $params[] = $data['date_paiement'];
}
if (isset($data['client_id'])) {
  $fields[] = "client_id = ?";
  $params[] = $data['client_id'];
}

if (empty($fields)) {
  http_response_code(400);
  echo json_encode(["error" => "Aucune donnée à mettre à jour"]);
  exit;
}

$params[] = $id;
$sql = "UPDATE paiements SET " . implode(", ", $fields) . " WHERE id = ?";
$stmt = $pdo->prepare($sql);

try {
  $stmt->execute($params);
  echo json_encode(["success" => true, "message" => "Paiement mis à jour"]);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["error" => "Erreur : " . $e->getMessage()]);
}
