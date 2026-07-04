<?php
require_once 'config/connexion_bdd.php';

$message = "";
$messageClass = "";

// 1. Charger les données actuelles de l'élève à modifier
if (isset($_GET['matricule']) && !empty($_GET['matricule'])) {
    $matricule = $_GET['matricule'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM eleve WHERE matricule = :matricule");
        $stmt->execute([':matricule' => $matricule]);
        $eleve = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$eleve) {
            die("Élève introuvable.");
        }
    } catch (PDOException $e) {
        die("Erreur de chargement : " . $e->getMessage());
    }
} else {
    header("Location: eleves.php");
    exit();
}

// 2. Traiter la validation du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom_nom = trim($_POST['prenom_nom']);
    $classe = trim($_POST['classe']);

    if (!empty($prenom_nom) && !empty($classe)) {
        try {
            $stmt = $pdo->prepare("UPDATE eleve SET prenom_nom = :prenom_nom, classe = :classe WHERE matricule = :matricule");
            $stmt->execute([
                ':prenom_nom' => $prenom_nom,
                ':classe' => $classe,
                ':matricule' => $matricule
            ]);
            
            // Redirection vers la liste avec un message de succès
            header("Location: eleves.php");
            exit();
        } catch (PDOException $e) {
            $message = "Erreur lors de la mise à jour : " . $e->getMessage();
            $messageClass = "alert-danger";
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
    <title>Modifier un Étudiant - UVS Connect</title>
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
                <li class="nav-item"><a class="nav-link" href="accueil.php"><i class="fa-solid fa-chart-pie me-2"></i> Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="saisir_note.php"><i class="fa-solid fa-pen-to-square me-2"></i> Notes</a></li>
                <li class="nav-item"><a class="nav-link" href="classes.php"><i class="fa-solid fa-graduation-cap me-2"></i> Classes</a></li>
                <li class="nav-item"><a class="nav-link active" href="eleves.php"><i class="fa-solid fa-user-graduate me-2"></i> Elèves</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fa-solid fa-user-tie me-2"></i> Professeurs</a></li>
            </ul>
        </div>

        <div class="main-content w-100">
            <h2 class="fw-bold text-secondary mb-1">MODIFIER L'ÉTUDIANT</h2>
            <p class="text-muted mb-4">Mettez à jour les informations de la fiche élève ci-dessous.</p>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $messageClass; ?>"><?php echo $message; ?></div>
            <?php endif; ?>

            <div class="card shadow-sm border-0 rounded-3 p-4 bg-white" style="max-width: 600px;">
                <form action="" method="POST">
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Matricule (Non modifiable)</label>
                        <input type="text" class="form-control bg-light fw-bold" value="<?php echo htmlspecialchars($eleve['matricule']); ?>" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="prenom_nom" class="form-label fw-semibold text-secondary">Prénom & Nom</label>
                        <input type="text" name="prenom_nom" id="prenom_nom" class="form-control" value="<?php echo htmlspecialchars($eleve['prenom_nom']); ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="classe" class="form-label fw-semibold text-secondary">Classe</label>
                        <select name="classe" id="classe" class="form-select" required>
                            <option value="L1 IDA" <?php if($eleve['classe'] == 'L1 IDA') echo 'selected'; ?>>L1 IDA</option>
                            <option value="L2 IDA" <?php if($eleve['classe'] == 'L2 IDA') echo 'selected'; ?>>L2 IDA</option>
                            <option value="L3 IDA" <?php if($eleve['classe'] == 'L3 IDA') echo 'selected'; ?>>L3 IDA</option>
                        </select>
                    </div>

                    <div class="d-flex gap-3">
                        <a href="eleves.php" class="btn btn-light border w-50 py-2fw-semibold">Annuler</a>
                        <button type="submit" class="btn btn-success w-50 py-2 fw-semibold">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>