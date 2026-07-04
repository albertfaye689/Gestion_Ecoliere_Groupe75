<?php
require_once 'config/connexion_bdd.php';

$message = "";
$messageClass = "";

try {
    $stmt_eleves = $pdo->query("SELECT matricule, prenom_nom FROM eleve ORDER BY prenom_nom ASC");
    $eleves = $stmt_eleves->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors du chargement des élèves : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricule = trim($_POST['matricule_eleve']);
    $matiere = trim($_POST['matiere']);
    $note_valeur = trim($_POST['note_valeur']);

    if (!empty($matricule) && !empty($matiere) && $note_valeur !== "") {
        if ($note_valeur >= 0 && $note_valeur <= 20) {
            try {
                $stmt = $pdo->prepare("INSERT INTO note (matiere, note_valeur, matricule_eleve) VALUES (:matiere, :note_valeur, :matricule_eleve)");
                $stmt->execute([
                    ':matiere' => $matiere,
                    ':note_valeur' => $note_valeur,
                    ':matricule_eleve' => $matricule
                ]);
                $message = "Note enregistrée avec succès !";
                $messageClass = "alert-success";
            } catch (PDOException $e) {
                $message = "Erreur lors de l'enregistrement de la note.";
                $messageClass = "alert-danger";
            }
        } else {
            $message = "La note doit être comprise entre 0 et 20.";
            $messageClass = "alert-warning";
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
    <title>Saisir les Notes - UVS Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { height: 100vh; background-color: #f8f9fa; border-right: 1px solid #dee2e6; position: fixed; width: 250px; }
        .sidebar .nav-link { color: #333; padding: 12px 20px; font-weight: 500; }
        .sidebar .nav-link:hover { background-color: #e9ecef; }
        .sidebar .nav-link.active { background-color: #198754; color: white; }
        .main-content { margin-left: 250px; padding: 40px; }
        .card-custom { max-width: 550px; }
    </style>
</head>
<body class="bg-light">

    <div class="d-flex">
        <div class="sidebar p-3">
            <h4 class="text-center fw-bold my-3 text-uppercase text-success">Gestion Scolaire</h4>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="accueil.php"><i class="fa-solid fa-chart-pie me-2"></i> Tableau de bord</a></li>
                <li class="nav-item"><a class="nav-link active" href="saisir_note.php"><i class="fa-solid fa-pen-to-square me-2"></i> Notes</a></li>
                <li class="nav-item"><a class="nav-link" href="classes.php"><i class="fa-solid fa-graduation-cap me-2"></i> Classes</a></li>
                <li class="nav-item"><a class="nav-link" href="eleves.php"><i class="fa-solid fa-user-graduate me-2"></i> Elèves</a></li>
                <li class="nav-item"><a class="nav-link" href="professeurs.php"><i class="fa-solid fa-user-tie me-2"></i> Professeurs</a></li>
            </ul>
        </div>

        <div class="main-content w-100">
            <h2 class="fw-bold text-secondary mb-1">SAISIE DES EVALUATIONS</h2>
            <p class="text-muted mb-4">Attribuez une note d'examen ou de devoir à un étudiant.</p>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $messageClass; ?> alert-dismissible fade show card-custom" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card card-custom shadow-sm border-0 rounded-3 p-4 bg-white">
                <form action="saisir_note.php" method="POST">
                    <div class="mb-3">
                        <label for="matricule_eleve" class="form-label fw-semibold text-secondary">Sélectionner l'élève</label>
                        <select name="matricule_eleve" id="matricule_eleve" class="form-select" required>
                            <option value="">-- Choisir un étudiant --</option>
                            <?php foreach ($eleves as $eleve): ?>
                                <option value="<?php echo htmlspecialchars($eleve['matricule']); ?>">
                                    <?php echo htmlspecialchars($eleve['prenom_nom'] . ' (' . $eleve['matricule'] . ')'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="matiere" class="form-label fw-semibold text-secondary">Matière</label>
                        <select name="matiere" id="matiere" class="form-select" required>
                            <option value="">-- Choisir la matière --</option>
                            <option value="Développement Web PHP">Développement Web PHP</option>
                            <option value="Bases de Données Relationnelles">Bases de Données Relationnelles</option>
                            <option value="Génie Logiciel (UML)">Génie Logiciel (UML)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="note_valeur" class="form-label fw-semibold text-secondary">Note (sur 20)</label>
                        <input type="number" step="0.01" min="0" max="20" name="note_valeur" id="note_valeur" class="form-control" placeholder="Ex: 15.5" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Enregistrer la Note</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>