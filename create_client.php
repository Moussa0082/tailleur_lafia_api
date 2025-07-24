<?php
$pdo = new PDO("mysql:host=localhost;dbname=monapp;charset=utf8", "root", "");

$data = json_decode(file_get_contents("php://input"), true);
$nom = $data['nom'] ?? null;
$prenom = $data['prenom'] ?? null;
$numero = $data['numero'] ?? null;
$numero = $data['adresse'] ?? null;
$code = $data['code_acces'] ?? null;
$date_expiration = $data['date_expiration'] ?? null;

if (!$nom || !$prenom || !$numero || !$code || !$date_expiration) {
  http_response_code(400);
  echo json_encode(["error" => "Champs manquants"]);
  exit;
}

$stmt = $pdo->prepare("INSERT INTO clients (nom, prenom, numero, code_acces, date_expiration) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$nom, $prenom, $numero, $code, $date_expiration]);

echo json_encode(["success" => true, "message" => "Client créé"]);
