<?php
    include '../config.php';
    include '../head.php';
    include '../footer.php';

    $head = new Head();
    $head->setTitle('Borrower');
    $head->addStyle('../css/styles.css');
    $head->drawHead();
    $head->drawMenu();
?>

<div class="right p-5">
    <main>
        <h1>Edit a Borrower</h1>
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

            // author info
            if( isset($_GET['id']) && $_GET['id'] )
            {

                $id = $_GET['id'];

                $borrowerSql = "select *
                              from BORROWER
                              where id = $id";

                $borrowerResult = $conn->query($borrowerSql);

                if ($borrowerResult && $borrowerResult->num_rows > 0)
                {
                    $borrowerRow = $borrowerResult->fetch_assoc();
                    echo '<form action="../update/borrower.php" method="post">';
                    echo '    <input type="hidden" name="id" value="'.$borrowerRow['id'].'">';
                    echo '    <div class="form-group mb-4">';
                    echo '        <label for="fName" class="mb-2">First Name</label>';
                    echo '        <input type="text" class="form-control" id="fName" name="fName" value="'.$borrowerRow['fName'].'" maxlength="35">';
                    echo '    </div>';
                    echo '    <div class="form-group mb-4">';
                    echo '        <label for="lName" class="mb-2 required">Last Name</label>';
                    echo '        <input type="text" class="form-control" id="lName" name="lName" value="'.$borrowerRow['lName'].'" maxlength="45" required>';
                    echo '    </div>';
                    echo '    <div class="form-group mb-4">';
                    echo '        <label for="email" class="mb-2 required">Email Address</label>';
                    echo '        <input type="email" class="form-control" id="email" name="email" value="'.$borrowerRow['email'].'" maxlength="35" required>';
                    echo '    </div>';
                    echo '    <div class="form-group mb-4">';
                    echo '        <label for="phone" class="mb-2">Phone </label>';
                    echo '        <input type="tel" class="form-control" id="phone" name="phone" value="'.$borrowerRow['phone'].'" maxlength="15" >';
                    echo '    </div>';
                    echo '    <div class="row">';
                    echo '          <div class="form-group mb-4 col">';
                    echo '              <label for="street" class="mb-2">Street Address</label>';
                    echo '              <input type="text" class="form-control" id="street" name="street" value="'.$borrowerRow['street'].'" maxlength="30" >';
                    echo '          </div>';
                    echo '          <div class="form-group mb-4 col">';
                    echo '              <label for="city" class="mb-2">City</label>';
                    echo '              <input type="text" class="form-control" id="city" name="city" value="'.$borrowerRow['city'].'" maxlength="30" >';
                    echo '          </div>';
                    echo '          <div class="form-group mb-4 col">';
                    echo '              <label for="prov" class="mb-2">Province</label>';
                    echo '              <div class="d-none" id="selected-prov" data-selected-prov="'.$borrowerRow['prov'].'"></div>';
                    echo '              <select class="form-select" id="prov" name="prov">';
                    echo '                <option value="" selected></option>';
                    echo '                <option value="NL">NL</option>';
                    echo '                <option value="PE">PE</option>';
                    echo '                <option value="NS">NS</option>';
                    echo '                <option value="NB">NB</option>';
                    echo '                <option value="QC">QC</option>';
                    echo '                <option value="ON">ON</option>';
                    echo '                <option value="MB">MB</option>';
                    echo '                <option value="SK">SK</option>';
                    echo '                <option value="AB">AB</option>';
                    echo '                <option value="BC">BC</option>';
                    echo '                <option value="YT">YT</option>';
                    echo '                <option value="NT">NT</option>';
                    echo '                <option value="NU">NU</option>';
                    echo '              </select>';
                    echo '          </div>';
                    echo '    </div>';
                    echo '    <div class="form-group mb-4">';
                    echo '        <label for="postalCode" class="mb-2">Postal Code</label>';
                    echo '        <input type="text" class="form-control" id="postalCode" name="postalCode" value="'.$borrowerRow['postalCode'].'" maxlength="10">';
                    echo '    </div>';
                    echo '    <div class="form-group mb-4">';
                    echo '        <input type="submit" class="form-control btn btn-primary" value="Update">';
                    echo '    </div>';
                    echo '</form>';

                }
                else
                {
                    echo '<div class="text-muted">No Borrower found.</div>';
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
    $footer->addScript('../js/edit-borrower.js');
    $footer->drawFooter();
?>
