<?php
require_once 'config/connexion_bdd.php';

try {
    // 1. Compter les élèves
    $stmt_eleves = $pdo->query("SELECT COUNT(*) FROM eleve");
    $total_eleves = $stmt_eleves->fetchColumn();

    // 2. Compter les classes uniques
    $stmt_classes = $pdo->query("SELECT COUNT(DISTINCT classe) FROM eleve");
    $total_classes = $stmt_classes->fetchColumn();

    // 3. Compter les notes saisies
    $stmt_notes = $pdo->query("SELECT COUNT(*) FROM note");
    $total_notes = $stmt_notes->fetchColumn();

    // 4. Calculer la moyenne générale
    $stmt_moyenne = $pdo->query("SELECT AVG(note_valeur) FROM note");
    $moyenne_generale = $stmt_moyenne->fetchColumn();
    $moyenne_generale = $moyenne_generale ? round($moyenne_generale, 2) : "N/A";

} catch (PDOException $e) {
    die("Erreur de statistiques : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - UVS Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { height: 100vh; background-color: #f8f9fa; border-right: 1px solid #dee2e6; position: fixed; width: 250px; }
        .sidebar .nav-link { color: #333; padding: 12px 20px; font-weight: 500; }
        .sidebar .nav-link:hover { background-color: #e9ecef; }
        .sidebar .nav-link.active { background-color: #198754; color: white; }
        .main-content { margin-left: 250px; padding: 40px; }
        .card-stat { border: none; border-radius: 15px; color: white; }
    </style>
</head>
<body class="bg-light">

    <div class="d-flex">
        <div class="sidebar p-3">
            <h4 class="text-center fw-bold my-3 text-uppercase text-success">Gestion Scolaire</h4>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link active" href="accueil.php"><i class="fa-solid fa-chart-pie me-2"></i> Tableau de bord</a></li>
                <li class="nav-item"><a class="nav-link" href="saisir_note.php"><i class="fa-solid fa-pen-to-square me-2"></i> Notes</a></li>
                <li class="nav-item"><a class="nav-link" href="classes.php"><i class="fa-solid fa-graduation-cap me-2"></i> Classes</a></li>
                <li class="nav-item"><a class="nav-link" href="eleves.php"><i class="fa-solid fa-user-graduate me-2"></i> Elèves</a></li>
                <li class="nav-item"><a class="nav-link" href="professeurs.php"><i class="fa-solid fa-user-tie me-2"></i> Professeurs</a></li>
            </ul>
        </div>

        <div class="main-content w-100">
            <h2 class="fw-bold text-secondary mb-1">TABLEAU DE BORD</h2>
            <p class="text-muted mb-4">Vue d'ensemble de l'établissement en temps réel.</p>

            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card card-stat bg-success p-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-white-50">Élèves inscrits</h6>
                                <h2 class="fw-bold mb-0"><?php echo $total_eleves; ?></h2>
                            </div>
                            <i class="fa-solid fa-user-graduate fa-2xl text-white-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-stat bg-primary p-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-white-50">Classes actives</h6>
                                <h2 class="fw-bold mb-0"><?php echo $total_classes; ?></h2>
                            </div>
                            <i class="fa-solid fa-graduation-cap fa-2xl text-white-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-stat bg-warning p-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-white-50">Notes saisies</h6>
                                <h2 class="fw-bold mb-0"><?php echo $total_notes; ?></h2>
                            </div>
                            <i class="fa-solid fa-pen-to-square fa-2xl text-white-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card card-stat bg-danger p-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-white-50">Moyenne Générale</h6>
                                <h2 class="fw-bold mb-0"><?php echo $moyenne_generale; ?>/20</h2>
                            </div>
                            <i class="fa-solid fa-chart-line fa-2xl text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm p-4 rounded-3 mt-2 bg-white">
                <h5 class="fw-bold text-dark mb-3">Actions rapides</h5>
                <div class="d-flex gap-3">
                    <a href="ajouter_eleve.php" class="btn btn-outline-success px-4 py-2 fw-semibold"><i class="fa-solid fa-plus me-2"></i>Inscrire un élève</a>
                    <a href="saisir_note.php" class="btn btn-outline-primary px-4 py-2 fw-semibold"><i class="fa-solid fa-marker me-2"></i>Saisir une note</a>
                </div>
            </div>

        </div>
    </div>

</body>
</html>