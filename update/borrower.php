<?php

    include '../config.php';

    if ($conn->connect_errno)
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../edit/borrower.php?id='.$_POST['id']);
    }

    if ( (isset($_POST['lName']) && $_POST['lName']) && (isset($_POST['email']) && $_POST['email']) )
    {

        $fName = addslashes( $_POST['fName'] );
        $lName = addslashes( $_POST['lName'] );
        $email = addslashes( $_POST['email'] );
        $phone = addslashes( $_POST['phone'] );
        $street = addslashes( $_POST['street'] );
        $city = addslashes( $_POST['city'] );
        $prov = addslashes( $_POST['prov'] );
        $postalCode = addslashes( $_POST['postalCode'] );


        $sql = "update BORROWER
                set fName = '$fName',
                    lName = '$lName',
                    email = '$email',
                    phone = '$phone',
                    street = '$street',
                    city = '$city',
                    prov = '$prov',
                    postalCode = '$postalCode'
                where id = '$_POST[id]'";

        $result = $conn->query($sql);


        if($result)
        {
            $_SESSION['success'] = 'Borrower updated.';
            header('Location: ../view/borrower.php?id='.$_POST['id']);
        }
        else
        {
            $err = $conn->errno;
            if ($err == 1062)
            {
                $_SESSION['error'] = 'A borrower with the same email already exists.';
            }
            else
            {
                $_SESSION['error'] = 'Borrower update failed.';
            }

            header('Location: ../edit/borrower.php?id='.$_POST['id']);
        }
    }
    else
    {
        $_SESSION['error'] = 'A required data is needed.';
        header('Location: ../edit/borrower.php?id='.$_POST['id']);
    }

?>
