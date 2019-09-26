

<?php

session_start();



if($_SESSION['username']!='admin'){

    header('location:index.php');
}



?><!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Linux pratique sur Wikpédia</title>
    <meta name="description" content="C'est un magazine spécialisé dans gnu nlinux et les logiciels libres ">
</head>
<body>
<h1>Linux pratique sur wikipédia</h1>

<p><strong><em>Linux pratique</em> </strong> est spéciaisé dans <a href="https://fr.wikipedia.org/wiki/gnu">GNU</a>/<a
        href="https://fr.wikipedia.org/wiki/linux"></a> et les <a href="https://fr.wikipedia.org/wiki/Logiciel_libre" title="logiciels_libres">
    logiciels libres </a> publié par les éditons diamonds , qui publient également <em> <a href="https://fr.wikipedia.org/wiki/linux">MISC</a></em>
</p>
<p>Le premier numéro est né en 1999. la publication de ce magazine est actuellement bimestrielle</p>
<p>Ce magazine s'adresse principalement aux utilisateurs de Linux , qu'ils soient particulier ou professionnels, et traite de l'utilisation du systeme, de la personnalisation
et sa configuration ainsi nque de l'actualité du monde des logiciels libres </p>

<div><a href="post.php">Billets précédents</a><a href="index.php">Accueil</a><a href="main.php">Billet suivant </a> </div>

</body>
</html>