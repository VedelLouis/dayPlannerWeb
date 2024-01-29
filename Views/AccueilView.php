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

</body>
</html>