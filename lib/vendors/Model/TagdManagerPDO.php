<?php
namespace Model;

use \Entity\Tagd;

class TagdManagerPDO extends TagdManager
{

    public function add(Tagd $tagd) // s'occuper des doublons ici en faisant un left inner join sur lui même
    {
        $q = $this->dao->prepare('INSERT INTO T_NEW_tagd SET NTD_fk_NTC = :idtag, NTD_fk_new = :idnew');

        $q->bindValue(':idtag', $tagd->Idtag());
        $q->bindValue(':idnew', $tagd->Idnew());

        $q->execute();

    }




    public function delete($id)
    {
        $this->dao->exec('DELETE FROM T_NEW_tagd WHERE NTD_id = '.(int) $id);
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


    public function get($id)
    {
        $q = $this->dao->prepare('SELECT NTC_id, NTC_name FROM T_NEW_tagd WHERE NTD_id = :id');
        $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Tag');

        return $q->fetch();
    }

    public function count($tagid,$idnew)
    {
        return $this->dao->query("SELECT COUNT(*) FROM T_NEW_tagd WHERE NTD_id = '$tagid' AND NTD_fk_new = '$idnew'")->fetchColumn();
    }

    public function deleteFromNews($news)
    {
        $this->dao->exec('DELETE FROM T_NEW_tagd WHERE NTD_fk_new = '.(int) $news);
    }

    public function getListOf($idnews)
    {
        if (!ctype_digit($idnews))
        {
            throw new \InvalidArgumentException('L\'identifiant de la news passé doit être un nombre entier valide');
        }

        $q = $this->dao->prepare('SELECT NTD_fk_NTC  FROM T_NEW_tagd  WHERE NTD_fk_new = :idnews GROUP BY NTD_fk_NTC');
        $q->bindValue(':idnews', $idnews, \PDO::PARAM_INT);
        $q->execute();

        $tag = $q->fetchAll();

        return $tag;
    }


}