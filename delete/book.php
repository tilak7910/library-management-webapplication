<?php

    include '../config.php';

    if ($conn->connect_errno) 
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../list/books.php');
    }

    if ( isset($_GET['id']) && $_GET['id'] ) 
    {
        $sql = "delete from BOOK where id = '$_GET[id]'";
        $result = $conn->query($sql);

        if($result)
        {
            $_SESSION['success'] = 'Book deleted.';
            header('Location: ../list/books.php');
        }
        else
        {
            $err = $conn->errno;
            if($err == 1451) {
                $_SESSION['error'] = 'This book is currently being rented. Book deletion failed.';
            } else {
                $_SESSION['error'] = 'Book deletion failed.';
            }

            header('Location: ../list/books.php');
        }
    } 
    else 
    {
        $_SESSION['error'] = 'A required data is needed. Check the url.';
        header('Location: ../list/books.php');
    }

?>
