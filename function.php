<?php
require('config.php');

function addActivity($Id_users, $Name_activity, $Description, $Lieu, $Heure, $Date, $Priorite, $Tags, $conn)
{
        $query = "INSERT into `activity` (Id_users, Name_activity, Description, Lieu, Heure, Date, Priorite, Tags)
                    VALUES ('$Id_users', '$Name_activity', '$Description', '$Lieu', '$Heure', '$Date', '$Priorite', '$Tags')";
        $res = mysqli_query($conn, $query);
        if($res){
            return true;
        }
        else{
            return false;
        }
}
?>