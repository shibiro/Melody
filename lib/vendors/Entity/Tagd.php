<?php
namespace Entity;

use \OCFram\Entity;

class Tagd extends Entity
{
    protected
        $idTag,
        $idNew;
    const IDTAG_INVALIDE = 1;
    const IDNEW_INVALIDE = 2;
    public function isValid()
    {
        return !(empty($this->idTag)||empty($this->idNew));
    }


    // SETTERS //

    public function setIdtag($idTag)
    {
        if (!is_string($idTag) || empty($idTag))
        {
            $this->erreurs[] = self::IDTAG_INVALIDE;
        }

        $this->idTag = $idTag;
    }

    public function setIdnew($idNew)
    {
        if (!is_string($idNew) || empty($idNew))
        {
            $this->erreurs[] = self::IDNEW_INVALIDE;
        }

        $this->idNew = $idNew;
    }

    // GETTERS //

    public function idTag()
    {
        return $this->idTag;
    }

    public function idNew()
    {
        return $this->idNew;
    }

}