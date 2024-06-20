<?php 
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'projectakhirperpus';

    $connect = mysqli_connect($host, $user, $pass, $db);


    if(!$connect){
        echo 'Error :'. mysqli_connect_error($connect);
    }

?>