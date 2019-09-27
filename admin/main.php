
<?php
$errmessage=null;

    include_once ('includes/functions.php');


    secureAccess();
    // variables propres à la page main
$page['title']='Accueil';
$page['windowTitle']="Gestion des Articles";



if (isset($_GET['action'])=='delete'){

    $fileName= 'posts/'.$_GET['file'].'.md';
   if ( unlink($fileName)){

       $errmessage='<div style="background:pink">Fichier supprimé</div>';
   }


}


?>

<?= printHeader($page,$errmessage); ?>



<?php






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

<?= printFooter() ;?>