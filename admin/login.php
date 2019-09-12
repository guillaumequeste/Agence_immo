<?php

include("../lib/connexion.php");

session_start();

if (isset($_SESSION["user_login"])) //check condition session user login not direct back to index.php page
{
 header("location:index.php?page=admin");
}

if (isset($_REQUEST['btn_login'])) //button name is "btn_login" 
{
 $username = strip_tags($_REQUEST["txt_username_email"]); //textbox name "txt_username_email"
 $email  = strip_tags($_REQUEST["txt_username_email"]); //textbox name "txt_username_email"
 $password = strip_tags($_REQUEST["txt_password"]);   //textbox name "txt_password"
  
 if (empty($username)){      
  $errorMsg[] = "Veuillez entrer un nom d'utilisateur ou un email"; //check "username/email" textbox not empty 
 }
 else if (empty($email)){
  $errorMsg[] = "Veuillez entrer un nom d'utilisateur ou un email"; //check "username/email" textbox not empty 
 }
 else if (empty($password)){
  $errorMsg[] = "Veuillez entrer un mot de passe"; //check "passowrd" textbox not empty 
 }
 else
 {
  try
  {
   $select_stmt = $pdo->prepare("SELECT * FROM users WHERE username=:uname OR email=:uemail"); //sql select query
   $select_stmt->execute(array(':uname'=>$username, ':uemail'=>$email)); //execute query with bind parameter
   $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
   
   if ($select_stmt->rowCount() > 0) //check condition database record greater zero after continue
   {
    if($username == $row["username"] OR $email == $row["email"]) //check condition user taypable "username or email" are both match from database "username or email" after continue
    {
     if (password_verify($password, $row["password"])) //check condition user taypable "password" are match from database "password" using password_verify() after continue
     {
      $_SESSION["user_login"] = $row["id"]; //session name is "user_login"
      $loginMsg = "Connexion réussie...";  //user login success message
      header("refresh:2; index.php?page=admin");   //refresh 2 second after redirect to "welcome.php" page
     }
     else
     {
      $errorMsg[] = "mauvais mot de passe";
     }
    }
    else
    {
     $errorMsg[] = "mauvais nom d'utilisateur ou email";
    }
   }
   else
   {
    $errorMsg[] = "mauvais nom d'utilisateur ou email";
   }
  }
  catch(PDOException $e)
  {
   $e->getMessage();
  }  
 }
}
?>

<?php
if (isset($errorMsg))
{
 foreach($errorMsg as $error)
 {
?>

<div class="alert alert-danger">
  <strong><?php echo $error; ?></strong>
</div>

<?php
 }
}
if (isset($loginMsg))
{
?>

<div class="alert alert-success">
  <strong><?php echo $loginMsg; ?></strong>
</div>

<?php
}
?>

<form method="post" class="form-horizontal pt-4">   
  <div class="form-group">
    <label class="col-sm-3 control-label">Nom d'utilisateur ou Email</label>
    <div class="col-sm-6">
      <input type="text" name="txt_username_email" class="form-control" placeholder="entrez un nom d'utilisateur ou un email" />
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
      <input type="submit" name="btn_login" class="btn btn-success" value="Se connecter">
    </div>
  </div>
    
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
      Vous n'avez pas de compte ? <a href="index.php?page=register"><p class="text-info">Créer un compte</p></a>
    </div>
  </div>   
</form>