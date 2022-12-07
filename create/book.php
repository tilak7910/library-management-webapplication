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
        <h1>Add a Book</h1>
        <hr>

        
        <?php
            if (isset($_SESSION['error']) && $_SESSION['error']) {
                echo '<div class="bg-danger text-white p-3 mb-5">'.$_SESSION['error'].'</div>';
            }
            
            unset($_SESSION['error']);
            unset($_SESSION['success']);
        ?>


        <form action="../insert/book.php" method="post">

            <!--title-->
            <div class="form-group mb-4">
                <label for="title" class="mb-2 required">Book Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Alice in Wonderland" maxlength=100 required>
            </div>
            <!--title-->

            <!--author-->
            <div class="form-group mb-4 p-4 multiple-select">
                <label for="title" class="mb-2">Add author</label>
                <div class="container-fluid">

                    <?php
                    
                        $sql = 'select * from AUTHOR order by lName asc';
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) 
                        { 
                            echo '<div class="row mt-3 author">';
                            echo '<select name="authors[]" class="form-control flex-grow-1">';
                            echo '<option value="">No author selected</option>';

                            while($row = $result->fetch_assoc()) 
                            {
                                if(!$row['fName']) 
                                {
                                    echo '<option value="'.$row['id'].'">'.$row['lName'].'</option>';
                                } 
                                else 
                                {
                                    echo '<option value="'.$row['id'].'">'.$row['lName'].', '.$row['fName'].'</option>';
                                }  
                            }
                            echo '</select>';
                            echo '<div class="btn btn-secondary addfield" onclick="addField(this)"><i class="fas fa-plus"></i></div>';
                            echo '<div class="btn btn-secondary addfield" onclick="removeField(this)"><i class="fas fa-minus"></i></div>';
                            echo '</div>';
                        } 
                        else 
                        {
                            echo '<div class="px-2 py-2 bg-light text-dark">No authors found</div>';
                        }
                    ?>

                </div>
             </div>
             <!--author-->

             <!--pub year-->
            <div class="form-group mb-4">
                <label for="pubYear" class="mb-2">Publication Year</label>
                <input type="number" class="form-control" id="pubYear" name="pubYear" placeholder="1986" maxlength="4" min="0" max="3000">
            </div>
             <!--pub year-->

             <!--num copies-->
            <div class="form-group mb-4">
                <label for="amount" class="mb-2">Number of Copies</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="" maxlength="2" min="0" max="25">
            </div>
             <!--num copies-->

             <!--genre-->
            <div class="form-group mb-4 p-4 multiple-select">
                <label for="genre" class="mb-2">Assign Genre</label>
                <div class="container-fluid">

                    <?php
                        $sql = 'select * from GENRE order by name asc';
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) 
                        { 
                            echo '<div class="row mt-3 genre">';
                            echo '<select name="genres[]" class="form-control flex-grow-1">';
                            echo '<option value="">No genre selected</option>';

                            while($row = $result->fetch_assoc()) 
                            {
                                echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                            }
                            echo '</select>';
                            echo '<div class="btn btn-secondary addfield" onclick="addField(this)"><i class="fas fa-plus"></i></div>';
                            echo '<div class="btn btn-secondary addfield" onclick="removeField(this)"><i class="fas fa-minus"></i></div>';
                            echo '</div>';
                        } 
                        else 
                        {
                            echo '<div class="px-2 py-2 bg-light text-dark">No genres found</div>';
                        }
                    ?>

                </div>
             </div>
             <!--genre-->

             <div class="form-group mb-4">
                <input type="submit" class="form-control btn btn-primary" value="Save">
            </div>
        </form>
  </main>
</div>

<?php
    $footer = new Footer();
    $footer->addScript('../js/site.js');
    $footer->drawFooter();
?>