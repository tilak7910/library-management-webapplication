<?php
    include '../config.php';
    include '../head.php';
    include '../footer.php';

    $head = new Head();
    $head->setTitle('View a Book');
    $head->addStyle('../css/styles.css');
    $head->drawHead();
    $head->drawMenu();
?>



<div class="right p-5">
    <main id="view-page">

        <?php
            if ( isset($_GET['view']) && $_GET['view'] == "delete" ) {
                echo '<h1>Returning a Book</h1>';
            } 
            else 
            {
                echo '<h1>View a Rental</h1>';
            }
            echo '<hr>';
        ?>


        <?php

            if ($conn->connect_errno) 
            {
                echo '<div class="bg-danger text-white p-3 mb-5">Connection error!</div>';
                exit;
            }



            // success message
            if (isset($_SESSION['success']) && $_SESSION['success']) {
                echo '<div class="bg-success text-white p-3 mb-5">'.$_SESSION['success'].'</div>';
            }

            unset($_SESSION['error']);
            unset($_SESSION['success']);


            // view rental info
            if ( (isset($_GET['borrower']) && $_GET['borrower']) && 
                 (isset($_GET['book']) && $_GET['book']) && 
                 (isset($_GET['rental']) && $_GET['rental']) )
            {
                
                $borrowerID = $_GET['borrower'];
                $bookID = $_GET['book'];
                $rentalDate = $_GET['rental'];


                $sql = "select * from RENTAL where bookID = '$bookID' and borrowerID = '$borrowerID' and rentalDate = '$rentalDate'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0)
                {
                    $infoSql = "select bookID, borrowerID, rentalDate, dueDate, title, pubYear, 
                                       fName, lName, email, phone, street, city, prov, postalCode
                                from BOOK, BORROWER, RENTAL 
                                where RENTAL.bookID = BOOK.id and 
                                    RENTAL.borrowerID = BORROWER.id and 
                                    RENTAL.borrowerID = '$borrowerID' and 
                                    RENTAL.bookID = '$bookID' and 
                                    RENTAL.rentalDate = '$rentalDate'";

                    $authorSql = "select AUTHOR.lName 
                                  from WRITES 
                                  join AUTHOR 
                                  where AUTHOR.id = WRITES.authorID and 
                                        WRITES.bookID = '$bookID'";
            
                    $infoResult = $conn->query($infoSql);
                    $authorResult = $conn->query($authorSql);

                    $info = $infoResult->fetch_assoc();
                    

                    $authors = [];
                    while ($authorRow = $authorResult->fetch_assoc()) {
                        array_push($authors, $authorRow['lName']);
                    }


                    /** Borrower ***************************************************/
                    echo '<table class="table table-striped">';

                    echo '<tr>';
                    echo '<td class="col-12"><strong>BORROWER IDENTIFICATION</strong></td>';
                    echo '</tr>';
                    
                    echo '<tr>';
                    echo '<td class="col-12">';
                    echo $info['fName'].' '.$info['lName'].'<br>';
                    echo $info['email'].'<br>';
                    echo $info['phone'].'<br><br>';
                    echo $info['street'].' '.$info['city'].' '.$info['prov'].'<br>'.$info['postalCode'];
                    echo '</td>';
                    echo '</tr>';

                    echo '</table>';
                    /** Borrower ***************************************************/


                    /** Book *******************************************************/
                    echo '<table class="table table-striped">';

                    echo '<tr>';
                    echo '<td class="col-12"><strong>RENTED BOOK</strong></td>';
                    echo '</tr>';
                    
                    echo '<tr>';
                    echo '<td class="col-12">'.$info['title'].' ('.$info['pubYear'].')<br>'.implode(', ', $authors).'</td>';
                    echo '</tr>';

                    echo '</table>';
                    /** Book *******************************************************/


                    /** Rental Date *******************************************************/
                    echo '<table class="table table-striped">';

                    echo '<tr>';
                    echo '<td class="col-12"><strong>RENTAL DATE</strong></td>';
                    echo '</tr>';
                    
                    echo '<tr>';
                    echo '<td class="col-12" id="rentalDate-raw">'.$info['rentalDate'].'</td>';
                    echo '</tr>';

                    echo '</table>';
                    /** Rental Date *******************************************************/

                     /** Due Date *******************************************************/
                     echo '<table class="table table-striped">';

                     echo '<tr>';
                     echo '<td class="col-12"><strong>DUE DATE</strong></td>';
                     echo '</tr>';
                     
                     echo '<tr>';
                     echo '<td class="col-12" id="dueDate-raw">'.$info['dueDate'].'</td>';
                     echo '</tr>';
 
                     echo '</table>';
                     /** Due Date *******************************************************/

                      /** Due Date *******************************************************/
                      echo '<table class="table table-striped">';

                      echo '<tr>';
                      echo '<td class="col-12"><strong>STATUS</strong></td>';
                      echo '</tr>';
                      
                      echo '<tr>';
                      echo '<td class="col-12" id="rent-status"></td>';
                      echo '</tr>';
  
                      echo '</table>';
                      /** Due Date *******************************************************/

                      if ( isset($_GET['view']) && $_GET['view'] == "delete" )
                      {
                            /** Delete Button ******************************************************/
                            echo '<a class="btn btn-danger mt-5 w-100" href="../delete/rental.php?borrower='.$info['borrowerID'].'&book='.$info['bookID'].'&rental='.$info['rentalDate'].'">Return Book</a>';
                            /** Delete Button ******************************************************/
                      }
                } 
                else 
                {
                    echo '<div class="text-muted">No rental found.</div>';
                }

            }
            else 
            {
                echo '<div class="bg-danger text-white p-3 mb-5">A required data is needed. Check the url.</div>';
            }

           

        ?>

    </main>
</div>


<?php
    $footer = new Footer();
    $footer->addScript('../js/site.js');
    $footer->addScript('../js/view-rental.js');
    $footer->drawFooter();
?>