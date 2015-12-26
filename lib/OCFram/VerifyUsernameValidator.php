<?php
namespace OCFram;


class VerifyUsernameValidator extends Validator
{
    protected $managers;
//vérifier que c'est un pseudo qui existe

    public function __construct($errorMessage,$managers)
    {
        parent::__construct($errorMessage);

        $this->setManagers($managers);
    }

    public function isValid($value)
    {
        return  $this->managers->verifyUsername($value);
    }

    public function setManagers($managers)
    {
        $this->managers = $managers;
    }
}