<?php
$host = 'sql100.infinityfree.com';
$db = 'if0_40523081_tailleur_lafia';
// $db = 'monapp';
$user = 'if0_40523081';
// $pass = '';
$pass = 'Osn2fI2CdAwyFwS';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}



// $host = 'localhost';
// $db = 'monapp';
// $user = 'root';
// $pass = '';
// $charset = 'utf8mb4';

// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// $options = [
//   PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
// ];

// try {
//     $pdo = new PDO($dsn, $user, $pass, $options);
// } catch (PDOException $e) {
//     die("Erreur de connexion : " . $e->getMessage());
// }
