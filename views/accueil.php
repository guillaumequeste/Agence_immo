<?php
    include("../lib/connexion.php");

    $statement = $pdo->query('SELECT biens.id, biens.title, biens.surface, biens.rooms, biens.price, biens.image FROM biens ORDER BY biens.id DESC');
?>

<h2 class="pt-2 pb-2" style="text-align:center;">Agence immobilière</h2>

<div class="row">
<?php while($bien = $statement->fetch()) : ?>
    <div class="col-lg-4">
        <div class="card" style="width: 18rem;">
            <img src="./images/<?= $bien['image'];?>" alt="<?= $bien['title'] ?>" style="width: 18rem;height: 10rem;">
            <div class="card-body">
                <h5 class="card-title"><?= $bien['title'] ?></h5>
                <p class="card-text"><?= $bien['surface'] ?> m2 - <?= $bien['rooms'] ?> pièces</p>
                <p class="card-text"><?= number_format($bien['price'], 0, ',', ' ') ?> €</p>
                <a href="index.php?page=detail&id=<?=$bien['id']?>" class="btn btn-primary">Voir plus</a>
            </div>
        </div>
    </div>
<?php endwhile ?>
</div>