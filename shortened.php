<?php
//Farhans aziz hermansya-2440044251
require 'config.php';
require 'functions.php';


if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];

    $long_url = getLongURLBySlug($slug);

 
    if ($long_url) {
        
        incrementVisitCount($slug);

        header("Location: $long_url");
        exit();
    } else {
        echo "Invalid URL";
    }
} else {
    echo "Invalid URL";
}

?>
