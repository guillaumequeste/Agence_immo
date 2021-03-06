<?php
     
     include("../lib/connexion.php");
 
    $typeError = $titleError = $descriptionError = $surfaceError = $roomsError = $bedroomsError = $imageError = $priceError = $addressError = $postal_codeError = $cityError = $type = $title = $description = $surface = $rooms = $bedrooms = $price = $address = $postal_code = $city = $image = "";
    $succes = null;
    $erreur = null;

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
        $imagePath  = '../public/images/'. basename($image);
        $imageExtension = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess  = true;
        $isUploadSuccess    = false;
        
        if(empty($type)) 
        {
            $typeError = 'Vous devez choisir un type';
            $isSuccess = false;
        }
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
        if(empty($image)) 
        {
            $imageError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        else
        {
            $isUploadSuccess = true;
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
        
        if($isSuccess && $isUploadSuccess) 
        {
            $statement = $pdo->prepare("INSERT INTO biens (type, title,description,surface,rooms,bedrooms,price,address,postal_code,city,image,created_at) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $statement->execute([$type,$title,$description,$surface,$rooms,$bedrooms,$price,$address,$postal_code,$city,$image]);
            $succes = 'Le bien a été ajouté.';
            header("refresh:2; index.php?page=admin");
        } else {
            $erreur = "Le bien n'a pas été ajouté correctement.";
        }
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>

<h1 style="text-align:center;">Ajouter un bien</h1>
<h6 style="color:blue;">Veillez à bien remplir les 11 champs à chaque fois que vous validez le formulaire</h6>

<?php if ($erreur): ?>
<div class="alert alert-danger">
    <?= $erreur ?>
</div>
<?php elseif ($succes): ?>
<div class="alert alert-success">
    <?= $succes ?>
</div>
<?php endif ?>

<form class="form mb-4" action="index.php?page=insert" role="form" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="type"><span style="font-weight:bold;">1</span> - Type :</label>
        <select name="type">
            <option value="">Veuillez choisir un type</option>
            <option value="Maison">Maison</option>
            <option value="Appartement">Appartement</option>
        </select>
        <span class="help-inline" style="color:red;"><?= $typeError;?></span>
    </div>
    <div class="form-group">
        <label for="title"><span style="font-weight:bold;">2</span> - Titre :</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Titre" value="<?= $title;?>">
        <span class="help-inline" style="color:red;"><?= $titleError;?></span>
    </div>
    <div class="form-group">
        <label for="description"><span style="font-weight:bold;">3</span> - Description :</label>
        <input type="textarea" class="form-control" id="description" name="description" placeholder="Description" value="<?= $description;?>">
        <span class="help-inline" style="color:red;"><?= $descriptionError;?></span>
    </div>
    <div class="form-group">
        <label for="surface"><span style="font-weight:bold;">4</span> - Surface (en m2) :</label>
        <input type="number" step="0.01" class="form-control" id="surface" name="surface" placeholder="Surface" value="<?= $surface;?>">
        <span class="help-inline" style="color:red;"><?= $surfaceError;?></span>
    </div>
    <div class="form-group">
        <label for="rooms"><span style="font-weight:bold;">5</span> - Nombre de pièces :</label>
        <input type="number" step="0.01" class="form-control" id="rooms" name="rooms" placeholder="Nombre de pièces" value="<?= $rooms;?>">
        <span class="help-inline" style="color:red;"><?= $roomsError;?></span>
    </div>
    <div class="form-group">
        <label for="bedrooms"><span style="font-weight:bold;">6</span> - Nombre de chambres :</label>
        <input type="number" step="0.01" class="form-control" id="bedrooms" name="bedrooms" placeholder="Nombre de chambres" value="<?= $bedrooms;?>">
        <span class="help-inline" style="color:red;"><?= $bedroomsError;?></span>
    </div>
    <div class="form-group">
        <label for="price"><span style="font-weight:bold;">7</span> - Prix (en €) :</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?= $price;?>">
        <span class="help-inline" style="color:red;"><?= $priceError;?></span>
    </div>
    <div class="form-group">
        <label for="address"><span style="font-weight:bold;">8</span> - Adresse :</label>
        <input type="textarea" class="form-control" id="address" name="address" placeholder="Adresse" value="<?= $address;?>">
        <span class="help-inline" style="color:red;"><?= $addressError;?></span>
    </div>
    <div class="form-group">
        <label for="postal_code"><span style="font-weight:bold;">9</span> - Code postal :</label>
        <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Code postal" value="<?= $postal_code;?>">
        <span class="help-inline" style="color:red;"><?= $postal_codeError;?></span>
    </div>
    <div class="form-group">
        <label for="city"><span style="font-weight:bold;">10</span> - Ville :</label>
        <input type="text" class="form-control" id="city" name="city" placeholder="Ville" value="<?= $city;?>">
        <span class="help-inline" style="color:red;"><?= $cityError;?></span>
    </div>
    <div class="form-group">
        <label for="image"><span style="font-weight:bold;">11</span> - Sélectionner une image:</label>
        <input type="file" id="image" name="image">
        <span>Si le fichier existe déjà, renommer le fichier avant de l'ajouter.</span>
        <span class="help-inline" style="color:red;"><?= $imageError;?></span>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
        <a class="btn btn-primary" href="index.php?page=admin"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
    </div>
</form>
