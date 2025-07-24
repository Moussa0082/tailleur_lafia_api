<?php
require_once 'db.php'; // <-- inclut la connexion

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$nom = $data['nom'] ?? null;
$prenom = $data['prenom'] ?? null;
$numero = $data['numero'] ?? null;
$adresse = $data['adresse'] ?? null;
$code = $data['code_acces'] ?? null;
$date_expiration = $data['date_expiration'] ?? null;

if (!$nom || !$prenom || !$numero || !$code || !$date_expiration) {
  http_response_code(400);
  echo json_encode(["error" => "Champs manquants"]);
  exit;
}

$stmt = $pdo->prepare("
  INSERT INTO clients (nom, prenom, numero, adresse, code_acces, date_expiration)
  VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->execute([$nom, $prenom, $numero, $adresse, $code, $date_expiration]);

http_response_code(400);
echo json_encode(["success" => true, "message" => "Client créé"]);
