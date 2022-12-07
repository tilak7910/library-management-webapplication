<?php
    include '../config.php';
    include '../head.php';
    include '../footer.php';

    $head = new Head();
    $head->setTitle('View a Borrower');
    $head->addStyle('../css/styles.css');
    $head->drawHead();
    $head->drawMenu();
?>


<div class="right p-5">
    <main id="view-page">
        <h1>View a Borrower</h1>
        <hr>

        <?php

            if ($conn->connect_errno)
            {
                echo '<div class="bg-danger text-white p-3 mb-5">Connection error!</div>';
                exit;
            }


            // success message
            if (isset($_SESSION['success']) && $_SESSION['success']) {
              echo '<div class="bg-success text-white p-3 mb-5">'.$_SESSION['success'].'</div>';
            }

            unset($_SESSION['error']);
            unset($_SESSION['success']);



            // view borrower info
            if ( isset($_GET['id']) && $_GET['id'] )
            {

                $id = $_GET['id'];

                $borrowerSql = "select *
                              from BORROWER
                              where id = $id";

                $borrowerResult = $conn->query($borrowerSql);
                $txt = "";

                if ($borrowerResult && $borrowerResult->num_rows > 0)
                {
                    $borrowerRow = $borrowerResult->fetch_assoc();

                    echo '<table class="table table-striped">';

                    echo '<tr>';
                    echo '<td class="col-3">First Name</td>';
                    echo '<td class="col-9">'.$borrowerRow['fName'].'</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td class="col-3">Last Name</td>';
                    echo '<td class="col-9">'.$borrowerRow['lName'].'</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td class="col-3">Email</td>';
                    echo '<td class="col-9">'.$borrowerRow['email'].'</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td class="col-3">Phone Number</td>';
                    echo '<td class="col-9">'.$borrowerRow['phone'].'</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td class="col-3">Street Address</td>';
                    echo '<td class="col-9">'.$borrowerRow['street'].'</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td class="col-3">City</td>';
                    echo '<td class="col-9">'.$borrowerRow['city'].'</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td class="col-3">Province</td>';
                    switch ($borrowerRow['prov']) {
                      case 'NL':
                        $txt = "Newfoundland and Labrador";
                        break;
                      case 'PE':
                        $txt = "Prince Edward Island";
                        break;
                      case 'NS':
                        $txt = "Nova Scotia";
                        break;
                      case 'NP':
                        $txt = "Newfoundland and Labrador";
                        break;
                      case 'QC':
                        $txt = "Quebec";
                        break;
                      case 'ON':
                        $txt = "Ontario";
                        break;
                      case 'MB':
                        $txt = "Manitoba";
                        break;
                      case 'SK':
                        $txt = "Saskatchewan";
                        break;
                      case 'AB':
                        $txt = "Alberta";
                        break;
                      case 'BC':
                        $txt = "British Columbia";
                        break;
                      case 'YT':
                        $txt = "Yukon";
                        break;
                      case 'NT':
                        $txt = "Northwest Territories";
                        break;
                      case 'NU':
                        $txt = "Nunavut";
                        break;
                      default:
                        $txt = "";
                        break;
                    }
                    echo '<td class="col-9">'.$txt.'</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td class="col-3">Postal Code</td>';
                    echo '<td class="col-9">'.$borrowerRow['postalCode'].'</td>';
                    echo '</tr>';

                    echo '</table>';

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
    // $footer->addScript('../js/urlfix.js');
    $footer->drawFooter();
?>
