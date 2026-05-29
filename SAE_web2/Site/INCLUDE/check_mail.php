<?php
include 'functions.php';

header('Content-Type: application/json');

$mail = $_POST['mail'] ?? '';

if (empty($mail)) {
    echo json_encode(['valid' => false, 'message' => 'Email vide']);
    exit();
}

// Vérification format côté serveur
if (!preg_match('/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,}$/', $mail)) {
    echo json_encode(['valid' => false, 'message' => 'format']);
    exit();
}

// Vérification que l'email existe en BDD
$liste = get_bdd_comptes('../BDD/comptes.sqlite');
$existe = false;
foreach ($liste as $val) {
    if ($val['EMAIL'] === $mail) {
        $existe = true;
        break;
    }
}

if (!$existe) {
    echo json_encode(['valid' => false, 'message' => 'nomail']);
} else {
    echo json_encode(['valid' => true, 'message' => 'ok']);
}
?>
