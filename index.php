<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="Styles/style.css" type="text/css">
    <link rel="stylesheet" href="Styles/menu.css" type="text/css">
    <link rel="stylesheet" href="Styles/accueil.css" type="text/css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="icon" href="/Images/dayPlannerLogo.png">
    <title>DayPlanner</title>
</head>

<body>

<div id="wrapper">

    <?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ERROR | E_COMPILE_ERROR | E_CORE_ERROR);
    date_default_timezone_set('Europe/Paris');

    function loadClasses($classe)
    {
        $cls = str_replace('\\', DIRECTORY_SEPARATOR, $classe);
        include $cls . '.php';
    }

    spl_autoload_register('loadClasses');

    $controller = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_STRING);
    if (!$controller) {
        $controller = "connexion";
    }

    if ($controller !== "connexion" && $controller !== "account") {
        include_once 'Views/MenuView.php';
    }

    switch ($controller) {

        case "connexion":
            $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
            if (!$action) {
                $action = "index";
            }
            $c = new \Controllers\ConnexionController($action);
            break;

        case "accueil":
            $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
            if (!$action) {
                $action = "index";
            }
            $c = new \Controllers\AccueilController($action);
            break;

        case "account":
            $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
            if (!$action) {
                $action = "index";
            }
            $c = new \Controllers\AccountController($action);
            break;

    }

    ?>

</div>

</body>
</html>
