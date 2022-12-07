<?php

    include '../config.php';

    if ($conn->connect_errno)
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../edit/genre.php?name='.$_POST['oldGenre']);
    }

    if ( (isset($_POST['oldGenre']) && $_POST['oldGenre']) && 
            (isset($_POST['newGenre']) && $_POST['newGenre']) )
    {
        $newGenre = addslashes( strtolower($_POST['newGenre']) );  

        $sql = "update GENRE
                set name = '$newGenre'
                where name = '$_POST[oldGenre]'";

        $result = $conn->query($sql);

        if($result)
        {
            $_SESSION['success'] = 'Genre updated.';
            header('Location: ../view/genre.php?name='.$_POST['newGenre']);
        }
        else
        {
            $err = $conn->errno;
            if ($err == 1062)
            {
                $_SESSION['error'] = 'An genre with the same name already exists.';
            }
            else
            {
                $_SESSION['error'] = 'Genre update failed.';
            }

            header('Location: ../edit/genre.php?name='.$_POST['oldGenre']);
        }
    }
    else
    {
        $_SESSION['error'] = 'A required data is needed.';
        header('Location: ../edit/genre.php?name='.$_POST['oldGenre']);
    }

?>
