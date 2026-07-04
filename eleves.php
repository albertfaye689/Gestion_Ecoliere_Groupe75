<?php
require_once 'config/connexion_bdd.php';

try {
    $stmt = $pdo->query("SELECT * FROM eleve ORDER BY prenom_nom ASC");
    $eleves = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Élèves - UVS Connect</title>
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
                <li class="nav-item"><a class="nav-link" href="classes.php"><i class="fa-solid fa-graduation-cap me-2"></i> Classes</a></li>
                <li class="nav-item"><a class="nav-link active" href="eleves.php"><i class="fa-solid fa-user-graduate me-2"></i> Elèves</a></li>
                <li class="nav-item"><a class="nav-link" href="professeurs.php"><i class="fa-solid fa-user-tie me-2"></i> Professeurs</a></li>
            </ul>
        </div>

        <div class="main-content w-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-secondary mb-1">BASE DE DONNÉES ÉLÈVES</h2>
                    <p class="text-muted mb-0">Consultez, modifiez ou supprimez les étudiants enregistrés.</p>
                </div>
                <a href="ajouter_eleve.php" class="btn btn-success"><i class="fa-solid fa-plus me-2"></i>Inscrire un élève</a>
            </div>

            <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    L'étudiant a été supprimé avec succès.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0 rounded-3 mt-3 bg-white">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-center">
                            <thead class="table-success text-uppercase fs-7">
                                <tr>
                                    <th class="py-3">Matricule</th>
                                    <th class="py-3">Prénom & Nom</th>
                                    <th class="py-3">Classe</th>
                                    <th class="py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($eleves)): ?>
                                    <tr>
                                        <td colspan="4" class="text-muted py-4">Aucun élève trouvé dans la base de données.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($eleves as $eleve): ?>
                                        <tr>
                                            <td class="fw-bold text-secondary py-3"><?php echo htmlspecialchars($eleve['matricule']); ?></td>
                                            <td class="text-dark fw-semibold"><?php echo htmlspecialchars($eleve['prenom_nom']); ?></td>
                                            <td><span class="badge bg-light text-success border border-success px-3 py-2 rounded-pill"><?php echo htmlspecialchars($eleve['classe']); ?></span></td>
                                            <td>
                                                <a href="modifier_eleve.php?matricule=<?php echo urlencode($eleve['matricule']); ?>" class="btn btn-sm btn-outline-warning me-1" title="Modifier">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <a href="supprimer_eleve.php?matricule=<?php echo urlencode($eleve['matricule']); ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   title="Supprimer"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?');">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>