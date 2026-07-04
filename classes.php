<?php
require_once 'config/connexion_bdd.php';

// Récupérer le nombre d'élèves par classe
try {
    $stmt = $pdo->query("SELECT classe, COUNT(*) as total_eleves FROM eleve GROUP BY classe ORDER BY classe ASC");
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors du chargement des classes : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Classes - UVS Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { height: 100vh; background-color: #f8f9fa; border-right: 1px solid #dee2e6; position: fixed; width: 250px; }
        .sidebar .nav-link { color: #333; padding: 12px 20px; font-weight: 500; }
        .sidebar .nav-link:hover { background-color: #e9ecef; }
        .sidebar .nav-link.active { background-color: #198754; color: white; }
        .main-content { margin-left: 250px; padding: 40px; }
    </style>
</head>
<body class="bg-light">

    <div class="d-flex">
        <div class="sidebar p-3">
            <h4 class="text-center fw-bold my-3 text-uppercase text-success">Gestion Scolaire</h4>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="accueil.php"><i class="fa-solid fa-chart-pie me-2"></i> Tableau de bord</a></li>
                <li class="nav-item"><a class="nav-link" href="saisir_note.php"><i class="fa-solid fa-pen-to-square me-2"></i> Notes</a></li>
                <li class="nav-item"><a class="nav-link active" href="classes.php"><i class="fa-solid fa-graduation-cap me-2"></i> Classes</a></li>
                <li class="nav-item"><a class="nav-link" href="eleves.php"><i class="fa-solid fa-user-graduate me-2"></i> Elèves</a></li>
                <li class="nav-item"><a class="nav-link" href="professeurs.php"><i class="fa-solid fa-user-tie me-2"></i> Professeurs</a></li>
            </ul>
        </div>

        <div class="main-content w-100">
            <h2 class="fw-bold mb-4 text-secondary">LISTE DES CLASSES</h2>
            <p class="text-muted">Aperçu des effectifs par section et filière informatique.</p>

            <div class="row mt-4">
                <?php if (empty($classes)): ?>
                    <div class="col-12">
                        <div class="alert alert-info">Aucune classe enregistrée pour le moment.</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($classes as $c): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-0 border-start border-success border-4 bg-white">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($c['classe']); ?></h4>
                                            <p class="text-muted mb-0">Filière Informatique</p>
                                        </div>
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3">
                                            <i class="fa-solid fa-users fa-xl"></i>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-secondary fw-semibold">Effectif :</span>
                                        <span class="badge bg-success fs-6 px-3 py-2 rounded-pill"><?php echo $c['total_eleves']; ?> étudiant(s)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>