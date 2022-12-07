<?php
    class Head {
        public $title = '';
        public $styles = [];

        function setTitle($pTitle) {
            $this->title = $pTitle;
        }

        function addStyle($pStyle) {
            array_push($this->styles, $pStyle);
        }

        function drawHead() {
            echo 
            '
            <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/fontawesome.min.css" integrity="sha512-Rcr1oG0XvqZI1yv1HIg9LgZVDEhf2AHjv+9AuD1JXWGLzlkoKDVvE925qySLcEywpMAYA/rkg296MkvqBF07Yw==" crossorigin="anonymous" referrerpolicy="no-referrer">
                    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&family=Source+Sans+Pro:wght@300;700&display=swap" rel="stylesheet">
                    
            ';

            foreach ($this->styles as $item) {
                echo '<link rel="stylesheet" href="'.$item.'">';
            }

            echo
                '<title>'.$this->title.'</title>
                </head>';
        }

        function drawMenu() {
            echo
            '
                <body>
                    <div class="body-wrapper d-flex">
                        <div class="left menu p-3">
                                <ul>
                                    <li>
                                        <a href="../create/author.php">
                                            <i class="fas fa-bookmark"></i>    
                                            <div>Add an author</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../create/book.php">
                                            <i class="fas fa-book"></i>
                                            <div>Add a book</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../create/borrower.php">
                                            <i class="fas fa-user"></i>
                                            <div>Register a borrower</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../create/genre.php">
                                            <i class="fas fa-dragon"></i>    
                                            <div>Add a Genre</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../create/rental.php">
                                            <i class="fas fa-file-export"></i>    
                                            <div>Rent a book</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../list/authors.php">
                                            <i class="far fa-list-alt"></i>    
                                            <div>List all authors</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../list/books.php">
                                            <i class="far fa-list-alt"></i>    
                                            <div>List all books</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../list/borrowers.php">
                                            <i class="far fa-list-alt"></i>    
                                            <div>List all borrowers</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../list/genres.php">
                                            <i class="far fa-list-alt"></i>    
                                            <div>List all genres</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../list/rental.php">
                                            <i class="far fa-list-alt"></i>    
                                            <div>List of unreturned books</div>
                                        </a>
                                    </li>
                                </ul>
                        </div>
            ';
        }
    }

?>