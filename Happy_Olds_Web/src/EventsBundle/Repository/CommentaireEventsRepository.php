<?php

namespace EventsBundle\Repository;

/**
 * CommentaireEventsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */

use Doctrine\ORM\EntityRepository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentaireEventsRepository extends \Doctrine\ORM\EntityRepository
{
   // public function getCommentsForBlog($blogId)
   // {
       // $qb = $this->createQueryBuilder('c')
        //    ->select('c')
         //   ->where('c.blog = :blog_id')
          //  ->addOrderBy('c.created')
         //   ->setParameter('blog_id', $blogId);

      //  if (false === is_null($approved))
         //   $qb->andWhere('c.approved = :approved')
          //      ->setParameter('approved', $approved);

      //  return $qb->getQuery()
       //     ->getResult();
   // }
}
