<?php
    require_once '../vendor/autoload.php';
    require_once '../src/constantes.php';
    use App\Functions;

    // Définir le bon fuseau horaire
    date_default_timezone_set('Europe/Paris');
    // Récupérer l'heure d'aujourd'hui (heure saisie si vide heure actuelle)
    $heure = (int)($_GET['heure'] ?? date('G'));
    // Récupérer le jour (jour saisi si vide on récupère le jour)
    $jour = (int)($_GET['jour'] ?? date('N') - 1);
    // Récupérer les créneaux d'aujourd'hui
    $creneaux = CRENEAUX[$jour];
    // Vérifier si le magasin est ouvert
    $ouvert = Functions::in_creneaux($heure, $creneaux);
    // couleur si ouvert = vert, si fermé = rouge
    $color = $ouvert ? 'green' : 'red';

    // Formulaire de contact
    $array = array("visitor_name" => "", "visitor_email" => "", "visitor_message" => "", "visitor_nameError" => "", "visitor_emailError" => "", "visitor_messageError" => "", "isSuccess" => false);
    $emailTo = "guillaume.queste@laposte.net";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $array["visitor_name"] = test_input($_POST["visitor_name"]);
        $array["visitor_email"] = test_input($_POST["visitor_email"]);
        $array["visitor_message"] = test_input($_POST["visitor_message"]);
        $array["isSuccess"] = true; 
        $emailText = "";
        
        if (empty($array["visitor_name"]))
        {
            $array["visitor_nameError"] = "J'aimerais connaitre votre nom !";
            $array["isSuccess"] = false; 
        } 
        else
        {
            $emailText .= "Nom: {$array['visitor_name']}\n";
        }

        if(!isEmail($array["visitor_email"])) 
        {
            $array["visitor_emailError"] = "Ca ne me semble pas être un email ça !";
            $array["isSuccess"] = false; 
        } 
        else
        {
            $emailText .= "Email: {$array['visitor_email']}\n";
        }

        if (empty($array["visitor_message"]))
        {
            $array["visitor_messageError"] = "Qu'est-ce que vous voulez me dire ?";
            $array["isSuccess"] = false; 
        }
        else
        {
            $emailText .= "Message: {$array['visitor_message']}\n";
        }

        if($array["isSuccess"]) 
        {
            $headers = "From: {$array['visitor_name']} <{$array['visitor_email']}>\r\nReply-To: {$array['visitor_email']}";
            mail($emailTo, "Un message de votre site", $emailText, $headers);
            echo "<div class=\"alert alert-success\">Merci de nous avoir contactés</div>";
        } else {
            echo "<p>Something went wrong.</p>";
        }
    }

    function test_input($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    function isEmail($email) 
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
?>

<div class="row pt-4">
    <div class="offset-md-1 col-md-10">
        <!-- message indiquant si le magasin est ouvert -->
        <?php if($ouvert): ?>
        <div class="alert alert-success">
            Le magasin est ouvert
        </div>
        <?php else: ?>
        <div class="alert alert-danger">
            Le magasin est fermé
        </div>
        <?php endif ?>
        <h3 style="text-align:center;">Horaires d'ouverture</h3>
        <ul>
            <!-- afficher les horaires d'ouverture du magasin -->
            <?php foreach(JOURS as $k => $jour): ?>
                <li>
                    <strong><?= $jour ?></strong> :
                    <?= Functions::creneaux_html(CRENEAUX[$k]) ?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>

<h3 style="text-align:center;">Envoyer un message</h3>
<div class="row pb-4">
    <div class="offset-md-1 col-md-10">
        <form action="index.php?page=contact" method="post">
            <div class="row">
                <div class="col-md-6">
                    <label for="visitor_name">* Votre nom</label>
                    <input type="text" id="visitor_name" name="visitor_name" placeholder="Nom" pattern=[A-Z\sa-z]{3,20} class="form-control">
                    <?php if(!empty($array["visitor_nameError"])): ?>
                        <div class="alert alert-danger">
                            <?= $array["visitor_nameError"] ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="col-md-6">
                    <label for="email">* Votre e-mail</label>
                    <input type="email" id="email" name="visitor_email" placeholder="Email" class="form-control">
                    <?php if(!empty($array["visitor_emailError"])): ?>
                        <div class="alert alert-danger">
                            <?= $array["visitor_emailError"] ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="col-md-12">
                    <label for="message">* Votre message</label>
                    <textarea id="message" name="visitor_message" placeholder="Message" class="form-control" rows="4"></textarea>
                    <?php if(!empty($array["visitor_messageError"])): ?>
                        <div class="alert alert-danger">
                            <?= $array["visitor_messageError"] ?>
                        </div>
                    <?php endif ?>
                </div>
                <div class="col-md-12">
                    <p>* Ces informations sont requises</p>
                </div>
                <div class="col-md-12">
                    <input type="submit" class="btn btn-success" value="Envoyer">
                </div>
            </div>
        </form>
    </div>
</div>