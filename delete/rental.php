
<?php

    include '../config.php';

    if ($conn->connect_errno) 
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../list/rental.php');
    }

    $proceed = (isset($_GET['borrower']) && $_GET['borrower']) && 
                (isset($_GET['book']) && $_GET['book']) &&
                (isset($_GET['rental']) && $_GET['rental']);


    if ( $proceed ) 
    {
        $sql = "delete from RENTAL 
                where bookID = '$_GET[book]' and
                        borrowerID = '$_GET[borrower]' and
                        rentalDate = '$_GET[rental]'";
                        
        $result = $conn->query($sql);

        if($result)
        {
                // subtract aount of returned book
                $bookSql = "select amount from BOOK where id = '$_GET[book]'";
                $bookResult = ($conn->query($bookSql))->fetch_assoc();
                $bookAmount = $bookResult['amount'];

                $newBookAmount = $bookAmount + 1;
                $bookSql = "update BOOK set amount = '$newBookAmount' where id = '$_GET[book]'";
                $conn->query($bookSql);

                $_SESSION['success'] = 'Book returned.';
                header('Location: ../list/rental.php');
        }
        else
        {
                $_SESSION['error'] = 'Book return failed.';
                header('Location: ../view/rental.php?view=delete&borrower='.$_GET['borrower'].'&book='.$_GET['book'].'&rental='.$_GET['rental']);
        }
    } 
    else 
    {
        $_SESSION['error'] = 'A required data is needed. Check the url.';
        header('Location: ../list/rental.php');
    }

?>
