<?php

    include '../config.php';

    if ($conn->connect_errno) 
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../edit/book.php?id='.$_POST['id']);
    }

    if ( isset($_POST['title']) && $_POST['title'] ) 
    {

        $bookID = $_POST['id'];
        $bookTitle = addslashes( $_POST['title'] );

        $bookSql = "update BOOK 
                    set title = '$bookTitle',
                        pubYear = '$_POST[pubYear]',
                        amount = '$_POST[amount]'
                    where id = '$_POST[id]'";

        $bookResult = $conn->query($bookSql);


        // delete existing records from WRITES and ASSIGNS table related to this book
        $deleteWritesSql = "delete from WRITES where bookID = '$bookID'";
        $deleteAssignsSql = "delete from ASSIGNS where bookID = '$bookID'";
        $conn->query($deleteWritesSql);
        $conn->query($deleteAssignsSql);
        
        $authors = [];
        $genres = [];

        // get all authors id from the $_POST['authors']
        foreach ($_POST['authors'] as $author) {
            array_push($authors, $author);
        }

        foreach ($_POST['genres'] as $genre) {
            array_push($genres, $genre);
        }

        // remove duplicates
        $authors = array_unique($authors);
        $genres = array_unique($genres);


        // insert authors and genres to WRITES and ASSIGNS table
        foreach ($authors as $author) {
            $authorSql = "insert into WRITES (authorID, bookID) values ('$author', '$bookID')";
            $conn->query($authorSql);
        }

        foreach ($genres as $genre) {
            $genreSql = "insert into ASSIGNS (genreName, bookID) values ('$genre', '$bookID')";
            $conn->query($genreSql);
        }

        if($bookResult)
        {
            $_SESSION['success'] = 'Book updated.';
            header('Location: ../view/book.php?id='.$_POST['id']);
        }
        else
        {
            $_SESSION['error'] = 'Book failed to update.';
            header('Location: ../edit/book.php?id='.$_POST['id']);
        }
    } 
    else 
    {
        $_SESSION['error'] = 'A required data is needed.';
        header('Location: ../edit/book.php?id='.$_POST['id']);
    }

?>
