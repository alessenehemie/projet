<?php
// 1. Fonction pour nettoyer les entrées utilisateur
function nettoyer($valeur) {
    return htmlspecialchars(trim($valeur), ENT_QUOTES, 'UTF-8');
}

// 2. Fonction pour valider les champs du contact
function valider_contact($nom, $email, $telephone) {
    $erreurs = [];

    // Le nom doit faire au moins 2 caractères
    if (strlen($nom) < 2) {
        $erreurs[] = "Le nom doit contenir au moins 2 caractères.";
    }

    // L'email doit être valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email n'est pas valide.";
    }

    // Le téléphone doit contenir uniquement des chiffres et exactement 10 caractères
    if (!ctype_digit($telephone) || strlen($telephone) !== 10) {
        $erreurs[] = "Le téléphone doit contenir exactement 10 chiffres.";
    }

    // TRÈS IMPORTANT : Le return doit être ICI, à l'intérieur de la fonction
    return $erreurs;
}

// 3. Fonction pour compter le nombre de contacts
function compter_contacts($contacts) {
    return count($contacts);
}
?>