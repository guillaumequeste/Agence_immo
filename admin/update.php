<?php

    include("../lib/connexion.php");

    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    // modifier les données concernant le bien
    $titleError = $descriptionError = $surfaceError = $roomsError = $bedroomsError = $priceError = $addressError = $postal_codeError = $cityError = $imageError = $type = $title = $description = $surface = $rooms = $bedrooms = $price = $address = $postal_code = $city = $image = "";
    $succes = null;
    $erreur = null;
    $succesPhotos = null;
    $erreurPhotos = null;

    if(!empty($_POST)) 
    {
        $type = checkInput($_POST['type']);
        $title = checkInput($_POST['title']);
        $description = checkInput($_POST['description']);
        $surface = checkInput($_POST['surface']);
        $rooms = checkInput($_POST['rooms']);
        $bedrooms = checkInput($_POST['bedrooms']);
        $price = checkInput($_POST['price']);
        $address = checkInput($_POST['address']);
        $postal_code = checkInput($_POST['postal_code']);
        $city = checkInput($_POST['city']);
        $image = checkInput($_FILES["image"]["name"]);
        $imagePath = './images/'. basename($image);
        $imageExtension = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess  = true;
       
        if(empty($title)) 
        {
            $titleError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($description)) 
        {
            $descriptionError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($surface)) 
        {
            $surfaceError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($rooms)) 
        {
            $roomsError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($bedrooms)) 
        {
            $bedroomsError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($price)) 
        {
            $priceError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($address)) 
        {
            $addressError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($postal_code)) 
        {
            $postal_codeError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($city)) 
        {
            $cityError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($image)) // le input file est vide, ce qui signifie que l'image n'a pas ete update
        {
            $isImageUpdated = false;
        }
        else
        {
            $isImageUpdated = true;
            $isUploadSuccess =true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
            {
                $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath)) 
            {
                $imageError = "Le fichier existe deja";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 500000) 
            {
                $imageError = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) 
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
                {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                } 
            } 
        }
         
        if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) 
        { 
            if($isImageUpdated)
            {
                $statement = $pdo->prepare("UPDATE biens  set type = ?, title = ?, description = ?, surface = ?, rooms = ?, bedrooms = ?, price = ?, address = ?, postal_code = ?, city = ?, image = ? WHERE id = ?");
                $statement->execute([$type, $title,$description,$surface,$rooms,$bedrooms,$price,$address,$postal_code,$city,$image,$id]);
            }
            else
            {
                $statement = $pdo->prepare("UPDATE biens  set type = ?, title = ?, description = ?, surface = ?, rooms = ?, bedrooms = ?, price = ?, address = ?, postal_code = ?, city = ? WHERE id = ?");
                $statement->execute([$type, $title,$description,$surface,$rooms,$bedrooms,$price,$address,$postal_code,$city,$id]);
            }
            $succes = "Le bien a été modifié correctement.";
            header("refresh:2; index.php?page=admin");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $statement = $pdo->prepare("SELECT * FROM biens where id = ?");
            $statement->execute([$id]);
            $bien = $statement->fetch();
            $image = $item['image'];
            $erreur = "Le bien n'a pas été modifié correctement.";
        }
    }
    else 
    {
        $statement = $pdo->prepare("SELECT * FROM biens where id = ?");
        $statement->execute([$id]);
        $item = $statement->fetch();
        $type = $item['type'];
        $title = $item['title'];
        $description = $item['description'];
        $surface = $item['surface'];
        $rooms = $item['rooms'];
        $bedrooms = $item['bedrooms'];
        $price = $item['price'];
        $address = $item['address'];
        $postal_code = $item['postal_code'];
        $city = $item['city'];
        $image = $item['image'];
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    // ajout de photos
    if(isset($_POST['submit'])){
        $countfiles = count($_FILES['files']['name']);
        $id = checkInput($_GET['id']);
        $query = "INSERT INTO images (bien_id,name,image) VALUES($id,?,?)";
        $statement = $pdo->prepare($query);
        for($i=0;$i<$countfiles;$i++){
          $filename = $_FILES['files']['name'][$i];
          $ext = end((explode(".", $filename)));
          $valid_ext = array("png","jpeg","jpg");
          if(in_array($ext, $valid_ext)){
            if(move_uploaded_file($_FILES['files']['tmp_name'][$i],'../public/images/'.$filename)){
              $statement->execute(array($filename,'../public/images/'.$filename));
            } else {
             $erreurPhotos = "L'enregistrement a échoué";
             }
          }
        }
        $succesPhotos = "Enregistrement réussi";
      }

?>

<h1 style="text-align: center;"><strong>Modifier un bien</strong></h1>

<?php if ($erreur): ?>
<div class="alert alert-danger">
    <?= $erreur ?>
</div>
<?php elseif ($succes): ?>
<div class="alert alert-success">
    <?= $succes ?>
</div>
<?php endif ?>

<?php if ($erreurPhotos): ?>
<div class="alert alert-danger">
    <?= $erreurPhotos ?>
</div>
<?php elseif ($succesPhotos): ?>
<div class="alert alert-success">
    <?= $succesPhotos ?>
</div>
<?php endif ?>

<form class="form mb-4" action="<?= 'index.php?page=update&id='.$id;?>" role="form" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="type">Type :</label>
        <select name="type">
            <option value="<?= $type ?>"><?= $type ?></option>
            <option value="maison">Maison</option>
            <option value="appartement">Appartement</option>
        </select>
    </div>    
    <div class="form-group">
        <label for="title">Titre :</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Titre" value="<?= $title;?>">
        <span class="help-inline"><?= $titleError;?></span>
    </div>
    <div class="form-group">
        <label for="description">Description :</label>
        <input type="textarea" class="form-control" id="description" name="description" placeholder="Description" value="<?= $description;?>">
        <span class="help-inline"><?= $descriptionError;?></span>
    </div>
    <div class="form-group">
        <label for="surface">Surface :</label>
        <input type="number" class="form-control" id="surface" name="surface" placeholder="Surface" value="<?= $surface;?>">
        <span class="help-inline"><?= $surfaceError;?></span>
    </div>
    <div class="form-group">
        <label for="rooms">Nombre de pièces :</label>
        <input type="number" class="form-control" id="rooms" name="rooms" placeholder="Nombre de pièces" value="<?= $rooms;?>">
        <span class="help-inline"><?= $roomsError;?></span>
    </div>
    <div class="form-group">
        <label for="bedrooms">Nombre de chambres :</label>
        <input type="number" class="form-control" id="bedrooms" name="bedrooms" placeholder="Nombre de chambres" value="<?= $bedrooms;?>">
        <span class="help-inline"><?= $bedroomsError;?></span>
    </div>
    <div class="form-group">
        <label for="price">Prix (en €) :</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?= $price;?>">
        <span class="help-inline"><?= $priceError;?></span>
    </div>
    <div class="form-group">
        <label for="address">Adresse :</label>
        <input type="text" class="form-control" id="address" name="address" placeholder="Adresse" value="<?= $address;?>">
        <span class="help-inline"><?= $addressError;?></span>
    </div>
    <div class="form-group">
        <label for="postal_code">Code postal :</label>
        <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Code postal" value="<?= $postal_code;?>">
        <span class="help-inline"><?= $postal_codeError;?></span>
    </div>
    <div class="form-group">
        <label for="city">Ville :</label>
        <input type="text" class="form-control" id="city" name="city" placeholder="Ville" value="<?= $city;?>">
        <span class="help-inline"><?= $cityError;?></span>
    </div>
    <div class="form-group">
        <label for="image">Image :</label>
        <img src="./images/<?= $image;?>" style="width:300px;"/>
        <label for="image">Sélectionner une nouvelle image:</label>
        <input type="file" id="image" name="image"> 
        <span class="help-inline"><?= $imageError;?></span>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
        <a class="btn btn-primary" href="index.php?page=admin"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
    </div>
</form>

<h4>Ajouter des photos</h4>
 
<?php if ($erreurPhotos): ?>
<div class="alert alert-danger">
    <?= $erreurPhotos ?>
</div>
<?php elseif ($succesPhotos): ?>
<div class="alert alert-success">
    <?= $succesPhotos ?>
</div>
<?php endif ?>

 <!-- formulaire pour l'ajout de photos -->
 <form method='post' action='' enctype='multipart/form-data' class="pt-4 pb-4">
   <input type='file' name='files[]' multiple />
   <input type='submit' value='Valider' name='submit' />
 </form>

<!-- affichage des photos -->
<div class="row">
    <div class="col-3">
    <?php
    $query = $pdo->query("SELECT * FROM biens LEFT JOIN images ON biens.id = images.bien_id WHERE biens.id = $id");
    while ($donnees = $query->fetch())
    {
    if (isset($donnees['image'])): ?>
        <div class="container pb-4">
            <img src="./images/<?= $donnees['name'];?>" style="width:150px;">
            <button style="width:150px;"><a href="index.php?page=deletePhotos&id=<?=$donnees['id']?>" style="text-decoration:none;color:black;">supprimer</a></button>
        </div>
    <?php
    endif;
    }
    ?>
    </div>
</div>