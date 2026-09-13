<?php
require_once 'db.php';
// header('Content-Type: application/json');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$stmt = $pdo->query("SELECT * FROM clients");
$paiements = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($paiements);
