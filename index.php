<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Styles/style.css" type="text/css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="icon" href="/Images/dayPlannerLogo.png">
    <title>DayPlanner</title>
</head>

<body>

<div id="wrapper">

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ERROR | E_COMPILE_ERROR | E_CORE_ERROR);
    date_default_timezone_set('Europe/Paris');

    setcookie('idUser', '1234');
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
        case "event":
            $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
            if (!$action) {
                $action = "index";
            }
            $c = new \Controllers\EventController($action);
            break;
        case "task":
            $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
            if (!$action) {
                $action = "index";
            }
            $c = new \Controllers\TaskController($action);
            break;
        case "note":
            $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
            if (!$action) {
                $action = "index";
            }
            $c = new \Controllers\NoteController($action);
            break;
        case "settings":
            $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
            if (!$action) {
                $action = "index";
            }
            $c = new \Controllers\SettingsController($action);
            break;
    }

    ?>

</div>

</body>
</html>
