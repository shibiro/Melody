<?php
namespace Entity;

use \OCFram\Entity;

class Member extends Entity
{
    protected $id,
        $username,
        $password,
        $confirmation,
        $description,
        $priorit,
        $mail;

    const ID_INVALIDE = 1;
    const USERNAME_INVALIDE = 2;
    const PASSWORD_INVALIDE = 3;
    const CONFIRMATION_INVALIDE = 6;
    const PRIORITY_INVALIDE = 4;
    const DESCRIPTION_INVALIDE = 5;
    const MAIL_INVALIDE = 8;

    public function setID($id)
    {
        if (!is_int($id) || empty($id))
        {
            $this->erreurs[] = self::ID_INVALIDE;
        }

        $this->id = $id;
    }
    public function setUsername($username)
    {
        if (!is_string($username) || empty($username))
        {
            $this->erreurs[] = self::USERNAME_INVALIDE;
        }

        $this->username = $username;
    }

    public function setPassword($password)
    {
        if (!is_string($password) || empty($password))
        {
            $this->erreurs[] = self::PASSWORD_INVALIDE;
        }

        $this->password = $password;
    }

    public function setDescription($description)
    {
        if (!is_string($description) || empty($description))
        {
            $this->erreurs[] = self::USERNAME_INVALIDE;
        }

        $this->description = $description;
    }

    public function setPriority($priority)
    {
        if (!is_int($priority) || empty($priority))
        {
            $this->erreurs[] = self::PRIORITY_INVALIDE;
        }

        $this->priority = $priority;
    }

    public function setConfirmation($confirmation)
    {
        if (!is_string($confirmation) || empty($confirmation))
        {
            $this->erreurs[] = self::CONFIRMATION_INVALIDE;
        }
        $this->confirmation = $confirmation;
    }
    public function setMail($mail)
    {
        if (!is_string($mail) || empty($mail))
        {
            $this->erreurs[] = self::MAIL_INVALIDE;
        }
        $this->mail = $mail;
    }
    public function isValid()
    {
        return !(empty($this->username) || empty($this->password));
    }
    public function id()
    {
        return $this->id;
    }
    public function username()
    {
        return $this->username;
    }

    public function password()
    {
        return $this->password;
    }

    public function confirmation()
    {
        return $this->confirmation;
    }

    public function description()
    {
        return $this->description;
    }

    public function priority()
    {
        return $this->priority;
    }

    public function mail()
    {
        return $this->mail;
    }
}