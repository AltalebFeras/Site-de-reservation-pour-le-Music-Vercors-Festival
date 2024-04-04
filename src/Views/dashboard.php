<?php
include_once __DIR__ . '/Includes/header.php';
include_once __DIR__ . '/Includes/colonne.php';

if ($_SESSION['role'] == 'user') {
    echo '<div>
            <a href="dashboard/reservation" class="btn btn-info">Ma réservation</a>
            <a href="dashboard/compte" class="btn btn-info">Mon compte</a>
          </div>';


?>

    <div>
        <p> " Cliquez sur le
            <a class="btn btn-warning my-3" href="createReservation">lien</a>
            pour creér une réservation."
        </p>
    </div>


<?php } ?>
<?php
include_once __DIR__ . '/Includes/footer.php';
?>
