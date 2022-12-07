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
        <h1>View an Author</h1>
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


            // view author info
            if ( isset($_GET['id']) && $_GET['id'] )
            {
                
                $id = $_GET['id'];

                $authorSql = "select * 
                              from AUTHOR 
                              where id = $id";

                $bookSql = "select title, pubYear
                            from WRITES
                            join BOOK
                            where WRITES.bookID = BOOK.id and 
                                  WRITES.authorID = $id
                            order by title asc";


                $bookResult = $conn->query($bookSql);
                $authorResult = $conn->query($authorSql);

 
                if ($authorResult && $authorResult->num_rows > 0)
                {
                    $authorRow = $authorResult->fetch_assoc();

                    echo '<table class="table table-striped">';

                    echo '<tr>';
                    echo '<td class="col-3">First Name</td>';
                    echo '<td class="col-9">'.$authorRow['fName'].'</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td class="col-3">Last Name</td>';
                    echo '<td class="col-9">'.$authorRow['lName'].'</td>';
                    echo '</tr>';

                    echo '</table>';


                    if ($bookResult->num_rows > 0)
                    {
                        echo '<h2 class="mt-5">Books Published</h2>';
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
                    echo '<div class="text-muted">No author found.</div>';
                }

            }
            else 
            {
                echo '<div class="bg-danger text-white p-3">A required data is needed. Check the url.</div>';
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