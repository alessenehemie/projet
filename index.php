<?php
session_start();
require 'fonctions.php';

if (!isset($_SESSION['contacts'])) {
    $_SESSION['contacts'] = [];
}
$erreurs = [];
if (isset($_GET['supprimer'])) {
    $indexASupprimer = (int) $_GET['supprimer'];
    
    
    if (isset($_SESSION['contacts'][$indexASupprimer])) {
        unset($_SESSION['contacts'][$indexASupprimer]);
        
        
        $_SESSION['contacts'] = array_values($_SESSION['contacts']);
        
       
        header('Location: index.php');
        exit;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = nettoyer($_POST['nom'] ?? '');
    $email = nettoyer($_POST['email'] ?? '');
    $telephone = nettoyer($_POST['telephone'] ?? '');

    $erreurs = valider_contact($nom, $email, $telephone);

    if (empty($erreurs)) {
        $nouveauContact = [
            'nom' => $nom,
            'email' => $email,
            'telephone' => $telephone
        ];
        
        $_SESSION['contacts'][] = $nouveauContact;

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon carnet de contacts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Mon carnet de contacts</h1>

        <?php if (!empty($erreurs)): ?>
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?php echo $erreur; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post">
            <label>Nom : 
                <input type="text" name="nom" placeholder="Ex: Jean Dupont" required>
            </label>
            <label>Email : 
                <input type="text" name="email" placeholder="Ex: jean@example.com" required>
            </label>
            <label>Téléphone : 
                <input type="text" name="telephone" placeholder="Ex: 0612345678" required>
            </label>
            <button type="submit">Ajouter le contact</button>
        </form>

        <h2>Liste des contacts</h2>
        
        <p><strong>Total : <?php echo compter_contacts($_SESSION['contacts']); ?> contact(s)</strong></p>

        <table>
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($_SESSION['contacts'])): ?>
                    <?php foreach ($_SESSION['contacts'] as $index => $contact): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $contact['nom']; ?></td>
                            <td><?php echo $contact['email']; ?></td>
                            <td><?php echo $contact['telephone']; ?></td>
                            <td>
                                
                                <a href="index.php?supprimer=<?php echo $index; ?>" class="btn-supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce contact ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Aucun contact pour le moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>