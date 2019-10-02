<?php


class BlogMgr
{


    function secureAccess()
    {
        session_start();
        if (!$this->checkAccess()) {
            header('location:index.php');
            exit();
        }
    }

// verification de la session
    function checkAccess()
    {

        return ($_SESSION['username'] == 'admin');

    }

// affichage du footer

    function printFooter()
    {

        print '</article>';

        print

            "<hr>
<script src=\"../assets/web/assets/jquery/jquery.min.js\"></script>
<script src=\"../assets/popper/popper.min.js\"></script>
<script src=\"../assets/bootstrap/js/bootstrap.min.js\"></script>
<script src=\"../assets/smooth-scroll/smooth-scroll.js\"></script>
<script src=\"../assets/dropdown/js/script.min.js\"></script>
<script src=\"../assets/touch-swipe/jquery.touch-swipe.min.js\"></script>
<script src=\"../assets/theme/js/script.js\"></script>
</body>
</html>";

    }

// affichage du header

    function printHeader($page, $errmessage = null)
    {


        print '<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../css/main.css">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <link rel="stylesheet" href="../assets/web/assets/mobirise-icons/mobirise-icons.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="../assets/dropdown/css/style.css">
    <link rel="stylesheet" href="../assets/socicon/css/styles.css">
    <link rel="stylesheet" href="../assets/theme/css/style.css">
    <link rel="stylesheet" href="../assets/mobirise/css/mbr-additional.css" type="text/css">
    <title>Administration -';
        print $page['windowTitle'];

        print '</title>
</head>
<body>
<section class="menu popup-btn-cards cid-qyXn6aM2G0" once="menu" id="menu2-4k" data-rv-view="3237">

    
    

    <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
        <div class="mbr-overlay" style="opacity: 0.9;"></div>

      <a class="full-link" href="http://www.mobirise.com"></a>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
        <div class="left-menu">
          <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true"><li class="nav-item">
                  <a class="nav-link link text-black display-4" href="../index.html">
                      Home</a>
              </li>
              <li class="nav-item dropdown open">
                  <a class="nav-link link dropdown-toggle text-black display-4" href="https://mobirise.com" data-toggle="dropdown-submenu" aria-expanded="true">
                       Pages</a><div class="dropdown-menu"><a class="dropdown-item text-black display-4" href="page1.html">Page 1</a><a class="dropdown-item text-black display-4" href="page2.html">Page 2</a><a class="dropdown-item text-black display-4" href="page3.html">Page 3</a></div>
              </li></ul>
        </div>

        <div class="brand-container">
          <div class="navbar-brand">
              <span class="navbar-logo">
                  <a href="#">
                      <img src="../download/logo.jpg" alt="Mobirise" media-simple="true" style="height: 3.8rem;">
                  </a>
              </span>
           
          </div>
        </div>

        <div class="right-menu">
          <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true"><li class="nav-item">
                <a class="nav-link link text-black display-4" href="index.html#video1-9o">
                    Watch Video</a>
            </li>
            <li class="nav-item dropdown open">
                <a class="nav-link link dropdown-toggle text-black display-4" href="https://mobirise.com" data-toggle="dropdown-submenu" aria-expanded="true">
                    Blocks</a><div class="dropdown-menu"><a class="dropdown-item text-black display-4" href="menu.html">Menu</a><a class="dropdown-item text-black display-4" href="headers.html">Headers</a><a class="dropdown-item text-black display-4" href="sliders-galleries.html">Sliders &amp; Galleries</a><a class="dropdown-item text-black display-4" href="features.html">Features</a><a class="dropdown-item text-black display-4" href="shops.html">Shops</a><a class="dropdown-item text-black display-4" href="content.html">Content</a><a class="dropdown-item text-black display-4" href="info.html">Info</a><a class="dropdown-item text-black display-4" href="pricings.html">Pricings</a><a class="dropdown-item text-black display-4" href="testimonials.html">Testimonials</a><a class="dropdown-item text-black display-4" href="forms-timelines.html">Forms &amp; Timelines</a><a class="dropdown-item text-black display-4" href="accordions-toggles.html" aria-expanded="false">Accordions &amp; Toggles</a><a class="dropdown-item text-black display-4" href="tables.html" aria-expanded="false">Tables</a><a class="dropdown-item text-black display-4" href="teams.html" aria-expanded="false">Teams</a><a class="dropdown-item text-black display-4" href="footers.html" aria-expanded="false">Footers</a></div>
            </li></ul>
        </div>
      </div>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
          </button>
    </nav>
</section>
<article class="topSite">

<div><a class="btnDeconnexion" href="../index.php?action=logout">Déconnection</a></div>
<h2 style="text-align: center;background-color: blanchedalmond">';
        print $page['title'];
        print'</h2>';
        print $errmessage;
    }


// retourne la liste des fichier du dossier post ayant l'extension .MD
    function listPostFiles()
    {

        return glob('posts/*.md');
    }

