<?php
include_once __DIR__ . '/Includes/header.php';
?>


<div class="main">
    <form action="admin" method="post">

        <fieldset>
            <h1>Administration</h1>

            <label for="motDePasseAdmin">Code d'accès :</label>
            <input type="password" id="motDePasseAdmin" name="motDePasseAdmin" required>
            <?php if ($erreur == "connexion") { ?>
                <div class="error">
                    Erreur de connexion.
                </div>
            <?php } ?>
            <input type="submit" class="btn btn-info" value="Se connecter">

        </fieldset>
    </form>
</div>


<div class="main">
    <h1>Modifier la réservation</h1>
    <form action="modifier_reservation.php?id=<?php echo $reservation_id; ?>" method="post">
        <label for="nom">Nom:</label><br>
        <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br>
        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="<?php echo $date; ?>"><br><br>
        <input type="submit" value="Mettre à jour">
    </form>
</div>

<div class="main">
    <h1>Supprimer la réservation</h1>
    <p>Êtes-vous sûr de vouloir supprimer cette réservation ?</p>
    <form action="supprimer_reservation.php?id=<?php echo $reservation_id; ?>" method="post">
        <input type="submit" value="Oui">
        <a href="admin.php">Non</a>
    </form>
</div>


<?php
include_once __DIR__ . '/Includes/footer.php';
?>