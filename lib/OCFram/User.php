<?php
namespace OCFram;
 
session_start();
 
class User
{
  public function getAttribute($attr)
  {
    return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;
  }
 
  public function getFlash()
  {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
 
    return $flash;
  }
 
  public function hasFlash()
  {
    return isset($_SESSION['flash']);
  }
 
  public function isAuthenticated()
  {
    return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
  }
 
  public function setAttribute($attr, $value)
  {
    $_SESSION[$attr] = $value;
  }
 
  public function setAuthenticated($authenticated = true)
  {
    if (!is_bool($authenticated))
    {
      throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthenticated() doit être un boolean');
    }
 
    $_SESSION['auth'] = $authenticated;
  }

  public function isMember()
  {
    return isset($_SESSION['mem']) && $_SESSION['mem'] !== null;
  }

  public function setMember($member_type)
  {
    if(!is_int($member_type)){
      throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setMember() doit être un int');
    }
    $_SESSION['mem']=$member_type;
  }

  public function isId()
  {
    return isset($_SESSION['id']) && $_SESSION['id'] !== null;
  }

  public  function  setId($id){
    if(!is_int($id)){
      throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setId() doit être un int');
    }
    $_SESSION['id']=$id;
  }

  public function isUsername()
  {
    return isset($_SESSION['user']) && $_SESSION['user'] !== null;
  }

  public  function  setUsername($username){
    if(!is_string($username)){
      throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setId() doit être un string');
    }
    $_SESSION['user']=$username;
  }

  public function setMail($mail){
    if(!is_string($mail)){
      throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setMail() doit être un string');
    }
    $_SESSION['mail']=$mail;
  }


  public function setFlash($value)
  {
    $_SESSION['flash'] = $value;
  }

    public function setDeconnexion(){

// On détruit les variables de notre session
        session_unset ();

// On détruit notre session
        session_destroy ();
    }

}