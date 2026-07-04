<?php
require_once 'config/connexion_bdd.php';

// Vérifier si le matricule est bien passé dans l'URL
if (isset($_GET['matricule']) && !empty($_GET['matricule'])) {
    $matricule = $_GET['matricule'];

    try {
        // Préparer la requête de suppression
        $stmt = $pdo->prepare("DELETE FROM eleve WHERE matricule = :matricule");
        $stmt->execute([':matricule' => $matricule]);

        // Rediriger vers la liste avec un message de succès
        header("Location: eleves.php?status=deleted");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la suppression de l'élève : " . $e->getMessage());
    }
} else {
    // Si pas de matricule, retour direct à la liste
    header("Location: eleves.php");
    exit();
}
?>