<?php
    include '../config.php';
    include '../head.php';
    include '../footer.php';

    $head = new Head();
    $head->setTitle('View an Author');
    $head->addStyle('../css/styles.css');
    $head->drawHead();
    $head->drawMenu();
?>


<div class="right p-5">
    <main id="view-page">
        <h1>Rental Confirmation</h1>
        <hr>

        <?php

            if ($conn->connect_errno) 
            {
                echo '<div class="bg-danger text-white p-3">Connection error!</div>';
                exit;
            }


            // success message
            if (isset($_SESSION['message']) && $_SESSION['message']) {
                echo $_SESSION['message'];
            } else {
                echo '<div class="text-muted">Nothing to confirm.</div>'; 
            }

            unset($_SESSION['error']);
            unset($_SESSION['success']);
            unset($_SESSION['message']);

        ?>

    </main>
</div>


<?php
    $footer = new Footer();
    $footer->addScript('../js/site.js');
    $footer->drawFooter();
?>