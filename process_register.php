<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Méthode non autorisée');
}

if (!csrf_validate($_POST['csrf_token'] ?? null)) {
    http_response_code(400);
    exit('CSRF invalide');
}

$emailRaw = (string)($_POST['email'] ?? '');
$email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL);
$password = (string)($_POST['password'] ?? '');
$confirm = (string)($_POST['confirm_password'] ?? '');

if (!$email) {
    http_response_code(400);
    exit('Email invalide');
}

if ($password !== $confirm) {
    http_response_code(400);
    exit('Les mots de passe ne correspondent pas');
}

if (strlen($password) < 8) {
    http_response_code(400);
    exit('Mot de passe trop court (min 8 caractères)');
}

$hash = password_hash($password, PASSWORD_DEFAULT);
if ($hash === false) {
    http_response_code(500);
    exit('Erreur de hachage');
}

try {
    // Vérifie si l'utilisateur existe déjà (UserName = email dans ton projet)
    $check = $dbh->prepare('SELECT id FROM users WHERE UserName = :email LIMIT 1');
    $check->execute([':email' => $email]);

    if ($check->fetch()) {
        http_response_code(409);
        exit('Un compte existe déjà avec cet email');
    }

    // Insertion sécurisée (is_admin=0)
    $stmt = $dbh->prepare(
        'INSERT INTO users (UserName, Password, is_admin) VALUES (:email, :password, 0)'
    );
    $stmt->execute([
        ':email' => $email,
        ':password' => $hash
    ]);

    echo 'Inscription réussie';
} catch (Throwable $e) {
    http_response_code(500);
    exit('Erreur serveur');
}
