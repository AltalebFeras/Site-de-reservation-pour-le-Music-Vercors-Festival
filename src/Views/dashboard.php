<?php

include_once __DIR__ . '/Includes/header.php';

include_once __DIR__ . '/Includes/colonne.php';

// echo "From dashboard this echo => role is" . " " . $_SESSION['role'];
// echo "<br>";
// echo ("utilisateurID =$utilisateurID");


?>
<div class="content">

  <?php

  if ($_SESSION['role'] == 'user') {


    echo '<div>
    <a href="dashboard/reservation" class="btn btn-info">Ma réservation</a>
    <a href="dashboard/compte" class="btn btn-info">Mon compte</a>
  </div>';
    // include_once __DIR__ . '/utilisateurView/compte.php';

  }
  // switch ($section) {
  //   case '':
  //     switch ($action) {
  //       case '#':
  //         include_once __DIR__ . '';
  //         break;

  //       default:
  //         include_once __DIR__ . '';
  //         break;
  //     }
  //     break;

  //   default:
  //     include_once __DIR__ . '';
  //     break;
  // }
  ?>
</div>
<?php
include_once __DIR__ . '/Includes/footer.php';
