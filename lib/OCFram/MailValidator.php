<?php
namespace OCFram;

class MailValidator extends Validator
{
    const cst_PatternAro = '@';
    const cst_Patternpoint = '.';
    public function __construct($errorMessage)
    {
        parent::__construct($errorMessage);

    }

    public function isValid($value)
    {
        $aro = stripos($value,self::cst_PatternAro);
        $point = stripos($value,self::cst_Patternpoint);
        if($aro !=false)
        {
            if($point!= false)
            {
                if($aro<2+$point)
                {
                    return true;
                }else false;
            }else false;
        }else false;
    }
}