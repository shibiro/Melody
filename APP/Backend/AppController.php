<?php
namespace App\Backend;

trait AppController
{

    protected  function run(){
        $this->setMenu();
        $this->page->addVar('Router',$this->app->router());
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

        if($user->isAuthenticated()){
            array_push($menu_nav,array(
                array('text'=>'Admin','link'=>$Router->BuildRoute('News','index',[])),
                array('text'=>'Ajouter une News','link'=>$Router->BuildRoute('News','insert',[])),
                array('text'=>'Deconnexion','link'=>$Router->BuildRoute('Deconnexion','index',[])))
            );
        }
        else {

            array_push($menu_nav,array(
                    array('text'=>'Connexion de l\'admin ','link'=>$Router->BuildRoute('News','index',[])))
            );
        }
        $this->page->addVar('menu_nav',$menu_nav);

    }


}
?>
