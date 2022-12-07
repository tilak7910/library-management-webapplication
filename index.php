<?php

    include './config.php';
    include './head.php';
    include './footer.php';

    $head = new Head();
    $head->setTitle('Home');
    $head->addStyle('./css/styles.css');
    $head->drawHead();
    $head->drawMenu();

    /** MAIN */
   
    echo '
    
    <div class="right p-5">
        <main>
            <h1>Dashboard</h1>
            <hr>
        </main>
    </div>
    
    ';

    /** MAIN */

    $footer = new Footer();
    $footer->addScript('./js/site.js');
    $footer->addScript('./js/urlfixhome.js');
    $footer->drawFooter();
?>