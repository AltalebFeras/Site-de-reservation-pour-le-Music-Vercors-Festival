<?php
include_once __DIR__ . '/Includes/header.php';

if (isset($_SESSION['error_message0'])) {
  echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message0'] . '</div>';
  unset($_SESSION['error_message0']);
}
?>
<form action="" id="inscription" method="post">
  <fieldset id="reservation">
    <legend>Réservation</legend>
    <h3>Nombre de réservation(s) :</h3>
    <input type="number" name="nombrePlaces" id="nombrePlaces" min="1" max="20" required>
    <div id="alertMessage" class="bg-danger text-white"></div>
    <h3>Réservation(s) en tarif réduit</h3>
    <input type="checkbox" name="tarifReduit" id="tarifReduit" onclick="afficherMasquerTarifsReduits()">
    <label for="tarifReduit">Ma réservation sera en tarif réduit</label>

    <h3>Choisissez votre formule :</h3>
    <div id="tarifsNormaux">
      <input type="radio" name="choixPass" id="pass1jour" value="pass1jour" onclick="choixDate1jour()">
      <label for="pass1jour">Pass 1 jour : 40€</label>

      <!-- Si case cochée, afficher le choix du jour -->
      <section id="pass1jourDate">
        <div>
          <input type="checkbox" name="choixJour" id="choixJour1" value="choixJour1" aria-required="true" onchange="toggleCheck(this) , toggleRadio(this)" />
          <label for="choixJour1">Pass pour la journée du 01/07</label>
        </div>
        <div> <input type="checkbox" name="choixJour" id="choixJour2" value="choixJour2" aria-required="true" onchange="toggleCheck(this) , toggleRadio(this)" />
          <label for="choixJour2">Pass pour la journée du 02/07</label>
        </div>
        <div> <input type="checkbox" name="choixJour" id="choixJour3" value="choixJour3" aria-required="true" onchange="toggleCheck(this) , toggleRadio(this)" />
          <label for="choixJour3">Pass pour la journée du 03/07</label>
        </div>
      </section>

      <input type="radio" name="choixPass" id="pass2jours" value="pass2jours" onclick="choixDate2jours()">
      <label for="pass2jours">Pass 2 jours : 70€</label>

      <!-- Si case cochée, afficher le choix des jours -->
      <section id="pass2joursDate">
        <div>
          <input type="checkbox" name="choixJour2" id="choixJour12" value="choixjour12" aria-required="true" onchange="toggleCheck(this) , toggleRadio(this)" />
          <label for="choixJour12">Pass pour deux journées du 01/07 au 02/07</label>
        </div>
        <div>
          <input type="checkbox" name="choixJour2" id="choixJour23" value="choixjour23" aria-required="true" onchange="toggleCheck(this) , toggleRadio(this)" />
          <label for="choixJour23">Pass pour deux journées du 02/07 au 03/07</label>
        </div>
      </section>

      <input type="radio" name="choixPass" id="pass3jours" value="pass3jours">
      <label for="pass3jours">Pass 3 jours : 100€</label>
    </div>

    <!-- tarifs réduits : à n'afficher que si tarif réduit est sélectionné -->
    <section class="tarifsReduits" id="tarifsReduits">
      <input type="radio" name="choixPassReduit" id="pass1jourreduit" value="pass1jourreduit" onclick="choixDate1jourReduit()">
      <label for="pass1jourreduit">Pass 1 jour : 25€</label>

      <section id="pass1jourDateReduit">
        <div>
          <input type="checkbox" name="choixJourReduit" id="choixJour1reduit" value="choixJour1reduit" aria-required="true" onchange="toggleCheck(this) , toggleRadio(this)" />
          <label for="choixJour1reduit">Pass pour la journée du 01/07</label>
        </div>
        <div>
          <input type="checkbox" name="choixJourReduit" id="choixJour2reduit" value="choixJour2reduit" aria-required="true" onchange="toggleCheck(this) , toggleRadio(this)" />
          <label for="choixJour2reduit">Pass pour la journée du 02/07</label>
        </div>
        <div>
          <input type="checkbox" name="choixJourReduit" id="choixJour3reduit" value="choixJour3reduit" aria-required="true" onchange="toggleCheck(this) , toggleRadio(this)" />
          <label for="choixJour3reduit">Pass pour la journée du 03/07</label>
        </div>
      </section>


      <input type="radio" name="choixPassReduit" id="pass2joursreduit" value="pass2joursreduit" onclick="choixDate2joursReduit()">
      <label for="pass2joursreduit">Pass 2 jours : 50€</label>

      <section id="pass2joursDateReduit">
        <div>
          <input type="checkbox" name="choixJour2Reduit" id="choixJour12reduit" value="choixJour12reduit" aria-required="true" onchange="toggleCheck(this) , toggleRadio(this)" />
          <label for="choixJour12reduit">Pass pour deux journées du 01/07 au 02/07</label>
        </div>
        <div>
          <input type="checkbox" name="choixJour2Reduit" id="choixJour23reduit" value="choixJour23reduit" aria-required="true" onchange="toggleCheck(this) , toggleRadio(this)" />
          <label for="choixJour23reduit">Pass pour deux journées du 02/07 au 03/07</label>
        </div>
      </section>

      <input type="radio" name="choixPassReduit" id="pass3joursreduit" value="pass3joursreduit">
      <label for="pass3joursreduit">Pass 3 jours : 65€</label>
    </section>

    <!-- FACULTATIF : ajouter un pass groupe (5 adultes : 150€ / jour) uniquement pass 1 jour -->
    <div>
      <p class="btn btn-info" id="btnSuivant1">Suivant</p>
      <div id="alertOption" class="bg-danger text-white"></div>

    </div>

  </fieldset>
  <fieldset id="options">
    <h3>Réserver un emplacement de tente : </h3>
    <input type="checkbox" id="tenteNuit1" name="tenteNuit1" class="tenteNuit" value="tenteNuit1" onchange="cocherTente3nuits()">
    <label for="tenteNuit1">Pour la nuit du 01/07 (5€)</label><br>
    <input type="checkbox" id="tenteNuit2" name="tenteNuit2" class="tenteNuit" value="tenteNuit2" onchange="cocherTente3nuits()">
    <label for="tenteNuit2">Pour la nuit du 02/07 (5€)</label><br>
    <input type="checkbox" id="tenteNuit3" name="tenteNuit3" class="tenteNuit" value="tenteNuit3" onchange="cocherTente3nuits()">
    <label for="tenteNuit3">Pour la nuit du 03/07 (5€)</label><br>
    <input type="checkbox" id="tente3Nuits" name="tente3Nuits" class="tenteNuit" value="tente3Nuits" onchange="cocherTente3nuits()">
    <label for="tente3Nuits">Pour les 3 nuits (12€)</label>

    <h3>Réserver un emplacement de camion aménagé : </h3>
    <input type="checkbox" id="vanNuit1" name="vanNuit1" class="vanNuit" value="vanNuit1" onchange="cocherVan3nuits()">
    <label for="vanNuit1">Pour la nuit du 01/07 (5€)</label><br>
    <input type="checkbox" id="vanNuit2" name="vanNuit2" class="vanNuit" value="vanNuit2" onchange="cocherVan3nuits()">
    <label for="vanNuit2">Pour la nuit du 02/07 (5€)</label><br>
    <input type="checkbox" id="vanNuit3" name="vanNuit3" class="vanNuit" value="vanNuit3" onchange="cocherVan3nuits()">
    <label for="vanNuit3">Pour la nuit du 03/07 (5€)</label><br>
    <input type="checkbox" id="van3Nuits" name="van3Nuits" class="vanNuit" value="van3Nuits" onchange="cocherVan3nuits()">
    <label for="van3Nuits">Pour les 3 nuits (12€)</label>

    <h3>Venez-vous avec des enfants ?</h3>
    <select name="enfants" id="venirAvecDesEnfants">
      <!-- <option name="enfants" value="Non" id="enfantsNon">Non</option>
      <option name="enfants" value="Oui" id="enfantsOui">Oui</option> -->
      <option name="enfants" value="Non" id="enfantsNon" onchange="afficherMasquerCasques()">Non</option>
      <option name="enfants" value="Oui" id="enfantsOui" onchange="afficherMasquerCasques()">Oui</option>
    </select>
    <!-- Si oui, afficher : -->
    <section id="casquesEnfants">
      <h4>Voulez-vous louer un casque antibruit pour enfants* (2€ / casque) ?</h4>
      <label for="nombreCasquesEnfants">Nombre de casques souhaités :</label>
      <input type="number" name="nombreCasquesEnfants" id="nombreCasquesEnfants" min="0" max="5">
      <div id="alertMessageEnfants" class="bg-danger text-white"></div>
      <p>*Dans la limite des stocks disponibles.</p>
    </section>

    <h3>Profitez de descentes en luge d'été à tarifs avantageux !</h3>
    <label for="NombreLugesEte">Nombre de descentes en luge d'été :</label>
    <input type="number" name="NombreLugesEte" id="NombreLugesEte" min="0" max="5">
    <div id="alertMessageEte" class="bg-danger text-white"></div>

    <div class="d-flex justify-content-between">
      <p class="btn btn-warning" id="btnPrecedent">Précédent</p>
      <p class="btn btn-info" id="btnSuivant2">Suivant</p>
    </div>

  </fieldset>

  <fieldset id="coordonnees">
    <legend>Coordonnées</legend>
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" required autocomplete="family-name">
    <label for="prenom">Prénom :</label>
    <input type="text" name="prenom" id="prenom" required autocomplete="given-name">
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required autocomplete="email">

    <label for="motDePasse">Mot de passe :</label>
    <input type="password" name="motDePasse" id="motDePasse" min="8" required>
    <label for="motDePasseVerifier">Verifier le mot de passe :</label>
    <input type="password" name="motDePasseVerifier" min="8" id="motDePasseVerifier">
    <span class="password-toggle fw-bold mb-3" id="togglePassword">Voir le MDP</span>


    <label for="telephone">Téléphone :</label>
    <input type="text" name="telephone" id="telephone" required autocomplete="tel">
    <label for="adresse">Adresse Postale :</label>
    <input type="text" name="adresse" id="adresse" required autocomplete="address-line1">
    <div class="d-flex flex-row align-items-baseline my-2">
      <input type="checkbox" class="me-2" name="RGPD" id="RGPD" enababled>
      <label for="RGPD">Veuillez accepter les RGPD </label>
    </div>
    <div class="d-flex justify-content-between">
      <!-- <p class="btn btn-warning" id="btnPrecedent2">Précédent</p> -->
      <input class="btn btn-warning" id="btnPrecedent2" value="Précédent">
      <input type="submit" name="soumission" class="btn btn-success" id="btnReserver" value="Réserver">
    </div>
  </fieldset>
</form>

<?php
include_once __DIR__ . '/Includes/footer.php';
?>