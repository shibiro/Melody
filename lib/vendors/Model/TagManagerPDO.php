<?php
namespace Model;

use \Entity\Tag;

class TagManagerPDO extends TagManager
{

    public function add($nametag)
    {
        $q = $this->dao->prepare('INSERT INTO T_NEW_tagc SET NTC_name = :name');

        $q->bindValue(':name', htmlspecialchars($nametag), \PDO::PARAM_INT);

        $q->execute();

        //$tag->setId($this->dao->lastInsertId());
    }


    public function addTag($nametag)
    {
        $q = $this->dao->prepare('INSERT INTO T_NEW_tagc SET NTC_name = :name');

        $q->bindValue(':name', htmlspecialchars($nametag), \PDO::PARAM_INT);

        $q->execute();

        //$tag->setId($this->dao->lastInsertId());
    }

    public function delete($id)
    {
        $this->dao->exec('DELETE FROM T_NEW_tagc WHERE NTC_id = '.(int) $id);
    }

    /*public function getListOf($tag)
    {
        if (!ctype_digit($tag))
        {
            throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un nombre entier valide');
        }

        $q = $this->dao->prepare('SELECT name FROM T_NEW_tagc WHERE id = :id');
        $q->bindValue(':news', $news, \PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        $comments = $q->fetchAll();

        foreach ($comments as $comment)
        {
            $comment->setDate(new \DateTime($comment->date()));
        }

        return $comments;
    }*/

    protected function modify(Tag $tag)
    {
        $q = $this->dao->prepare('UPDATE T_NEW_tagc SET name = :name WHERE NTC_id = :id');

        $q->bindValue(':id', $tag->id());

        $q->execute();
    }

    public function get($id)
    {
        $q = $this->dao->prepare('SELECT NTC_id, NTC_name FROM T_NEW_tagc WHERE NTC_id = :id');
        $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Tag');

        return $q->fetch();
    }

    public function countTag($tag)
    {
        return $this->dao->query("SELECT COUNT(*) FROM T_NEW_tagc WHERE NTC_name = '$tag'")->fetchColumn();
    }

    public function getId($nametag){ //erreur probable
        return $this->dao->query("SELECT NTC_id FROM T_NEW_tagc WHERE NTC_name = '$nametag'")->fetchColumn();
    }

    public function getListOf($idnews)
    {
        $q = $this->dao->prepare('SELECT NTC_name, NTD_fk_new, NTC_id FROM T_NEW_tagd INNER JOIN T_NEW_tagc on NTC_id=NTD_fk_NTC WHERE NTD_fk_new = :idnews GROUP BY NTC_name');
        $q->bindValue(':idnews', $idnews, \PDO::PARAM_INT);
        $q->execute();

        $tag = $q->fetchAll();

        return $tag;
    }

    public function getListOfNews($idtag)
    {
        $q = $this->dao->prepare('SELECT id, auteur, titre, contenu  FROM T_NEW_tagd INNER JOIN news on NTD_fk_new=news.id WHERE NTD_fk_NTC = :idtag GROUP BY id');
        $q->bindValue(':idtag', $idtag);
        $q->execute();

        $tag = $q->fetchAll();

        return $tag;
    }

    public function getname($id){ //erreur probable
        return $this->dao->query("SELECT NTC_name FROM T_NEW_tagc WHERE NTC_id = '$id'")->fetchColumn();
    }

    public function getUnique($id){
        return $this->dao->query("SELECT NTC_name FROM T_NEW_tagc INNER JOIN t_new_tagd on NTD_fk_NTC=NTC_id WHERE NTD_fk_new = '$id'")->fetchAll();
    }


}