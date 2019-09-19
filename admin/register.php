<?php

include("../lib/connexion.php");

if (isset($_REQUEST['btn_register']))
{
 $username = strip_tags($_REQUEST['txt_username']);
 $email  = strip_tags($_REQUEST['txt_email']);
 $password = strip_tags($_REQUEST['txt_password']);
  
 if (empty($username)){
  $errorMsg[]="Veuillez entrer un nom d'utilisateur";
 }
 else if (empty($email)){
  $errorMsg[]="Veuillez entrer un email";
 }
 else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
  $errorMsg[] = "Veuillez entrer une adresse mail valide";
 }
 else if (empty($password)){
  $errorMsg[] = "Veuillez entrer un mot de passe";
 }
 else if(strlen($password) < 6){
  $errorMsg[] = "Le mot de passe doit comporter au moins 6 caractères";
 }
 else
 { 
  try
  { 
   $select_stmt = $pdo->prepare("SELECT username, email FROM users WHERE username=:uname OR email=:uemail");
   
   $select_stmt->execute(array(':uname'=>$username, ':uemail'=>$email));
   $row=$select_stmt->fetch(PDO::FETCH_ASSOC); 
   
   if ($row["username"] == $username){
    $errorMsg[] = "Désolé ce nom d'utilisateur existe déjà";
   }
   else if($row["email"] == $email){
    $errorMsg[] = "Désolé cet email existe déjà";
   }
   else if (!isset($errorMsg))
   {
    $new_password = password_hash($password, PASSWORD_DEFAULT);
    
    $insert_stmt = $pdo->prepare("INSERT INTO users (username,email,password) VALUES(:uname,:uemail,:upassword)");   
    
    if ($insert_stmt->execute(array( ':uname' =>$username, 
                                    ':uemail'=>$email, 
                                    ':upassword'=>$new_password))){
     $registerMsg="Enregistrement réussi..... Veuillez cliquer sur Login Account pour vous connecter";
    }
   }
  }
  catch(PDOException $e)
  {
   echo $e->getMessage();
  }
 }
}
?>

<?php
if (isset($errorMsg))
{
 foreach ($errorMsg as $error)
 {
 ?>
  <div class="alert alert-danger">
   <strong>WRONG ! <?php echo $error; ?></strong>
  </div>
    <?php
 }
}
if (isset($registerMsg))
{
?>
 <div class="alert alert-success">
  <strong><?php echo $registerMsg; ?></strong>
 </div>
<?php
}
?>

<form method="post" class="form-horizontal pt-4">    
  <div class="form-group">
    <label class="col-sm-3 control-label">Nom d'utilisateur</label>
    <div class="col-sm-6">
      <input type="text" name="txt_username" class="form-control" placeholder="entrez un nom d'utilisateur" />
    </div>
  </div>
    
  <div class="form-group">
    <label class="col-sm-3 control-label">Email</label>
    <div class="col-sm-6">
      <input type="text" name="txt_email" class="form-control" placeholder="entrez un email" />
    </div>
  </div>
     
  <div class="form-group">
    <label class="col-sm-3 control-label">Mot de passe</label>
    <div class="col-sm-6">
      <input type="password" name="txt_password" class="form-control" placeholder="entrez un mot de passe" />
    </div>
  </div>
     
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
      <input type="submit"  name="btn_register" class="btn btn-primary " value="S'enregistrer">
    </div>
  </div>
    
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
      Vous avez déjà un compte ? <a href="index.php?page=login"><p class="text-info">Login</p></a>  
    </div>
  </div>    
</form>