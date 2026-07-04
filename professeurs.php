<?php
require_once 'config/connexion_bdd.php';

// Liste des professeurs pour enrichir ton application de Licence 3
$professeurs = [
    ['nom' => 'M. Drame', 'matiere' => 'Développement PHP / MySQL', 'statut' => 'Permanent'],
    ['nom' => 'Mme Diop', 'matiere' => 'Algorithmique & Structures de Données', 'statut' => 'Permanente'],
    ['nom' => 'M. Ndiaye', 'matiere' => 'Réseaux et Systèmes informatiques', 'statut' => 'Vacataire'],
    ['nom' => 'M. Cissé', 'matiere' => 'Gestion de Projet Méthode Agile', 'statut' => 'Vacataire']
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enseignants - UVS Connect</title>
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
                <li class="nav-item"><a class="nav-link" href="eleves.php"><i class="fa-solid fa-user-graduate me-2"></i> Elèves</a></li>
                <li class="nav-item"><a class="nav-link active" href="professeurs.php"><i class="fa-solid fa-user-tie me-2"></i> Professeurs</a></li>
            </ul>
        </div>

        <div class="main-content w-100">
            <h2 class="fw-bold text-secondary mb-1">CORPS ENSEIGNANT</h2>
            <p class="text-muted mb-4">Liste des professeurs affectés à la filière Informatique.</p>

            <div class="card shadow-sm border-0 rounded-3 bg-white">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-success text-uppercase fs-7">
                            <tr>
                                <th class="py-3">Prénom & Nom</th>
                                <th class="py-3">Matière Enseignée</th>
                                <th class="py-3">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($professeurs as $prof): ?>
                                <tr>
                                    <td class="fw-bold text-dark py-3"><?php echo $prof['nom']; ?></td>
                                    <td class="text-secondary fw-semibold"><?php echo $prof['matiere']; ?></td>
                                    <td>
                                        <span class="badge <?php echo $prof['statut'] == 'Permanent' || $prof['statut'] == 'Permanente' ? 'bg-success' : 'bg-warning text-dark'; ?> px-3 py-2 rounded-pill">
                                            <?php echo $prof['statut']; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>