<?php
namespace App\Frontend;

use \OCFram\Application;
use \OCFram\BackController;

trait AppController
{



    protected  function run(){
        $this->setMenu();

        $this->page->addVar('Router',$this->app->router());
    }
    public function setRouter(){

    }

    public function setMenu(){
        //if admin
        $user=$this->app->user();
        $menu_nav = array();
        $Router=$this->app->router();
        // chaque lien du menu est inséré dans un tableau

        if($this->app->name()=='Frontend'){
            array_push($menu_nav,array(
                array('text'=>'Tu es dans le FrontEnd','link'=>$Router->BuildRoute('News','index',[]))
            ));
        }

        if($user->isMember()){
            array_push($menu_nav,array(
                    array('text'=>'Profil','link'=>$Router->BuildRoute('Profil','index',[])),
                    array('text'=>'Ajouter une News','link'=>$Router->BuildRoute('News','insert',[])),
                    array('text'=>'Deconnexion','link'=>$Router->BuildRoute('Deconnexion','index',[])))
                    );
        }
        else {

            array_push($menu_nav,array(
                array('text'=>'inscription','link'=>$Router->BuildRoute('Register','index',[])),
                array('text'=>'Connexion','link'=>$Router->BuildRoute('Connexion','index',[]))
                    ));
        }
        $this->page->addVar('menu_nav',$menu_nav);

    }

    /**
    * @param string $targetmodule
    * @param string $targetaction
    */
    /*
    protected function jump($targetmodule, $targetaction){
        //vérifier ce que l'on reçoit ?
        $controllerClass = 'App\\Frontend\\Modules\\'.$targetmodule.'\\'.$targetmodule.'Controller';
        $ControllerClass = new $controllerClass($this->app(),$targetmodule,$targetaction);// pourquoi backcontroller n'est pas intencier ?


        $this->setView($targetaction); // pourquoi il ne s'appelle pas tout seul ?
        $ControllerClass->execute();



        //$this->app->httpResponse->setPage($ControllerClass->page());
        //$this->app->httpResponse->send();

    }*/


}
?>
