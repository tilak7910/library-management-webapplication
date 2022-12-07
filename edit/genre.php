<?php
    include '../config.php';
    include '../head.php';
    include '../footer.php';

    $head = new Head();
    $head->setTitle('Genre');
    $head->addStyle('../css/styles.css');
    $head->drawHead();
    $head->drawMenu();
?>




<div class="right p-5">
    <main>
        <h1>Edit a Genre</h1>
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

            // genre info
            if( isset($_GET['name']) && $_GET['name'] )
            {

                $name = $_GET['name'];

                $genreSql = "select *
                              from GENRE
                              where name = '$name'";

                $genreResult = $conn->query($genreSql);

                if ($genreResult && $genreResult->num_rows > 0)
                {
                    $genreRow = $genreResult->fetch_assoc();
                    echo '<form action="../update/genre.php" method="post">';
                    echo '    <input type="hidden" name="oldGenre" value="'.$genreRow['name'].'">';
                    echo '    <div class="form-group mb-4">';
                    echo '        <label for="genre" class="mb-2">Name</label>';
                    echo '        <input type="text" class="form-control" name="newGenre" id="genre" placeholder="Adventure" value="'.$genreRow['name'].'" maxlength="35">';
                    echo '    </div>';
                    echo '    <div class="form-group mb-4">';
                    echo '        <input type="submit" class="form-control btn btn-primary" value="Update">';
                    echo '    </div>';
                    echo '</form>';

                }
                else
                {
                    echo '<div class="text-muted">No genre found.</div>';
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
