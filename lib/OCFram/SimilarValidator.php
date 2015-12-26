<?php
namespace OCFram;


class SimilarValidator extends Validator
{
    protected $reference;

//vérifier que c'est un pseudo qui existe

    public function __construct($errorMessage,$reference)
    {
        parent::__construct($errorMessage);

        $this->setReference($reference);
    }

    public function isValid($value)
    {
        return  $value==$this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }
}