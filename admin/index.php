<?php

session_start();



    if(isset($_POST['username'])=='admin' && isset($_POST['password'])=='kangourou'){

        $_SESSION['username']='admin';
        header('location:../main.php');


    }



?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Projet Reilly Admonistration</title>
</head>
<body>
<?= $e ?>
<h1>Accès controllé</h1>
<p>Veuillez vous identifier ci dessous </p>

<form action="#" method="post">

    <input type="text" placeholder="Nom d'utilisateur " name="username">
    <input type="password" name="password" placeholder="Votre Mdp">
    <input type="submit">

</form>

</body>
</html>