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
        <h1>Register a Borrower</h1>
        <hr>


        <?php
            if (isset($_SESSION['error']) && $_SESSION['error']) {
                echo '<div class="bg-danger text-white p-3 mb-5">'.$_SESSION['error'].'</div>';
            }
            
            unset($_SESSION['error']);
            unset($_SESSION['success']);
        ?>


        <form action="../insert/borrower.php" method="post">
            <div class="form-group mb-4">
                <label for="fName" class="mb-2">First Name</label>
                <input type="text" class="form-control" id="fName" name="fName" placeholder="John" maxlength="35">
            </div>
            <div class="form-group mb-4">
                <label for="lName" class="mb-2 required">Last Name</label>
                <input type="text" class="form-control" id="lName" name="lName" placeholder="Smith" maxlength="45" required>
            </div>
            <div class="form-group mb-4">
                <label for="email" class="mb-2 required">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="example@email.com" maxlength="35" required>
            </div>
            <div class="form-group mb-4">
                <label for="phone" class="mb-2">Phone #</label>
                <input type="tel" class="form-control" id="phone" name="phone" maxlength="15" >
            </div>

            <div class="row">
                <div class="form-group mb-4 col">
                    <label for="street" class="mb-2">Street Address</label>
                    <input type="text" class="form-control" id="street" name="street" maxlength="30" >
                </div>
                <div class="form-group mb-4 col">
                    <label for="city" class="mb-2">City</label>
                    <input type="text" class="form-control" id="city" name="city" maxlength="30" >
                </div>
                <div class="form-group mb-4 col">
                    <label for="prov" class="mb-2">Province</label>
                    <select class="form-select" id="prov" name="prov">
                    <option value="" selected></option>
                    <option value="NL">NL</option>
                    <option value="PE">PE</option>
                    <option value="NS">NS</option>
                    <option value="NB">NB</option>
                    <option value="QC">QC</option>
                    <option value="ON">ON</option>
                    <option value="MB">MB</option>
                    <option value="SK">SK</option>
                    <option value="AB">AB</option>
                    <option value="BC">BC</option>
                    <option value="YT">YT</option>
                    <option value="NT">NT</option>
                    <option value="NU">NU</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group mb-4">
                <label for="postalCode" class="mb-2">Postal Code</label>
                <input type="text" class="form-control" id="postalCode" name="postalCode" maxlength="10">
            </div>
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
