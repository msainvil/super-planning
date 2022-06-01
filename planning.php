<?php
require('config.php');

// Initialiser la session

session_start();
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion

if(!isset($_SESSION["email"])) {
    header("Location: index.html");
    exit();
}
$email = $_SESSION["email"];

$users_info = "SELECT * FROM `users` WHERE Email='$email'";

$conn =mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

$resultat = $conn->query($users_info );
while ($ligne = $resultat->fetch_assoc()) {
    $Id_user=$ligne['Id_users'];
    $Username = $ligne['Username'];
    $Email =$ligne['Email'];
    $Nom= $ligne['Nom'];
    $Prenom=$ligne['Prenom'];
    $Pays =$ligne['Pays'];
    $Membership = $ligne['Membership'] ;
}


$get_avatar = "SELECT * FROM `avatar` WHERE Id_users='$Id_user'";

$resultat_avatar = $conn->query($get_avatar );
$avatar_url = 'https://images.squarespace-cdn.com/content/v1/54b7b93ce4b0a3e130d5d232/1519987020970-8IQ7F6Z61LLBCX85A65S/icon.png?format=750w';
while ($ligne = $resultat_avatar->fetch_assoc()) {
    $avatar_url = $ligne['link'];
}

$get_activity = "SELECT * FROM `activity` WHERE Id_users='$Id_user'";
$resultat_activity = $conn->query($get_activity );

$i = 0;
$a = 0;

while ($ligne = $resultat_activity->fetch_assoc()) {

    $Id_activity = $ligne['Id_activity'];
    $Id_users = $ligne['Id_users'];
    $Name_activity = $ligne['Name_activity'];
    $Description = $ligne['Description'];
    $Lieu = $ligne['Lieu'];
    $Etat = $ligne['Etat'];
    $Heure = $ligne['Heure'];
    $Date = $ligne['Date'];
    $Priorite = $ligne['Priorite'];
    $Tags = $ligne['Tags'];
    $Avancement = $ligne['Avancement'];

    $activity[$i] = $ligne;
    $i += 1;


}



function show_activity($Id_activity, $Id_users,$Name_activity,$Description, $Lieu, $Etat, $Heure, $Date, $Priotite, $Tags, $Avancement)
{
    $div_activity = "<div class='activity'>";
    $div_options = "<div class='options'>";

    $div_options_del = "<a href='?del=true&id=".$Id_activity."'><img class='top' src='icon/close.png' /></a>";
    $div_options_mod = "<a href='?modifier=".$Id_activity."><img class='middle' src='icon/edit.png' /></a>";



    $div_container = "<div class='containers' >";
    $div_img = "<div class='img' >";
    $img = "<img src='icon/activity.png'/>";

    $div_close ="</div>";
    $title = utf8_encode("<h1>".$Name_activity." </h1>");
    $resume = utf8_encode("<p>".substr($Description, 0, 150) . '...'."</p>");

    $avancement_label = "<label for='file'>Avancement:</label>";

    $avancement = "<progress id='file' max='100' value='".$Avancement."'>".$Avancement."%</progress>";
    $date = "<p>Date :".$Date."</p>";
    $heure = "<p>Heure :".$Heure."</p>";

    echo htmlspecialchars_decode($div_container);
    echo htmlspecialchars_decode($div_img);
    echo htmlspecialchars_decode($img);
    echo htmlspecialchars_decode($div_close);

    echo htmlspecialchars_decode($div_activity);
    echo htmlspecialchars_decode($title);
    echo htmlspecialchars_decode($resume);
    echo htmlspecialchars_decode($avancement_label);
    echo htmlspecialchars_decode($avancement);
    echo htmlspecialchars_decode($date);
    echo htmlspecialchars_decode($heure);

    echo htmlspecialchars_decode($div_close);

    echo htmlspecialchars_decode($div_options);
    echo htmlspecialchars_decode($div_options_del);
    echo htmlspecialchars_decode($div_options_mod);
    echo htmlspecialchars_decode($div_close);


    echo htmlspecialchars_decode($div_close);

    echo htmlspecialchars_decode("<br/>");
    echo htmlspecialchars_decode("<br/>");
}

