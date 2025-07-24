<?php
require_once 'db.php';
header('Content-Type: application/json');

$stmt = $pdo->query("SELECT * FROM paiements");
$paiements = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($paiements);
