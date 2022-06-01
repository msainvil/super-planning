<?php

require("config.php");


echo '<p>Ajouter une activité</p>';





if (isset($_REQUEST['titre']) && isset($_REQUEST['date'])){

    $titre= $_GET['titre'];
    $date = $_GET['date'];
    $heure = $_GET['heure'];
    $lieu= $_GET['lieu'];
    $priorite = $_GET['priorite'];
    $tags = $_GET['tags'];
    $description = $_GET['description'];
    $id_user = $_GET['id_user'];
    $avancement = 0;

    try{

            $query = "INSERT into `activity` (Id_users,Name_activity, Description, Lieu, Heure, Date, Priorite, Tags,Avancement)
              VALUES ('$id_user','$titre','$description','$lieu','$date','$heure','$priorite','$tags','$avancement')";


        $res = mysqli_query($conn, $query);
            echo $res;
            if($res){
                echo "<h3>Activités Ajouter avec succès</h3><a class=\"menu-lien1\" href=\"planning.php\">Retour</a> ";
                sleep(1);
                header("Location: planning.php");
            }
            else{
                echo "<h3>Erreur lors de l'ajout</h3>";
                header("Location: planning.php");

            }


    }catch(PDOException $e){
        die('Erreur : '.$e->getMessage());
    }
}