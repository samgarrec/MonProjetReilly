
<?php
require('modeles/BlogMgr.php');

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

$page['title']='';
$page['windowTitle']="Gestion des Articles";
$blogmgr->printHeader($page,$errmessage);

?>




   <?php
$blogmgr->printTableauxEdition();



   ?>



</div>

<?php $blogmgr->printFooter() ;?>