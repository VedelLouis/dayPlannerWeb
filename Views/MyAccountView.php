<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/account.css">
    <title>Modifier mon compte</title>
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="create-container">
        <h2>Modifier mon compte</h2>

        <form id="edit-form" action="index.php?controller=account&action=edit" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="login" value="<?php echo $_SESSION['login']; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="firstname" value="<?php echo $_SESSION['firstname']; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="lastname" value="<?php echo $_SESSION['lastname']; ?>">
            </div>

            <h4>Modifier mon mot de passe</h4>

            <div class="form-group">
                <input type="password" class="form-control" name="mdpActuel" placeholder="Mot de passe actuel">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="nouveauMdp" placeholder="Nouveau mot de passe" oninput="checkPassword()">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="confirmationMdp" placeholder="Confirmer le nouveau mot de passe" oninput="checkPassword()">
                <span id="passwordError" class="error-message"></span>
                <?php
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
                    unset($_SESSION['error_message']);
                }
                ?>
            </div>
            <button type="submit" class="btn btn-create btn-block" id="submitBtn">Modifier mon compte</button>
        </form>

        <form id="back-form" action="index.php?controller=accueil&action=index" method="post">
            <button type="submit" class="btn btn-back btn-block">Retour</button>
        </form>

        <button type="button" class="btn btn-danger btn-block" id="deleteAccountBtn" onclick="showConfirmationPopup()">Supprimer mon compte</button>

        <div id="confirmationPopup" class="popup">
            <p>Voulez-vous vraiment supprimer votre compte?</p>
            <button onclick="deleteAccount()">Oui, supprimer</button>
            <button onclick="hideConfirmationPopup()">Annuler</button>
        </div>

    </div>
</div>

<script>
    function checkPassword() {
        var mdpActuel = document.getElementsByName('mdpActuel')[0].value;
        var newPassword = document.getElementsByName('nouveauMdp')[0].value;
        var confirmPassword = document.getElementsByName('confirmationMdp')[0].value;
        var errorSpan = document.getElementById('passwordError');
        var submitBtn = document.getElementById('submitBtn');

        // Si le champ "Nouveau mot de passe" est rempli, effectuer la validation
        if (newPassword !== "") {
            // Les champs de mot de passe sont obligatoires
            if (confirmPassword === "") {
                errorSpan.innerHTML = "Les champs de mot de passe sont obligatoires.";
                submitBtn.disabled = true;
            } else if (newPassword !== confirmPassword) {
                errorSpan.innerHTML = "Les nouveaux mots de passe ne correspondent pas.";
                submitBtn.disabled = true;
            } else {
                // Si le champ "Mot de passe actuel" est rempli, effectuer la vérification
                if (mdpActuel === "") {
                    errorSpan.innerHTML = "Le champ 'Mot de passe actuel' est obligatoire.";
                    submitBtn.disabled = true;
                } else {
                    errorSpan.innerHTML = "";
                    submitBtn.disabled = false;
                }
            }
        } else {
            // Si le champ "Nouveau mot de passe" est vide, pas besoin de validation des champs de mot de passe
            errorSpan.innerHTML = "";
            submitBtn.disabled = false;
        }
    }

    document.getElementsByName('confirmationMdp')[0].addEventListener('input', checkPassword);
    document.getElementsByName('nouveauMdp')[0].addEventListener('input', checkPassword);
    document.getElementsByName('mdpActuel')[0].addEventListener('input', checkPassword);

    function showConfirmationPopup() {
        document.getElementById('confirmationPopup').style.display = 'block';
    }

    function hideConfirmationPopup() {
        document.getElementById('confirmationPopup').style.display = 'none';
    }

    function deleteAccount() {
        window.location.href = 'index.php?controller=account&action=delete';
        alert("Compte supprimé avec succès!");
    }

</script>

</body>
</html>
