
<?php

    include '../config.php';

    if ($conn->connect_errno) 
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../create/author.php');
    }

    if ( isset($_POST['lName']) && $_POST['lName'] ) 
    {
        $fName = addslashes( $_POST['fName'] ); 
        $lName = addslashes( $_POST['lName'] );

        $sql = "insert into AUTHOR (fName, lName) values ('$fName', '$lName')";
        $result = $conn->query($sql);

        if($result)
        {
            $_SESSION['success'] = 'Author added.';
            header('Location: ../view/author.php?id='.$conn->insert_id);
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
                $_SESSION['error'] = 'Adding an author failed';
            }

            header('Location: ../create/author.php');
        }
    } 
    else 
    {
        $_SESSION['error'] = 'A required data is needed.';
        header('Location: ../create/author.php');
    }
?>