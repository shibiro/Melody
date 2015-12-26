
<ul id="profilmenu">


    <li> <?php
        $vars= array();
        $vars['id']=$id;
        echo '<a href='.$Router->BuildRoute('Membre','index',$vars).'>'?>Retour à son Profil</a></li>

    <?php if($auteur!=false)
    {?><li> <?php echo '<a href='.$Router->BuildRoute('Membre','News',$vars).'>'?>Ses News</a></li>
    <?php }?>
</ul>

<?php

if($number>0) {
    foreach ($comments as $comment) {
        ?>
        <fieldset>
            <legend>
                Posté par <strong><?= htmlspecialchars($comment['auteur']) ?></strong>
                le <?= $comment['date']->format('d/m/Y à H\hi') ?>

                <?php if ($user->isAuthenticated()) { ?>
                    <a href="../admin/comment-update-<?= $comment['id'] ?>.html">Modifier</a>
                    <a href="../admin/comment-delete-<?= $comment['id'] ?>.html">Supprimer</a>
                <?php } ?>

                sur cette <?php
                            $vars= array();
                            $vars['id']=$comment['news'];
                            echo '<a href='.$Router->BuildRoute('News','show',$vars).'>'?>New</a>
            </legend>
            <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p>
        </fieldset>
        <?php
    }
}
else
{
?>
    <h2>Il n'a pas écris de commentaire</h2>
    <p>Allez donc voir quelques news<?php echo '<a href='.$Router->BuildRoute('News','index',[]).'>'?><img src="/images/update.png" alt="Accueil" /></a></p>
<?php
}?>
