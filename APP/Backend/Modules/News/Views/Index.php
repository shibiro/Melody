<p style="text-align: center">Il y a actuellement <?= $nombreNews ?> news. En voici la liste :</p>
 
<table>
  <tr>
    <th>Auteur</th>
    <th>Titre</th>
    <th>Date d'ajout</th>
    <th>Dernière modification</th>
    <th>Action</th>
  </tr>

<?php
foreach ($listeNews as $news)
{
  $vars=array();
  $vars['id']=$news['id'];
  echo '<tr>
            <td>', $news['auteur'], '</td>
            <td>', $news['titre'], '</td>
            <td>le ', $news['dateAjout']->format('d/m/Y à H\hi'), '</td>
            <td>', ($news['dateAjout'] == $news['dateModif'] ? '-' : 'le '.$news['dateModif']->format('d/m/Y à H\hi')), '</td>
            <td>
                <a href='.$Router->BuildRoute('News','update',$vars).' >
                  <img src="/images/update.png" alt="Modifier" /></a>
                <a href='.$Router->BuildRoute('News','delete',$vars).'>
                  <img src="/images/delete.png" alt="Supprimer" /></a>
              </td>
          </tr>',
        "\n";
}
?>
</table>