<?php
namespace App\Backend\Modules\Deconnexion;

use \OCFram\BackController;
use \OCFram\HTTPRequest;


class DeconnexionController extends BackController
{
    public function executeIndex(HTTPRequest $request)
    {

        $this->app->user()->setDeconnexion();
        $this->app->httpResponse()->redirect('.');

    }
}