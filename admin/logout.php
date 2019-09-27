<?php
session_start();



if ($_GET['action']=='logout') {


  $_SESSION= array();
    $errmessage='déconnecté';
  header('location:index.php');

} else echo 'bye;';


?>