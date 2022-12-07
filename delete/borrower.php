<?php

    include '../config.php';

    if ($conn->connect_errno)
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../list/borrowers.php');
    }

    if ( isset($_GET['id']) && $_GET['id'] )
    {
        $sql = "delete from BORROWER where id = '$_GET[id]'";
        $result = $conn->query($sql);

        if ($result)
        {
            $_SESSION['success'] = 'Borrower deleted.';
            header('Location: ../list/borrowers.php');
        }
        else
        {
            $err = $conn->errno;
            if($err == 1451) {
                $_SESSION['error'] = 'This borrower is currently renting a book. Borrower deletion failed.';
            } else {
                $_SESSION['error'] = 'Borrower deletion failed.';
            }

            header('Location: ../list/borrowers.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'A required data is needed. Check the url.';
        header('Location: ../list/borrowers.php');
    }
?>