    /**
     * @param $file
     *  extrait les metadonnées de la premiere ligne d'un fichier (le titre encodé en json) et décode pour l'enregistrer sous forme de tableau
     */
    function extractMetaDataFroPostFiles($file)
    {
        $fh = fopen($file, 'r');
        $line = fgets($fh);
        fclose($fh);
        return json_decode($line, true);


    }

    function getFromConfig($var)
    {


        static $config;
        include_once('/Applications/MAMP/htdocs/projetreilly/admin/config.php');
        return $config[$var];
    }

    function getExtension($filename)
    {

        $pos = strrpos($filename, '.');
        return substr($filename, $pos + 1);

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
        $index['title'] = 'Liste d\'actualités';
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
            if (method_exists($this, 'tag' . ucfirst($tagName))) {
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

        return (isset($item['next'])) ? '<a href="' . $this->tagPostUrl($item['next']) . '"
            title="Article suivant">' . $this->tagPostTitle($item['next']) . '</a>' : '';
    }

    function tagPreviousPost($item)
    {


        return (isset($item['previous'])) ? '<a href="' . $this->tagPostUrl($item['previous']) . '"
            title="Article precedent">' . $this->tagPostTitle($item['previous']) . '</a>' : '';
    }

    function tagHome()
    {
        return '<a href="../../index.html">Accueil</a>';
    }

    function tagPageDescription($item)
    {

        return (isset($item['resume']));
    }


    function printTableauxEdition()
    {
        $files = $this->listPostFiles();

      print'  <div class="row">
<div class="col-12">
<h2>Gesion des articles</h2>
</div>
<div class="col-12">
<p><a  class="mainLinkEdit" href="edit.php">Créer un nouvel article</a>
<a href="?action=publish" class="mainLinkEdit">Publier</a>
    <a href="/projetreilly/index.html" class="mainLinkEdit">accueil</a></p>
<table border="1">
<tr>
    <th>Titre</th>
    <th>Action</th>
</tr>';

        foreach ($files as $file) {

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
        print '</table></div></div>';
    }


    /**
     * @param $imgFilename
     * @param $width
     * @param $height
     *
     *  gestion du cache contenant les miniatures  et creation de la miniature
     */
    function getResized($imgFilename, $width, $height)
    {

        $cachedFilename = $this->getFromConfig('cacheddirectory') . '/' .
            $this->getResizedFilename($imgFilename, $width, $height);

        if (!file_exists($cachedFilename)) {
            $this->resize($imgFilename, $_SERVER['DOCUMENT_ROOT'] . '/' . $cachedFilename, $width, $height);


        }
        return '/' . $cachedFilename;
    }

    /**
     * @param $imgOriFilename
     * @param $imgDestFilename
     * @param $width
     * @param $height
     * @return bool
     */
    function resize($imgOriFilename, $imgDestFilename, $width, $height)
    {

        if (!is_string($createFunction = $this->getImageCreateFunctionFromFile($imgOriFilename))) {

            return false;
        }

        if (!is_string($writeFunction = $this->getImageWriteFunctionFromFile($imgOriFilename))) {

            return false;
        }
        $oriImg = $createFunction($imgOriFilename);
        $oriWidth = imagesx($oriImg);
        $oriHeight = imagesy($oriImg);

        if ($oriWidth / $oriHeight > $width / $height) {
            $height = $oriHeight / $oriWidth * $width;
        } else {
            $width = $oriWidth / $oriHeight * $height;
        }
        $destImg = imagecreatetruecolor($width, $height);
        imageinterlace($destImg, true);
        imagecopyresized($destImg, $oriImg, 0, 0, 0, 0, $width, $height, $oriWidth, $oriHeight);

        return $writeFunction($destImg, $imgDestFilename);


    }

    function getResizedFilename($imgFilename, $width, $height)
    {

        $ext = $this->getExtension($imgFilename);
        $algo = $this->getFromConfig('cachehashalgo');
        $hash = hash($algo, $imgFilename);
        return $hash . '-' . $width . 'x' . $height . '.' . $ext;

    }


    function getImageCreateFunctionFromFile($filename)
    {
        $type2function = array(

            IMAGETYPE_GIF => 'imagecreatefromgif',
            IMAGETYPE_JPEG => 'imagecreatefromjpeg',
            IMAGETYPE_PNG => 'imagecreatefrompng',


        );
        $type = exif_imagetype($filename);
        return array_key_exists($type, $type2function) ? $type2function[$type] : false;


    }

    function getImageWriteFunctionFromFile($filename)
    {
        $type2function = array(

            IMAGETYPE_GIF => 'imagegif',
            IMAGETYPE_JPEG => 'imagejpeg',
            IMAGETYPE_PNG => 'imagepng',


        );
        $type = exif_imagetype($filename);
        return array_key_exists($type, $type2function) ? $type2function[$type] : false;


    }
}

?>