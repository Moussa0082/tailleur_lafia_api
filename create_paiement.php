
<?php
require_once 'db.php';

// header('Content-Type: application/json');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$data = json_decode(file_get_contents("php://input"), true);

$montant = $data['montant'] ?? null;
$date_paiement = $data['date_paiement'] ?? null;
$client_id = $data['client_id'] ?? null;

if (!$montant || !$date_paiement || !$client_id) {
  http_response_code(400);
  echo json_encode(["error" => "montant, date_paiement et client_id sont requis"]);
  exit;
}

$stmt = $pdo->prepare("INSERT INTO paiements (montant, date_paiement, client_id) VALUES (?, NOW(), ?)");

try {
  $stmt->execute([$montant, $date_paiement, $client_id]);
  echo json_encode(["success" => true, "message" => "Paiement ajouté"]);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["error" => "Erreur : " . $e->getMessage()]);
}
