<?php


function secureAccess(){

    session_start();

    if(!checkAccess()){

        header('location:index.php');
        exit();

    }
}

/**
 *
 *
 */
function checkAccess()
{

    return ($_SESSION['username']=='admin');

}


function printFooter(){

    print

        "<hr>

</body>
</html>";

}


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

function listPostFiles(){

    return glob('posts/*.md');
}

/**
 * @param $file
 */
function extractMetaDataFroPostFiles($file){
    $fh= fopen($file,'r');
    $line=fgets($fh);
    fclose($fh);
    return json_decode($line,true);


}