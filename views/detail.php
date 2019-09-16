<?php
    include("../lib/connexion.php");

    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }
     
    $statement = $pdo->prepare("SELECT biens.id, biens.type, biens.title, biens.description, biens.surface, biens.rooms, biens.bedrooms, biens.price, biens.address, biens.postal_code, biens.city, biens.image FROM biens WHERE biens.id = ?");
    $statement->execute([$id]);
    $bien = $statement->fetch();

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

?>

<h1 style="text-align:center;"><?= $bien['type'] ?> <?= $bien['title'] ?></h1>

<div class="row">
    <div class="col-md-6 col-12 p-4">
        <img src="./images/<?= $bien['image'];?>" alt="<?= $bien['title'] ?>" style="width:90%;height:40vh">
    </div>
    <div class="col-md-6 p-4">
        <p>Description : <?= '  '.$bien['description'];?></p>
        <p>Surface : <?= '  '.$bien['surface'];?></p>
        <p>Nombre de pièces : <?= '  '.$bien['rooms'];?></p>
        <p>Nombre de chambres : <?= '  '.$bien['bedrooms'];?></p>
        <p>Prix : <?= '  ' . (int)$bien['price'] . ' €';?></p>
        <p>Adresse : <?= '  '.$bien['address'];?></p>
        <p>Code postal : <?= '  '.$bien['postal_code'];?></p>
        <p>Ville : <?= '  '.$bien['city'];?></p>
    </div>
</div>

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
    <?php
    $query = $pdo->query("SELECT * FROM biens LEFT JOIN images ON biens.id = images.bien_id WHERE biens.id = $id");
    $counter = 1;
    while ($donnees = $query->fetch()) {
        if (isset($donnees['image'])): ?>
        <div class="carousel-item <?php if ($counter === 1) { echo 'active'; } ?>" style="width:85vw;height:500px;">
            <img class="d-block w-100" src="./images/<?= $donnees['name'];?>" style="width:85vw;height:500px;">
        </div>
        <?php
        $counter++;
    endif;
        }
        $query->closeCursor();
        ?>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<div class="form-actions mt-4 mb-4">
    <a href="index.php?page=home">Retour</a>
</div>