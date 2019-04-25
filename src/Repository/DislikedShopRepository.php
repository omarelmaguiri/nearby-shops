<?php

namespace App\Repository;

use App\Entity\DislikedShop;
use App\Entity\FavoriteShop;
use App\Entity\Shop;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DislikedShop|null find($id, $lockMode = null, $lockVersion = null)
 * @method DislikedShop|null findOneBy(array $criteria, array $orderBy = null)
 * @method DislikedShop[]    findAll()
 * @method DislikedShop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DislikedShopRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DislikedShop::class);
    }

    // /**
    //  * @return DislikedShop[] Returns an array of DislikedShop objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @param User $user
     * @param Shop $shop
     * @return FavoriteShop|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByUserAndShop(User $user, Shop $shop): ?FavoriteShop
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.user = :user')
            ->andWhere('f.shop = :shop')
            ->setParameter('user', $user)
            ->setParameter('shop', $shop)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
