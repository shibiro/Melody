<?php
namespace Model;
 
use \Entity\News;
 
class NewsManagerPDO extends NewsManager
{
  protected function add(News $news)
  {
    $requete = $this->dao->prepare('INSERT INTO news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()');
 
    $requete->bindValue(':titre', htmlspecialchars($news->titre()));
    $requete->bindValue(':auteur', htmlspecialchars($news->auteur()));
    $requete->bindValue(':contenu', htmlspecialchars($news->contenu()));
 
    $requete->execute();
  }

  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM news')->fetchColumn();
  }
 
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM news WHERE id = '.(int) $id);
  }

  /**
   * @param int $debut
   * @param int $limite
   * @return News[]
   */
  
  public function getList($debut = -1, $limite = -1)
  {
    $sql = 'SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news ORDER BY id DESC';
 
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
 
    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
 
    $listeNews = $requete->fetchAll();
 
    foreach ($listeNews as $news)
    {
      $news->setDateAjout(new \DateTime($news->dateAjout()));
      $news->setDateModif(new \DateTime($news->dateModif()));
    }
 
    $requete->closeCursor();
 
    return $listeNews;
  }

  public function getUnique($id)
  {
    $requete = $this->dao->prepare('SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

    if ($news = $requete->fetch())
    {
      $news->setDateAjout(new \DateTime($news->dateAjout()));
      $news->setDateModif(new \DateTime($news->dateModif()));

      return $news;
    }

    return null;
  }
 
  protected function modify(News $news)
  {
    $requete = $this->dao->prepare('UPDATE news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateModif = NOW() WHERE id = :id');
 
    $requete->bindValue(':titre', $news->titre());
    $requete->bindValue(':auteur', $news->auteur());
    $requete->bindValue(':contenu', $news->contenu());
    $requete->bindValue(':id', $news->id(), \PDO::PARAM_INT);
 
    $requete->execute();
  }

  public function get($id)
  {
    $q = $this->dao->prepare('SELECT id, auteur FROM News WHERE id = :id');
    $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $q->execute();

    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

    return $q->fetch();
  }

  public function getlastid(){ //erreur probable
    return $this->dao->query('SELECT id FROM News ORDER BY id DESC')->fetchColumn();
  }

  public function getListMember($auteur)
  {
    $req = $this->dao->prepare("SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news WHERE auteur = :auteur ORDER BY id DESC");
    $req->execute(array(
        ':auteur' => $auteur));
    $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

    $listeNews = $req->fetchAll();

    foreach ($listeNews as $news)
    {
      $news->setDateAjout(new \DateTime($news->dateAjout()));
      $news->setDateModif(new \DateTime($news->dateModif()));
    }

    $req->closeCursor();

    return $listeNews;
  }

  public function getListNewComments($news_id,$comment_id)
  {

    return $this->getListCommentsUsingNewsIdAndCommentId(
        "SELECT b.id, b.news, b.auteur, b.contenu, b.date
          FROM comments as b
          WHERE b.news = :news_id
          AND b.id > :comment_id
          ORDER BY b.id ASC",
        $news_id,
        $comment_id);
  }


  public function getListOldComments($news_id,$comment_id)
  {
    return $this->getListCommentsUsingNewsIdAndCommentId(
        "SELECT b.id, b.news, b.auteur, b.contenu, b.date
            FROM comments as b
            WHERE b.news = :news_id
            AND b.id < :comment_id
            ORDER BY b.id DESC
            LIMIT 6",
        $news_id,
        $comment_id);
  }

  private function getListCommentsUsingNewsIdAndCommentId($sql, $news_id,$comment_id) {
    $req = $this->dao->prepare($sql);
    $req->execute(array(
            ':news_id' => $news_id,
            ':comment_id' => $comment_id)
    );
    $listeNews = $req->fetchAll();
    $req->closeCursor();

    return $listeNews;
  }


  public function countNewsMember($username)
  {
    return $this->dao->query("SELECT COUNT(*) FROM news WHERE auteur = '$username'")->fetchColumn();
  }
}