<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.0/font/bootstrap-icons.min.css"
          rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier Journalier</title>
</head>
<body>
<?php

$today = strftime("%A %e %B %Y");
$date = filter_input(INPUT_GET, 'dateCalendar', FILTER_SANITIZE_STRING);
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
if ($date == NULL || $date == date('Y-m-d')) {
    $dateActuelle = $today;
    $date = date('Y-m-d');
    $jourSemaineActuel = strftime("%A");
    $jourMoisActuel = ltrim(strftime("%e"), ' ');
    $moisActuel = strftime("%B");
    $joursSemaine = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

    $premierJourMois = strtotime('first day of this month');
    $jourSemainePremierJour = strtolower(strftime("%A", $premierJourMois));
    $decalage = array_search($jourSemaineActuel, $joursSemaine);

    $currentHour = (int)strftime('%H');
    $previousDate = date('Y-m-d', strtotime(' -1 day'));
    $nextDate = date('Y-m-d', strtotime(' +1 day'));

} else {
    $dateActuelle = strftime("%A %e %B %Y", strtotime($date));

    $jourSemaineActuel = strftime("%A", strtotime($date));
    $jourMoisActuel = ltrim(strftime("%e", strtotime($date)), ' ');
    $moisActuel = strftime("%B", strtotime($date));
    $joursSemaine = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

    $premierJourMois = strtotime('first day of this month', strtotime($date));
    $jourSemainePremierJour = strtolower(strftime("%A", $premierJourMois));
    $decalage = array_search($jourSemaineActuel, $joursSemaine);

    $currentHour = (int)strftime('%H');
    $previousDate = date('Y-m-d', strtotime(' -1 day', strtotime($date)));
    $nextDate = date('Y-m-d', strtotime(' +1 day', strtotime($date)));
}
?>

<form id="dateForm">
    <input type="date" id="dateCalendar" name="dateCalendar">
    <button type="button" onclick="onDateChange()" class="btn btn-date btn-block">Aller à cette date</button>
</form>

<div class="date-container">
    <div class="row">
        <div class="col-auto  flechel d-flex align-items-center justify-content-center">
            <button type="button" onclick="onDateChangePrevious('<?php echo $previousDate ?>');" class="btn btn-light"><i class="bi bi-caret-left fs-2"></i></button>
        </div>

        <div class="col jours-et-dates">
            <div class="row jour">
                <?php
                foreach ($joursSemaine as $jour) {
                    echo '<div class="col">' . strtoupper($jour[0]) . '</div>';
                }
                ?>
            </div>

            <div class="row jour">
                <?php
                // Obtenir le mois et l'année de la date sélectionnée
                $annee = date('Y', strtotime($date));
                $mois = date('m', strtotime($date));

                // Nombre de jours dans le mois précédent
                $joursDansMoisPrecedent = date('t', mktime(0, 0, 0, $mois - 1, 1, $annee));

                for ($i = 0; $i < 7; $i++) {
                    $jourAffiche = $jourMoisActuel - $decalage + $i;
                    // Extraire le jour du mois de la date actuelle
                    $jourActuel = (int)strftime("%e");

                    $dateBouton = date('Y-m-d', strtotime($annee . '-' . $mois . '-' . $jourAffiche));

                    if ($jourAffiche == $jourMoisActuel) {
                        $classeJourActuel = 'jour-actuel';
                    } elseif ($jourAffiche == $jourMoisActuel && $dateActuelle == $today) {
                        $classeJourActuel = 'jour-actuel-today';
                    } else {
                        $classeJourActuel = '';
                    }

                    echo '<button type="button" class="col btn btn-jour ' . $classeJourActuel . '" onclick="goToDate(\'' . $dateBouton . '\')">';

                    if ($jourAffiche <= 0) {
                        // Si le jour est dans le mois précédent
                        $jourAffiche = $joursDansMoisPrecedent + $jourAffiche;
                        echo str_pad($jourAffiche, 2, '0', STR_PAD_LEFT);
                    } elseif ($jourAffiche > date('t', strtotime($date))) {
                        // Si le jour est dans le mois suivant
                        $jourAffiche = $jourAffiche - date('t', strtotime($date));
                        echo str_pad($jourAffiche, 2, '0', STR_PAD_LEFT);
                    } else {
                        // Si le jour est dans le mois en cours
                        echo str_pad($jourAffiche, 2, '0', STR_PAD_LEFT);
                    }

                    echo '</button>';
                }
                ?>
            </div>
        </div>

        <div class="col-auto flecher d-flex align-items-center justify-content-center">
            <button type="button" onclick="onDateChangeNext('<?php echo $nextDate ?>');" class="btn btn-light"><i class="bi bi-caret-right fs-2"></i></button>

        </div>
    </div>

    <h2><?php echo $dateActuelle ?></h2>
</div>


