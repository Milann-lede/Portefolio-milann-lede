<?php


  $ch = curl_init('https://api.github.com/users/milann-lede/repos');

  $header = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
  curl_setopt($ch, CURLOPT_USERAGENT, $header);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  

  $result = curl_exec($ch);

  $projets = json_decode($result, true);

  
   foreach($projets as $projet ){
    echo($projet ['full_name']);
    echo($projet ['html_url']);
    echo($projet ['created_at']);
    echo("<br>");
    echo("<br>");


   }
