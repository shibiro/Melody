<?php
namespace App\Frontend\Modules\Register;

use App\Frontend\AppController;
use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Member;
use \FormBuilder\RegisterFormBuilder;
use \OCFram\FormHandler;


class RegisterController extends BackController
{
    use AppController;

    public function executeIndex(HTTPRequest $request)
    {

        $this->run();

        if ($request->method() == 'POST')
        {
            $member = new Member([
                'username' => $request->postData('username'),
                'password' => $request->postData('password'),
                'confirmation' => $request->postData('confirmation'),
                'description' => $request->postData('description'),
                'mail' => $request->postData('mail')

            ]);
        }
        else
        {
            $member = new Member; // on garde cette entité member ?
        }

        $formBuilder = new RegisterFormBuilder($member); // même formbuilder ?
        $formBuilder->build($this->managers->getManagerOf('Member'));

        $form = $formBuilder->form();

        $formHandler = new FormHandler($form, $this->managers->getManagerOf('Member'), $request);

        if ($formHandler->process())
        {
            $this->app->user()->setFlash('vous êtes bien inscrit');

            $this->app->httpResponse()->redirect('.');
        }
        $this->page->addVar('title', 'Inscription');
        $this->page->addVar('Member', $member);
        $this->page->addVar('form', $form->createView());


    }
}