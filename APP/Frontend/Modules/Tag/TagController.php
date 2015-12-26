<?php
namespace App\Frontend\Modules\Tag;

use App\Frontend\AppController;
use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Tag;
use \FormBuilder\TagFormBuilder;


class TagController extends BackController
{
    use AppController;

    public function executeIndex(HTTPRequest $request)
    {

        $this->run();

        $managers=$this->managers->getManagerOf('Tag');

        if ($request->method() == 'POST' && $request->postData('name')!='')
        {
            $tag = new Tag([
            'name' => $request->postData('name')]);
            $table=TagController::separateTag($tag->name());
            var_dump($table);
            var_dump(count($table));

            TagController::saveTag($table,$managers);
        } else{

            $tag = new Tag;
        }
        $formBuilder = new TagFormBuilder($tag); // même formbuilder ?
        $formBuilder->build($managers);
        $form = $formBuilder->form();
        $this->page->addVar('form', $form->createView());

    }

    public static function separateTag($name)
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
                    $managers->add($tableau[$i]);
                }
                //si ça n'appartiens pas a la table des tags, l'ajouter
                $i++;
            }
            return true;
        }
        else return false;
    }

    public function executeShowTag(HTTPRequest $request){

        $this->run();

        $managertag= $this->managers->getManagerOf('Tag');
        // Si le numéro de tag exist :
        $idtag=$request->getData('id');

        $tagname = $managertag->getname($idtag);
        if($tagname != false){

            $ListTag = $managertag->getListOfNews($idtag);

            $this->page->addVar('ListNewsTag', $ListTag);
            $this->page->addVar('nametag', $tagname);
        }
        else{
            $this->page->addVar('undefined', 1);
        }


    }

}