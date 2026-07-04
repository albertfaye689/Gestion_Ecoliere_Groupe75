<?php
// Inclusion de la connexion pour vérifier qu'elle n'engendre pas d'erreur
require_once 'config/connexion_bdd.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - UVS Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom { background-color: #198754; } /* Menu vert harmonisé */
        .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: white; }
        .hero-section { background: linear-gradient(135deg, #198754 0%, #146c43 100%); color: white; padding: 60px 0; border-radius: 15px; margin-top: 30px; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php">UVS Connect - IDA</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link text-white fw-bold" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="ajouter_eleve.php">Ajouter un Élève</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="eleves.php">Liste des Élèves</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container text-center">
        <div class="hero-section shadow-sm">
            <h1 class="display-4 fw-bold">Application de Gestion Scolaire</h1>
            <p class="lead">Plateforme centralisée de suivi des effectifs et de saisie des évaluations - Licence 3 IDA</p>
        </div>

        <div class="row mt-5 justify-content-center">
            <div class="col-md-5 mb-4">
                <div class="card h-100 shadow border-0 py-3">
                    <div class="card-body">
                        <h4 class="card-title fw-bold text-success mb-3">Inscriptions</h4>
                        <p class="card-text text-muted">Accéder au formulaire d'inscription pour enregistrer de nouveaux étudiants dans le système informatique.</p>
                        <a href="ajouter_eleve.php" class="btn btn-success px-4 py-2 mt-2 fw-semibold">Inscrire un élève</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5 mb-4">
                <div class="card h-100 shadow border-0 py-3">
                    <div class="card-body">
                        <h4 class="card-title fw-bold text-dark mb-3">Base de Données</h4>
                        <p class="card-text text-muted">Visualiser, modifier ou consulter l'effectif complet des élèves actuellement enregistrés dans l'établissement.</p>
                        <a href="eleves.php" class="btn btn-dark px-4 py-2 mt-2 fw-semibold">Voir la liste</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>