<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/account.css">
    <title>Création de compte</title>
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="create-container">
        <h2>Création de compte</h2>

        <form id="create-form" action="index.php?controller=account&action=create" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="login" id="login" placeholder="Login (email)" required>
                <span id="loginError" class="error-message"></span>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="passwordConfirm" id="passwordConfirm" placeholder="Confirmer le mot de passe" required>
                <span id="passwordError" class="error-message"></span>
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
            <button type="submit" class="btn btn-back btn-block">Annuler</button>
        </form>

    </div>
</div>

<script>

    // Gère si les mots de passe correspondent
    // Si les mots de passe ne correspondent pas, le bouton de soumission est désactivé

    function checkPassword() {
        var password = document.getElementById('password').value;
        var passwordConfirm = document.getElementById('passwordConfirm').value;
        var errorSpan = document.getElementById('passwordError');

        if (password !== passwordConfirm) {
            errorSpan.innerHTML = "Les mots de passe ne correspondent pas.";
            document.getElementById('submitBtn').disabled = true;
        } else {
            errorSpan.innerHTML = "";
            document.getElementById('submitBtn').disabled = false;
        }
    }

    // Gère si l'identifiant est valide, correspond à la regex d'un email
    // Si l'identifiant n'est pas valide, le bouton de soumission est désactivé

    function checkEmail() {
        var login = document.getElementById('login').value;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var errorSpan = document.getElementById('loginError');

        if (!emailRegex.test(login)) {
            errorSpan.innerHTML = "Veuillez saisir une adresse email valide.";
            document.getElementById('submitBtn').disabled = true;
        } else {
            errorSpan.innerHTML = "";
            document.getElementById('submitBtn').disabled = false;
        }
    }

    document.getElementById('password').addEventListener('input', checkPassword);
    document.getElementById('passwordConfirm').addEventListener('input', checkPassword);
    document.getElementById('login').addEventListener('input', checkEmail);
</script>

</body>
</html>
