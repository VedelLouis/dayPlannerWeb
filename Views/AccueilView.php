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
            <button type="button" onclick="onDateChangePrevious('<?php echo $previousDate ?>');" class="btn btn-light">
                <i class="bi bi-caret-left fs-2"></i></button>
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

                    if ($jourAffiche == $jourMoisActuel && $dateBouton == date('Y-m-d')) {
                        $classeJourActuel = 'jour-actuel-today-both';
                    } elseif ($dateBouton == date('Y-m-d')) {
                        $classeJourActuel = 'jour-actuel-today';
                    } elseif ($jourAffiche == $jourMoisActuel) {
                        $classeJourActuel = 'jour-actuel';
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
            <button type="button" onclick="onDateChangeNext('<?php echo $nextDate ?>');" class="btn btn-light"><i
                        class="bi bi-caret-right fs-2"></i></button>

        </div>
    </div>

    <h2><?php echo $dateActuelle ?></h2>
</div>


<div class="container calendar">
    <h1>Calendrier</h1>

    <button type="button" class="btn btn-primary eventButton" data-bs-toggle="modal" data-bs-target="#createEventModal">
        Ajouter un événement <i class="bi bi-bookmark-plus fs-4"></i>
    </button>

    <div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h1 class="modal-title fs-5" id="titleModal">Ajouter un événement</h1>
                            </div>
                            <div class="col text-end">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="index.php?controller=event&action=create" method="post">
                        <div class="mb-3">
                            <label for="eventName" class="form-label">Nom de l'événement</label>
                            <input type="text" class="form-control" id="eventName" name="eventName" required>
                        </div>
                        <div class="mb-3">
                            <label for="dateEvent" class="form-label">Date de l'événement</label>
                            <input type="date" class="form-control" id="eventDate" name="eventDate">
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="startTime" class="form-label">Heure de début</label>
                                <input type="time" class="form-control" id="startTime" name="startTime" required>
                            </div>
                            <div class="col">
                                <label for="endTime" class="form-label">Heure de fin</label>
                                <input type="time" class="form-control" id="endTime" name="endTime" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="eventColor" class="form-label">Couleur de l'événement</label>
                            <input type="color" class="form-control" id="eventColor" name="eventColor">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn saveButton">Créer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateEventModal" tabindex="-1" aria-labelledby="updateEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h1 class="modal-title fs-5" id="titleModal">Modifier l'événement</h1>
                            </div>
                            <div class="col text-end">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="index.php?controller=event&action=update" method="post">
                        <input type="hidden" id="updateEventId" name="updateEventId">
                        <div class="mb-3">
                            <label for="updateEventName" class="form-label">Nom de l'événement</label>
                            <input type="text" class="form-control" id="updateEventName" name="updateEventName" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateEventDateStart" class="form-label">Date de l'événement</label>
                            <input type="date" class="form-control" id="updateEventDate" name="updateEventDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateEventDateEnd" class="form-label">Heure de début</label>
                            <input type="time" class="form-control" id="updateEventTimeStart" name="updateEventTimeStart" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateEventDateEnd" class="form-label">Heure de fin</label>
                            <input type="time" class="form-control" id="updateEventTimeEnd" name="updateEventTimeEnd" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateEventColor" class="form-label">Couleur de l'événement</label>
                            <input type="color" class="form-control" id="updateEventColor" name="updateEventColor" value="#ffffff">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn saveButton">Modifier</button>
                    </form>

                    <form id="deleteEventForm" action="index.php?controller=event&action=delete" method="post">
                        <input type="hidden" id="deleteEventId" name="deleteEventId">
                        <input type="hidden" id="deleteEventDate" name="deleteEventDate">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    $currentHourMinute = date('H:i');
    ?>
    <div class="row tableauHeure">
        <?php
        if ($date == NULL || $date == date('Y-m-d')) {

            echo '<div class="row heureLigneActuelle">';
            echo '<div class="col colLigneActuelle">';
            echo '<hr class="ligneHeureActuelle"/>';
            echo '</div>';
            echo '<div class="col-auto colHeureActuelle">';
            echo '<div class="heureActuelle">';
            echo $currentHourMinute;
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        for ($i = 0; $i < 24; $i++) {
            echo '<div class="row heureLigne heure-row-' . $i . '">';

            echo '<div class="col-auto colHeure">';
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            echo '<div class="heure">' . $hour . ':00</div>';
            echo '</div>';

            echo '</div>';
        }
        ?>

    </div>
</div>

<?php
if ($date == NULL || $date == date('Y-m-d')) {
    ?>
    <script>

        function updateHourLinePosition() {
            var hourLine = document.querySelector('.heureLigneActuelle');
            var now = new Date();
            var currentHour = now.getHours();
            var currentMinute = now.getMinutes();

            var totalShift = ((currentHour * 60 + currentMinute) * 1.5) - 15;

            hourLine.style.marginTop = totalShift + 'px';
        }

        updateHourLinePosition();
        setInterval(updateHourLinePosition, 1000);

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

    function populateUpdateEventModal(eventId, eventName, eventDateStart, eventDateEnd, eventColor) {
        var startDate = new Date(eventDateStart);
        var endDate = new Date(eventDateEnd);

        var eventDate = startDate.toISOString().split('T')[0];

        document.getElementById("updateEventId").value = eventId;
        document.getElementById("updateEventName").value = eventName;
        document.getElementById("updateEventDate").value = eventDate;
        document.getElementById("updateEventTimeStart").value = startDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        document.getElementById("updateEventTimeEnd").value = endDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        document.getElementById("updateEventColor").value = eventColor;

        document.getElementById("deleteEventId").value = eventId;
        document.getElementById("deleteEventDate").value = eventDate;
    }

</script>

<script>

    function createEvents(id, color, dateStart, dateEnd, name) {
        var startTime = new Date(dateStart);
        var endTime = new Date(dateEnd);

        var startHours = startTime.getHours();
        var startMinutes = startTime.getMinutes();
        var endHours = endTime.getHours();
        var endMinutes = endTime.getMinutes();
        var start = (startHours * 60 + startMinutes) * 1.5;
        var duration = (((endHours - startHours) * 60) + (endMinutes - startMinutes)) * 1.5;

        var eventElement = document.createElement('div');
        eventElement.classList.add('event');
        eventElement.classList.add('d-flex');
        eventElement.classList.add('justify-content-center');
        eventElement.style.marginTop = start + 'px';
        eventElement.style.height = duration + 'px';
        eventElement.style.backgroundColor = color + '30';

        var timeStartElement = document.createElement('div');
        timeStartElement.classList.add('timeStart');
        timeStartElement.textContent = startTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        eventElement.appendChild(timeStartElement);

        var timeEndElement = document.createElement('div');
        timeEndElement.classList.add('timeEnd');
        timeEndElement.textContent = endTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        eventElement.appendChild(timeEndElement);

        var nameEventElement = document.createElement('button');
        nameEventElement.classList.add('nameEvent');
        nameEventElement.classList.add('btn');
        nameEventElement.classList.add('btn-primary');
        nameEventElement.textContent = name;
        nameEventElement.style.backgroundColor = color;
        nameEventElement.setAttribute('data-bs-toggle', 'modal');
        nameEventElement.setAttribute('data-bs-target', '#updateEventModal');
        nameEventElement.setAttribute('onclick', 'populateUpdateEventModal("' + id + '","' + name + '", "' + dateStart + '", "' + dateEnd + '", "' + color + '")');
        eventElement.appendChild(nameEventElement);

        var tableauHeure = document.querySelector('.tableauHeure');
        tableauHeure.appendChild(eventElement);
    }

    <?php
    $events = \Repositories\EventRepository::getEvents($date);

    if ($events) {
    foreach ($events as $event) {
    ?>
    var id = '<?php echo $event->getIdEvent(); ?>';
    var color = '<?php echo $event->getColor(); ?>';
    var dateStart = '<?php echo $event->getDateStart(); ?>';
    var dateEnd = '<?php echo $event->getDateEnd(); ?>';
    var name = '<?php echo $event->getName(); ?>';

    createEvents(id, color, dateStart, dateEnd, name);
    <?php
    }
    }
    ?>

</script>

</body>
</html>
