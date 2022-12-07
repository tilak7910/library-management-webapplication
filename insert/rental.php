<?php

    include '../config.php';

    if ($conn->connect_errno) 
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../create/rental.php');
    }

    $proceed = (isset($_POST['borrowerID']) && $_POST['borrowerID']) &&
                (isset($_POST['bookID']) && $_POST['bookID']) &&
                (isset($_POST['rentDate']) && $_POST['rentDate']) &&
                (isset($_POST['dueDate']) && $_POST['dueDate']);

    if ($proceed) 
    {
        $message = '';

        try 
        {
            foreach ($_POST['bookID'] as $book) 
            {
                $bookAvailSql = "select amount from BOOK where id = '$book' LIMIT 1";
                $bookResult = ($conn->query($bookAvailSql))->fetch_assoc();
                $bookAmount = $bookResult['amount'];
                
                if ($bookAmount > 0)
                {
                    // insert new tuple to the RENTAL table
                    $rentalSql = "insert into RENTAL (bookID, borrowerID, rentalDate, dueDate) 
                                    values ('$book', '$_POST[borrowerID]', '$_POST[rentDate]', '$_POST[dueDate]')";
                    $rentalResult = $conn->query($rentalSql);


                    // borrower and book ident
                    $infoSql = "select fName, lName, title, pubYear 
                                from BOOK, BORROWER, RENTAL 
                                where 
                                    RENTAL.bookID = BOOK.id and 
                                    RENTAL.borrowerID = BORROWER.id and 
                                    RENTAL.rentalDate = '$_POST[rentDate]' and
                                    RENTAL.bookID = '$book' and 
                                    RENTAL.borrowerID = '$_POST[borrowerID]'";
                    $infoResult = $conn->query($infoSql);
                    $info = $infoResult->fetch_assoc();
                    $infoBorrower = $info['fName'].' '.$info['lName'];
                    $infoBook = $info['title'].' ('.$info['pubYear'].')';


                    if ($rentalResult)
                    {                                    
                            // subtract amount of the book from the BOOK table
                            $newAmount = $bookAmount - 1;
                            $updateBook = "update BOOK set amount = '$newAmount' where id = '$book'";
                            $conn->query($updateBook);


                            $text = 
                                '<div class="bg-success text-white p-3 mt-3">
                                    Rental complete.
                                    <br>
                                    Borrower '.$infoBorrower.' has rented a book '.$infoBook.' on '.$_POST['rentDate'].'. 
                                </div>';
                            $message .= $text;

                    }
                    else
                    {
                            $text = 
                               '<div class="bg-danger text-white p-3">
                                    Borrower '.$infoBorrower.' already rented a book '.$infoBook.' on '.$_POST['rentDate'].'.
                                    <br>
                                    A borrower is not allowed to rent the same books on the same date.
                                </div>';
                            $message .= $text;
                    }
                }
                else
                {
                    $text = '<div class="bg-danger text-white p-3">Book to be rented is unavailable.</div>';
                    $message .= $text;
                }
            }
        }
        catch (Exception $e)
        {
            $text = '<div class="bg-danger text-white p-3">There was a problem adding a rental. Try again.</div>';
            $message .= $text;
        }

        $_SESSION['message'] = $message;
        header('Location: ../view/rent-confirmation.php');
    } 
    else 
    {
        $_SESSION['error'] = 'A required data is needed.';
        header('Location: ../create/rental.php');
    }
?>