function removeTask($activitid) {
    $conn =mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $remove_activity = "DELETE  FROM `activity` WHERE Id_activity='$activitid'";

    $resact = mysqli_query($conn, $remove_activity);

    if($resact){
        return true;
    }
    else{
        return false;
    }

}
$remove_msg = "";
$update_msg = " ";
$add_msg = " ";

if (isset($_GET['del'])) {
    $activitid = $_GET['id'];

    $remove = removeTask($activitid);

    if($remove){

        $remove_msg = "<h3 class='msg'>Tâche supprimer avec succès</h3>";


    }else{
        $remove_msg = "<h3 class='msg'>Erreur lors de la suppression</h3>";


    }
}
function getTabById($Id_activity){
    $conn =mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql = "SELECT * FROM `activity` WHERE Id_activity='$Id_activity'";

    $resultat = $conn->query($sql );

    while ($ligne = $resultat->fetch_assoc()) {
        $activity= $ligne;
    }
    return $activity;
}

if( isset($_REQUEST['titre']) && isset($_REQUEST['date']) && $_REQUEST['edit']== "true")
{

    $conn =mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $_Id_user = $_GET['id_user'];
    $_Name = $_GET['titre'];
    $_Date = $_GET['date'];
    $_Heure = $_GET['heure'];
    $_Lieu = $_GET['lieu'];
    $_Priorite = $_GET['priorite'];
    $_Tags = $_GET['tags'];
    $_Description = $_GET['description'];
    $_Avancement = "En cours";


    $id = $_REQUEST['Id_activity'];
    $sql ="UPDATE `activity` SET  Id_users = '$_Id_user', Name_activity = '$_Name', Description ='$_Description', Lieu = '$_Lieu', Heure = '$_Heure', `Date` = '$_Date', Priorite = '$_Priorite', Tags = '$_Tags', Avancement = '$_Avancement'  WHERE Id_activity='$id'" ;
    $res = mysqli_query($conn, $sql);

    if ($res){

        $update_msg ="<h3 class='msg'>Tâche Mis à jour avec succès</h3>";

    } else {

        $update_msg = "<h3 class='msg'>Erreur lors de la mis à jour de la tache</h3>";

    }

}





/************************ Ajouter une activité ******************************************************/


