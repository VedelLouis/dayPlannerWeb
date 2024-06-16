<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/menu.css" type="text/css">
</head>
<body>
<nav class="navbar justify-content-start px-5">
    <a href="index.php?controller=accueil&action=index"><img id="logo" src="Images/dayPlannerLogo.png"></a>
    <ul class="menu">
        <li>
            <a href="index.php?controller=accueil&action=index">Aujourd'hui&nbsp;<i class="bi bi-calendar-day"></i></a>
        </li>
        <li>
            <a href="index.php?controller=account&action=account">Mon compte&nbsp;<i class="bi bi-person"></i></a>
        </li>
        <li>
            <a href="index.php?controller=settings&action=index">Paramètres&nbsp;<i class="bi bi-gear"></i></a>
        </li>
        <li>
            <a href="index.php?controller=connexion&action=deconnect">Déconnexion&nbsp;<i class="bi bi-door-open"></i></a>
        </li>
    </ul>
</nav>
</body>
</html>