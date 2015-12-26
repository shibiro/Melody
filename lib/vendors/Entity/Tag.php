<?php
namespace Entity;

use \OCFram\Entity;

class Tag extends Entity
{
    protected
        $id,
        $name;
    const NAME_INVALIDE = 1;
    const ID_INVALIDE = 2;
    public function isValid()
    {
        return !(empty($this->name));
    }


    // SETTERS //

    public function setName($name)
    {
        if (!is_string($name) || empty($name))
        {
            $this->erreurs[] = self::NAME_INVALIDE;
        }

        $this->name = $name;
    }

    public function setID($id)
    {
        if (!is_string($id) || empty($id))
        {
            $this->erreurs[] = self::ID_INVALIDE;
        }

        $this->id = $id;
    }

    // GETTERS //

    public function name()
    {
        return $this->name;
    }

    public function id()
    {
        return $this->id;
    }

}