<div class="container">
    <div class="row">
        <?php
        $currentHourMinute = date('H:i');
        for ($i = 0; $i < 24; $i++) {
            echo '<div class="row heureLigne heure-row-' . $i . '">';

            echo '<div class="col-auto colHeure">';
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            echo '<div class="heure">' . $hour . ':00</div>';
            echo '</div>';

            echo '<div class="col colLigne">';

            echo '<div>';
            $classLigneHeure = ($i == $currentHour) ? 'ligneHeureActuelle' : 'ligneHeure';
            echo '<hr class="' . $classLigneHeure . '" />';
            echo '</div>';

            echo '</div>';
            echo '</div>';

            if ($date == NULL || $date == date('Y-m-d')) {
                if ($i == $currentHour) {
                    echo '<div class="row heureLigneActuelle">';

                    echo '<div class="col-auto colHeureActuelle">';
                    echo '<div class="heureActuelle">' . $currentHourMinute . '</div>';
                    echo '</div>';

                    echo '<div class="col colLigneActuelle">';

                    echo '<div>';
                    echo '<hr class="ligneHeureActuelle" />';
                    echo '</div>';

                    echo '</div>';

                    echo '</div>';
                }
            }
        }
        ?>
    </div>
</div>
<?php
if ($date == NULL || $date == date('Y-m-d')) {
    ?>
    <script>

        function updateDateTime() {
            var currentDateElement = document.querySelector('h2');
            var currentTimeElement = document.querySelector('.heureActuelle');
            var now = new Date();

            var days = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
            var day = days[now.getDay()];
            var dayOfMonth = now.getDate().toString().padStart(2, '0');
            var monthNames = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
            var month = monthNames[now.getMonth()];
            var year = now.getFullYear().toString();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');

            var dateString = day + ' ' + dayOfMonth + ' ' + month + ' ' + year;
            var timeString = hours + ':' + minutes;

            currentDateElement.textContent = dateString;
            currentTimeElement.textContent = timeString;
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);

        function updateHourLinePosition() {
            var hourLine = document.querySelector('.heureLigneActuelle');
            var hourLines = document.querySelectorAll('.heureLigne');
            var now = new Date();
            var currentHour = now.getHours(); // Ajout de la récupération de l'heure actuelle
            var currentMinute = now.getMinutes();

            // Calculer le déplacement en pixels
            var totalShift = currentMinute * 0.5;

            // Appliquer le déplacement à la div
            hourLine.style.marginTop = totalShift + 'px';
            hourLine.style.marginBottom = 30 - totalShift + 'px';

            hourLines.forEach(function (hourLine) {
                var hourLineHour = parseInt(hourLine.classList[2].split('-')[2]); // Récupérer l'heure de la classe
                if (hourLineHour === currentHour) {
                    // Enlever le margin-bottom de 30px si c'est l'heure actuelle
                    hourLine.style.marginBottom = '0';
                } else {
                    // Sinon, rétablir le margin-bottom à 30px
                    hourLine.style.marginBottom = '30px';
                }
            });
        }

        updateHourLinePosition();
        setInterval(updateHourLinePosition, 1000);

        function moveCurrentTime() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var timeString = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');

            // Mettre à jour le texte de l'heure actuelle
            document.querySelector('.heureActuelle').innerText = timeString;

            // Récupérer l'élément de l'heure actuelle
            var heureActuelleElement = document.querySelector('.heureActuelle');

            // Récupérer la colonne de l'heure actuelle
            var colHeureActuelle = document.querySelector('.colHeureActuelle');

            // Récupérer la colonne de l'heure précédente
            var previousHour = hours === 0 ? 23 : hours - 1; // Si 0 heures, aller à 23 heures
            var previousHourColumn = document.querySelector('.heure-row-' + previousHour);

            // Si l'heure actuelle est différente de l'heure précédente, déplacer l'élément de l'heure actuelle
            if (previousHourColumn !== colHeureActuelle) {
                // Déplacer l'élément de l'heure actuelle dans la colonne appropriée
                colHeureActuelle.appendChild(heureActuelleElement);
            }
        }

        moveCurrentTime();
        setInterval(moveCurrentTime, 1000);

    </script>
    <?php
}
?>

<script>

    function onDateChange() {
        var newDate = document.getElementById("dateCalendar").value;
        console.log(newDate);
        document.location.href = "index.php?controller=accueil&action=index&dateCalendar=" + newDate;
    }

    function onDateChangePrevious(previousDate) {
        document.location.href = "index.php?controller=accueil&action=index&dateCalendar=" + previousDate;
    }

    function onDateChangeNext(nextDate) {
        document.location.href = "index.php?controller=accueil&action=index&dateCalendar=" + nextDate;
    }

    function goToDate(date) {
        document.location.href = "index.php?controller=accueil&action=index&dateCalendar=" + date;
    }

</script>

</body>
</html>
