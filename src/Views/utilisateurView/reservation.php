<?php

include_once __DIR__ . '/../Includes/header.php';

include_once __DIR__ . '/../Includes/colonne.php';
if (isset($_SESSION['connecté'])) {
    echo '<div><a href="/" class="btn btn-info">dashoard</a>';
};


echo "hello from page reservation";
include_once __DIR__ . '/reservationCalculation.php';

// <?php
include_once __DIR__ . '/../Includes/footer.php';
