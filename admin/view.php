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

<div class="pt-4 pb-4" style="text-align:center;">
        <div class="pb-4">
            <img src="./images/<?= $bien['image'];?>" alt="<?= $bien['title'] ?>" style="width:60vw;height:60vh;">
        </div>
        <?php
$query = $pdo->query("SELECT * FROM biens LEFT JOIN images ON biens.id = images.bien_id WHERE biens.id = $id");
while ($donnees = $query->fetch())
{
    if (isset($donnees['image'])): ?>
<img src="./images/<?= $donnees['name'];?>">
<?php
endif;
}
?>
</div>

<div class="row">
    <div class="col-md-6">
        <p>Description : <?= '  '.$bien['description'];?></p>
        <p>Surface : <?= '  '.$bien['surface'];?></p>
        <p>Nombre de pièces : <?= '  '.$bien['rooms'];?></p>
        <p>Nombre de chambres : <?= '  '.$bien['bedrooms'];?></p>
    </div>
    <div class="col-md-6">
        <p>Prix : <?= '  ' . (int)$bien['price'] . ' €';?></p>
        <p>Adresse : <?= '  '.$bien['address'];?></p>
        <p>Code postal : <?= '  '.$bien['postal_code'];?></p>
        <p>Ville : <?= '  '.$bien['city'];?></p>
    </div>
</div>



<div class="form-actions">
    <a href="index.php?page=admin">Retour</a>
</div>