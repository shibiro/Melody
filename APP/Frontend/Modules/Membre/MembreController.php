<?php

namespace App\Frontend\Modules\Membre;


use App\Frontend\AppController;
use OCFram\BackController;
use \OCFram\HTTPRequest;

use \Entity\Member;



class MembreController extends  BackController
{
    use AppController;

    public function executeIndex(HTTPRequest $request)
    {

        $this->run();


        // On récupère le manager des member.
        /** @var NewsManagerPDO $manager */

            $id=$request->getData('id');

            $manager = $this->managers->getManagerOf('Member');

            $auteur=$manager->getusername($id);
        // petite fonction qui permet de vérifié si le paramètre dans l'url n'est pas le pseudo du membre au lieu de l'id
        // si c'est le cas alors on remplace le nom par l'id.
            if($auteur==false) {
                $id=$manager->getId($id);
                if($id!=false){
                    $auteur=$manager->getusername($id);
                }
                else{

                    $id=$request->getData('id');
                }
            }




            if($auteur!==false) {
                // Récupéré l'id du membre que l'on veux voir, et avec récupérer le nom, puis appliquer ce que l'on souhaite dans membre
                $member = new Member([
                    'username' => $manager->getusername($id),
                    'mail' => $manager->getMail($auteur),
                    'description' => $manager->getdescription($auteur),
                    'priority' => $manager->getPriority($auteur)
                ]);
            }
            else{
                $member = new Member([
                    'username' => $id,
                    'priority' => '0'
                ]);
            }

                $this->page->addVar('title', 'Profil');

                $this->page->addVar('id', $id);
                $this->page->addVar('auteur', $auteur);
                $this->page->addVar('member', $member);
                $this->app->user()->setFlash('Bienvenue sur le profil de ' .$member->username());

            // Mettre les informatiosn du membres ici

    }

    public function executeNews(HTTPRequest $request)
    {

        $this->run();

            $id=$request->getData('id');
            $manager = $this->managers->getManagerOf('Member');
            $auteur= $manager->getUsername($id);

            if($auteur==false) {
                $id=$manager->getId($id);
                if($id!=false){
                    $auteur=$manager->getusername($id);
                }else {

                    $id=$request->getData('id');
                }
            }

        if($auteur===false) {

                $this->app->httpResponse()->redirect404();
            }

            $manager = $this->managers->getManagerOf('News');
            // Récupéré l'id du membre que l'on veux voir, et avec récupérer le nom, puis appliquer ce que l'on souhaite dans membre

            $number = $manager->countNewsMember($auteur);
            $listeNews = $manager->getListMember( $auteur);


            // On ajoute la variable $listeNews à la vue.
            $this->page->addVar('id',  $id);
            $this->page->addVar('number', $number);
            $this->page->addVar('listeNews', $listeNews);
            $this->page->addVar('title', 'Mes news');

    }

    public function executeComments(HTTPRequest $request)
    {

        $this->run();

            $id=$request->getData('id');
            $manager = $this->managers->getManagerOf('Member');
            // Récupéré l'id du membre que l'on veux voir, et avec récupérer le nom, puis appliquer ce que l'on souhaite dans membre
            $auteur = $manager->getusername($id);

            if($auteur==false) {
                $id=$manager->getId($id);
                if($id!=false){
                    $auteur=$manager->getusername($id);
                }else{

                    $id=$request->getData('id');
                }
            }

            $this->page->addVar('auteur', $auteur);

            if($auteur===false) {

                $auteur=$id;

            }

            $manager = $this->managers->getManagerOf('Comments');
            $this->page->addVar('id',  $id);
            $this->page->addVar('title', 'Mes commentaires');
            $this->page->addVar('comments', $manager->getListOfMember($auteur));

            $this->page->addVar('number', $manager->countCountMember($auteur));

    }
}
