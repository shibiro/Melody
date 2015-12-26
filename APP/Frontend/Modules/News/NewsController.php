<?php
namespace App\Frontend\Modules\News;

use \Model\NewsManagerPDO;

use \App\Frontend\AppController;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \OCFram\FormHandler;
use \OCFram\Page;

use \Entity\News;
use \Entity\Comment;
use \Entity\Tag;
use \Entity\Tagd;

use \FormBuilder\CommentFormBuilder;
use \FormBuilder\NewsMemberFormBuilder;
use \FormBuilder\TagFormBuilder;

class NewsController extends BackController
{
  //const ROUTER = $this->app->router();
  use AppController;

  public function executeIndex(HTTPRequest $request)
  {
    // On génère le titre
    $this->run();

    $nombreNews = $this->app->config()->get('nombre_news');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');

    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Liste des '.$nombreNews.' dernières news');
 
    // On récupère le manager des news.
    /** @var NewsManagerPDO $manager */
    $manager = $this->managers->getManagerOf('News');
 
    $listeNews = $manager->getList(0, $nombreNews);
    $ListTag =  array();
    foreach ($listeNews as $news)
    {
      if (strlen($news->contenu()) > $nombreCaracteres)
      {
        $debut = substr($news->contenu(), 0, $nombreCaracteres);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';
 
        $news->setContenu($debut);

      }

      //Insertion des tags ??
      $managerTag = $this->managers->getManagerOf('Tag');
      $Listtagtemporary = $managerTag->getListOf($news->id());


      $ListTag=array_merge($ListTag, $Listtagtemporary);

    }

    // On ajoute la variable $listeNews à la vue.
    $this->page->addVar('listeNews', $listeNews);
    // et aussi la liste des tags
    $this->page->addVar('tags', $ListTag);


  }
 
  public function executeShow(HTTPRequest $request)
  {

    $this->run();

    $managerNews = $this->managers->getManagerOf('News');
    $managerComments = $this->managers->getManagerOf('Comments');
    $managerMember = $this->managers->getManagerOf('Member');

    $nombrecommentaireshow = 5;


    $news = $managerNews->getUnique($request->getData('id'));
 
    if (empty($news) ||$news ==null){

      $this->jump('News','Test');
      //$this->jump
      //$this->app->httpResponse()->redirect404();
    }
    else{



    $ListComments = $managerComments->getListOf($news->id());
    $this->page->addVar('anycomments',count($ListComments)>5);

    $ListComments = array_slice($ListComments, 0, $nombrecommentaireshow);
    $this->page->addVar('comments', $ListComments);

    $this->page->addVar('id',$managerMember->getID($news->auteur()));
    $this->page->addVar('title', $news->titre());
    $this->page->addVar('news', $news);

    //Insertion des tags

    $managerTag = $this->managers->getManagerOf('Tag');
    $ListTag = $managerTag->getListOf($news->id());
    $this->page->addVar('tags', $ListTag);
    }
  }

  public function executeInsertComment(HTTPRequest $request)
  {
  //ajout menu navigateur
    $this->run();

    // si la news dans laquelle on veut insérer n'existe pas, redirection
    $news = $this->managers->getManagerOf('News')->getUnique($request->getData('news'));
    if($news == null){
      $this->app->httpResponse()->redirect404();
    }


    // Si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
      if(isset($_SESSION['user']))
      {
        $comment = new Comment([
            'news' => $request->getData('news'),
            'auteur'=>$this->app->user()->getAttribute('user'),
            'mail'=>$this->managers->getManagerOf('Member')->getMail($this->app->user()->getAttribute('user')),
            'contenu' => $request->postData('contenu')
        ]);
      }
      else
      {
        $comment = new Comment([
            'news' => $request->getData('news'),
            'auteur' => $request->postData('auteur'),
            'mail' => $request->postData('mail'),
            'contenu' => $request->postData('contenu')
        ]);
      }
    }
    else
    {
      $comment = new Comment;
    }
    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();
 
