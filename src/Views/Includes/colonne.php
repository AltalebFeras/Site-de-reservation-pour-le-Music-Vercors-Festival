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
    } elseif ($_SESSION['role'] == 'user') {
      $utilisateur = $_SESSION['utilisateur'];
      // Assuming getPrenom() is a method of UtilisateurRepositories
      $prenom = $utilisateurRepositories->getPrenom($utilisateur);
      echo "<h2>Bonjour $prenom!</h2>";
      $all = $utilisateurRepositories->getAll($utilisateur);
      var_dump($all);
    }
  }
  ?>

  <ul>
    <li class="administration <?= $section == "administration" ? "actif" : "" ?>" onclick="location.href='/tableau-admin'">Administration</li>
  </ul>
</div>