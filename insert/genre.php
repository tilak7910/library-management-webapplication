<?php

    include '../config.php';

    if ($conn->connect_errno) 
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../create/genre.php');
    }

    if ( isset($_POST['genre']) && $_POST['genre'] ) 
    {
        $genre = addslashes( strtolower($_POST['genre']) );
        $sql = "insert into GENRE (name) values ('$genre')";
        $result = $conn->query($sql);

        if($result)
        {
            $_SESSION['success'] = 'Genre added.';
            header('Location: ../view/genre.php?name='.$genre);
        }
        else
        {
            $err = $conn->errno;
            if ($err == 1062)
            {
                $_SESSION['error'] = 'A genre with the same name already exists.';
            }
            else
            {
                $_SESSION['error'] = 'Adding a genre failed.';
            }

            header('Location: ../create/genre.php');
        }
    } 
    else 
    {
        $_SESSION['error'] = 'A required data is needed.';
        header('Location: ../create/genre.php');
    }
?>
