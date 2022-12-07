

<?php

    include '../config.php';

    if ($conn->connect_errno) {
        echo 'No results found.';
        exit;
    }

    $restrict = (isset($_GET['restrict']) && $_GET['restrict']) ? $_GET['restrict'] : '';

    $searchSql = "select * from BORROWER where id != '$restrict'";



    if ( $_GET['search'] )
    {
        $searchSql = "select * from BORROWER 
                      where id != '$restrict' and 
                            (
                                lName like '%$_GET[search]%' or 
                                id like '%$_GET[search]%' or
                                email like '%$_GET[search]%'
                            )";   
    }

    $searchResult = $conn->query($searchSql);

    if ($searchResult && $searchResult->num_rows > 0) 
    {
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">ID</th>';
        echo '<th scope="col">First Name</th>';
        echo '<th scope="col">Last Name</th>';
        echo '<th scope="col">Email</th>';
        echo '<th scope="col">Phone Number</th>';
        echo '<th scope="col">Address</th>';
        echo '<th scope="col">City</th>';
        echo '<th scope="col">Province</th>';
        echo '<th scope="col">Postal Code</th>';
        echo '<th scope="col">Select</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while ($row = $searchResult->fetch_assoc())
        {
            echo '<tr>';
            echo '<td class="col">'.$row['id'].'</td>';
            echo '<td class="col">'.$row['fName'].'</td>';
            echo '<td class="col">'.$row['lName'].'</td>';
            echo '<td class="col">'.$row['email'].'</td>';
            echo '<td class="col">'.$row['phone'].'</td>';
            echo '<td class="col">'.$row['street'].'</td>';
            echo '<td class="col">'.$row['city'].'</td>';
            echo '<td class="col">'.$row['prov'].'</td>';
            echo '<td class="col">'.$row['postalCode'].'</td>';
            echo '<td class="col">';
            echo '<button type="button" class="select-borrower-tuple">SELECT</button>';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
    }
    else
    {
        echo 'No results found.';
    }



?>