<?php

    include("../lib/connexion.php");

    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    $titleError = $descriptionError = $surfaceError = $roomsError = $bedroomsError = $priceError = $addressError = $postal_codeError = $cityError = $imageError = $title = $description = $surface = $rooms = $bedrooms = $price = $address = $postal_code = $city = $image = "";
    $succes = null;
    $erreur = null;

    if(!empty($_POST)) 
    {
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
                $statement = $pdo->prepare("UPDATE biens  set title = ?, description = ?, surface = ?, rooms = ?, bedrooms = ?, price = ?, address = ?, postal_code = ?, city = ?, image = ? WHERE id = ?");
                $statement->execute([$title,$description,$surface,$rooms,$bedrooms,$price,$address,$postal_code,$city,$image,$id]);
            }
            else
            {
                $statement = $pdo->prepare("UPDATE biens  set title = ?, description = ?, surface = ?, rooms = ?, bedrooms = ?, price = ?, address = ?, postal_code = ?, city = ? WHERE id = ?");
                $statement->execute([$title,$description,$surface,$rooms,$bedrooms,$price,$address,$postal_code,$city,$id]);
            }
            $succes = "Le bien a été modifié correctement.";
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

?>

<h1><strong>Modifier un bien</strong></h1>

<?php if ($erreur): ?>
<div class="alert alert-danger">
    <?= $erreur ?>
</div>
<?php elseif ($succes): ?>
<div class="alert alert-success">
    <?= $succes ?>
</div>
<?php endif ?>

<form class="form mb-4" action="<?= 'index.php?page=update&id='.$id;?>" role="form" method="post" enctype="multipart/form-data">
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
        <label for="image">Image:</label>
        <img src="./images/<?= $image;?>" />
        <label for="image">Sélectionner une nouvelle image:</label>
        <input type="file" id="image" name="image"> 
        <span class="help-inline"><?= $imageError;?></span>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
        <a class="btn btn-primary" href="index.php?page=admin"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
    </div>
</form>
