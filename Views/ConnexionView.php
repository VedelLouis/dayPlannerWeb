<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/connexion.css">
    <title>Connexion</title>
</head>
<body>

<div class="container">
    <div class="login-container">
        <img src="Images/dayPlannerLogo.png" alt="DayPlanner Logo" class="logo">
        <h2>Connexion au site</h2>

        <form id="login-form" action="index.php?controller=connexion&action=connect" method="post">
            <?php
            // Si la connexion échoue afficher le message d'erreur
            if (isset($erreur_session)) {
                echo '<div class="error-message">' . $erreur_session . '</div>';
            }
            ?>
            <div class="form-group">
                <input type="text" class="form-control" name="login" placeholder="Login" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
            </div>
            <?php
            // Si la connexion échoue afficher le message d'erreur
            if (isset($erreur_connexion)) {
                echo '<div class="error-message">' . $erreur_connexion . '</div>';
            }
            ?>
            <button type="submit" class="btn btn-success btn-block">Se connecter</button>
        </form>

        <form id="login-form" action="index.php?controller=account&action=index" method="post">
            <button type="submit" class="btn btn-create btn-block">Créer un compte</button>
        </form>

    </div>
</div>

</body>
</html>
