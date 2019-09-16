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

<form class="row">
    <div class="col-md-6 mt-4">
        <div class="form-group">
            <label>Type :</label><?= '  '.$bien['type'];?>
        </div>
        <div class="form-group">
            <label>Titre :</label><?= '  '.$bien['title'];?>
        </div>
        <div class="form-group">
            <label>Description :</label><?= '  '.$bien['description'];?>
        </div>
        <div class="form-group">
            <label>Surface :</label><?= '  '.$bien['surface'];?>
        </div>
        <div class="form-group">
            <label>Nombre de pièces :</label><?= '  '.$bien['rooms'];?>
        </div>
        <div class="form-group">
            <label>Nombre de chambres :</label><?= '  '.$bien['bedrooms'];?>
        </div>
        <div class="form-group">
            <label>Prix :</label><?= '  ' . (int)$bien['price'] . ' €';?>
        </div>
        <div class="form-group">
            <label>Adresse :</label><?= '  '.$bien['address'];?>
        </div>
        <div class="form-group">
            <label>Code postal :</label><?= '  '.$bien['postal_code'];?>
        </div>
        <div class="form-group">
            <label>Ville :</label><?= '  '.$bien['city'];?>
        </div>
    </div>
    <div class="col-md-6 mt-4">
        <div class="form-group">
            <img src="./images/<?= $bien['image'];?>" alt="<?= $bien['title'] ?>">
        </div>
    </div>
</form>

<?php
$query = $pdo->query("SELECT * FROM biens LEFT JOIN images ON biens.id = images.bien_id WHERE biens.id = $id");
while ($donnees = $query->fetch())
{
    if (isset($donnees['image'])): ?>
<img src="./images/<?= $donnees['name'];?>" style="width:10%;">
<?php
endif;
}
?>

<div class="form-actions">
    <a href="index.php?page=admin">Retour</a>
</div>