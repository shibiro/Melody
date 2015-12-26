<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Tagd;

abstract class TagdManager extends Manager
{

    abstract protected function add(Tagd $tagd);


    abstract public function delete($id);


    public function save(Tagd $tagd)
    {
        if ($tagd->isValid())
        {
            $tagd->isNew() ? $this->add($tagd) : true ;
        }
        else
        {
            throw new \RuntimeException('Le commentaire doit être validé pour être enregistré');
        }
    }

    abstract public function count($id,$idnew);
}