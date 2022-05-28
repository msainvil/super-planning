
<html>
<head>
    <title>SuperPlanning</title>
    <link rel="stylesheet" href="assets/css/master.css">
    <link rel="stylesheet" href="assets/css/inscription.css">
    <link rel="stylesheet" href="assets/css/connexion.css">
</head>
<body>
<?php
require("config.php");

echo '<p>Inscription</p>';

$username = $_POST['username'];
$nom = $_POST['usr_nom'];
$prenom = $_POST['usr_prenom'];
$email = $_POST['usr_mail'];
$password = $_POST['password'];
$telephone = $_POST['usr_phone'];
$nationalite = $_POST['nationalite'];
$membership = "Standard";


echo "Nom : ".$_POST['usr_nom']."</br>";
echo "Prenom : ".$_POST['usr_prenom']. "</br>";

if (isset($_REQUEST['usr_mail'])){

    try{

        $query = "SELECT * FROM `users` WHERE Email='$email' or Username='$username'";
        $result = mysqli_query($conn,$query) or die(mysql_error());
        $rows = mysqli_num_rows($result);

        if($rows==1){
            echo "<h3>Ce utilisateur existe déja (Reessayer avec un autre identifiants ou une adresse email différente) </h3><a class=\"btn insc\" href=\"index.html\">Connexion</a><br><a class=\"btn insc\" href=\"inscription.html\">Retour</a> ";
        }
        else{

            $query = "INSERT into `users` (Username, Email, Password, Nom, Prenom, Pays, Membership)
              VALUES ('$username', '$email','".hash('sha256', $password)."','$nom','$prenom','$nationalite','$membership')";

            $res = mysqli_query($conn, $query);



            if($res){
                echo "<h3>Données Ajouter avec succès</h3><a class=\"menu-lien1\" href=\"index.html\">Retour</a> ";
                header("Location: success.html");
            }
            else{
                echo "<h3>Erreur lors de l'inscription</h3>";
            }
        }

    }catch(PDOException $e){
        die('Erreur : '.$e->getMessage());
    }
}

?>
</body>
</html>