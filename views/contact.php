<?php
    require_once '../vendor/autoload.php';
    require_once '../src/constantes.php';
    use App\Functions;

    // Définir le bon fuseau horaire
    date_default_timezone_set('Europe/Paris');
    // Récupérer l'heure d'aujourd'hui (heure saisie si vide heure actuelle)
    $heure = (int)($_GET['heure'] ?? date('G'));
    // Récupérer le jour (jour saisi si vide on récupère le jour)
    $jour = (int)($_GET['jour'] ?? date('N') - 1);
    // Récupérer les créneaux d'aujourd'hui
    $creneaux = CRENEAUX[$jour];
    // Vérifier si le magasin est ouvert
    $ouvert = Functions::in_creneaux($heure, $creneaux);
    // couleur si ouvert = vert, si fermé = rouge
    $color = $ouvert ? 'green' : 'red';
?>

<div class="row pt-4">
    <div class="offset-md-1 col-md-10">
        <!-- message indiquant si le magasin est ouvert -->
        <?php if($ouvert): ?>
        <div class="alert alert-success">
            Le magasin est ouvert
        </div>
        <?php else: ?>
        <div class="alert alert-danger">
            Le magasin est fermé
        </div>
        <?php endif ?>
        <h3 style="text-align:center;">Horaires d'ouverture :</h3>
        <ul>
            <!-- afficher les horaires d'ouverture du magasin -->
            <?php foreach(JOURS as $k => $jour): ?>
                <li>
                    <strong><?= $jour ?></strong> :
                    <?= Functions::creneaux_html(CRENEAUX[$k]) ?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>