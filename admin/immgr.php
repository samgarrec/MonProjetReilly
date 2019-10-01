<?php

$page['title']='Gestionnaire d\'image';
$page['windowTitle']='gestion des images';
include_once ('includes/functions.php');
include_once ('includes/imagesFunctions.php');
$chdir='';
secureAccess();
$imgRoot=getFromConfig('imgdirectory').'/';

if (! array_key_exists('immgr',$_SESSION)) $_SESSION['immgr']=array();
//reglage du repertoire courant


$root='root';
if (isset($_GET['chdir']))
{
 echo 'chdorrrr: '.$_GET['chdir'];
   if ($_GET['chdir']==''){

        $curDir= $_SESSION['immgr']['currentdir']=$_SERVER['DOCUMENT_ROOT'].'/projetreilly/download/';

    }elseif (!empty($_GET['chdir'])) {

       echo 'pasroot';
       $newDir = ($_SERVER['DOCUMENT_ROOT'] . '/projetreilly/download/' . $_GET['chdir']);

       $absoluteImgRoot = realpath($_SERVER['DOCUMENT_ROOT'] . '/' . $imgRoot);

       $chdir = $_GET['chdir'];
       $curDir = $_SESSION['immgr']['currentdir'] = $_SERVER['DOCUMENT_ROOT'] . '/projetreilly/download/' . $chdir;


   }}else{
    $curDir= $_SESSION['immgr']['currentdir']=$_SERVER['DOCUMENT_ROOT'].'/projetreilly/download/';
}
$absoluteCurDir=realpath($_SERVER['DOCUMENT_ROOT'].'/'.$curDir) ;

if(isset($_GET['action'])=='upload' && $_POST && $_FILES['imagefile']&& $_GET['dir']){
$chdir=$_GET['dir'];

    if(strpos($_FILES['imagefile']['type'],'image')!==0){


        $errmessage='ce n est pas reconnu comme une image';
    }else {

        $i='/'.$chdir.'/';
        $name=basename($_FILES['imagefile']['name']);
        move_uploaded_file($_FILES['imagefile']['tmp_name'], $curDir.$i.$name);
    }

}


 if (isset($_GET['action'])=='createdir' && $crdir= basename($_POST['directoryname'])){


     if(mkdir('../download/'.$crdir)){
         $curDir.=$crdir.'/';

         $absoluteCurDir= realpath($_SERVER['DOCUMENT_ROOT']).'/'.$curDir;
     }else {


         $errmessage='impossible de creer le dossier'.$crdir;
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
<body>



  <h2>Emplacement actuel :</h2>

<?php

echo $curDir.'<br>';



//remonter d un niveau
if ($curDir != $_SERVER['DOCUMENT_ROOT'].'/projetreilly/download/'){

print '<a href="?chdir=">remonter d un niveau</a>';
}else{
// affichage des dossiers
    $dirs= glob($_SERVER['DOCUMENT_ROOT'].'/projetreilly/download/*', GLOB_ONLYDIR);
    if($dirs){

        print '<ul>';
        foreach ($dirs as $dir)
        {
            $dir= basename($dir);
            $dirb= dirname($curDir);
            print '<li>';
            print '<a href="?chdir='.$dir.'">'.$dir.'</a>';



            print '</li>';

        }
        print '</ul>';


    }


}

$imageFiles=array();

$finfo=finfo_open(FILEINFO_MIME_TYPE);
foreach (glob($curDir.'*') as $filename){

    if (strpos(finfo_file($finfo,$filename),'image')===0){

        $imageFiles[]=$filename;}
}
finfo_close($finfo);
if($imageFiles){


    $thumbWidth=getFromConfig('thumbwidth');
    $thumbHeight=getFromConfig('thumbheight');
    foreach($imageFiles as $imageFile)

    {
        $url=substr(realpath($imageFile),strlen($_SERVER['DOCUMENT_ROOT']));
        print '<img src="'.getResized($imageFile,$thumbWidth,$thumbHeight).'" onclick="javascript:c=parent.document.getElementById(\'content\');
c.value+=\'![texte]('.$url.')\';c.focus();">';
    }

}


?>

  <form enctype="multipart/form-data" method="post" action="?action=upload&dir=<?= $chdir?$chdir:''?>">
      <input type="hidden" name="MAX_FILE_SIZE" value="<?= getFromConfig('maxuploadedfilesize');?>">
      <fieldset><legend>Envoyer une image</legend>
          <label for="imagefile">Choisissez une image</label>
          <input  type="file" name="imagefile" id ="directoryname" id="imagefile"><br>
          <input type="submit">
      </fieldset>



  </form>

<form method="post" action="?action=creatdir">
    <fieldset><legend>Creer un dossier</legend>
    <label for="directoryname">Nom du dossier à creer :</label>
    <input name="directoryname" id="directoryname"><br>
    <input type="submit">
    </fieldset>



</form>



</body>
</html>
