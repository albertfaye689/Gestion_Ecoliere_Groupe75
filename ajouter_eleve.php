<?php
// On inclut le fichier de connexion situé dans le dossier config
require_once 'config/connexion_bdd.php';

$message = "";
$messageClass = "";

// Traitement du formulaire lors de la soumission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricule = trim($_POST['matricule']);
    $prenom_nom = trim($_POST['prenom_nom']);
    $classe = trim($_POST['classe']);

    if (!empty($matricule) && !empty($prenom_nom) && !empty($classe)) {
        try {
            // Requête préparée (PDO) pour empêcher les injections SQL comme prévu au rapport
            $stmt = $pdo->prepare("INSERT INTO eleve (matricule, prenom_nom, classe) VALUES (:matricule, :prenom_nom, :classe)");
            $stmt->execute([
                ':matricule' => $matricule,
                ':prenom_nom' => $prenom_nom,
                ':classe' => $classe
            ]);
            $message = "Élève enregistré avec succès !";
            $messageClass = "alert-success";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Code d'erreur pour clé primaire en double
                $message = "Erreur : Ce matricule existe déjà.";
                $messageClass = "alert-danger";
            } else {
                $message = "Une erreur est survenue lors de l'enregistrement.";
                $messageClass = "alert-danger";
            }
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
        $messageClass = "alert-warning";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Élève - UVS Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom { background-color: #198754; } /* Le menu vert harmonisé UNCHK */
        .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: white; }
        .card-custom { max-width: 500px; margin: 50px auto; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">UVS Connect - IDA</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-link"><a class="nav-link text-white" href="index.php">Accueil</a></li>
                    <li class="nav-link"><a class="nav-link text-white fw-bold" href="ajouter_eleve.php">Ajouter un Élève</a></li>
                    <li class="nav-link"><a class="nav-link text-white" href="eleves.php">Liste des Élèves</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card card-custom shadow border-0">
            <div class="card-header text-center navbar-custom text-white py-3">
                <h4 class="mb-0">Formulaire d'Inscription</h4>
            </div>
            <div class="card-body p-4 bg-white">
                
                <?php if (!empty($message)): ?>
                    <div class="alert <?php echo $messageClass; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="ajouter_eleve.php" method="POST">
                    <div class="mb-3">
                        <label for="matricule" class="form-label fw-semibold">Matricule de l'élève</label>
                        <input type="text" name="matricule" id="matricule" class="form-control" placeholder="Ex: MAT-1234" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom_nom" class="form-label fw-semibold">Prénom & Nom</label>
                        <input type="text" name="prenom_nom" id="prenom_nom" class="form-control" placeholder="Ex: Souleymane FAYE" required>
                    </div>
                    <div class="mb-3">
                        <label for="classe" class="form-label fw-semibold">Classe</label>
                        <select name="classe" id="classe" class="form-select" required>
                            <option value="">Sélectionnez la classe</option>
                            <option value="L1 IDA">Licence 1 IDA</option>
                            <option value="L2 IDA">Licence 2 IDA</option>
                            <option value="L3 IDA">Licence 3 IDA</option>
                        </select>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success py-2 fw-bold">Enregistrer l'élève</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>