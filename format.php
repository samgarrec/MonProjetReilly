<?php
use \Intervention\Image\imageManager;
require ('vendor/autoload.php');
$imgr= new ImageManager();
$i=0;
$imges=glob('src/*');
ini_set('memory_limit', '-1');
set_time_limit ( 200 ) ;
foreach ($imges as $img){
    if( $image = $imgr->make($img)->resize(600, 400, function ($constraint) {$constraint->aspectRatio();})) {
        $image->save('src/'.$i.'.jpg', 80);
        unlink($img);
        $i++;

        echo 'ok;';
        var_dump($img);
    }


}