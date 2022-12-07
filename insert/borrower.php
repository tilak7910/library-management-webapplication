<?php

    include '../config.php';

    if ($conn->connect_errno)
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../create/borrower.php');
    }

    if ( (isset($_POST['lName']) && $_POST['lName']) && (isset($_POST['email']) && $_POST['email']) )
    {
        try
        {
            $fName = addslashes( $_POST['fName'] );
            $lName = addslashes( $_POST['lName'] );
            $email = addslashes( $_POST['email'] );
            $phone = addslashes( $_POST['phone'] );
            $street = addslashes( $_POST['street'] );
            $city = addslashes( $_POST['city'] );
            $prov = addslashes( $_POST['prov'] );
            $postalCode = addslashes( $_POST['postalCode'] );

            $sql = "insert into BORROWER (fName, lName, email, phone, street, city, prov, postalCode)
                    values ('$fName', '$lName', '$email', '$phone', '$street', '$city', '$prov', '$postalCode')";

            $result = $conn->query($sql);

            if ($result)
            {
                $_SESSION['success'] = 'Borrower added.';
                header('Location: ../view/borrower.php?id='.$conn->insert_id);
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
                    $_SESSION['error'] = 'Registering a borrower failed.'; 
                }

                header('Location: ../create/borrower.php');

            }
        }
        catch (Exception $e)
        {
            $_SESSION['error'] = 'There was a problem in adding a borrower.';
            header('Location: ../create/borrower.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'A required data is needed.';
        header('Location: ../create/borrower.php');
    }
?>
