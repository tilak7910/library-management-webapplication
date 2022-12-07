<?php

    include '../config.php';
    
    if ($conn->connect_errno) 
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../edit/author.php?id='.$_POST['id']);
    }

    if ( isset($_POST['lName']) && $_POST['lName'] ) 
    {
        $sql = "update AUTHOR 
                set fName = '$_POST[fName]',
                    lName = '$_POST[lName]'
                where id = '$_POST[id]'";

        $result = $conn->query($sql);


        if($result)
        {
            $_SESSION['success'] = 'Author updated.';
            header('Location: ../view/author.php?id='.$_POST['id']);
        }
        else
        {
            $err = $conn->errno;
            if ($err == 1062)
            {
                $_SESSION['error'] = 'An author with the same first name and last name already exists.';
            }
            else
            {
                $_SESSION['error'] = 'Author update failed.';
            }

            header('Location: ../edit/author.php?id='.$_POST['id']);

        }
    } 
    else 
    {
        $_SESSION['error'] = 'A required data is needed.';
        header('Location: ../edit/author.php?id='.$_POST['id']);
    }

?>
