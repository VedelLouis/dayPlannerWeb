<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier Journalier</title>

    <script>
        function updateClock() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var timeString = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');

            document.querySelector('.heureActuelle').innerText = timeString;

            // Assurez-vous que la classe utilisée ici correspond à celle utilisée dans la boucle PHP
            var currentHourRow = document.querySelector('.heure-row-' + hours);
            var heureActuelleElement = document.querySelector('.heureActuelle');
            var ligneHeureActuelle = document.querySelector('.ligneHeureActuelle');

            heureActuelleElement.parentElement.removeChild(heureActuelleElement);
            currentHourRow.appendChild(heureActuelleElement);

            ligneHeureActuelle.parentElement.removeChild(ligneHeureActuelle);
            currentHourRow.querySelector('.colLigne').appendChild(ligneHeureActuelle);

            setTimeout(updateClock, 1000);
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateClock();
        });
    </script>




</head>
<body>

<?php
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
$dateActuelle = strftime("%A %e %B %Y");
$jourSemaineActuel = strftime("%A");
$jourMoisActuel = strftime("%e");
$moisActuel = strftime("%B");
$joursSemaine = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

$premierJourMois = strtotime('first day of this month');
$jourSemainePremierJour = strtolower(strftime("%A", $premierJourMois));
$decalage = array_search($jourSemaineActuel, $joursSemaine);

$currentHour = (int)strftime('%H');

?>

<div class="date-container">
    <div class="row jour">
        <?php
        foreach ($joursSemaine as $jour) {
            echo '<div class="col">' . strtoupper($jour[0]) . '</div>';
        }
        ?>
    </div>

    <div class="row jour">
        <?php
        for ($i = 0; $i < 7; $i++) {
            $jourAffiche = $jourMoisActuel - $decalage + $i;
            $classeJourActuel = ($jourAffiche == $jourMoisActuel) ? 'jour-actuel' : '';
            echo '<div class="col ' . $classeJourActuel . '">';
            if ($jourAffiche > 0 && $jourAffiche <= date('t', strtotime($dateActuelle))) {
                echo str_pad($jourAffiche, 2, '0', STR_PAD_LEFT);
            }
            echo '</div>';
        }
        ?>
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
            echo '<div class="col heure">' . $hour . ':00</div>';
            if ($i == $currentHour) {
                echo '<div class="heureActuelle">' . $currentHourMinute . '</div>';
            }
            echo '</div>';

            echo '<div class="col colLigne">';
            echo '<table class="table calendar">';
            echo '<tbody>';
            echo '<hr class="ligneHeure" />';
            if ($i === $currentHour) {
                echo '<hr class="ligneHeureActuelle" />';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';

            echo '</div>';
        }
        ?>
    </div>
</div>

</body>
</html>