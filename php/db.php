<?php
    define('HOST','localhost');
    define('USER','root');
    define('PWD','root');
    define('DB','registration');

    $conn = mysqli_connect(HOST,USER,PWD,DB);

    if (!$conn){
        header('Location:../index.php?message=not_connected_to_the_base');
        exit();
    }
