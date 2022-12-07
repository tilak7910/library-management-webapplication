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
        <h1>List of Books</h1>
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

            if (isset($_SESSION['success']) && $_SESSION['success']) {
                echo '<div class="bg-success text-white p-3 mb-5">'.$_SESSION['success'].'</div>';
            }

            unset($_SESSION['error']);
            unset($_SESSION['success']);

            // book info
            $sql = 'select BOOK.id,
                           BOOK.title,
                           group_concat(concat(AUTHOR.fName," ",AUTHOR.lName)) as authorNames,
                           BOOK.pubYear,
                           BOOK.amount
                    from BOOK
                    left join WRITES
                        on BOOK.id = WRITES.bookID
                    left join AUTHOR
                        on WRITES.authorID = AUTHOR.id
                    group by BOOK.id';

            $result = $conn->query($sql);

            if (!$result) 
            {
                echo '<div class="bg-danger text-white p-3">Connection error!</div>';
                exit;
            } 
            else if ($result->num_rows > 0)
            {
                echo '<table class="table table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th scope="col">Title</th>';
                echo '<th scope="col">Author(s)</th>';
                echo '<th scope="col">Year Published</th>';
                echo '<th scope="col">Available Copies</th>';
                echo '<th scope="col">Rented Copies</th>';
                echo '<th scope="col">Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while($row = $result->fetch_assoc()) {

                    $amtBookRentedSql = "select count(*) as amount from RENTAL where bookID = '$row[id]'";
                    $amtBookRentedResult = $conn->query($amtBookRentedSql);
                    $amtRented =  $amtBookRentedResult->fetch_assoc()['amount'];

                    $authorSql = "select fName, lName 
                                  from AUTHOR 
                                  join WRITES 
                                  where AUTHOR.id = WRITES.authorID and
                                        WRITES.bookID = '$row[id]'";

                    $authorResult = $conn->query($authorSql);
                    $authors = [];

                    while ($authorRow = $authorResult->fetch_assoc()) {
                        array_push($authors, $authorRow['fName'].' '.$authorRow['lName']);
                    }
                    $authors = implode(', ', $authors);


                    echo '<tr>';
                    echo '<td class="col">'.$row['title'].'</td>'; 
                    echo '<td class="col">'.$authors.'</td>'; 
                    echo '<td class="col">'.$row['pubYear'].'</td>'; 
                    echo '<td class="col">'.$row['amount'].'</td>'; 
                    echo '<td class="col">'.$amtRented.'</td>'; 
                    echo '<td class="col">';
                    echo '<a title="Update" class="mx-1 my-1 p-1 btn btn-primary" href="../view/book.php?id='.$row['id'].'"><i class="fas fa-eye"></i>';
                    echo '<a title="Edit" class="mx-1 my-1 p-1 btn btn-success" href="../edit/book.php?id='.$row['id'].'"><i class="fas fa-edit"></i></a>';
                    echo '<a title="Delete" class="mx-1 my-1 p-1 btn btn-danger" href="../delete/book.php?id='.$row['id'].'"><i class="fas fa-trash-alt"></i></a>';
                    echo '</td>'; 
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';

            } 
            else 
            {
                echo '<div class="text-muted">No authors found.</div>';
            }

        ?>

    </main>
</div>

<?php
    $footer = new Footer();
    $footer->addScript('../js/site.js');
    $footer->drawFooter();
?>