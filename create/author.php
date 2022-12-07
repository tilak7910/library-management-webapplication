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
        <h1>Add an Author</h1>
        <hr>

        <?php
            if (isset($_SESSION['error']) && $_SESSION['error']) {
                echo '<div class="bg-danger text-white p-3 mb-5">'.$_SESSION['error'].'</div>';
            }
            
            unset($_SESSION['error']);
            unset($_SESSION['success']);
        ?>
   
        <form action="../insert/author.php" method="post">
            <div class="form-group mb-4">
                <label for="fName" class="mb-2">First Name</label>
                <input type="text" class="form-control" id="fName" name="fName" placeholder="John" maxlength="35">
            </div>
            <div class="form-group mb-4">
                <label for="lName" class="mb-2 required">Last Name</label>
                <input type="text" class="form-control" id="lName" name="lName" placeholder="Smith" maxlength="45" required>
            </div>
             <div class="form-group mb-4">
                <input type="submit" class="form-control btn btn-primary" value="Save">
            </div>
        </form>
     </main>
</div>

<?php
    $footer = new Footer();
    $footer->addScript('../js/site.js');
    $footer->drawFooter();
?>