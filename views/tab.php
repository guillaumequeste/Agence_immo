<?php

use App\URLHelper;
use App\TableHelper;
use App\NumberHelper;

require_once '../vendor/autoload.php';
include("../lib/connexion.php");

define('PER_PAGE', 10);

$query = "SELECT * FROM biens";
$queryCount = "SELECT COUNT(id) as count FROM biens";
$params = [];
$sortable = ["id", "type", "city", "price"];

// Recherche par ville
if (!empty($_GET['q'])) {
    $query .= " WHERE city LIKE :city";
    $queryCount .= " WHERE city LIKE :city";
    $params['city'] = '%' . $_GET['q'] . '%';
}

// Organisation
if (!empty($_GET['sort']) && in_array($_GET['sort'], $sortable) ) {
    $direction = $_GET['dir'] ?? 'asc';
    if (!in_array($direction, ['asc', 'desc'])) {
        $direction = 'asc';
    }
    $query .= " ORDER BY " . $_GET['sort'] . " $direction";
}

// Pagination
$page = (int)($_GET['p'] ?? 1);
$offset = ($page-1) * PER_PAGE;

$query .= " LIMIT " . PER_PAGE . " OFFSET $offset";

$statement = $pdo->prepare($query);
$statement->execute($params);
$biens = $statement->fetchAll();

$statement = $pdo->prepare($queryCount);
$statement->execute($params);
$count = (int)$statement->fetch()['count'];
$pages = ceil($count / PER_PAGE);

?>

<h2 class="pt-2 pb-2" style="text-align:center;">Les biens immobiliers</h2>

<!-- formulaire pour recherche par ville -->
<!-- <form action="index.php?page=tab" class="mb-4"> --> <!-- pas de method->GET -->
    <!-- <div class="form-group">
        <input type="text" class="form-control" name="q" placeholder="Rechercher par ville" value="<?= htmlentities($_GET['q'] ?? null) ?>">
    </div>
    <button class="btn btn-primary">Rechercher</button>
</form> -->

<table class="table table-striped">
    <thead>
        <tr>
            <th><?= TableHelper::sort('id', 'ID', $_GET) ?></th>
            <th><?= TableHelper::sort('type', 'Type', $_GET) ?></th>
            <th><?= TableHelper::sort('price', 'Prix', $_GET) ?></th>
            <th><?= TableHelper::sort('city', 'Ville', $_GET) ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($biens as $bien): ?>
        <tr>
        <td>#<?= $bien['id'] ?></td>
            <td><?= $bien['type'] ?></td>
            <td><?= NumberHelper::price($bien['price']); ?></td>
            <td><?= $bien['city'] ?></td>
            <td><a href="index.php?page=detail&id=<?=$bien['id']?>" class="btn btn-primary">Voir plus</a></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php if ($pages > 1 && $page > 1): ?>
    <a href="?<?= URLHelper::withParam($_GET, "p", $page - 1) ?>" class="btn btn-primary">Page précédente</a>
<?php endif ?>

<?php if ($pages > 1 && $page < $pages): ?>
    <a href="?<?= URLHelper::withParam($_GET, "p", $page + 1) ?>" class="btn btn-primary">Page suivante</a>
<?php endif ?>
