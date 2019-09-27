<?php


include_once ('includes/functions.php');
secureAccess();
$page['title']='Creation/Edition d\'articles';
$page['windowTitle']="Articles";
    $errmessage=null;
$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
    'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
    'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
    'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
    'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

if ($_POST) {

    if (isset($_POST['titre']) && trim($_POST['titre'])) {
        $fileName = isset($_GET['edition']) ? $_GET['edition'] : strtolower($_POST['titre']);
        $fileName = strtr( $fileName, $unwanted_array );
        $fileName=preg_replace('/[^a-z0-9-]/','-',$fileName);


        $fileName = 'posts/' . $fileName . '.md';
        // creation du tableau de metadonnées
        $metaData['titre'] = $_POST['titre'];
        //on enregistre les données
        $fileContent = json_encode($metaData) . "\n";
        $fileContent .= strip_tags($_POST['contenu']);

         if (file_put_contents($fileName, $fileContent)) {

                header('location:main.php');
            exit;
          } else {
            $errmessage = '<div style="border: 2px solid red ; background:pink;color:red padding:1em;display:inline-block">
               problème lors de l\'enregistrement du fichier</div > ';


          }
         } else {
                      $errmessage = '<div style="border: 2px solid red ; background:pink;color:red padding:1em;display:inline-block">
                    Titre insuffisant</div > ';
          }
    }  elseif (isset($_GET['edition'])){

$fileContent= file_get_contents('posts/'.$_GET['edition'].'.md' );

$explodedContent= explode("\n",$fileContent,2);
$metaData= json_decode($explodedContent[0],true);
$content= $explodedContent[1];


}

?>
<?php printHeader($page); ?>
<?= $errmessage ;?>
<form action="#" method="post">
    <label for="titre" >Titre de l'article</label>
    <input type="text" name="titre" <?php if (isset($metaData['titre'])) echo 'value="'.$metaData['titre'].'"'; ?>>
    <label for="contenu" >Contenu de l'article</label>

    <textarea id="content" rows="25" cols="60" type="text" name="contenu"><?php if (isset($content)) echo $content; ?></textarea>
    <input type="submit" value="envoyer">

<?php printFooter();?>