
<?php
require_once 'db.php'; // <-- inclut la connexion

$data = json_decode(file_get_contents("php://input"), true);
$code = $data['code_acces'] ?? null;

if (!$code) {
  http_response_code(400);
  echo json_encode(["error" => "Code d'accès manquant"]);
  exit;
}

$stmt = $pdo->prepare("SELECT * FROM clients WHERE code_acces = ?");
$stmt->execute([$code]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$client) {
  http_response_code(404);
  echo json_encode(["error" => "Clé non trouvée"]);
  exit;
}

if ($client['etat'] != 'actif') {
  http_response_code(403);
  echo json_encode(["error" => "Clé bloquée"]);
  exit;
}

if (strtotime($client['date_expiration']) < time()) {
  http_response_code(403);
  echo json_encode(["error" => "Clé expirée"]);
  exit;
}

 http_response_code(200);
 echo json_encode([
  "success" => true,
  "nom" => $client['nom'],
  "prenom" => $client['prenom'],
  "numero" => $client['numero'],
  "etat" => $client['etat'],
  "date_expiration" => $client['date_expiration']
]);
