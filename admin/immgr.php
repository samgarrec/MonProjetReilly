<?php
use \Intervention\Image\imageManager;
require ('../vendor/autoload.php');
include_once('modeles/BlogMgr.php');



$page['title']='Gestionnaire d\'image';
$page['windowTitle']='gestion des images';

$blogMgr= new BlogMgr();
$chdir='';

$blogMgr->secureAccess();
$imgRoot=$blogMgr->getFromConfig('imgdirectory').'/';

if (! array_key_exists('immgr',$_SESSION)) $_SESSION['immgr']=array();


    $curDir= $_SESSION['immgr']['currentdir']=$_SERVER['DOCUMENT_ROOT'].'/projetreilly/download/';

    $absoluteCurDir=realpath($_SERVER['DOCUMENT_ROOT'].'/'.$curDir) ;

    if(isset($_GET['action'])=='upload' && $_POST && $_FILES['imagefile'])
        {

         if(strpos($_FILES['imagefile']['type'],'image')!==0){

                     $errmessage='ce n est pas reconnu comme une image';
         }
         else {

                   $i='/'.$chdir;
                   $imgr= new ImageManager();
                   $name=basename($_FILES['imagefile']['name']);
                   move_uploaded_file($_FILES['imagefile']['tmp_name'], $curDir.$i.$name);

                if( $image = $imgr->make($curDir.$name)->resize(null, 200, function ($constraint) {$constraint->aspectRatio();}))

                {
                    echo 'yeaaaah';
                     $image->save($curDir.$name, 80);

                };

    }

}


?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">



</head>
<style>

    img:hover{


        transform: scale(1.2);
        transition-duration: 0.2s;
        cursor: pointer;
    }

</style>
<body style="background-color: crimson;color:white;">



<h2 style="text-align: center;color:white;margin-top: 10px;">Importer des images</h2>

<form enctype="multipart/form-data" method="post" action="?action=upload&dir=<?= $chdir?$chdir:''?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?= $blogMgr->getFromConfig('maxuploadedfilesize');?>">
    <fieldset><legend>Envoyer une image</legend>
        <label for="imagefile">Choisissez une image</label>
        <input  type="file" name="imagefile" id ="directoryname" id="imagefile"><br>
        <input type="submit">
    </fieldset>



</form>

<?php

$imageFiles=array();

$finfo=finfo_open(FILEINFO_MIME_TYPE);
foreach (glob($curDir.'*') as $filename){

    if (strpos(finfo_file($finfo,$filename),'image')===0){

        $imageFiles[]=$filename;}
    }

finfo_close($finfo);

        if($imageFiles){


                          $thumbWidth=$blogMgr->getFromConfig('thumbwidth');
                         $thumbHeight=$blogMgr->getFromConfig('thumbheight');

                      foreach($imageFiles as $imageFile)

                  {
                             $url=substr(realpath($imageFile),strlen($_SERVER['DOCUMENT_ROOT']));
                              print' 
							<img src="'.$blogMgr->getResized($imageFile,$thumbWidth,$thumbHeight).'" style="margin-left:5px;border:4px solid white;box-shadow:2px 2px 3px black;" class="photography-entry img  d-flex justify-content-center align-items-center"
							  onclick="javascript:c=parent.document.getElementById(\'content\');c.value+=\'![texte]('.$url.')\';c.focus()">
							';

                     }

        }


?>





</body>
</html>
