<?php

namespace ChatRoomBundle\Repository;

/**
 * MembreGroupeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MembreGroupeRepository extends \Doctrine\ORM\EntityRepository
{

    public function getListGroupMembers($groupe_id, $user_id,$username,$nom,$prenom,$offset =0, $maxResult = 100)
    {
        //return $this->findAll();
        $query=$this->getEntityManager()
            ->createQuery("SELECT u.id, u.username, u.nom, u.prenom FROM ChatRoomBundle:MembreGroupe m "
                ."JOIN m.groupe g "
                ."JOIN m.user u "
                ."WHERE m.groupe = :groupe "
                ."AND m.banned != 1 "
                ."AND m.authorized = 1 "
                ."AND u.username LIKE :username "
                ."AND u.prenom LIKE :prenom "
                ."AND u.nom LIKE :nom "
                ."AND ( "
                    ."g.type in ('private','public') "
                    ."OR :user_id in ("
                        ."SELECT u2.id FROM ChatRoomBundle:MembreGroupe m2 "
                        ."JOIN m2.user u2 "
                        ."JOIN m2.groupe g2 "
                        ."WHERE g2.id = :groupe "
                    .") "
                .") ")
            ->setParameter(':groupe',$groupe_id)
            ->setParameter(':user_id',$user_id)
            ->setParameter(":username","%".$username."%")
            ->setParameter(":nom","%".$nom."%")
            ->setParameter(":prenom","%".$prenom."%")
            ->setFirstResult($offset)
            ->setMaxResults($maxResult);
        return $query->getResult();
    }

    public function isInWaitingList($groupe_id, $member_id)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT count(1) as result from ChatRoomBundle:MembreGroupe m "
                ."WHERE m.groupe = :groupe "
                ."AND m.user = :member "
                ."AND m.authorized != 1 "
                ."AND m.banned != 1 ")
            ->setParameter(":member",$member_id)
            ->setParameter(":groupe",$groupe_id);
        return $query->getOneOrNullResult()["result"] > 0;
    }

    public function getListToAuthorizeGroupMembers($groupe_id, $user_id,$username,$nom,$prenom,$offset =0, $maxResult = 100)
    {
        //return $this->findAll();
        $query=$this->getEntityManager()
            ->createQuery("SELECT u.id, u.username, u.nom, u.prenom FROM ChatRoomBundle:MembreGroupe m "
                ."JOIN m.groupe g "
                ."JOIN m.user u "
                ."WHERE m.groupe = :groupe "
                ."AND m.authorized != 1 "
                ."AND u.username LIKE :username "
                ."AND u.prenom LIKE :prenom "
                ."AND u.nom LIKE :nom "
                ."AND ( "
                ."g.type in ('private','public')"
                ."OR :user_id in ("
                ."SELECT u2.id FROM ChatRoomBundle:MembreGroupe m2 "
                ."JOIN m2.user u2 "
                ."JOIN m2.groupe g2 "
                ."WHERE g2.id = :groupe "
                .") "
                .") ")
            ->setParameter(':groupe',$groupe_id)
            ->setParameter(':user_id',$user_id)
            ->setParameter(":username","%".$username."%")
            ->setParameter(":nom","%".$nom."%")
            ->setParameter(":prenom","%".$prenom."%")
            ->setFirstResult($offset)
            ->setMaxResults($maxResult);
        return $query->getResult();
    }

    public function getListBannedGroupMembers($groupe_id, $user_id,$username,$nom,$prenom,$offset =0, $maxResult = 100)
    {
        //return $this->findAll();
        $query=$this->getEntityManager()
            ->createQuery("SELECT u.id, u.username, u.nom, u.prenom FROM ChatRoomBundle:MembreGroupe m "
                ."JOIN m.groupe g "
                ."JOIN m.user u "
                ."WHERE m.groupe = :groupe "
                ."AND m.banned = 1 "
                ."AND u.username LIKE :username "
                ."AND u.prenom LIKE :prenom "
                ."AND u.nom LIKE :nom "
                ."AND ( "
                ."g.type in ('private','public')"
                ."OR :user_id in ("
                ."SELECT u2.id FROM ChatRoomBundle:MembreGroupe m2 "
                ."JOIN m2.user u2 "
                ."JOIN m2.groupe g2 "
                ."WHERE g2.id = :groupe "
                .") "
                .") ")
            ->setParameter(':groupe',$groupe_id)
            ->setParameter(':user_id',$user_id)
            ->setParameter(":username","%".$username."%")
            ->setParameter(":nom","%".$nom."%")
            ->setParameter(":prenom","%".$prenom."%")
            ->setFirstResult($offset)
            ->setMaxResults($maxResult);
        return $query->getResult();
    }

    public function getListOfUsersToInvite($groupe_id,$username,$nom,$prenom,$offset =0, $maxResult = 100)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT u.id, u.username, u.nom, u.prenom from HappyOldsMainBundle:User u "
                ."WHERE u.username LIKE :username "
                ."AND u.prenom LIKE :prenom "
                ."AND u.nom LIKE :nom "
                ."AND u.id NOT IN ("
                    ."SELECT u2.id FROM ChatRoomBundle:MembreGroupe m "
                    ."JOIN m.user u2 "
                    ."JOIN m.groupe g "
                    ."WHERE g.id = :groupe "
                .") ")
            ->setParameter(":groupe",$groupe_id)
            ->setParameter(":username","%".$username."%")
            ->setParameter(":nom","%".$nom."%")
            ->setParameter(":prenom","%".$prenom."%")
            ->setFirstResult($offset)
            ->setMaxResults($maxResult);
        return $query->getResult();
    }

    public function findMember($group_id, $user_id)
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT m FROM ChatRoomBundle:MembreGroupe m "
                ."WHERE m.groupe = :groupe "
                ."AND m.user = :user_id "
                ."AND m.banned != 1 "
                ."AND m.authorized = 1 ")
            ->setParameter(':groupe',$group_id)
            ->setParameter(':user_id',$user_id);
        return $query->getOneOrNullResult();
    }

    public function findToAuthorizeMember($group_id, $user_id)
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT m FROM ChatRoomBundle:MembreGroupe m "
                ."WHERE m.groupe = :groupe "
                ."AND m.user = :user_id "
                ."AND m.authorized != 1 ")
            ->setParameter(':groupe',$group_id)
            ->setParameter(':user_id',$user_id);
        return $query->getOneOrNullResult();
    }

    public function findBannedMember($group_id, $user_id)
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT m FROM ChatRoomBundle:MembreGroupe m "
                ."WHERE m.groupe = :groupe "
                ."AND m.user = :user_id "
                ."AND m.banned = 1 ")
            ->setParameter(':groupe',$group_id)
            ->setParameter(':user_id',$user_id);
        return $query->getOneOrNullResult();
    }
}
