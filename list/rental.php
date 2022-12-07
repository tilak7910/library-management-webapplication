<?php
    include '../config.php';
    include '../head.php';
    include '../footer.php';

    $head = new Head();
    $head->setTitle('Borrowers');
    $head->addStyle('../css/styles.css');
    $head->drawHead();
    $head->drawMenu();
?>



<div class="right p-5">
    <main>
        <h1>Unreturned Books</h1>
        <hr>

        <?php

            // session
            if (isset($_SESSION['error']) && $_SESSION['error']) {
                echo '<div class="bg-danger text-white p-3 mb-5">'.$_SESSION['error'].'</div>';
            }

            if (isset($_SESSION['success']) && $_SESSION['success']) {
                echo '<div class="bg-success text-white p-3 mb-5">'.$_SESSION['success'].'</div>';
            }

            unset($_SESSION['error']);
            unset($_SESSION['success']);
            
        ?>

        <div class="form-group mb-4">
            <label for="search-unreturned" class="mb-2">Filter Unreturned Books by Borrower ID, Borrower Last Name, or Rental Date (YYYY-MM-DD).</label>
            <input type="text" class="form-control" id="search-unreturned" name="search-unreturned" placeholder="" onkeyup="showRentals(this.value)">
        </div>
        <div id="rental-results" class="ajax-results bg-light"></div>
    </main>
</div>




<?php
    $footer = new Footer();
    $footer->addScript('../js/site.js');
    $footer->addScript('../js/list-rental.js');
    $footer->drawFooter();
?>