    $form = $formBuilder->form();
 
    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);
 
    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');


      $vars = array();
      $vars['id']=$request->getData('news');
      $this->app->httpResponse()->redirect($this->app->router()->getBuiltRoute('News','show',$vars));
      //$this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
    }
 
    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');
  }

  public function executeInsert(HTTPRequest $request)
  {


      // vérifier que la personne est bien connecté

    $this->processForm($request);

    $this->page->addVar('title', 'Ajout d\'une news');
  }

  public function executeUpdate(HTTPRequest $request)
  {
      $this->processForm($request);

      $this->page->addVar('title', 'Modification d\'une news');
  }

  public function processForm(HTTPRequest $request)
  {

    $this->run();

    //manager news
    $managersNews =$this->managers->getManagerOf('News');

    // manager tag
    $managersTag=$this->managers->getManagerOf('Tag');

    if ($request->method() == 'POST')
    {
      // Éléménet News
      $news = new News([
        'auteur'=>$this->app->user()->getAttribute('user'),
        'titre' => $request->postData('titre'),
        'contenu' => $request->postData('contenu')
    ]);
      // Élément Tag
      if($request->postData('name')!='')
      {
        $tag = new Tag([
            'name' => $request->postData('name')]);
        $table=NewsController::separateTag($tag->name()); //vraiment ici ?

        //on sauvegarde tout les tags rentré si ils n'existes pas !
      }else{
        $tag = new Tag;
      }

      if ($request->getExists('id'))
      {
        $news->setId($request->getData('id'));
        $tag = new Tag;
      }
    }
    else
    {
      // L'identifiant de la news est transmis si on veut la modifier
      if ($request->getExists('id') )
      {
        $news = $managersNews->getUnique($request->getData('id'));
        $text='';
        foreach($managersTag->getUnique($request->getData('id')) as $value) {
          $text = $text.' '.$value['NTC_name'];
        }

        $tag = new Tag([
            'name' => $text]);
        if( $news == null ){

          $this->app->httpResponse()->redirect404();
        }
      }
      else
      {
        $news = new News;
        $tag = new Tag;
      }
    }

    //construction formulaire news
    $formBuilderNews = new NewsMemberFormBuilder($news);
    $formBuilderNews->build();


    $formNews = $formBuilderNews->form();

    $formHandlerNews = new FormHandler($formNews, $managersNews, $request);

    //Construction formulaire Tag
    $formBuilderTag = new TagFormBuilder($tag); // même formbuilder ?
    $formBuilderTag->build($managersTag);

    $formTag = $formBuilderTag->form();

    // manager tagd
    $managersTagd=$this->managers->getManagerOf('Tagd');


    if ($formHandlerNews->process())
    { //Refaire proprement le handler pour les tags
      $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !'  : 'La news a bien été modifiée !');
      // récupérer le dernier id de news
      if($news->isNew()){

      $news->setId($managersNews->getlastid());
      }
      //var_dump($news->id());

      NewsController::saveTag($table,$managersTag);
      foreach ($table as $key => $value) {

        $idtag= $managersTag->getId($value);
        $tagd = new Tagd;

        $tagd->setIdnew($news->id());
        $tagd->setIdtag($idtag);
        $managersTagd->add($tagd);
      }

      $this->app->httpResponse()->redirect($this->app->router()->getBuiltRoute('News','index',[]));
    }
    $this->page->addVar('formNews', $formNews->createView());
    $this->page->addVar('formTag', $formTag->createView());
  }

  public function executeDelete(HTTPRequest $request)
  {
      if($this->managers->getManagerOf('News')->get($request->getData('id'))===false
          || $this->managers->getManagerOf('News')->get($request->getData('id'))->auteur()!==$this->app->user()->getAttribute('user') )
      {
          $this->app->httpResponse()->redirect404();
      }

      $newsId = $request->getData('id');
      $this->managers->getManagerOf('News')->delete($newsId);
      $this->managers->getManagerOf('Comments')->deleteFromNews($newsId);

      $this->managers->getManagerOf('Tagd')->deleteFromNews($newsId);
      $this->app->user()->setFlash('La news a bien été supprimée !');

      $this->app->httpResponse()->redirect($this->app->router()->getBuiltRoute('News','index',[]));
  }


  public function getjsonComment($ListComm){

    $ListComm = json_encode($ListComm);
    $this->page->setTypeLayout(Page::TYPE_JSON);
    $this->page->addVar('contentjson', $ListComm);
  }

  public function executegetNewComments(HTTPRequest $request)
  {
    $ListComm = $this->managers->getManagerOf('News')->getListNewComments((int)$request->postData('newsid'),(int)$request->postData('commentid')) ;

    self::getjsonComment($ListComm);
  }

  public function executegetOldComments(HTTPRequest $request)
  {
    $news_id = (int)$request->postData('newsid');
    $comment_id = (int)$request->postData('commentid');
    $managernews= $this->managers->getManagerOf('News');


    $ListComm = $managernews->getListOldComments($news_id,$comment_id) ;

    $ListComm = json_encode($ListComm);
    $this->page->setTypeLayout(Page::TYPE_JSON);
    $this->page->addVar('contentjson', $ListComm);
  }

  public function executeTest(HTTPRequest $request){
    $this->page->addVar('test',$request->getData('id'));
    echo 'test ';
    echo $request->getData('id');
  }

  public static function separateTag($name) // utiliser la function explode
  {
    $tableau = array();
    $name = trim($name);

    while (strpos($name,' ')!== false)
    {
      $ajout= substr($name,0,strpos($name,' '));
      array_push($tableau,$ajout);
      $name= substr($name,strpos($name,' ')+1);
    }
    array_push($tableau,$name);

    return $tableau;
  }

  public static function saveTag($tableau,$managers)
  {
    if(is_array($tableau)){
      $i=0;
      $count=count($tableau);
      while($i<$count)
      {
        if($managers->countTag($tableau[$i])<1)
        {
          $managers->addTag($tableau[$i]);
        }
        //si ça n'appartiens pas a la table des tags, l'ajouter
        $i++;
      }
      return true;
    }
    else return false;
  }

}
