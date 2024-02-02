<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier Journalier</title>
</head>
<body>

<?php
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
$dateActuelle = strftime("%A %e %B %Y");
$jourSemaineActuel = strftime("%A");
$jourMoisActuel = ltrim(strftime("%e"), ' ');
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

            // Vérifier si le jour affiché est dans le mois en cours
            if ($jourAffiche > 0 && $jourAffiche <= date('t', strtotime($dateActuelle))) {
                echo str_pad($jourAffiche, 2, '0', STR_PAD_LEFT);
            } else {
                // Si le jour est hors du mois, afficher les jours du mois précédent
                $jourAffiche = date('t', strtotime('last month', strtotime($dateActuelle))) + $jourAffiche;
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
            echo '<div class="heure">' . $hour . ':00</div>';
            echo '</div>';

            echo '<div class="col colLigne">';

            echo '<div>';
            echo '<hr class="ligneHeure" />';
            echo '</div>';

            echo '</div>';
            echo '</div>';

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
        ?>
    </div>
</div>

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
          var now = new Date();
          var currentMinute = now.getMinutes();

          // Calculer le déplacement en pixels
          var totalShift = currentMinute * 0.5;

          // Appliquer le déplacement à la div
          hourLine.style.marginTop = totalShift + 'px';
          hourLine.style.marginBottom = -totalShift + 'px';
      }

      updateHourLinePosition();
      setInterval(updateHourLinePosition, 1000);

        function moveCurrentTime() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var timeString = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');

            document.querySelector('.heureActuelle').innerText = timeString;

            var currentHourRow = document.querySelector('.heure-row-' + hours);
            var heureLigneActuelleElement = document.querySelector('.heureLigneActuelle');

            heureLigneActuelleElement.parentElement.removeChild(heureLigneActuelleElement);
            currentHourRow.appendChild(heureLigneActuelleElement);
        }

            moveCurrentTime();
            setInterval(moveCurrentTime, 1000);

</script>

</body>
</html>