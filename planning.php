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

while ($ligne = $resultat_avatar->fetch_assoc()) {
    $avatar_url = $ligne['link'];
}

$get_activity = "SELECT * FROM `activity` WHERE Id_users='$Id_user'";
$resultat_activity = $conn->query($get_activity );

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
}

function show_activity($Id_activity, $Id_users,$Name_activity,$Description, $Lieu, $Etat, $Heure, $Date, $Priotite, $Tags, $Avancement)
{
    $div_activity = "<div class='activity'>";
    $div_options = "<div class='options'>";

    $div_options_del = "<a><img class='top' src='icon/close.png' /></a>";
    $div_options_mod = "<a><img class='middle' src='icon/edit.png' /></a>";



    $div_container = "<div class='container' >";
    $div_img = "<div class='img' >";
    $img = "<img src='icon/activity.png'/>";

    $div_close ="</div>";
    $title = utf8_encode("<h1>".$Name_activity." </h1>");
    $resume = utf8_encode("<p>".substr($Description, 0, 200) . '...'."</p>");

    $avancement_label = "<label for='file'>Avancement:</label>";

    $avancement = "<progress id='file' max='100' value='".$Avancement."'>".$Avancement."'%'</progress>";

    echo htmlspecialchars_decode($div_container);
    echo htmlspecialchars_decode($div_img);
    echo htmlspecialchars_decode($img);
    echo htmlspecialchars_decode($div_close);

    echo htmlspecialchars_decode($div_activity);
    echo htmlspecialchars_decode($title);
    echo htmlspecialchars_decode($resume);
    echo htmlspecialchars_decode($avancement_label);
    echo htmlspecialchars_decode($avancement);
    echo htmlspecialchars_decode($div_close);

    echo htmlspecialchars_decode($div_options);
    echo htmlspecialchars_decode($div_options_del);
    echo htmlspecialchars_decode($div_options_mod);
    echo htmlspecialchars_decode($div_close);


    echo htmlspecialchars_decode($div_close);
}






$conn->close();
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
    <script src="assets/js/app.js" defer></script>


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
                <div class="onglets"><img src="icon/plus.png"></div>
                <div class="onglets active"><img class="calendar" src="icon/calendar.png"></div>
                <div class="onglets">Demain</div>
            </div>

            <div class="contenu">
                <h3>Ajouter une nouvelle tâche</h3>
                <hr>

                    <div class="addPlanning">
                        <form name="loginForm" action="planning.php"  method="POST" >

                            <input type="text" name="email" id="email" placeholder="Titre" >
                            <input type="date" id="date" name="password" placeholder="Date">
                            <input type="time" id="heure" name="password" placeholder="Heure">
                            <input type="text" id="lieu" name="password" placeholder="Lieu">
                            <input type="text" id="lieu" name="password" placeholder="Priorité">
                            <input type="text" id="lieu" name="password" placeholder="Priorité">

                            <textarea id="story" name="story" rows="5" cols="50">Description...</textarea>

                            <input class="btn" type="submit" value="Connexion">


                        </form>
                    </div>



            </div>




            <div class="contenu active-contenu">
                <h3>Mon planning</h3>
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
                show_activity($Id_activity, $Id_users,$Name_activity,$Description, $Lieu, $Etat, $Heure, $Date, $Priorite, $Tags, $Avancement);
                ?>

            </div>







            <div class="contenu">
                <h3>Mon planning</h3>
                <hr>
                   </div>


        </div>
    </div>
    <div class="sidebar">
        <div class="profile">
            <img src="<?php echo $avatar_url ?>" alt="profile_picture">

            <h3><?php echo $Prenom."<br>".$Nom ?></h3>
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
                    <span class="icon"><i class="fas fa-cog"></i></span>
                    <span class="item"><a href="logout.php">Deconnexion</a></span>
                </a>
            </li>
        </ul>
    </div>

</div>
</section>
<script>
    const onglets = Array.from(document.querySelectorAll(".onglets"));
    const contenu = Array.from(document.querySelectorAll(".contenu"));

    onglets.forEach(onglet => {
        onglet.addEventListener("click", function(){
            document.querySelector(".onglets").classList.toggle("active");
            document.querySelector(".contenu").classList.toggle("active-contenu");
        })


</script>
</body>
</html>
