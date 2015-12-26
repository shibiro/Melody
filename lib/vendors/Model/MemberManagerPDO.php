<?php
namespace Model;


use \Entity\Member;
class MemberManagerPDO extends MemberManager
{

    const mmc_priority_admin = 2;
//v�rifie que le login rentr� existe et retourner la priorit� dans ces cas l�

// Attention pseudo ou id , unicit� sur pseudo ?

    protected function add(Member $member)
    {
        $requete = $this->dao->prepare('INSERT INTO T_mem_memberc SET mmc_username = :username, mmc_password = :password, mmc_description = :description, mmc_mail = :mail');

        $requete->bindValue(':username', htmlspecialchars($member->username()));
        $requete->bindValue(':password', htmlspecialchars($member->password()));
        $requete->bindValue(':description', htmlspecialchars($member->description()));
        $requete->bindValue(':mail', htmlspecialchars($member->mail()));

        $requete->execute();
    }

    public function isAdmin($username){
        $i=0;
        $requete = $this->dao->prepare('SELECT mmc_priority FROM T_mem_memberc WHERE mmc_username = :login AND mmc_priority = :priority');
        $requete->bindValue(':login',  $username);
        $requete->bindValue(':priority',  self::mmc_priority_admin);
        $requete->execute();
        while( $resultat = $requete->fetch(\PDO::FETCH_OBJ) ){
            $i=$i+1;
        }

        if($i != 1){
            return false;
        }
        else{
            return true;
        }
    }

    public function verifyUsername($username){
        $i=0;
        $requete = $this->dao->prepare('SELECT mmc_username FROM T_mem_memberc WHERE mmc_username = :login');
        $requete->bindValue(':login', $username);
        $requete->execute();
        while( $resultat = $requete->fetch(\PDO::FETCH_OBJ) ){
            $i=$i+1;
        }

        if($i != 1){
            return false;
        }
        else{
            return $requete;
        }
    }
    public function verifyunexistUsername($username){
        $i=0;
        $requete = $this->dao->prepare('SELECT mmc_username FROM T_mem_memberc WHERE mmc_username = :login');
        $requete->bindValue(':login', $username);
        $requete->execute();
        while( $resultat = $requete->fetch(\PDO::FETCH_OBJ) ){
            $i=$i+1;
        }

        if($i != 0){
            return false;
        }
        else{
            return $requete;
        }
    }

    public function getUsername($id){ //erreur probable
        return $this->dao->query("SELECT mmc_username FROM T_mem_memberc WHERE mmc_id = '$id'")->fetchColumn();
    }
//faire une function get globale possible ?
    public function getId($username){ //erreur probable
        return $this->dao->query("SELECT mmc_id FROM T_mem_memberc WHERE mmc_username = '$username'")->fetchColumn();
    }

    public function getMail($username){ //erreur probable
        return $this->dao->query("SELECT mmc_mail FROM T_mem_memberc WHERE mmc_username = '$username'")->fetchColumn();
    }

    public function getPassword($username){ //erreur probable
        return $this->dao->query("SELECT mmc_password FROM T_mem_memberc WHERE mmc_username ='$username'")->fetchColumn();
    }

    public function getPriority($username){ //erreur probable
        return $this->dao->query("SELECT mmc_priority FROM T_mem_memberc WHERE mmc_username ='$username'")->fetchColumn();
    }

    public function getDescription($username){ //erreur probable
        return $this->dao->query("SELECT mmc_description FROM T_mem_memberc WHERE mmc_username ='$username'")->fetchColumn();
    }



    public function verifyPassword($username, $password){
        $i=0;
        $requete = $this->dao->prepare('SELECT mmc_password FROM t_mem_memberc WHERE mmc_username = :login AND mmc_password =:password');
        $requete->bindValue(':login', $username);
        $requete->bindValue(':password', $password);
        $requete->execute();
        if( $resultat = $requete->fetch(\PDO::FETCH_OBJ) ){
            $i=$i+1;
        }
        if($i != 1  ){
            return false;
        }
        else{
            return true;
        }
    }


}