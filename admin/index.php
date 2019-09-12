<?php
    include("../lib/connexion.php");

    session_start();

 if(!isset($_SESSION['user_login'])) //check unauthorize user not access in "welcome.php" page
 {
  header("location: index.php?page=home");
 }
    
 $id = $_SESSION['user_login'];
    
 $select_stmt = $pdo->prepare("SELECT * FROM users WHERE id=:uid");
 $select_stmt->execute(array(":uid"=>$id));
 
 $row=$select_stmt->fetch(PDO::FETCH_ASSOC);

 if(isset($_SESSION['user_login']))
 {
 ?>
 <div class="row pt-4 pb-4">
     <div class="col-md-10">
        <h5>Bienvenue 
<?php
   echo $row['username'];
 }
 ?>
, voici la Liste de vos biens :</h5>
    </div>
    <div class="col-md-2">
        <h5><a href="index.php?page=insert">Ajouter un bien</a></h5>
    </div>
</div>
                
<table class="table">
    <thead>
        <tr>
            <th scope="col">Titre</th>
            <th scope="col">Prix</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $statement = $pdo->query('SELECT biens.id, biens.title, biens.price FROM biens ORDER BY biens.id DESC');
        while($bien = $statement->fetch()) : ?>
            <tr>
                <td><?= $bien['title'] ?></td>
                <td><?= $bien['price'] ?> €</td>
                <td width=300>
                    <a class="btn btn-success" href="index.php?page=view&id=<?=$bien['id']?>">Voir</a>
                    <a class="btn btn-primary" href="index.php?page=update&id=<?=$bien['id']?>">Modifier</a>
                    <a class="btn btn-danger" href="index.php?page=delete&id=<?=$bien['id']?>">Supprimer</a>
                </td>
            </tr>
        <?php endwhile ?>
    </tbody>
</table>

<a href="index.php?page=logout">Se déconnecter</a>