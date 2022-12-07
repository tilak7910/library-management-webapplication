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
        <h1>Edit an Author</h1>
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

            // author info
            if( isset($_GET['id']) && $_GET['id'] )
            {

                $id = $_GET['id'];

                $authorSql = "select * 
                              from AUTHOR 
                              where id = $id";

                $authorResult = $conn->query($authorSql);

                if ($authorResult && $authorResult->num_rows > 0)
                {
                    $authorRow = $authorResult->fetch_assoc();
                    echo '<form action="../update/author.php" method="post">';
                    echo '    <input type="hidden" name="id" value="'.$authorRow['id'].'">';
                    echo '    <div class="form-group mb-4">';
                    echo '        <label for="fName" class="mb-2">First Name</label>';
                    echo '        <input type="text" class="form-control" id="fName" name="fName" placeholder="John" value="'.$authorRow['fName'].'" maxlength="35">';
                    echo '    </div>';
                    echo '    <div class="form-group mb-4">';
                    echo '        <label for="lName" class="mb-2">Last Name</label>';
                    echo '        <input type="text" class="form-control" id="lName" name="lName" placeholder="Smith" value="'.$authorRow['lName'].'" maxlength="45" required>';
                    echo '    </div>';
                    echo '    <div class="form-group mb-4">';
                    echo '        <input type="submit" class="form-control btn btn-primary" value="Update">';
                    echo '    </div>';
                    echo '</form>';

                }
                else
                {
                    echo '<div class="text-muted">No author found.</div>';
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
    $footer->addScript('../js/edit-book.js');
    $footer->drawFooter();
?>