<?php

namespace App\Frontend\Modules\Profil;


use App\Frontend\AppController;
use OCFram\BackController;
use \OCFram\HTTPRequest;

use \Entity\Member;



class ProfilController extends  BackController
{
    use AppController;

    public function executeIndex(HTTPRequest $request)
    {

        $this->run();

        // On récupère le manager des member.
        /** @var NewsManagerPDO $manager */
        $manager = $this->managers->getManagerOf('Member');

        if(isset($_SESSION['id'])){

            $id=$_SESSION['id'];
            $manager = $this->managers->getManagerOf('Member');
            $auteur=$manager->getusername($id);
            $member = new Member([
                'username' => $this->app->user()->getAttribute('user'),
                'mail' => $manager->getMail($auteur),
                'password' => $manager->getPassword($auteur),
                'description' => $manager->getdescription($auteur),
                'priority' => $manager->getPriority($auteur)
            ]);



            $this->page->addVar('title', 'Profil');

            $this->page->addVar('member', $member);
            $this->app->user()->setFlash('Bienvenue sur ton profil');
            // Mettre les informatiosn du membres ici
        }
        else{
            $this->app->httpResponse()->redirect404();
        }
    }

    public function executeNews(HTTPRequest $request)
    {

        $this->run();

        if(!isset($_SESSION['id']))
        {
            $this->app->httpResponse()->redirect404();
        }
        else{

            $this->page->addVar('title', 'Mes news');
            $manager = $this->managers->getManagerOf('News');
            $auteur = $_SESSION['user'];
            $number = $manager->countNewsMember($auteur);
            $listeNews = $manager->getListMember( $auteur);


            // On ajoute la variable $listeNews à la vue.
            $this->page->addVar('number', $number);
            $this->page->addVar('listeNews', $listeNews);
        }
    }

    public function executeComments(HTTPRequest $request)
    {

        $this->run();

        if(!isset($_SESSION['id']))
        {
            $this->app->httpResponse()->redirect404();
        }
        else{

            $manager = $this->managers->getManagerOf('Comments');
            $auteur = $_SESSION['user'];

            $this->page->addVar('title', 'Mes commentaires');
            $this->page->addVar('comments', $manager->getListOfMember($auteur));

            $this->page->addVar('number', $manager->countCountMember($auteur));
        }
    }
}