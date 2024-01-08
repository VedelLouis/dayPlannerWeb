<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/account.css">
    <title>Mon compte</title>
</head>
<body>

<div class="container">
    <div class="create-container">
        <h2>Création de compte</h2>

        <form id="create-form" action="index.php?controller=account&action=create" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="login" placeholder="Login" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="firstname" placeholder="Prénom" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="lastname" placeholder="Nom" required>
            </div>
            <button type="submit" class="btn btn-create btn-block" id="submitBtn" disabled>Créer mon compte</button>
        </form>

        <form id="back-form" action="index.php?controller=connexion&action=index" method="post">
            <button type="submit" class="btn btn-back btn-block">Retour</button>
        </form>

    </div>
</div>

</body>
</html>
