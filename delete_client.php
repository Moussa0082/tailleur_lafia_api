
<?php
require_once 'db.php';

// header('Content-Type: application/json');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;

if (!$id) {
  http_response_code(400);
  echo json_encode(["error" => "ID requis pour la suppression"]);
  exit;
}

$stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");

try {
  $stmt->execute([$id]);
  echo json_encode(["success" => true, "message" => "Client supprimé"]);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["error" => "Erreur : " . $e->getMessage()]);
}
