<?php
/**
 * Created by PhpStorm.
 * User: cleconte
 * Date: 09/10/2015
 * Time: 10:47
 */
namespace OCFram;

class ConnexionValidator extends Validator {
    protected $login;
    protected $password;

    public function __construct($errorMessage, $login,$password)
    {
        parent::__construct($errorMessage);

        $this->setMaxLength($login);
        $this->setMaxLength($password);
    }

    public function isValid($value)
    {
       // a definir
    }

    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;

        if ($maxLength > 0)
        {
            $this->maxLength = $maxLength;
        }
        else
        {
            throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
        }
    }
}
