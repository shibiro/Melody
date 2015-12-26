<?php
namespace OCFram;

class VerifyPasswordValidator extends Validator
{
//vérifier que le mdp est deux (que c'est un admin)

    protected $managers;
    protected $pseudo;
    protected $password;
    public function __construct($errorMessage,$managers,$pseudo)
    {
        parent::__construct($errorMessage);

        $this->setManagers($managers);
        $this->setPseudo($pseudo);

    }

    public function isValid($value)
    {
        $username=$this->pseudo;
        return $this->managers->verifyPassword($username, $value);
        //return $value=='mdp';//Comment vérifier en récupérant le bon mdp par rapport au champ précédent ?
        //return $value== $this->password;
    }

    public function setManagers($managers)
    {
        $this->managers = $managers;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo =  $pseudo;
    }
}