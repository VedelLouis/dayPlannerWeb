<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/settings.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <title>Paramètres</title>
</head>
<body>
<div class="container containerSettings">
    <div class="create-container">
        <h2>Paramètres du Thème</h2>
        <button id="theme-toggle" class="theme-toggle">
            <i class="bi bi-brightness-high-fill"></i>
            <i class="bi bi-moon-fill" style="display:none;"></i>
            Changer de thème
        </button>
        <div class="font-size-controls">
            <label>Police des textes</label>
            <button id="decrease-font" class="font-adjust-btn"><i class="bi bi-dash-square"></i></button>
            <button id="increase-font" class="font-adjust-btn"><i class="bi bi-plus-square"></i></button>
        </div>
    </div>

    <form id="back-form" action="index.php?controller=accueil&action=index" method="post">
        <button type="submit" class="btn btn-back btn-block">Retour</button>
    </form>

</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeToggleButton = document.getElementById('theme-toggle');
        const iconBrightness = themeToggleButton.querySelector('.bi-brightness-high-fill');
        const iconMoon = themeToggleButton.querySelector('.bi-moon-fill');
        const bodyElement = document.body;
        const navbarElement = document.querySelector('.navbar');

        themeToggleButton.addEventListener('click', () => {
            iconBrightness.style.display = iconBrightness.style.display === 'none' ? 'block' : 'none';
            iconMoon.style.display = iconMoon.style.display === 'none' ? 'block' : 'none';
            bodyElement.classList.toggle('dark-theme');
            navbarElement.classList.toggle('dark-theme');
        });
    });
</script>
</body>
</html>
