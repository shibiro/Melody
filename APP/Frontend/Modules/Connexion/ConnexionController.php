<?php
namespace App\Frontend\Modules\Connexion;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Member;
use \FormBuilder\AutorFormBuilder;
use \OCFram\FormHandler;

use \App\Frontend\AppController;
class ConnexionController extends BackController
{

    use AppController;

    public function executeIndex(HTTPRequest $request)
    {

        $this->run();

        if ($request->method() == 'POST')
        {
            $member = new Member([
                'username' => $request->postData('username'),
                'password' => $request->postData('password')

            ]);
        }
        else
        {
            $member = new Member;
        }

        $formBuilder = new AutorFormBuilder($member);
        $formBuilder->build($this->managers->getManagerOf('Member'));
        $form = $formBuilder->form();

        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Member'), $request);
        $entier=(int)$this->managers->getManagerOf('Member')->getId($member->username());


        if ($formHandler->process())
        {

            $this->app->user()->setMember(1); // on met 1 pour auteur, il faudrait le faire dynamiquement ? (récupérer $member->priority() ?
            $this->app->user()->setUsername($member->username());


            $this->app->user()->setId($entier);//récupérer l'id du member

            $this->app->user()->setFlash('Tu es connecté');

            $this->app->httpResponse()->redirect($this->app->router()->getBuiltRoute('News','index',[]));
        }
        $this->page->addVar('title', 'Connexion');
        $this->page->addVar('Member', $member);
        $this->page->addVar('form', $form->createView());

    }
}