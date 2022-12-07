<?php
    include '../config.php';
    include '../head.php';
    include '../footer.php';

    $head = new Head();
    $head->setTitle('Authors');
    $head->addStyle('../css/styles.css');
    $head->drawHead();
    $head->drawMenu();
?>




<div class="right p-5">
    <main>
        <h1>Edit a Rental</h1>
        <hr>

        <?php

            if ($conn->connect_errno) 
            {
                echo '<div class="bg-danger text-white p-3 mb-5">Connection error!</div>';
                exit;
            }


            // session
            if (isset($_SESSION['error']) && $_SESSION['error']) {
                echo '<div class="bg-danger text-white p-3 mb-5">'.$_SESSION['error'].'</div>';
            }

            unset($_SESSION['error']);
            unset($_SESSION['success']);

            

            // rental info
            if( (isset($_GET['borrower']) && $_GET['borrower']) && 
                (isset($_GET['book']) && $_GET['book']) && 
                (isset($_GET['rental']) && $_GET['rental']))
            {

                $borrower = $_GET['borrower'];
                $book = $_GET['book'];
                $rentalDate = $_GET['rental'];


                $infoSql = "select bookID, borrowerID, rentalDate, dueDate, title, pubYear, 
                                    fName, lName, email, phone, street, city, prov, postalCode
                            from BOOK, BORROWER, RENTAL 
                            where RENTAL.bookID = BOOK.id and 
                                RENTAL.borrowerID = BORROWER.id and 
                                RENTAL.borrowerID = '$borrower' and 
                                RENTAL.bookID = '$book' and 
                                RENTAL.rentalDate = '$rentalDate'";


                $authorSql = "select lName from AUTHOR join WRITES where AUTHOR.id = WRITES.authorID and WRITES.bookID = '$book'";

                $infoResult = $conn->query($infoSql);
                $authorResult = $conn->query($authorSql);

                $info = $infoResult->fetch_assoc();
                
                $authors = [];
                while ($authorRow = $authorResult->fetch_assoc()) {
                    array_push($authors, $authorRow['lName']);
                }

                /** Borrower ***************************************************/
                echo '<div class="mb-4" data-page="1">';
                echo '    <h3 class="text-center fw-bold bg-dark text-white mt-3 p-3">Borrower Identification</h3>';
                echo '    <div class="d-none" data-current-borrower="'.$info['borrowerID'].'"></div>';
                echo '    <div class="form-group mb-4">';
                echo '        <label for="search-borrowers" class="mb-2">Search by Borrower ID, Last Name, or Email (select only one)</label>';
                echo '        <input type="text" class="form-control" id="search-borrowers" name="search-borrowers" placeholder="" value="" onkeyup="showBorrowers(this.value, '.$info['borrowerID'].')">';
                echo '    </div>';
                echo '    <div id="borrower-results" class="ajax-results bg-light"></div>';
                echo '    <h4>PREVIOUS BORROWER</h4>';
                echo '    <div id="previous-borrower" class="my-4 select-box bg-light position-relative"></div>';
                echo '    <h4>CURRENT BORROWER</h4>';
                echo '    <div id="selected-borrower" class="my-4 select-box bg-light position-relative">';
                echo '        <div class="p-4 border border-success" data-borrower="'.$info['borrowerID'].'">';
                echo '              <div class="close close-borrower"><i class="fas fa-times"></i></div>';
                echo '              <div><strong>ID:</strong> '.$info['borrowerID'].'</div>';
                echo '              <div>'.$info['fName'].' '.$info['lName'].'</div>';
                echo '              <div>'.$info['email'].'</div>';
                echo '              <div>'.$info['phone'].'</div>';
                echo '              <div>'.$info['street'].' '.$info['city'].' '.$info['prov'].'</div>';
                echo '              <div>'.$info['postalCode'].'</div>';
                echo '        </div>';
                echo '    </div>';
                echo '    <div class="my-4 d-flex justify-content-end">';
                echo '        <div id="nav-borrower-next" class="arrow" onclick="next()">NEXT <i class="fas fa-arrow-right"></i></div>';
                echo '    </div>';
                echo '</div> ';
                /** Borrower ***************************************************/


                /** Book ***************************************************/
                echo '<div class="mb-4 d-none" data-page="2">';
                echo '    <h3 class="text-center fw-bold bg-dark text-white mt-3 p-3">Book to Borrow</h3>';
                echo '    <div class="d-none" data-current-book="'.$info['bookID'].'"></div>';
                echo '    <div class="form-group mb-4">';
                echo '        <label for="search-books" class="mb-2">Search by Book ID or Title</label>';
                echo '        <input type="text" class="form-control" id="search-books" name="search-books" placeholder="" value="" onkeyup="showBooks(this.value, '.$info['bookID'].')">';
                echo '    </div>';
                echo '    <div id="book-results" class="ajax-results bg-light"></div>';
                echo '    <h4>PREVIOUS BOOK</h4>';
                echo '    <div id="previous-book" class="my-4 select-box bg-light position-relative"></div>';
                echo '    <h4>CURRENT BOOK</h4>';
                echo '    <div id="selected-book" class="my-4 select-box bg-light position-relative">';
                echo '          <div class="p-4 border border-success position-relative" data-book="'.$info['bookID'].'">';
                echo '          <div class="close close-book"><i class="fas fa-times"></i></div>';
                echo '          <div><strong>ID:</strong> '.$info['bookID'].'</div>';
                echo '          <div>'.$info['title'].' ('.$info['pubYear'].')</div>';
                echo '          <div>by '.implode(', ', $authors).'</div>';
                echo '          </div>';
                echo '    </div>';
                echo '    <div class="my-4 d-flex justify-content-between">';
                echo '        <div class="arrow" onclick="prev()">PREV <i class="fas fa-arrow-left"></i></div>';
                echo '        <div id="nav-book-next" class="arrow" onclick="next()">NEXT <i class="fas fa-arrow-right"></i></div>';
                echo '    </div>';
                echo '</div>';
                /** Book ***************************************************/

                /** Dates ***************************************************/
                echo '<div class="mb-4 d-none" data-page="3">';
                echo '    <h3 class="text-center fw-bold bg-dark text-white mt-3 p-3">Dates</h3>';
                echo '    <div class="form-group mb-4">';
                echo '        <label for="rentalDate" class="mb-2">Rental Date</label>';
                echo '        <input type="date" class="form-control" name="rentalDate" id="rentalDate" value="'.$info['rentalDate'].'" onchange="changeDueDate(this.value)">';
                echo '    </div>';
                echo '    <div class="form-group mb-4">';
                echo '        <label for="dueDate" class="mb-2">Due Date</label>';
                echo '        <input type="date" class="form-control" name="dueDate" id="dueDate" value="'.$info['dueDate'].'">';
                echo '    </div>';
                echo '    <div id="date-error" class="p-3 text-white bg-danger d-none"></div>';
                echo '    <div class="my-4 d-flex justify-content-between">';
                echo '        <div class="arrow" onclick="prev()">PREV <i class="fas fa-arrow-left"></i></div>';
                echo '        <div id="nav-date-next" class="arrow" onclick="next(); showSummary(); populateForm();">NEXT <i class="fas fa-arrow-right"></i></div>';
                echo '    </div>';
                echo '</div>';
                /** Dates ***************************************************/


                /** Summary *************************************************/
                echo '<div class="mb-4 d-none" data-page="4">';
                echo '    <h3 class="text-center fw-bold bg-dark text-white mt-3 p-3 mb-5">Summary</h3>';

                    /** Borrower Identification *************************************************/
                    echo '      <table class="table table-striped">';
                    echo '          <tr>';
                    echo '              <td class="col-12"><strong>UPDATED BORROWER IDENTIFICATION</strong></td>';
                    echo '          </tr>';
                    echo '          <tr>';
                    echo '              <td class="col-12" id="summary-borrower"></td>';
                    echo '          </tr>';
                    echo '      </table>';
                    /** Borrower Identification *************************************************/


                    /** Book ********************************************************************/
                    echo '      <table class="table table-striped">';
                    echo '          <tr>';
                    echo '              <td class="col-12"><strong>UPDATED RENTED BOOK</strong></td>';
                    echo '          </tr>';
                    echo '          <tr>';
                    echo '              <td class="col-12" id="summary-book"></td>';
                    echo '          </tr>';
                    echo '      </table>';
                    /** Book ********************************************************************/


                    /** Rental Date *************************************************************/
                    echo '      <table class="table table-striped">';
                    echo '          <tr>';
                    echo '              <td class="col-12"><strong>UPDATED RENTAL DATE</strong></td>';
                    echo '          </tr>';
                    echo '          <tr>';
                    echo '              <td class="col-12" id="summary-rental"></td>';
                    echo '          </tr>';
                    echo '      </table>';
                    /** Rental Date *************************************************************/


                    /** Due Date *******************************************************/
                    echo '      <table class="table table-striped">';
                    echo '          <tr>';
                    echo '              <td class="col-12"><strong>UPDATED DUE DATE</strong></td>';
                    echo '          </tr>';
                    echo '          <tr>';
                    echo '              <td class="col-12" id="summary-due"></td>';
                    echo '          </tr>';
                    echo '      </table>';
                    /** Due Date *******************************************************/


                    /** Form ***********************************************************/
                    echo '      <form method="POST" action="../update/rental.php">';
                    echo '      <input type="hidden" name="form-old-borrower" value="'.$info['borrowerID'].'">';
                    echo '      <input type="hidden" name="form-new-borrower" value="">';
                    echo '      <input type="hidden" name="form-old-book" value="'.$info['bookID'].'">';
                    echo '      <input type="hidden" name="form-new-book" value="">';
                    echo '      <input type="hidden" name="form-old-rentalDate" value="'.$info['rentalDate'].'">';
                    echo '      <input type="hidden" name="form-new-rentalDate" value="">';
                    echo '      <input type="hidden" name="form-old-dueDate" value="'.$info['dueDate'].'">';
                    echo '      <input type="hidden" name="form-new-dueDate" value="">';
                    echo '      <input type="submit" class="form-control btn btn-primary" value="Update Rent">';
                    echo '      </form>';
                    /** Form ***********************************************************/

                echo '    <div class="my-4 d-flex justify-content-start">';
                echo '        <div class="arrow" onclick="prev()">PREV <i class="fas fa-arrow-left"></i></div>';
                echo '    </div>';
                echo '</div>';
                /** Summary *************************************************/

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
    $footer->addScript('../js/edit-rent.js');
    $footer->drawFooter();
?>