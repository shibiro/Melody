<?php
namespace OCFram;

class VerifyPriorityValidator extends Validator
{
    protected $manager;


    const mmc_priority_admin = 2;
//vérifier que c'est un pseudo qui existe

    public function __construct($errorMessage,$managers)
    {
        parent::__construct($errorMessage);

        $this->setManagers($managers);
    }

    public function isValid($value)
    {
        return self::mmc_priority_admin == $this->manager->isAdmin($value) ;
    }

    public function setManagers($managers)
    {
        $this->manager = $managers;
    }

}