<?php

namespace src\Controllers;

use src\Models\Database;
use src\Services\Reponse;

use src\Repositories\UtilisateurRepositories;
use src\Models\Utilisateur;

class UtilisateurController
{
    use Reponse;
    private $DB;

    public function __construct()
    {
        $database = new Database;
        $this->DB = $database->getDB();

        require_once __DIR__ . '/../../config.php';
    }


    public function traitmentUtilisateur()
    {
        if (
            empty($_POST) ||
            !isset($_POST['nom']) ||
            !isset($_POST['prenom']) ||
            !isset($_POST['email']) ||
            !isset($_POST['motDePasse']) ||
            !isset($_POST['motDePasseVerifier']) ||
            !isset($_POST['telephone']) ||
            !isset($_POST['adresse']) ||
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
        $RGPD = $_POST['RGPD'];

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
        $RGPDdate = new \DateTime();
        // Create new user instance
        $data = array(

            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'motDePasse' => $hashedmotDePasse,
            'telephone' => $telephone,
            'adresse' => $adresse,
            'RGPD' => $RGPDdate,
            'role' => "user"
        );

        $newUtilisateur = new Utilisateur($data);

        // Save user to the database
        $utilisateurRepositories->createUtilisateur($newUtilisateur);

        // Set success message and redirect to sign-in page
        $_SESSION['success_message'] = "Votre inscription est validée!";
        $_SESSION['utilisateur'] = $this->DB->lastInsertId();


        $this->render("connexion", ["erreur" => ""]);
        exit;
    }

    public function connexionUtilisateur()
    {

        if (
            isset($_POST['email']) &&
            isset($_POST['motDePasse']) &&
            !empty($_POST['email']) &&
            !empty($_POST['motDePasse'])
        ) {
            $email = $_POST['email'];
            $motDePasse = $_POST['motDePasse'];

            $db = new Database();
            $conn = $db->getDB();


            $request = "SELECT * FROM utilisateur WHERE email = :email";
            $stmt = $conn->prepare($request);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // echo "hi";
            // var_dump($_SESSION['utilisateur']);
            // var_dump(  $row['utilisateurID']);
            // echo "hi";
            // die;

            // Check if user exists
           // Check if user exists
if ($row) {
    // Fetch the first row
    $utilisateurData = $row[0];

    // Verify password
    if (password_verify($motDePasse, $utilisateurData['motDePasse'])) {
        // Password is correct, start session and redirect to treatment script
        $_SESSION['utilisateur'] = $utilisateurData['utilisateurID'];
        $_SESSION['connecté'] = true;
        header('location: ' . HOME_URL . 'dashboard');
        exit;
    } else {
        $_SESSION['error_message1'] = "Invalid email or password. Please try again.";
        header('location: ' . HOME_URL . 'connexion');
        exit;
    }
} else {
    $_SESSION['error_message1'] = "User not found. Please try again.";
    header('location: ' . HOME_URL . 'connexion');
    exit;
}
        }
    }


    public function showDashboard(){
        if (isset($_SESSION["connecté"])) {
            echo "hifromshow";
            $this->render("dashboard", ["erreur" => ""]);


        }


    }
    
}
