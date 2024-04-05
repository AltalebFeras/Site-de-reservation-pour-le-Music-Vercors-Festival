<?php

include_once __DIR__ . '/../Includes/header.php';
include_once __DIR__ . '/../Includes/colonne.php';

if (isset($_SESSION['connecté'])) {
    echo '<div><a href="/" class="btn btn-info">Dashboard</a></div>';
}

echo "Hello from page reservation";

$all = $ReservationRepositories->getAllReservations($ReservationRepositories);
$prixTotal = $ReservationRepositories->getPrixTotal($ReservationRepositories);
$nuitee = $ReservationRepositories->getNuitee($ReservationRepositories);
$option = $ReservationRepositories->getOption($ReservationRepositories);

?>

<form id="monCompteForm" action="" method="post">
    <fieldset class="d-flex flex-column">
        <legend>Vos réservations</legend>
        <label for="passJour">Pass Jour :</label>
        <input type="text" name="passJour" id="passJour" placeholder="<?php echo $all[0]['passJour']; ?>" disabled>

        <label for="prixTotal">Prix de la réservation :</label>
        <input type="text" name="prixTotal" id="prixTotal" placeholder="<?php echo $prixTotal; ?>" disabled>

        <label for="nuitee">Nuitee:</label>
        <input type="text" name="nuitee" id="nuitee" placeholder="<?php echo $all[0]['nuitee']; ?>" disabled>

        <label for="option">Option:</label>
        <input type="text" name="option" id="option" placeholder="<?php echo $all[0]['option']; ?>" disabled>


        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Supprimer la reservation
        </button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Confirmer la suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <input type="submit" name="suppression" class="btn btn-danger" value="Valider">
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<?php
include_once __DIR__ . '/../Includes/footer.php';
?>