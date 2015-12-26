
<ul id="profilmenu">


    <?php echo ' <li><a href='.$Router->BuildRoute('Profil','index',[]).'>Retour Profil</a></li>'; ?>
    <?php echo ' <li><a href='.$Router->BuildRoute('Profil','Comments',[]).'>Mes Commentaires</a></li>'; ?>

</ul>

<?php
if($number>0)
{
    foreach ($listeNews as $news) {
        ?>
         <?php echo ' <h2><a href='.$this->app->router()->BuildRoute('News','show',[$news['id']]).'>'.$news['titre'].'</a></h2>'; ?>

        <p><?= nl2br($news['contenu']) ?></p>
        <?php if ($this->app->user()->getAttribute('user') == $news['auteur']) {
            echo '<td><a href='.$this->app->router()->BuildRoute('News','update',[$news['id']]).'><img src="/images/update.png" alt="Modifier" /></a>
    <a href='.$this->app->router()->BuildRoute('News','delete',[$news['id']]).'><img src="/images/delete.png" alt="Supprimer" /></a></td>';
        } ?>
        <?php
    }
}
else
{?>
    <h2>Vous n'avez pas écris de news</h2>
    .$this->app->router()->BuildRoute('News','delete',[$news['id']]).

    <p>Allez en écrire une ici <?php echo '<a href='.$this->app->router()->BuildRoute('News','insert',[]).'>'?><img src="/images/update.png" alt="Écrire" /></a></p>

<?php
}?>
