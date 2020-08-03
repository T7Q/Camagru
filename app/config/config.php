<?php
  // App Root
  define('APPROOT', trim(basename(dirname($_SERVER['PHP_SELF']))));
  // URL Root
  // define('URLROOT', 'http://localhost:8080/camagru10');
  // Site Name

   // Application URL
   if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
    $urlroot = "https://";
  } else {
    $urlroot = "http://";
  }
  // Append the host(domain name, ip) to the URL.
  $urlroot .= $_SERVER['HTTP_HOST'];
  // Append the requested resource location to the URL
  $urlroot .= dirname($_SERVER['PHP_SELF']);
  
  define('URLROOT', $urlroot);
  define('SITENAME', 'Camagru');

?>