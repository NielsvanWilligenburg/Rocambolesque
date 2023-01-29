<?php 
// Step 1: Change the file name to Config.php
// Step 2: Change the comments of the DB Constanten to your own database settings
// Step 3: Change the comments of the URL Constanten to your own website settings

    //DB Constanten
    define('DB_HOST', '/* Database Host */');
    define('DB_USER', '/* Database Username */');
    define('DB_PASS', '/* Database Password */');
    define('DB_NAME', '/* Database Name */');

    //URL Constanten
    define('APPROOT', dirname(dirname(__FILE__)));
    define('URLROOT', '/* Website URL */');
    define('SITENAME', 'Rocambolesque');
?>