<?php

    include '../config.php';

    if ($conn->connect_errno) 
    {
        $_SESSION['error'] = 'Connection error!';
        header('Location: ../create/book.php');
    }

    if ( isset($_POST['title']) && $_POST['title'] ) 
    {
        try 
        {
            $title = addslashes( $_POST['title'] );
            $sql = "insert into BOOK (title, pubYear, amount) 
                    values ('$title', '$_POST[pubYear]', '$_POST[amount]')";

            $result = $conn->query($sql);
            $newBookID = $conn->insert_id; // id of the new book just inserted

            $authors = [];
            $genres = [];

            // get all authors id from the $_POST['authors']
            foreach ($_POST['authors'] as $author) {
                array_push($authors, $author);
            }

            // get all genres name from the $_POST['genres']
            foreach ($_POST['genres'] as $genre) {
                array_push($genres, $genre);
            }

            // remove duplicates
            $authors = array_unique($authors);
            $genres = array_unique($genres);

            foreach ($authors as $author) {
                $sql = "insert into WRITES (bookID, authorID) values ($newBookID, $author)";
                $conn->query($sql);
            }

            foreach ($genres as $genre) {
                $sql = "insert into ASSIGNS (genreName, bookID) values ('$genre', $newBookID)";
                $conn->query($sql);
            }

            $_SESSION['success'] = 'Book added.';
            header('Location: ../view/book.php?id='.$newBookID);
            
        }
        catch (Exception $e)
        {
            $_SESSION['error'] = 'There was a problem in adding a book.';
            header('Location: ../create/book.php');
        }
    } 
    else 
    {
        $_SESSION['error'] = 'A required data is needed.';
        header('Location: ../create/book.php');
    }
?>