<?php


/**
 *
 */
function publish()
{


    // Nettoyage du repertoire temporaire
    if(array_map('unlink', glob('./newSite/*.html'))){


    }

    $postFiles = listPostFiles();


    foreach ($postFiles as $k => $file) {

        $post = array();

        $post['orifile'] = $file;
        $post['url'] = basename($file, '.md').'.html';
        $post['destfile'] = './newSite/'.$post['url'];
        $post['time'] = filemtime($file);
        $explodedContent = explode("\n", file_get_contents($file), 3);
        $post['resume'] = $explodedContent[1];
        $post['content'] = $explodedContent[2];
        $post['meta'] = json_decode($explodedContent[0], true);
        $post['title'] = $post['meta']['titre'];
        $post['template'] = 'templates/post.html';
        $posts[$k] = $post;



    }


    function comparePostsByDate($a, $b)
    {

        if ($a['time'] == $b['time']) return 0;
        return ($a['time'] > $b['time']) ? -1 : 1;

    }

    usort($posts, 'comparePostsByDate');

    foreach ($posts as $k => $post) {


        if ($k) {
            $posts[$k]['previous'] =& $posts[$k - 1];

            $posts[$k-1]['next'] = &$posts[$k];

        }
    }

    foreach ($posts as $post) {

        try {
            file_put_contents($post['destfile'], parseTemplate($post, './templates/page.html'));
        }catch (Exception $e){
            $e->getMessage();
        }
    }
    //generation de la page d'accueil
    $index['template'] = './templates/index.html';
    $index['items'] = $posts;
    $index['title'] = 'Accueil';
    file_put_contents('./newSite/index.html', parseTemplate($index, './templates/page.html'));

    $oldFiles = glob('../*.html');
    foreach ($oldFiles as $file) {

        rename($file, './oldSite/' . basename($file));
    }
    $newFiles = glob('./newSite/*.html');
    foreach ($newFiles as $file) {

        rename($file, '../'. basename($file));
    }
    return '<div style="border:2px solid green">Publication terminée</div>';





}
/**
 * @param $item
 * @param $templateFile
 */
function parseTemplate($item, $templateFile)
{
    $template = file_get_contents($templateFile);
    $tags = searchTags($template);
    foreach ($tags as $tag) {


$tagName = substr($tag, 1, -1);
        $tagFunction = 'tag' . ucfirst($tagName);


        if (function_exists('tag' . ucfirst($tagName))) {
            $template = preg_replace('/' . $tag . '/', $tagFunction($item), $template, 1);
        }}
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
 */
function tagPostUrl($item){

    return $item['url'];
}

    function tagPostContent($item)
    {
        $parsedown=new Parsedown();
        return ($parsedown->text($item['content']));
    }
function tagPostResume($item)
{

    return $item['resume'];
}

    function tagSiteTitle($item)
    {

        return getFromConfig('siteTitle');

    }

    function getFromConfig($var)
    {


        static $config;
        include_once('config.php');
        return $config[$var];
    }

    /**
     *
     */
    function tagContent($item)
    {

        return parseTemplate($item, $item['template']);
    }

    /**
     * @param $item
     */
    function tagPostList($item)
    {
        $result = '';
        foreach ($item['items'] as $item) {

            $result .= parseTemplate($item, './templates/resumepost.html');
        }
        return $result;
    }

    function tagNextPost($item)
    {


        return $item['next'] ? '<a href="' . tagPostUrl($item['next']) . '"
            title="Article suivant">' . tagPostTitle($item['next']) . '</a>' : '';
    }

    function tagPreviousPost($item)
    {


        return $item['previous'] ? '<a href="' . tagPostUrl($item['previous']) . '"
            title="Article precedent">' . tagPostTitle($item['previous']) . '</a>' : '';
    }

    function tagHome(){
        return '<a href="index.html">Accueil</a>';
    }

    function tagPageDescription($item){

        return $item['resume'];
    }
