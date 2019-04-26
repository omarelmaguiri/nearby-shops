<?php

namespace App\Repository;

use App\Entity\Shop;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Shop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shop[]    findAll()
 * @method Shop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopRepository extends ServiceEntityRepository
{
    const MAX_RESULTS = 12;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Shop::class);
    }

    /**
     * Gets the nearby shops by geo localisation lat & long
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $excludedShopsIds
     * @param int $limit
     * @param int $page
     * @return Shop[] Returns an array of Shop objects
     */
    public function findByLatitudeAndLongitude(float $latitude, float $longitude, array $excludedShopsIds = [], int $page = 1, int $limit = self::MAX_RESULTS)
    {
        $queryBuilder = $this->createQueryBuilder('s')
            ->orderBy('GEO_DISTANCE(s.latitude, s.longitude, :lat, :long)')
            ->setParameter('lat', $latitude)
            ->setParameter('long', $longitude)
        ;
        if ($excludedShopsIds) {
          $queryBuilder->where($queryBuilder->expr()->notIn('s.id', $excludedShopsIds));
        }
        return $this->paginate($queryBuilder, $page, $limit);
    }

    /**
     * Get User Favorite shops
     *
     * @param User $user
     * @param int $page
     * @param int $limit
     * @return Shop[] Returns an array of Favorite Shop objects
     */
    public function findByUser(User $user, int $page = 1, int $limit = self::MAX_RESULTS)
    {
        $queryBuilder = $this->createQueryBuilder('s')
            ->innerJoin('s.favoritedBy', 'f')
            ->andWhere('f.user = :user')
            ->setParameter('user', $user)
            ->orderBy('f.created_at', 'DESC')
        ;
        return $this->paginate($queryBuilder, $page, $limit);
    }

    /*
    public function findOneBySomeField($value): ?Shop
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param QueryBuilder $queryBuilder
     * @param int $page
     * @param int $limit
     * @return Shop[]
     */
    protected function paginate(QueryBuilder $queryBuilder, int $page = 1, int $limit = self::MAX_RESULTS)
    {
        return $queryBuilder
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit)
            ->getQuery()
            ->getResult()
        ;
    }
}
