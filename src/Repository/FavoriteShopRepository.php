<?php

namespace App\Repository;

use App\Entity\FavoriteShop;
use App\Entity\Shop;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FavoriteShop|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavoriteShop|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavoriteShop[]    findAll()
 * @method FavoriteShop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteShopRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FavoriteShop::class);
    }

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
