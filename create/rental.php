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
        <h1>Rent a Book</h1>
        <hr>


        <?php
            if (isset($_SESSION['error']) && $_SESSION['error']) {
                echo '<div class="bg-danger text-white p-3 mb-5">'.$_SESSION['error'].'</div>';
            }
            
            unset($_SESSION['error']);
            unset($_SESSION['success']);
        ?>
        

        <!--borrower-->
        <div class="mb-4" data-page="1">
            <h3 class="text-center fw-bold bg-dark text-white mt-3 p-3">Borrower Identification</h3>
            <div class="form-group mb-4">
                <label for="search-borrowers" class="mb-2">Search by Borrower ID, Last Name, or Email (select only one)</label>
                <input type="text" class="form-control" id="search-borrowers" name="search-borrowers" placeholder="" onkeyup="showBorrowers(this.value)">
            </div>
            <div id="borrower-results" class="ajax-results bg-light"></div>
            <h4>SELECTED BORROWER</h4>
            <div id="selected-borrower" class="my-4 select-box bg-light position-relative"></div>
            <div class="my-4 d-flex justify-content-end">
                <div id="nav-borrower-next" class="arrow d-none" onclick="next()">NEXT <i class="fas fa-arrow-right"></i></div>
            </div>
        </div>
        <!--borrower-->

        <!--book-->
        <div class="mb-4 d-none" data-page="2">
            <h3 class="text-center fw-bold bg-dark text-white mt-3 p-3">Books to Borrow</h3>
            <div class="form-group mb-4">
                <label for="search-books" class="mb-2">Search by Book ID or Title</label>
                <input type="text" class="form-control" id="search-books" name="search-books" placeholder="" onkeyup="showBooks(this.value)">
            </div>
            <div id="book-results" class="ajax-results bg-light"></div>
            <h4>SELECTED BOOK(S)</h4>
            <div id="selected-book" class="my-4 select-box bg-light d-block d-lg-flex justify-content-start flex-wrap"></div>
            <div class="my-4 d-flex justify-content-between">
                <div class="arrow" onclick="prev()">PREV <i class="fas fa-arrow-left"></i></div>
                <div id="nav-book-next" class="arrow d-none" onclick="next()">NEXT <i class="fas fa-arrow-right"></i></div>
            </div>
        </div>
        <!--book-->

        <!--dates-->
        <div class="mb-4 d-none" data-page="3">
            <h3 class="text-center fw-bold bg-dark text-white mt-3 p-3">Dates</h3>
            <div class="form-group mb-4">
                <label for="rentalDate" class="mb-2">Rental Date</label>
                <input type="date" class="form-control" name="rentalDate" id="rentalDate" value="" onchange="changeDueDate(this.value)">
            </div>
            <div class="form-group mb-4">
                <label for="dueDate" class="mb-2">Due Date</label>
                <input type="date" class="form-control" name="dueDate" id="dueDate" value="">
            </div>
            <div id="date-error" class="p-3 text-white bg-danger d-none"></div>
            <div class="my-4 d-flex justify-content-between">
                <div class="arrow" onclick="prev()">PREV <i class="fas fa-arrow-left"></i></div>
                <div id="nav-date-next" class="arrow d-none" onclick="next()">NEXT <i class="fas fa-arrow-right"></i></div>
            </div>
        </div>
        <!--dates-->


        <!--summary-->
        <div class="mb-4 d-none" data-page="4">
           
            <form action="../insert/rental.php" method="post">
                <h3 class="text-center fw-bold bg-dark text-white mt-3 p-3">Summary</h3>
                <summary>

                    <table class="table table-striped">
                        <tr><td class="col-12"><strong>BORROWER IDENTIFICATION</strong></td></tr>
                        <tr><td class="col-12" id="summary-borrower"></td></tr>
                    </table>

                    <table class="table table-striped">
                        <tr><td class="col-12"><strong>BOOKS</strong></td></tr>
                        <tr><td class="col-12" id="summary-book"></td></tr>
                    </table>

                    <table class="table table-striped">
                        <tr><td class="col-12"><strong>DATES</strong></td></tr>
                        <tr><td class="col-12" id="summary-date"></td></tr>
                    </table>
                    
                </summary>
                <input type="submit" class="form-control btn btn-primary" value="Rent">
            </form>
            <div class="my-4 d-flex justify-content-start">
                <div class="arrow" onclick="prev()">PREV <i class="fas fa-arrow-left"></i></div>
            </div>
            
        </div>
        <!--summary-->
  </main>
</div>





<?php
    $footer = new Footer();
    $footer->addScript('../js/site.js');
    $footer->addScript('../js/create-rent.js');
    $footer->drawFooter();
?>