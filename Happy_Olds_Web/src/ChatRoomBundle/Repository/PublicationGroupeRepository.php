<?php

namespace ChatRoomBundle\Repository;

/**
 * PublicationGroupeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PublicationGroupeRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllAccessible($groupe_id, $user_id)
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT p FROM ChatRoomBundle:PublicationGroupe p "
                ."LEFT JOIN p.groupe g "
                ."WHERE g.id = :group "
                ."AND ( "
                    ."( "
                        ."g.type in ('private','closed') "
                        ."AND EXISTS( "
                            ."SELECT 1 FROM ChatRoomBundle:MembreGroupe m "
                            ."WHERE m.groupe = g.id "
                            ."AND m.user = :user "
                            ."AND m.authorized = 1 "
                            ."AND m.banned != 1 "
                        .") "
                    .") "
                    ."OR g.type = 'public' "
                    ."OR g.creator = :user "
                .")")
            ->setParameter(':group',$groupe_id)
            ->setParameter(':user',$user_id);
        return $query->getResult();
    }

    public function findMineAccessible($user_id)
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT p FROM ChatRoomBundle:PublicationGroupe p "
                ."WHERE p.user = :user ")
            ->setParameter(':user',$user_id);
        return $query->getResult();
    }

    public function findAccessible($publication_id, $user_id)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM ChatRoomBundle:PublicationGroupe p "
            ."LEFT JOIN p.groupe g "
            ."WHERE p.id = :publication "
            ."AND ( "
                ."( "
                    ."g.type in ('private','closed') "
                    ."AND EXISTS( "
                        ."SELECT 1 FROM ChatRoomBundle:MembreGroupe m "
                        ."WHERE m.groupe = g.id "
                        ."AND m.user = :user "
                        ."AND m.authorized = 1 "
                        ."AND m.banned != 1 "
                    .") "
                .") "
                ."OR g.type = 'public' "
                ."OR g.creator = :user "
            .")")
        ->setParameter(':publication',$publication_id)
        ->setParameter(':user',$user_id);
        return $query->getOneOrNullResult();
    }

    public function findAllSubscribed($user_id)
    {
        $query=$this->getEntityManager()
            ->createQuery("SELECT p FROM ChatRoomBundle:PublicationGroupe p "
                ."LEFT JOIN p.groupe g "
                ."WHERE EXISTS( "
                    ."SELECT 1 FROM ChatRoomBundle:MembreGroupe m "
                    ."WHERE m.groupe = g.id "
                    ."AND m.user = :user "
                    ."AND m.authorized = 1 "
                    ."AND m.banned != 1 "
                .") "
                ."ORDER BY p.datePublication DESC ")
            ->setParameter(':user',$user_id);
        return $query->getResult();
    }
}
