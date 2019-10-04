<?php



$icon= $datas['weather'][0]['icon'];?>


<div id="encart-meteo" >
<h2>Temps Aujoud'hui à  <?=$datas['name']; ?></h2>

<?php

print '<img src="http://openweathermap.org/img/wn/'.$icon.'@2x.png">';
?>
<ul>

    <li> il fera <?=$datas['weather'][0]['description'];?></li>
      <!--  <img src="http://openweathermap.org/img/wn/.png"> -->


    <li>Température : <?=$datas['main']['temp']; ?> C°</li>
    <li>Vent : <?=$datas['wind']['speed']*3.6 ?>  Kmh</li>
    <li>Humidité : <?=$datas['main']['humidity']; ?>  %</li>







</ul>
</div>