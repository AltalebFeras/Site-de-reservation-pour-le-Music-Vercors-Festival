<?php

namespace src\Controllers;
// session_start(); 
use src\Services\Reponse;

use src\Repositories\UtilisateurRepositories;


use src\Models\Utilisateur; // Assuming Utilisateur is an entity you've defined


class UtilisateurController
{
    use Reponse;

    public function x()
    {
        if (
            empty($_POST) ||
            !isset($_POST['nom']) ||
            !isset($_POST['prenom']) ||
            !isset($_POST['email']) ||
            !isset($_POST['motDePasse']) ||
            !isset($_POST['motDePasseVerifier']) ||
            !isset($_POST['telephone']) ||
            ! isset($_POST['adresse']) ||
            !isset($_POST['RGPD'])
        ) {
            echo "form submitted";
        }

        // Sanitize form inputs
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $motDePasse = $_POST['motDePasse'];
        $motDePasseVerifier = $_POST['motDePasseVerifier'];
        $telephone = htmlspecialchars($_POST['telephone']);
        $adresse = htmlspecialchars($_POST['adresse']);
        $RGPD = $_POST['RGPD']; // Assuming RGPD is coming from the form

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = "Invalid email format. Please enter a valid email.";
            header('Location: ./../index.php');
            exit;
        }

        // Verify motDePasse confirmation
        if ($motDePasse !== $motDePasseVerifier) {
            $_SESSION['error_message'] = "motDePasses do not match. Please try again.";
            header('Location: ./../index.php');
            exit;
        }

        // Check if email already exists
        $utilisateurRepositories = new UtilisateurRepositories();
        $existingUtilisateur = $utilisateurRepositories->findByEmail($email);
        if ($existingUtilisateur) {
            $_SESSION['error_message'] = "Email already exists.";
            header('Location: ./index.php');
            exit;
        }

        $hashedmotDePasse = password_hash($motDePasse, PASSWORD_DEFAULT);

        // Create new user instance
        $data = array(
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'motDePasse' => $hashedmotDePasse,
            'telephone' => $telephone,
            'adresse' => $adresse,
            'RGPD' => $RGPD,
            'role' => "user"
        );

        $newUtilisateur = new Utilisateur($data);

        // Save user to the database
        $utilisateurRepositories->createUtilisateur($newUtilisateur);

        // Set success message and redirect to sign-in page
        $_SESSION['success_message'] = "Your inscription has been validated!";
        exit;
    }
}
