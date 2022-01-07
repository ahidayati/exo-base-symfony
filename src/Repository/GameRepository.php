<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Genre;
use App\Entity\Library;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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

    public function findMostPlayedGames(int $nb): array
    {
        $q = $this->createQueryBuilder('game');

//        SELECT game.name, SUM(library.game_time) as total_played
//        FROM game
//        JOIN library ON library.game_id=game.id
//        GROUP BY game.name
//        ORDER BY total_played DESC
        $q -> select('game')
            -> join(Library::class, 'library', Join::WITH, 'library.game=game')
            -> setMaxResults($nb)
            -> groupBy('game.name')
            -> orderBy('SUM(library.gameTime)', 'DESC');

        return $q
            ->getQuery()
            ->getResult()
            ;
    }

    public function findGameWithRelation(string $slug): array
    {
        $q = $this->createQueryBuilder('game');
        $q -> select('game', 'genres', 'languages')
            -> innerJoin('game.genres', 'genres')
            -> innerJoin ('game.languages', 'languages')
//            -> andWhere($slug)
            ;

        return $q
            ->getQuery()
            ->getResult()
            ;
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