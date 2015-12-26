<!DOCTYPE html>
<html>
  <head>
    <title>
      <?= isset($title) ? $title : 'Mon super site' ?>
    </title>
 
    <meta charset="utf-8" />
 
    <link rel="stylesheet" href="/css/Envision.css" type="text/css" />

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="..\javascript\loadNewComment.js"></script>

  </head>

  <body>
    <div id="wrap">
      <header>
        <?php echo '<h1><a href='.$Router->getBuiltRoute('News','index',[]).'>Mon super site</a></h1>' ?>
        <p>Comment ça, il n'y a presque rien ?</p>
      </header>

      <nav>
        <ul>
          <?php echo '<li><a href='.$Router->BuildRoute('News','index',[]).'>Accueil</a></li>' ?>

          <?php

          if (isset($menu_nav)){

            foreach($menu_nav as $value){
              foreach($value as $value2) {
                echo '<li><a href=' . $value2['link'] . '>' . $value2['text'] . '</a></li>';
              }
            }

          }?>
        </ul>
      </nav>

      <div id="content-wrap">
        <section id="main">
          <?php if ($user->hasFlash()) echo '<p style="text-align: center;">', $user->getFlash(), '</p>'; ?>
 
          <?= $content ?>
        </section>
      </div>
 
      <footer></footer>
    </div>
  </body>
</html>