<?php


class blogMgr
{


    function secureAccess(){
        session_start();
        if(!$this->checkAccess()){
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
<div><a href="../index.php?action=logout">Déconnection</a></div>
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
    function publish()
    {


        // Nettoyage du repertoire temporaire
        if (array_map('unlink', glob('./newSite/*.html'))) {


        }
// fonction de la bibliothèque functions
        $postFiles = $this->listPostFiles();


        // pour chaque article, nous enregistrons les informations dans un tableau $post
        foreach ($postFiles as $k => $file) {
            echo 'ok';
            $post = array();

            $post['orifile'] = $file;
            $post['url'] = basename($file, '.md') . '.html';
            $post['destfile'] = './newSite/' . $post['url'];
            $post['time'] = filemtime($file);
            $explodedContent = explode("\n", file_get_contents($file), 3);
            $post['resume'] = $explodedContent[1];
            $post['content'] = $explodedContent[2];
            $post['meta'] = json_decode($explodedContent[0], true);
            $post['title'] = $post['meta']['titre'];
            $post['template'] = 'templates/post.html';
            $posts[$k] = $post;


        }

        // fonction de tri par le champs date
        function comparePostsByDate($a, $b)
        {

            if ($a['time'] == $b['time']) return 0;
            return ($a['time'] > $b['time']) ? -1 : 1;

        }

// tri du tableau $post via la fonction comparePostByDate
        usort($posts, 'comparePostsByDate');


        // création des lien suivants et précédent par article
        foreach ($posts as $k => $post) {


            if ($k) {
                $posts[$k]['previous'] =& $posts[$k - 1];

                $posts[$k - 1]['next'] = &$posts[$k];

            }
        }


        //pour chaque article existant dans le repertoire post
        // nous le déplacons dans le repertoire newSite
        //et nous parsons le templates page.html avec les infos des articles
        foreach ($posts as $post) {

            try {
                file_put_contents($post['destfile'], $this->parseTemplate($post, './templates/page.html'));
            } catch (Exception $e) {
                $e->getMessage();
            }
        }
        //generation de la page d'accueil
        $index['template'] = './templates/index.html';
        $index['items'] = $posts;
        $index['title'] = 'Accueil';
        // enregistrement de la page d'accueil dans new site, zt parssage de page.HTML AVEC LESinfos de la page d'accueil
        file_put_contents('./newSite/index.html', $this->parseTemplate($index, './templates/page.html'));
//selection des fichiers deja publié
        $oldFiles = glob('../*.html');
        foreach ($oldFiles as $file) {
//deplacement de ceux ci dans le repertoire oldSite
            rename($file, './oldSite/' . basename($file));
        }
        //recupération des nouveaux fichiers html dans newSire
        $newFiles = glob('./newSite/*.html');
        foreach ($newFiles as $file) {
//déplacement  de ceux ci a la racine du site ( accessible à l'utilisateur)
            rename($file, '../' . basename($file));
            var_dump('okk');

        }
        return '<div style="border:2px solid green">Publication terminée</div>';


    }

    /**
     * @param $item
     * @param $templateFile
     *
     * fonction permettnt de d'injecter les valeurs des fichier .md dans les teplates associés
     */
    function parseTemplate($item, $templateFile)
    {
        $template = file_get_contents($templateFile);
        // fonction parcourant les template et séléctionne les balises {}
        // recuperer le contenu des balises
        $tags = $this->searchTags($template);

        //pour chaque balise trouvé
        foreach ($tags as $tag) {

// recupération du contenu
            $tagName = substr($tag, 1, -1);
            $tagFunction = 'tag' . ucfirst($tagName);

// si une fonction éxiste ( tagNomDeTag)
            if (method_exists($this,'tag' . ucfirst($tagName))) {
                var_dump('fonction existe');
                //remplacement du tag par la fonction associée
                $template = preg_replace('/' . $tag . '/', $this->$tagFunction($item), $template, 1);
            }
        }
        return $template;


    }


    function searchTags($str)
    {

        preg_match_all('/{[a-zA-Z0-9]*}/', $str, $tags);
        return $tags[0];

    }

    /**
     * @param $item
     */
    function tagPostTitle($item)
    {

        return $item['title'];
    }

    /**
     * @param $item
     *
     * ($item représente un post dans notre application)
     */
    function tagPostUrl($item)
    {

        return $item['url'];
    }

    function tagPostContent($item)
    {
        //parssage du contenu de l'article grace à la librairie Parsedown
        $parsedown = new Parsedown();
        return ($parsedown->text($item['content']));
    }

    function tagPostResume($item)
    {
// le resumé represente la premiere ligne de l'article
        return $item['resume'];
    }

    function tagSiteTitle($item)
    {
        // recuperation des information dans le fichier config.php
        return $this->getFromConfig('siteTitle');

    }



    /**
     *
     */
    function tagContent($item)
    {

        return $this->parseTemplate($item, $item['template']);
    }

    /**
     * @param $item
     *
     * Fonction permettant d'afficher l'extrait de chaque article en page d'accueil
     */
    function tagPostList($item)
    {
        $result = '';
        foreach ($item['items'] as $item) {

            $result .= $this->parseTemplate($item, './templates/resumepost.html');
        }
        return $result;
    }

    function tagNextPost($item)
    {
        // si l'article à un suivant nous affichons le lien vers celui ci, sinon nous n'affichons rien

        return $item['next'] ? '<a href="' . $this->tagPostUrl($item['next']) . '"
            title="Article suivant">' . $this->tagPostTitle($item['next']) . '</a>' : '';
    }

    function tagPreviousPost($item)
    {


        return $item['previous'] ? '<a href="' . $this->tagPostUrl($item['previous']) . '"
            title="Article precedent">' . $this->tagPostTitle($item['previous']) . '</a>' : '';
    }

    function tagHome()
    {
        return '<a href="../../index.html">Accueil</a>';
    }

    function tagPageDescription($item)
    {

        return $item['resume'];
    }


    function printTableauxEdition(){
$files=$this->listPostFiles();
print'<table>';
foreach ( $files as $file) {

    $metaData = $this->extractMetaDataFroPostFiles($file);
    $shortFile = basename($file, '.md');


    ?>
    <tr>
        <td><?= $metaData['titre'] ?></td>
        <td><a href="edit.php?edition=<?= $shortFile ?>">Modifier</a>
            -- <a href="?action=delete&file=<?= $shortFile ?>">Supprimer</a>
        </td>
    </tr>

    <?php
}
print '</table>';}



}


?>