
<?php
$errmessage=null;

    include_once ('includes/functions.php');


if (isset($_GET['action'])=='delete' && isset($_GET['file'])){

    $fileName= 'posts/'.$_GET['file'].'.md';
    if ( unlink($fileName)){

        $errmessage='<div style="background:pink">Fichier supprimé</div>';
    }
}
    secureAccess();
if(isset($_GET['action'])=='publish') {
    include_once('includes/templatesFunctions.php');
    include_once('libs/parsedown.php');
    publish();


}




// variables propres à la page main

$page['title']='Accueil';
$page['windowTitle']="Gestion des Articles";
printHeader($page,$errmessage);

?>




<h2>Gesion des articles</h2>
<p><a href="edit.php">Créer un nouvel article</a></p>
<table border="1">
<tr>
    <th>Titre</th>
    <th>Action</th>
</tr>

   <?php
   $files=listPostFiles();
   foreach ( $files as $file) {

       $metaData=extractMetaDataFroPostFiles($file);
       $shortFile= basename($file,'.md');


       ?>
    <tr>
        <td><?= $metaData['titre'] ?></td>
        <td><a href="edit.php?edition=<?= $shortFile ?>">Modifier</a>
        -- <a href="?action=delete&file=<?= $shortFile ?>">Supprimer</a>
        </td>
    </tr>




      <?php
   }



   ?>
</table>
<a href="?action=publish">Publier</a>


<?= printFooter() ;?>