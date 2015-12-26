<?php
namespace OCFram;

class MaxLengthWordValidator extends Validator
{
    protected $maxLength;

    public function __construct($errorMessage, $maxLength)
    {
        parent::__construct($errorMessage);

        $this->setMaxLength($maxLength);
    }

    public function isValid($value)
    {
        $tableau = array();
        $name = trim($value);
        $i=0;

        while (strpos($name,' ')!== false)
        {
            $name= substr($name,strpos($name,' ')+1);
            if(strpos($name,' ')>$this->maxLength){
                $i++;
            }
        }
        if(strlen($name)>$this->maxLength){$i++;}
        return ($i==0);
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