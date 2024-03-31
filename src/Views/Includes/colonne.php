<?php

namespace src\Repositories;

use src\Repositories\UtilisateurRepositories;

$utilisateurRepositories = new UtilisateurRepositories();

?>
<div id="colonne">

  <?php
  if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
      echo "<h2>Bonjour Admin!</h2>";
      echo '<ul>
      <li class="administration ' . ($section == "administration" ? "actif" : "") . '" onclick="location.href=\'/tableau-admin\'">Administration</li>
    </ul>';
    } elseif ($_SESSION['role'] == 'user') {
      $utilisateurID = $_SESSION['utilisateur'];
      // echo ("utilisateurID =$utilisateurID");
      $prenom = $utilisateurRepositories->getPrenom($utilisateurID);
      echo "<h2>Bonjour $prenom!</h2>";
      // $all = $utilisateurRepositories->getAllUtilisateurDetails($utilisateurID);
      // var_dump($all);
     
    }
  }
  ?>


</div>