if (isset($_REQUEST['titre']) && isset($_REQUEST['date']) && isset($_REQUEST['id_user']) && $_REQUEST['add'] == "true" ){


    $titre= $_GET['titre'];
    $date = $_GET['date'];
    $heure = $_GET['heure'];

    $lieu= $_GET['lieu'];
    $priorite = $_GET['priorite'];
    $tags = $_GET['tags'];

    $description = $_GET['description'];
    $id_user = $_GET['id_user'];

    $avancement = 0;
    $etat = "Pas commencé";

    try{

        $query = "INSERT into `activity` (Id_users,Name_activity, Description, Lieu,Etat, Heure, `Date`, Priorite, Tags,Avancement)
              VALUES ('$id_user','$titre','$description','$lieu','$etat','$heure','$date','$priorite','$tags','$avancement')";


        $res = mysqli_query($conn, $query);
        echo $res;
        if($res){
            $add_msg= "<h3 class='msg' >Activités Ajouter avec succès</h3><a class=\"menu-lien1\" href=\"planning.php\">Retour</a> ";


        }
        else{
            $add_msg =  "<h3 class='msg' >Erreur lors de l'ajout</h3>";


        }


    }catch(PDOException $e){
        die('Erreur : '.$e->getMessage());
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mon Planning</title>
    <link rel="icon" type="image/x-icon" href="/icon/favicon.png">

    <!-- STYLES -->



    <link rel="stylesheet" href="assets/css/master.css">
    <link rel="stylesheet" href="assets/css/inscription.css">
    <link rel="stylesheet" href="assets/css/planning.css">


    <!-- SCRIPTS -->


    <!-- SCRIPTS Jquery -->


</head>
<body>
<header>
    <div class="container">

        <div class="left">
            <a href="" class="logo">SuperPlanning<span>.</span></a>

            <nav>

            </nav>
        </div>


        <!-- Bouton switch mode nuit-->


        <div class="buttons">
            <a id="login-btn" href="#" class="btn btn-empty"><?php echo $Username ?></a>
            <a href="logout.php" class="btn">Deconnexion</a>
        </div>

    </div>
</header>



<section>
<div class="wrapper">
    <div class="section">
        <div class="top_navbar">

        </div>








        <div class="container">

            <div class="container-onglets">
                <div class="onglets active">Ajouter</div>
                <div class="onglets">Mon planning</div>
                <div class="onglets edit">Modifier</div>

            </div>

            <div class="contenu active-contenu">
                <h3>Ajouter une nouvelle tâche</h3>
                <hr>
                <?php echo $add_msg ; ?>

                <hr>

                <div class="addPlanning">

                    <form name="AddForm" action="planning.php"  method="GET" >

                        <input type="hidden" id="id_user" name="id_user"  value="<?php echo $Id_user ?>">
                        <input type="hidden" id="add" name="add"  value="true">
                        <input type='hidden' id='edit' name='edit'  value='false'>
                        <input type="text" id="titre" name="titre"  placeholder="Titre" required>
                        <input type="date" id="date" name="date" placeholder="Date" >
                        <input type="time" id="heure" name="heure" placeholder="Heure">
                        <input type="text" id="lieu" name="lieu" placeholder="Lieu">
                        <input type="text" id="priorite" name="priorite" placeholder="Priorité" >
                        <input type="text" id="tags" name="tags" placeholder="Tag1, Tag2">

                        <textarea id="description" name="description" rows="5" cols="55" placeholder="  Description..."></textarea>

                        <input class="btn" type="submit"  value="Ajouter" >

                    </form>

                </div>

            </div>

            <div class="contenu ">
                <h3>Mon planning</h3>
                <hr>
                <?php echo $remove_msg ; ?>
                <hr>
                <style>
                    .vl {
                        border-left: 3px solid #0f0f1a;
                        height: 100%;
                        position: absolute;
                        left: 10%;
                        margin-left: -2px;
                        top: 14%;
                        border-radius: 2px;
                    }
                </style>
                <div class="vl"></div>

                <?php
               if(! isset($activity))
               {

                   echo "<center><h3>Aucune activité ici pour l'instant...</h3></center>";

               }else{
                while($a<count($activity)){

                    foreach ($activity as $ligne) {

                        $Id_activity_ = $ligne['Id_activity'];
                        $Id_users_ = $ligne['Id_users'];
                        $Name_activity_ = $ligne['Name_activity'];
                        $Description_ = $ligne['Description'];
                        $Lieu_ = $ligne['Lieu'];
                        $Etat_ = $ligne['Etat'];
                        $Heure_ = $ligne['Heure'];
                        $Date_ = $ligne['Date'];
                        $Priorite_ = $ligne['Priorite'];
                        $Tags_ = $ligne['Tags'];
                        $Avancement_ = $ligne['Avancement'];

                        show_activity($Id_activity_, $Id_users_,$Name_activity_,$Description_, $Lieu_, $Etat_, $Heure_, $Date_, $Priorite_, $Tags_, $Avancement_);

                    }


                    $a +=1;
                }
               }

                ?>

            </div>
            <div class="contenu editc">
                <h3>Modifier une tâche</h3>
                <br>
                <br>
                <hr>
                <?php echo $update_msg ; ?>
                <hr>
                    <div class="bgedit">
                        <form action="/planning.php" name="edit" method="get">
                            <select class="round"  name="modifier" required>
                                <option value="default">Selectionner une tâche</option>
                                <?php
                                foreach ($activity as $ligne) {
                                    echo "<option value='".$ligne['Id_activity']."'>".$ligne['Name_activity']."</option>";
                                }
                                ?>
                            </select>
                            <input type="submit" value="valider">

                        </form>
                    </div>


                <?php

                if( isset($_GET['modifier']) && $_GET['modifier']!='default' )
                {
                        $this_activity = getTabById($_GET['modifier']);

                        echo " 
 
                            <script>
                            var focus = once(function() { 
                            var ongl =document.querySelector('.onglets');
                            var cont =document.querySelector('.contenu');
                          
                          var edit =document.querySelector('.edit');
                          var editc =document.querySelector('.editc');
                          
                            ongl.classList.remove('active');
                            cont.classList.remove('active-contenu');
                            
                            edit.classList.add('active');
                            editc.classList.add('active-contenu');
                            
                            });
                            
                            focus();

                        </script>
                            
                        ";

                    echo "
                    
                   <div class='addPlanning'>
                  <form name='loginForm' action='planning.php'  method='GET' >
                  
                <label for='titre'>Nom</label>  
                <input type='hidden' id='id_user' name='id_user'  value='".utf8_encode($this_activity['Id_users'])."' required>
                <input type='hidden' id='edit' name='edit'  value='true'>
                <input type='hidden' id='add' name='add'  value='false'>
                <input type='hidden' id='Id_activity' name='Id_activity'   value='".utf8_encode($this_activity['Id_activity'])."'>
                     
                <input type='text' id='titre' name='titre'  placeholder='Titre' value='".utf8_encode($this_activity['Name_activity'])."' required>
                <label for='date'>Date</label> 
                <input type='date' id='date' name='date' placeholder='Date' value='".$this_activity['Date']."'>
                <label for='date'>Heure</label>
                <input type='time' id='heure' name='heure' placeholder='Heure' value='".$this_activity['Heure']."'>
                <label for='date'>Lieu</label>              
                <input type='text' id='lieu' name='lieu' placeholder='Lieu'value='".$this_activity['Lieu']."'>
                <label for='date'>Priorité</label>
                <input type='text' id='priorite' name='priorite' placeholder='Priorité' value='".$this_activity['Priorite']."'>
                <label for='date'>Tags</label>
                
                <input type='text' id='tags' name='tags' placeholder='Tag1, Tag2' value='".$this_activity['Tags']."'>

                <textarea id='description' name='description' rows='5' cols='55'  >".utf8_encode($this_activity['Description'])."</textarea>

                <input class='btn' type='submit' value='Enregistrer'>
                </form>
            </div>";


                }
       ?>

            </div>




        </div>



    <div class="sidebar">
        <div class="profile">
            <img src="<?php echo $avatar_url ?>" alt="profile_picture">

            <h3><?php echo $Prenom." ".$Nom ?></h3>
            <p><?php echo $Membership ?></p>
        </div>

        <ul>
            <li>
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </li>

            <li>

                <a href="#">
                    <span class="item"><a href="logout.php">Deconnexion</a></span>
                </a>

            </li>
        </ul>
    </div>

</div>

</section>
<div class="popup">

</div>

<script>

    const onglets = Array.from(document.querySelectorAll(".onglets"));
    const contenu = Array.from(document.querySelectorAll(".contenu"));


    onglets.forEach(onglet => {
        onglet.addEventListener("click", tabsAnimation)
    })

    let index = 0;

    function tabsAnimation(e){

        const el = e.target;

        onglets[index].classList.remove("active");
        contenu[index].classList.remove("active-contenu");

        index = onglets.indexOf(el);

        onglets[index].classList.add("active")
        contenu[index].classList.add("active-contenu");

    }

    const planning = Array.from(document.querySelectorAll(".onglets"));



</script>
</body>
</html>
