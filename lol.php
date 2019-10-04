<?php
$t= readline('entrez une heure :  ');

if (($t<=8 && $t>=14)||($t>=9 && $t<=12)){echo ' ouvert                      
';}
else{
    echo 'fermé ';
}