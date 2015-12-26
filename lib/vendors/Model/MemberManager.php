<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Member;

abstract class MemberManager extends Manager
{
    abstract public function verifyPassword($username, $pseudo);

    public function save(Member $member)
    {
        if ($member->isValid())
        {
            $member->description()  ? $this->add($member) : true ; //bien v�rifier que le pseudo n'est pas d�j� utilis� erreur potentiel ici attention
        }
        else
        {
            throw new \RuntimeException('L\inscription n\'est pas valide');
        }
    }
}