<?php

session_start();
if (isset($_GET['action'])=='logout') {


  $_SESSION= array();
    $errmessage='déconnecté';
  header('location:index.php');

} else echo 'bye;';




if (!isset($_SESSION['username'])){

    $_SESSION['username']=null;
}
if (!isset($errmessage)){

   $errmessage=null;
}

if ($_SESSION['username']=='admin'){

    header('location:main.php');
    exit;
}
if ($_POST){

    if ($_POST['username']== 'admin' && $_POST['password']=='monpass'){


        $_SESSION['username']=$_POST['username'];
        header('location:main.php');
        exit;
    } else{
        $errmessage= '<div style="border: 2px solid red ; background:pink;color:red padding:1em;display:inline-block">
        Nom d\'utilisateur ou mot de passe incorrect </div>';

    }
}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Projet Reilly Administration</title>
</head>
<body>
<h1>Accès controllé</h1>
<?php print $errmessage; ?>
<p>Veuillez vous identifier ci dessous </p>

<form action="#" method="post">

    <input type="text" placeholder="Nom d'utilisateur " name="username">
    <input type="password" name="password" placeholder="Votre Mdp">
    <input type="submit">

</form>

</body>
</html>