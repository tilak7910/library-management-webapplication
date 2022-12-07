<?php

    include '../config.php';

    if ($conn->connect_errno) 
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../edit/rental.php?borrower='.$_POST['form-old-borrower'].'&book='.$_POST['form-old-book'].'&rental='.$_POST['form-old-rentalDate']);
    }

    $proceed = (isset($_POST['form-old-borrower']) && $_POST['form-old-borrower']) && 
                (isset($_POST['form-old-book']) && $_POST['form-old-book']) &&
                (isset($_POST['form-old-rentalDate']) && $_POST['form-old-rentalDate']) &&
                (isset($_POST['form-old-dueDate']) && $_POST['form-old-dueDate']);



    if ( $proceed ) 
    {
        $oldBorrower = $_POST['form-old-borrower'];
        $oldBook = $_POST['form-old-book'];
        $oldRentalDate = $_POST['form-old-rentalDate'];
        $oldDueDate = $_POST['form-old-dueDate'];

        $newBorrower = $_POST['form-new-borrower'];
        $newBook = $_POST['form-new-book'];
        $newRentalDate = $_POST['form-new-rentalDate'];
        $newDueDate = $_POST['form-new-dueDate'];

        try
        {

            $proceed = false;
            $case = 0;

            if ($oldBook != $newBook) 
            {
                $newBookAvailSql = "select amount from BOOK where id = '$newBook' LIMIT 1";
                $bookResult = ($conn->query($newBookAvailSql))->fetch_assoc();
                $bookAmount = $bookResult['amount'];
                $proceed = $bookAmount > 0;
                $case = 1;
            }
            else
            {
                $proceed = true;
                $case = 2;
            }
            // check if new book is available
            

            if ( $proceed )
            {
                $rentalSql = "update RENTAL
                                set bookID = '$newBook', borrowerID = '$newBorrower', rentalDate = '$newRentalDate', dueDate = '$newDueDate'
                                where bookID = '$oldBook' and borrowerID = '$oldBorrower' and rentalDate = '$oldRentalDate'";
                $rentalResult = $conn->query($rentalSql);

                if ($rentalResult)
                {       
                        // subtract amount of old book
                        $oldBookSql = "select amount from BOOK where id = '$oldBook'";
                        $oldBookResult = ($conn->query($oldBookSql))->fetch_assoc();
                        $oldBookAmount = $oldBookResult['amount'];

                        $a = $oldBookAmount + 1;
                        $oldBookSql = "update BOOK set amount = '$a' where id = '$oldBook'";
                        $conn->query($oldBookSql);

                        // add amount of new book
                        $newBookSql = "select amount from BOOK where id = '$newBook'";
                        $newBookResult = ($conn->query($newBookSql))->fetch_assoc();
                        $newBookAmount = $newBookResult['amount'];

                        $a = $newBookAmount - 1;
                        $newBookSql = "update BOOK set amount = '$a' where id = '$newBook'";
                        $conn->query($newBookSql);

                        $_SESSION['success'] = 'Rental updated.';
                        header('Location: ../view/rental.php?borrower='.$newBorrower.'&book='.$newBook.'&rental='.$newRentalDate);
                }
                else
                {
                    $err = $conn->errno;
                    if ($err == 1062)
                    {   
                        $infoSql = "select fName, lName, title, pubYear 
                                    from BOOK, BORROWER, RENTAL 
                                    where 
                                        RENTAL.bookID = BOOK.id and 
                                        RENTAL.borrowerID = BORROWER.id and 
                                        RENTAL.rentalDate = '$newRentalDate' and
                                        RENTAL.bookID = '$newBook' and 
                                        RENTAL.borrowerID = '$newBorrower'";

                        $infoResult = $conn->query($infoSql);
                        $info = $infoResult->fetch_assoc();
                        $infoBorrower = $info['fName'].' '.$info['lName'];
                        $infoBook = $info['title'].' ('.$info['pubYear'].')';

                        $_SESSION['error'] = 'Borrower '.$infoBorrower.' already rented a book '.$infoBook.' on '.$newRentalDate.'<br>
                                              A borrower is not allowed to rent the same books on the same date.';
                    }
                    else
                    {
                        $_SESSION['error'] = 'Rental update failed.';
                    }

                    header('Location: ../edit/rental.php?borrower='.$oldBorrower.'&book='.$oldBook.'&rental='.$oldRentalDate);

                }
            }
            else
            {
                switch ($case) 
                {
                    case 1: 
                        $_SESSION['error'] = 'Book to be rented is unavailable.';
                        break;
                    default: 
                        throw new Exception();
                        break;
                }
                
                header('Location: ../edit/rental.php?borrower='.$oldBorrower.'&book='.$oldBook.'&rental='.$oldRentalDate);
            }



            
        }
        catch (Exception $e)
        {
            $_SESSION['error'] = 'There was a problem updating a rental. Try again.';
            header('Location: ../edit/rental.php?borrower='.$oldBorrower.'&book='.$oldBook.'&rental='.$oldRentalDate);
        }
    } 
    else 
    {
        $_SESSION['error'] = 'A required data is needed.';
        header('Location: ../edit/rental.php?borrower='.$oldBorrower.'&book='.$oldBook.'&rental='.$oldRentalDate);
    }

?>