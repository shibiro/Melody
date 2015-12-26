<?php
foreach ($listeNews as $news)
{
$vars= array();
  $vars['id']=$news['id'];
  echo'<h2><a href='.$Router->BuildRoute('News','show',$vars).'>'.$news['titre'].'</a></h2>';
?>
  <p><?= nl2br($news['contenu']) ?></p>
  <?php
   if($this->app->user()->getAttribute('user')==$news['auteur'])
    {
      echo'<td><a href='.$Router->BuildRoute('News','update',$vars).'><img src="/images/update.png" alt="Modifier" /></a>
        <a href='.$Router->BuildRoute('News','delete',$vars).'><img src="/images/delete.png" alt="Supprimer" /></a></td>';
    }
?>
  <fieldset>
    <legend>
      <strong>TAG</strong>
    </legend>

    <p>
      <?php
      $i = 0;
        foreach($tags as $tag)
        {
          if($tag[1]== $news['id']&&$i<5)
          {
            $i++;
             $vars= array();
              $vars['id']=$tag[2];
                echo '<a href='.$Router->BuildRoute('Tag','ShowTag',$vars).'> '.$tag[0] .'</a>';
          }
        }
        if($i==0)
        {
          echo 'il n\'y a pas de tag';
        }
      ?>
    </p>
  </fieldset>
  </br>
  <?php
}
?>

