<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/includes/csrf.php';
$token = csrf_token();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Inscription</title>
</head>
<body>
  <h2>Inscription</h2>

  <form method="POST" action="process_register.php" autocomplete="off">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token, ENT_QUOTES) ?>">

    <label for="email">Email</label><br>
    <input id="email" type="email" name="email" required maxlength="255"><br><br>

    <label for="password">Mot de passe</label><br>
    <input id="password" type="password" name="password" required minlength="8"><br><br>

    <label for="confirm_password">Confirmer le mot de passe</label><br>
    <input id="confirm_password" type="password" name="confirm_password" required minlength="8"><br><br>

    <button type="submit">Créer mon compte</button>
  </form>

  <p><a href="index.php">Retour</a></p>
</body>
</html>
