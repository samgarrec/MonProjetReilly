
<?php
require ('modeles/blogMgr.php');

$blogmgr=new blogMgr();
$errmessage=null;



if (isset($_GET['action'])=='delete' && isset($_GET['file'])){

    $fileName= 'posts/'.$_GET['file'].'.md';
    if ( unlink($fileName)){

        $errmessage='<div style="background:pink">Fichier supprimé</div>';
    }
}
    $blogmgr->secureAccess();
if(isset($_GET['action'])=='publish') {
    include_once('libs/parsedown.php');
        $blogmgr->publish();

}




// variables propres à la page main

$page['title']='Accueil';
$page['windowTitle']="Gestion des Articles";
$blogmgr->printHeader($page,$errmessage);

?>




<h2>Gesion des articles</h2>
<p><a href="edit.php">Créer un nouvel article</a></p>
<table border="1">
<tr>
    <th>Titre</th>
    <th>Action</th>
</tr>

   <?php
$blogmgr->printTableauxEdition();



   ?>

<a href="?action=publish">Publier</a>
    <a href="/projetreilly/index.html">accueil</a>



<?php $blogmgr->printFooter() ;?>