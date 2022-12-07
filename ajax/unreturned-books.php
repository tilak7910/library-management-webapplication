<?php


include '../config.php';

if ($conn->connect_errno) {
    echo 'No results found.';
    exit;
}

$searchSql = "select distinct BORROWER.id as borrowerID, BOOK.id as bookID, lName, fName, title, pubYear, rentalDate, dueDate
              from RENTAL, BORROWER, BOOK 
              where RENTAL.borrowerID = BORROWER.id and 
                    RENTAL.bookID = BOOK.id 
              order by lName";

if ( $_GET['search'] )
{
    $searchSql = "select BORROWER.id as borrowerID, BOOK.id as bookID, lName, fName, title, pubYear, rentalDate, dueDate
                  from RENTAL
                  join BORROWER
                  on RENTAL.borrowerID = BORROWER.id
                  join BOOK 
                  on RENTAL.bookID = BOOK.id 
                  where title like '%$_GET[search]%' or 
                        lName like '%$_GET[search]%' or 
                        borrowerID like '%$_GET[search]%' or 
                        rentalDate like '%$_GET[search]%'
                  order by lName";   
}

// print_r($searchSql);

$searchResult = $conn->query($searchSql);

// print_r($searchResult);

if ($searchResult && $searchResult->num_rows > 0) 
{
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Borrower Name</th>';
    echo '<th scope="col">Book Title</th>';
    echo '<th scope="col">Rental Date</th>';
    echo '<th scope="col">Due Date</th>';
    echo '<th scope="col">Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = $searchResult->fetch_assoc())
    {
        // $bookSql = "select * from BOOK where id = '$row[bookID]'";
        // $bookResult = $conn->query($bookSql);

        // if ($bookResult && $bookResult->num_rows > 0) {
        //     $bookRow = $bookResult->fetch_assoc();
        //     $bookTitle = $bookRow['title'].' ('.$bookRow['pubYear'].')';
        // } else {
        //     $bookTitle = '';
        // }
        $borrowerName = $row['fName'].' '.$row['lName'];
        $bookTitle = $row['title'].' '.'('.$row['pubYear'].')';
        $rentalDate = $row['rentalDate'];
        $dueDate = $row['dueDate'];

        echo '<tr>';
        echo '<td class="col">'.$borrowerName.'</td>';
        echo '<td class="col">'.$bookTitle.'</td>';
        echo '<td class="col">'.$rentalDate.'</td>';
        echo '<td class="col">'.$dueDate.'</td>';
        echo '<td>';
        echo '<a title="Update" class="mx-1 my-1 p-1 btn btn-primary" href="../view/rental.php?borrower='.$row['borrowerID'].'&book='.$row['bookID'].'&rental='.$row['rentalDate'].'"><i class="fas fa-eye"></i>';
        echo '<a title="Edit" class="mx-1 my-1 p-1 btn btn-success" href="../edit/rental.php?borrower='.$row['borrowerID'].'&book='.$row['bookID'].'&rental='.$row['rentalDate'].'"><i class="fas fa-edit"></i></a>';
        echo '<a title="Delete" class="mx-1 my-1 p-1 btn btn-danger" href="../view/rental.php?view=delete&borrower='.$row['borrowerID'].'&book='.$row['bookID'].'&rental='.$row['rentalDate'].'"><div class="d-flex align-items-center" style="font-size:15px; font-weight:bold; line-height:0;"><i class="fas fa-hand-holding" style="margin-right:5px;"></i>RETURN</div></a>';
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