<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findGamesByName(int $nb): array
    {
        return $this->createQueryBuilder('game')
            ->select('game')
            ->orderBy('game.name', 'ASC')
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findGamesByReleaseDate(int $nb): array
    {
        return $this->createQueryBuilder('game')
            ->select('game')
            ->orderBy('game.publishedAt', 'DESC')
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findLastGames(int $limit = 10, bool $isOrderedByName = false): array {
        // SELECT * FROM game JOIN on language & genre
        $qb = $this->createQueryBuilder('game');

        // Depending on the conditions true/false, I add different ORDER BY on my query
        if ($isOrderedByName) {
            $qb->orderBy('game.name', 'ASC');
        } else {
            $qb->orderBy('game.publishedAt', 'DESC');
        }

        // LIMIT 10 ou LIMIT $limit
        return $qb->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findMostPlayGames(int $nb=10): array
    {
        $q = $this->createQueryBuilder('game');

        $q -> select(['game'])
            -> addSelect('SUM(library.gameTime) AS HIDDEN total_played')
            -> join('library', 'library')
            -> groupBy('library.gameId');

        $q -> orderBy('total_played', 'DESC');

        return $q
            ->getQuery()
            ->getResult()
            ;

//        return $this->createQueryBuilder('library')
//            ->select('library', 'game')
//            ->addSelect('SUM(library.gameTime) as gamePlayed')
//            ->leftJoin('library.game', 'game')
//            ->orderBy('gamePlayed', 'DESC')
//            ->groupBy('library')
//            ->setMaxResults($nb)
//            ->getQuery()
//            ->getResult()
//            ;
    }

    // /**
    //  * @return Game[] Returns an array of Game objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}