<?php
	// Initialiser la session
	session_start();
	
	// Détruire la session.
	if(session_destroy())
	{
        mysql_close();
		// Redirection vers la page de connexion
		header("Location: index.html");
	}
?>