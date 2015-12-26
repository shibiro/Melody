<?php
namespace OCFram;

class CaractereValidator extends Validator
{
    public function isValid($value)
    {
        if (preg_match('/[^a-zA-Z0-9-]/', $value)) {
            // pas valide
            return false;
        }
        else {
            return true;
        }
    }
}