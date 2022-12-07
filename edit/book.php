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
        <h1>Edit a Book</h1>
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

            // book info
            if( isset($_GET['id']) && $_GET['id'] )
            {

                $id = $_GET['id'];

                $bookSql = "select * 
                            from BOOK 
                            where id = $id";

                $authorSql = "select AUTHOR.id, AUTHOR.fName, AUTHOR.lName
                              from WRITES
                              join AUTHOR
                              where WRITES.authorID = AUTHOR.id and WRITES.bookID = $id
                              order by AUTHOR.lName";

                $genreSql = "select GENRE.name 
                             from ASSIGNS 
                             join GENRE 
                             where ASSIGNS.genreName = GENRE.name and ASSIGNS.bookID = $id
                             order by GENRE.name";

                $allAuthors = "select * 
                               from AUTHOR 
                               order by lName asc";

                $allGenres = "select *
                              from GENRE
                              order by name asc";

                $bookResult = $conn->query($bookSql);
                $authorResult = $conn->query($authorSql);
                $genreResult = $conn->query($genreSql);
                $allAuthorsResult = $conn->query($allAuthors);
                $allGenresResult = $conn->query($allGenres);

                if ($bookResult && $bookResult->num_rows > 0)
                {

                    $bookRow = $bookResult->fetch_assoc();

                    $authorOptions = [];
                    $genreOptions = [];

                    /** hidden values **************************************************************************************************************************************************/
                    while ($authorRow = $authorResult->fetch_assoc())
                    {
                        echo '<span class="d-none" data-author="'.$authorRow['id'].'"></span>';
                    }
                    while ($genreRow = $genreResult->fetch_assoc())
                    {
                        echo '<span class="d-none" data-genre="'.$genreRow['name'].'"></span>';
                    }
                    /** hidden values **************************************************************************************************************************************************/

             

                    echo '<form action="../update/book.php" method="post">';
                    echo '    <input type="hidden" name="id" value="'.$bookRow['id'].'">';

                    /** title **********************************************************************************************************************************************************/
                    echo '<div class="form-group mb-4">';
                    echo '      <label for="title" class="mb-2">Book Title</label>';
                    echo '      <input type="text" class="form-control" id="title" name="title" placeholder="Alice in Wonderland" value="'.$bookRow['title'].'" maxlength=100 required>';
                    echo '</div>';
                    /** title **********************************************************************************************************************************************************/


                    /** initial author *************************************************************************************************************************************************/
                    echo '<div class="form-group mb-4 p-4 multiple-select author-multiple-select">';
                    echo '      <label for="title" class="mb-2">Add Author</label>';
                    echo '      <div class="container-fluid">';
                    echo '          <div class="row mt-3 author">';
                    echo '              <select name="authors[]" class="form-control flex-grow-1">';
                    echo '                  <option value="">No author selected</option>';
                                            while ($authorRow = $allAuthorsResult->fetch_assoc())
                                            {
                                                if(!$authorRow['fName']) 
                                                {
                                                    echo '<option value="'.$authorRow['id'].'">'.$authorRow['lName'].'</option>';
                                                } 
                                                else 
                                                {
                                                    echo '<option value="'.$authorRow['id'].'">'.$authorRow['lName'].', '.$authorRow['fName'].'</option>';
                                                }
                                            } 
                    echo '              </select>';
                    echo '              <div class="btn btn-secondary addfield" onclick="addField(this)"><i class="fas fa-plus"></i></div>';
                    echo '              <div class="btn btn-secondary addfield" onclick="removeField(this)"><i class="fas fa-minus"></i></div>';
                    echo '          </div>';   
                    echo '      </div>';
                    echo '</div>';
                    /** initial author *************************************************************************************************************************************************/


                    /** pub year *******************************************************************************************************************************************************/
                    echo '<div class="form-group mb-4">';
                    echo '    <label for="pubYear" class="mb-2">Publication Year</label>';
                    echo '    <input type="number" class="form-control" id="pubYear" name="pubYear" placeholder="1986" value="'.$bookRow['pubYear'].'" maxlength="4" min="0" max="3000">';
                    echo '</div>';
                    /** pub year *******************************************************************************************************************************************************/


                    $minAmtBookSql = "select count(*) as amount from RENTAL where bookID = '$id'";
                    $minAmtBookResult = $conn->query($minAmtBookSql);
                    $minAmtBook =  $minAmtBookResult->fetch_assoc()['amount'];
                    
                    /** num copies *****************************************************************************************************************************************************/
                    echo '<div class="form-group mb-4">';
                    echo '    <label for="amount" class="mb-2">Number of Total Copies</label>';
                    $disabled = '';
                    if ($minAmtBook > 0) {
                        echo '    <small class="d-block">There are <strong>'.$minAmtBook.'</strong> copies being rented. You cannot change the number of copies of this book.</small>';
                        $disabled = 'disabled';
                    } 
                    echo '    <input type="number" class="form-control" id="amount" name="amount" placeholder="" value="'.$bookRow['amount'] + $minAmtBook.'" maxlength="2" min="0" max="25" '.$disabled.'>';
                    echo '</div>';
                    /** num copies *****************************************************************************************************************************************************/

                    
                    /** genre **********************************************************************************************************************************************************/

                    echo '<div class="form-group mb-4 p-4 multiple-select genre-multiple-select">';
                    echo '      <label for="genre" class="mb-2">Assign Genre</label>';
                    echo '      <div class="container-fluid">';
                    echo '          <div class="row mt-3 genre">';
                    echo '              <select name="genres[]" class="form-control flex-grow-1">';
                    echo '                  <option value="">No genre selected</option>';
                                            while ($genreRow = $allGenresResult->fetch_assoc()) 
                                            {
                                                echo '<option value="'.$genreRow['name'].'">'.$genreRow['name'].'</option>';
                                            }
                    echo '              </select>';
                    echo '              <div class="btn btn-secondary addfield" onclick="addField(this)"><i class="fas fa-plus"></i></div>';
                    echo '              <div class="btn btn-secondary addfield" onclick="removeField(this)"><i class="fas fa-minus"></i></div>';
                    echo '          </div>';
                    echo '      </div>';
                    echo '</div>';
                    /** genre **********************************************************************************************************************************************************/


                    echo '<div class="form-group mb-4">';
                    echo '      <input type="submit" class="form-control btn btn-primary" value="Update">';
                    echo '</div>';
            

                    echo '</form>';

                }
                else
                {
                    echo '<div class="text-muted">No books found.</div>';
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