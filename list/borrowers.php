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
        <h1>List of Borrowers</h1>
        <hr>

        <?php

            if ($conn->connect_errno)
            {
                echo '<div class="bg-danger text-white p-3 mb-5">Connection Error!</div>';
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


            // borrower info
            $sql = 'select * from BORROWER order by lName asc';

            $result = $conn->query($sql);

            if (!$result)
            {
                echo '<div class="bg-danger text-white p-3 mb-5">Connection error!</div>';
                exit;
            }
            else if ($result->num_rows > 0)
            {
                echo '<table class="table table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th scope="col">Last Name</th>';
                echo '<th scope="col">First Name</th>';
                echo '<th scope="col">Email</th>';
                echo '<th scope="col">Phone Number</th>';
                echo '<th scope="col">Street</th>';
                echo '<th scope="col">City</th>';
                echo '<th scope="col">Province</th>';
                echo '<th scope="col">Postal Code</th>';
                echo '<th scope="col">Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td class="col">'.$row['lName'].'</td>';
                    echo '<td class="col">'.$row['fName'].'</td>';
                    echo '<td class="col">'.$row['email'].'</td>';
                    echo '<td class="col">'.$row['phone'].'</td>';
                    echo '<td class="col">'.$row['street'].'</td>';
                    echo '<td class="col">'.$row['city'].'</td>';
                    echo '<td class="col">'.$row['prov'].'</td>';
                    echo '<td class="col">'.$row['postalCode'].'</td>';
                    echo '<td class="col">';
                    echo '<a title="Update" class="mx-1 my-1 p-1 btn btn-primary" href="../view/borrower.php?id='.$row['id'].'"><i class="fas fa-eye"></i>';
                    echo '<a title="Edit" class="mx-1 my-1 p-1 btn btn-success" href="../edit/borrower.php?id='.$row['id'].'"><i class="fas fa-edit"></i></a>';
                    echo '<a title="Delete" class="mx-1 my-1 p-1 btn btn-danger" href="../delete/borrower.php?id='.$row['id'].'"><i class="fas fa-trash-alt"></i></a>';
                    echo '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';

            }
            else
            {
                echo '<div class="text-muted">No borrowers found.</div>';
            }

        ?>

    </main>
</div>

<?php
    $footer = new Footer();
    $footer->addScript('../js/site.js');
    $footer->drawFooter();
?>
