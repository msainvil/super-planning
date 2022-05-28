<?php
require('config.php');
session_start();


if(isset($_POST['email'])){
    $email = $_POST['email'];
    $password= $_POST['password'];

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM `users` WHERE Email='$email' and password='".hash('sha256', $password)."'";

    $result = mysqli_query($conn,$query) or die(mysql_error());
    $rows = mysqli_num_rows($result);

    if($rows==1){
        $_SESSION['email'] = $email;
        header("Location: planning.php");
    }else{
        $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
    }
}
?>
<html>
<head>
    <title>SuperPlanning</title>
    <link rel="stylesheet" href="assets/css/connexion.css">
</head>

<body>
<section>


<h1 id="message">
    <?php
        echo $message;
    ?>
</h1>
<br>
<a class="bouton" href="index.html"> Retour</a>
</section>
<script>
    document.getElementById("message").style.color = "red";
</script>
</body>

</html>


