<?php
require "./config/bd.cfg.php";

function mon_autoload($class) {
    if(file_exists('./classes/' . $class . '.cls.php')){
        include './classes/' . $class . '.cls.php';
    }else{
        exit("Classe '$class' n'est pas déclarée!!!");
    }
  }
   
  spl_autoload_register('mon_autoload');

$imageDuJour = new ImageDuJour();

$lesDonnees = $imageDuJour->unParDate(empty($_GET["jour"]) ? date("Y-m-d") : $_GET["jour"]);

if(property_exists($lesDonnees, 'img_id') == false){
    exit("non autorisé, svp utilisez l'interface graphique");
}

$comments = new Commentaire($lesDonnees->img_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image du jour</title>
    <link rel="shortcut icon" href="ressources/images/favicon.png" type="image/png">
    <link rel="stylesheet" href="ressources/css/idj.css">
    <style>
        html {
            background-image: url(ressources/photos/<?= $lesDonnees->img_fichier?>);
        }
    </style>
</head>
<body>
    <div class="etiquette aime">
        <img src="ressources/images/aime-actif.png" alt=""><?= $comments->obtenirNombreAime()?>
    </div>
    <aside>
        <form action="">
            <textarea name="commentaire" id="commentaire"></textarea>
        </form>
        <ul class="commentaires">

        <?php foreach ($comments->toutAvecVote() as $commentaire) { ?>
    
            <li style="opacity:<?= Utilitaire::tauxVotesPositifs($commentaire->vote_up, $commentaire->vote_down) ?>">
                <?= $commentaire->texte ?>
                <div class="vote">
                    <span class="up"><?= $commentaire->vote_up ?></span>
                    <span class="down"><?= $commentaire->vote_down ?></span>
                </div>
            </li>
        
        <?php } ?>

        </ul>
    </aside>
    
    <div class="info">
        <div class="date">
            <span class="premier <?= $imageDuJour->datePremiereImage() == $lesDonnees->img_jour ? 'inactif' : ''?>">
                <a title="Premier jour" <?= $imageDuJour->datePremiereImage() == $lesDonnees->img_jour ? '' : 'href="index.php?jour=' . $imageDuJour->datePremiereImage() . '"'?> >&#x2B70;</a>
            </span>
            <span class="prec <?= $lesDonnees->img_jour_precedent == null ? 'inactif' : ''?>">
                <a title="Jour précédent" <?= $lesDonnees->img_jour_precedent == null ? '' : 'href="index.php?jour='.$lesDonnees->img_jour_precedent .'"'?>>&#x2B60;</a>
            </span>
            <span class="suiv <?= $lesDonnees->img_jour_suivant == null ? 'inactif' : ''?>">
                <a title="Jour suivant" <?= $lesDonnees->img_jour_suivant == null ? '' : 'href="index.php?jour='.$lesDonnees->img_jour_suivant .'"'?>>&#x2B62;</a>
            </span>
            <span class="dernier <?= $lesDonnees->img_aujourdhui == $lesDonnees->img_jour ? 'inactif' : ''?>">
                <a title="Aujourd'hui" <?= $lesDonnees->img_aujourdhui == $lesDonnees->img_jour ? '' : 'href="index.php?jour='.$lesDonnees->img_aujourdhui .'"'?>>&#x2B72;</a>
            </span>
            <i><?= Utilitaire::dateFormatee($lesDonnees->img_jour); ?></i>
        </div>
        <?php if($lesDonnees->img_description){?>
        <div class="etiquette etiquette-etendue description"><?= $lesDonnees->img_description?></div>
        <?php } ?>
    </div>
</body>
</html>