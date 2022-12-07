<?php

    include '../config.php';

    if ($conn->connect_errno) 
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../list/authors.php');
    }

    if ( isset($_GET['id']) && $_GET['id'] ) 
    {
        $sql = "delete from AUTHOR where id = '$_GET[id]'";
        $result = $conn->query($sql);

        $_SESSION['success'] = 'Author deleted.';
        header('Location: ../list/authors.php');
    } 
    else 
    {
        $_SESSION['error'] = 'A required data is needed. Check the url.';
        header('Location: ../list/authors.php');
    }

?>
