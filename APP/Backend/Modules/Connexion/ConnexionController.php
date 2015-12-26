<?php
namespace App\Backend\Modules\Connexion;
 
use App\Backend\AppController;
use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Member;
use \FormBuilder\MemberFormBuilder;
use \OCFram\FormHandler;
 
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

    $formBuilder = new MemberFormBuilder($member);
    $formBuilder->build($this->managers->getManagerOf('Member'));

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Member'), $request);

    if ($formHandler->process())
    {
      $this->app->user()->setAuthenticated(true);
      $this->app->httpResponse()->redirect($this->app->router()->getBuiltRoute('News','index',[]));
    }
    $this->page->addVar('title', 'Connexion');
    $this->page->addVar('Member', $member);
    $this->page->addVar('form', $form->createView());

  }
}