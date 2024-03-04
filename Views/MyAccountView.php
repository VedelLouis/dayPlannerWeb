<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/account.css">
    <title>Modifier mon compte</title>
</head>
<body>
<?php
use Repositories\UserRepository;
$connectedUser = UserRepository::getConnectedUser();
?>
<div class="container">
    <div class="create-container">
        <h2>Modifier mon compte</h2>

        <form id="edit-form" action="index.php?controller=account&action=edit" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="login" value="<?php echo $connectedUser->getLogin(); ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="firstname" value="<?php echo $connectedUser->getFirstName(); ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="lastname" value="<?php echo $connectedUser->getLastName(); ?>">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="nouveauMdp" placeholder="Nouveau mot de passe"
                       oninput="checkPassword()">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="confirmationMdp"
                       placeholder="Confirmer le nouveau mot de passe" oninput="checkPassword()">
                <span id="passwordError" class="error-message"></span>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="mdpActuel" placeholder="Mot de passe actuel" required>
            </div>
            <?php
            if (isset($erreur_modification)) {
                echo '<div class="error-message">' . $erreur_modification . '</div>';
            }
            ?>
            <button type="submit" class="btn btn-update btn-block" id="submitBtn" disabled>Modifier mon compte</button>
        </form>

        <?php
        if (isset($modification)) {
            echo '<div class="success-message">' . $modification . '</div>';
        }
        ?>

        <form id="back-form" action="index.php?controller=accueil&action=index" method="post">
            <button type="submit" class="btn btn-back btn-block">Retour</button>
        </form>

        <button type="button" class="btn btn-danger btn-block" id="deleteAccountBtn" onclick="showConfirmationPopup()">
            Supprimer mon compte
        </button>

        <form id="delete-form" action="index.php?controller=account&action=delete" method="post">
            <div id="confirmationPopup" class="popup" <?php if(isset($erreur_suppression)) echo 'style="display: block;"'; ?>>
                <p>Voulez-vous vraiment supprimer votre compte?</p>
                <div class="form-group">
                    <input type="password" class="form-control" name="confirmDeletePassword" placeholder="Mot de passe"
                           required>
                </div>
                <?php
                if (isset($erreur_suppression)) {
                    echo '<div class="error-message">' . $erreur_suppression . '</div>';
                }
                ?>
                <button type="submit" class="btn btn-danger btn-block" onclick="deleteAccount()" id="submitDeleteBtn">Oui, supprimer</button>
                <button type="button" class="btn btn-cancel btn-block" onclick="hideConfirmationPopup()">Annuler
                </button>
                <br>
                <span id="deletePasswordError" class="error-message"></span>
            </div>
        </form>

    </div>
</div>

<script>
    function checkPassword() {
        var mdpActuel = document.getElementsByName('mdpActuel')[0].value;
        var newPassword = document.getElementsByName('nouveauMdp')[0].value;
        var confirmPassword = document.getElementsByName('confirmationMdp')[0].value;
        var errorSpan = document.getElementById('passwordError');
        var submitBtn = document.getElementById('submitBtn');

        if (newPassword !== "") {
            if (confirmPassword === "") {
                errorSpan.innerHTML = "Les champs de mot de passe sont obligatoires.";
                submitBtn.disabled = true;
            } else if (newPassword !== confirmPassword) {
                errorSpan.innerHTML = "Les nouveaux mots de passe ne correspondent pas.";
                submitBtn.disabled = true;
            } else {
                if (mdpActuel === "") {
                    errorSpan.innerHTML = "Le champ 'Mot de passe actuel' est obligatoire.";
                    submitBtn.disabled = true;
                } else {
                    errorSpan.innerHTML = "";
                    submitBtn.disabled = false;
                }
            }
        } else {
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
        resetDeleteForm();
    }

    function resetDeleteForm() {
        var submitDeleteBtn = document.getElementById('submitDeleteBtn');
        var errorSpan = document.getElementById('deletePasswordError');
        var confirmDeletePasswordInput = document.getElementsByName('confirmDeletePassword')[0];
        confirmDeletePasswordInput.value = "";
        errorSpan.innerHTML = "";
    }

    function deleteAccount() {
        var confirmDeletePassword = document.getElementsByName('confirmDeletePassword')[0].value;
        var errorSpan = document.getElementById('deletePasswordError');

        if (confirmDeletePassword === "") {
            errorSpan.innerHTML = "Veuillez saisir votre mot de passe pour confirmer la suppression du compte.";
        }
    }

    <?php if(isset($erreur_suppression)) : ?>
    window.onload = function() {
        showConfirmationPopup();
    };
    <?php endif; ?>

</script>

</body>
</html>