<?php
namespace Entity;
 
use \OCFram\Entity;
 
class Comment extends Entity
{
  protected $news,
            $auteur,
            $mail,
            $contenu,
            $date;
 
  const AUTEUR_INVALIDE = 1;
  const CONTENU_INVALIDE = 2;
  const MAIL_INVALIDE = 3;
 
  public function isValid()
  {
    return !(empty($this->auteur) || empty($this->contenu) || empty($this->mail) );
  }
 
  public function setNews($news)
  {
    $this->news = (int) $news;
  }
 
  public function setAuteur($auteur)
  {
    if (!is_string($auteur) || empty($auteur))
    {
      $this->erreurs[] = self::AUTEUR_INVALIDE;
    }
 
    $this->auteur = $auteur;
  }
 
  public function setContenu($contenu)
  {
    if (!is_string($contenu) || empty($contenu))
    {
      $this->erreurs[] = self::CONTENU_INVALIDE;
    }
 
    $this->contenu = $contenu;
  }

  public function setMail($mail)
  {
    if (!is_string($mail) || empty($mail))
    {
      $this->erreurs[] = self::MAIL_INVALIDE;
    }

    $this->mail = $mail;
  }

  public function setDate(\DateTime $date)
  {
    $this->date = $date;
  }
 
  public function news()
  {
    return $this->news;
  }
 
  public function auteur()
  {
    return $this->auteur;
  }
 
  public function contenu()
  {
    return $this->contenu;
  }
 
  public function date()
  {
    return $this->date;
  }

  public function mail()
  {
    return $this->mail;
  }
}