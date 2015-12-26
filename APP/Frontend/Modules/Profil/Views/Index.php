<fieldset>
    <legend>
        <strong><?Php echo 'Profil de '.htmlspecialchars($member->username()) ?></strong>
        <?php echo' niveau de priorité : '.htmlspecialchars($member->priority())?>



    </legend>
    <p>Adresse mail : <?php echo htmlspecialchars($member->mail()) ?></p>
    <p>Description : <?php echo htmlspecialchars($member->description()) ?></p>
    <p>Mot de passe : <?php echo htmlspecialchars($member->password()) ?></p>

</fieldset>

<ul id="profilmenu">

    <?php echo ' <li><a href='.$Router->BuildRoute('Profil','News',[]).'>Mes News</a></li>'; ?>

    <?php echo ' <li><a href='.$Router->BuildRoute('Profil','Comments',[]).'>Mes Commentaires</a></li>'; ?>

</ul>
