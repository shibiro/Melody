<ul id="profilmenu">

    <?php echo ' <li><a href='.$Router->BuildRoute('Profil','index',[]).'>Retour Profil</a></li>'; ?>

    <?php echo ' <li><a href='.$Router->BuildRoute('Profil','News',[]).'>Mes News</a></li>'; ?>

</ul>

<?php

if($number>0) {
    foreach ($comments as $comment) {
        ?>
        <fieldset>
            <legend>
                Posté par <strong><?= htmlspecialchars($comment['auteur']) ?></strong>
                le <?= $comment['date']->format('d/m/Y à H\hi') ?>

                <?php if ($user->isAuthenticated()) { ?> -
                    <a href="../admin/comment-update-<?= $comment['id'] ?>.html">Modifier</a> |
                    <a href="../admin/comment-delete-<?= $comment['id'] ?>.html">Supprimer</a>
                <?php } ?>

                sur cette <a href="../news-<?= $comment['news'] ?>.html">New</a>
            </legend>
            <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>
        </fieldset>
        <?php
    }
}
else
{
?>
    <h2>Vous n'avez pas écris de commentaire</h2>
    <p>Allez donc voir quelques news<td><a href="../"><img src="/images/update.png" alt="Accueil" /></a></p>
<?php
}?>
