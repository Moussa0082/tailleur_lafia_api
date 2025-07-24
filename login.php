<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once 'db.php'; // fichier de connexion PDO

// 🔐 Lecture du code d'accès depuis la requête POST
$input = json_decode(file_get_contents("php://input"), true);
$codeAcces = trim($input["code_acces"] ?? '');

// 🧪 Vérification minimale
if (empty($codeAcces)) {
    echo json_encode(["success" => false, "message" => "Code d'accès requis."]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE code_acces = :code_acces LIMIT 1");
    $stmt->execute(['code_acces' => $codeAcces]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$client) {
        echo json_encode(["success" => false, "message" => "Code invalide."]);
        exit;
    }

    // ⚠️ Vérifier l'état
    if ($client['etat'] !== 'actif') {
        echo json_encode(["success" => false, "message" => "Code bloqué."]);
        exit;
    }

    // 📅 Vérifier la date d'expiration
    $today = new DateTime();
    $expiration = new DateTime($client['date_expiration']);
    if ($expiration < $today) {
        echo json_encode(["success" => false, "message" => "Code expiré."]);
        exit;
    }

    // ✅ Authentification réussie
    echo json_encode([
        "success" => true,
        "message" => "Connexion réussie.",
        "data" => [
    "id" => $client["id"],
    "nom" => $client["nom"],
    "prenom" => $client["prenom"],
    "numero" => $client["numero"],
    "adresse" => $client["adresse"],
    "etat" => $client["etat"],
    "date_expiration" => $client["date_expiration"]
]

    ]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur serveur.", "error" => $e->getMessage()]);
}
?>
