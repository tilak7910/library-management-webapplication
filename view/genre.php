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
        <h1>View a Genre</h1>
        <hr>

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

            // view genre info
            if ( isset($_GET['name']) && $_GET['name'] )
            {
                
                $name = $_GET['name'];

                $genreSql = "select * from GENRE where name = '$name'";

                $bookSql = "select BOOK.title, BOOK.pubYear
                            from BOOK
                            join ASSIGNS
                            where BOOK.id = ASSIGNS.bookID and ASSIGNS.genreName = '$name'";


                $genreResult = $conn->query($genreSql);
                $bookResult = $conn->query($bookSql);

 
                if ($genreResult && $genreResult->num_rows > 0)
                {
                    $genreRow = $genreResult->fetch_assoc();

                    echo '<table class="table table-striped">';

                    echo '<tr>';
                    echo '<td class="col-3">Genre</td>';
                    echo '<td class="col-9">'.$genreRow['name'].'</td>';
                    echo '</tr>';

                    echo '</table>';

                    if ($bookResult->num_rows > 0)
                    {
                        echo '<h2 class="mt-5">Books in this Genre</h2>';
                        echo '<table class="table table-striped">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th scope="">Title</th>';
                        echo '<th scope="">Year Published</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        while ($bookRow = $bookResult->fetch_assoc())
                        {
                            echo '<tr>';
                            echo '<td class="">'.$bookRow['title'].'</td>'; 
                            echo '<td class="">'.$bookRow['pubYear'].'</td>'; 
                            echo '</tr>';

                        }
                    }

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
    // $footer->addScript('../js/urlfix.js');
    $footer->drawFooter();
?>