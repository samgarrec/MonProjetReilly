<?php


function secureAccess(){
    session_start();
    if(!checkAccess()){
        header('location:index.php');
        exit();
    }
}

// verification de la session
function checkAccess()
{

    return ($_SESSION['username']=='admin');

}
// affichage du footer

function printFooter(){

    print

        "<hr>

</body>
</html>";

}

// affichage du header

function printHeader($page,$errmessage=null){


    print '<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administration -';  print $page['windowTitle'];

    print '</title>
</head>
<body>
<h1>Administration</h1>
<div><a href="./index.php?action=logout">Déconnection</a></div>
<h2 style="text-align: center;background-color: blanchedalmond">';
    print $page['title'];
    print'</h2>';
    print $errmessage;
}


// retourne la liste des fichier du dossier post ayant l'extension .MD
function listPostFiles(){

    return glob('posts/*.md');
}

/**
 * @param $file
 *  extrait les metadonnées de la premiere ligne d'un fichier (le titre encodé en json) et décode pour l'enregistrer sous forme de tableau
 */
function extractMetaDataFroPostFiles($file){
    $fh= fopen($file,'r');
    $line=fgets($fh);
    fclose($fh);
    return json_decode($line,true);


}
function getFromConfig($var)
{


    static $config;
    include_once('/Applications/MAMP/htdocs/projetreilly/admin/config.php');
    return $config[$var];
}
function getExtension($filename){

    $pos=strrpos($filename,'.');
    return substr($filename,$pos+1);

}