<?php

namespace App\Controller\Api;

use App\Entity\DislikedShop;
use App\Entity\FavoriteShop;
use App\Entity\Shop;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Swagger\Annotations as SWG;

/**
 * @Rest\Route(path="/shops", name="api.shops_")
 */
class ShopController extends AbstractFOSRestController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ShopController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
      $this->em = $em;
    }

    /**
     * @SWG\Get(
     *     tags={"SHOP"},
     *     description="Return a chuck of nearby shops",
     *     @SWG\Parameter(name="latitude", type="number", in="query"),
     *     @SWG\Parameter(name="longitude", type="number", in="query"),
     *     @SWG\Response(
     *         response=200,
     *         description="Nearby shops list"
     *     )
     * )
     *
     * @Rest\Get("/", name="list")
     * @Rest\QueryParam(name="latitude", default="33.5739983", requirements="\-?\d+(\.\d+)?", description="User geo-location latitude")
     * @Rest\QueryParam(name="longitude", default="-7.6584367", requirements="\-?\d+(\.\d+)?", description="User geo-location longitude")
     * @Rest\QueryParam(name="page", default="1", requirements="\d+", description="Page to display")
     * @Rest\View(serializerGroups={"api"})
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $page
     * @return Shop[]
     */
    public function nearBy(float $latitude, float $longitude, int $page)
    {
        $favoriteShopsIds = $this->getUser()->getFavoriteShops()->map(function ($favoriteShop) {return $favoriteShop->getShop()->getId();})->toArray();
        $dislikedShopsIds = $this->getUser()->getLastDislikedShops()->map(function ($dislikedShop) {return $dislikedShop->getShop()->getId();})->toArray();
//        dump(compact('favoriteShopsIds', 'dislikedShopsIds'));die;
        return $this->em->getRepository(Shop::class)->findByLatitudeAndLongitude($latitude, $longitude, array_merge($favoriteShopsIds, $dislikedShopsIds), $page);
    }

    /**
     * @SWG\Get(
     *     tags={"SHOP"},
     *     description="Return a chuck of the favorite shops",
     *     @SWG\Response(
     *         response=200,
     *         description="Favorite shops list"
     *     )
     * )
     *
     * @Rest\Get("/favorites", name="favorites")
     * @Rest\QueryParam(name="page", default="1", requirements="\d+", description="Page to display")
     * @Rest\View(serializerGroups={"api"})
     *
     * @param int $page
     * @return Shop[]
     */
    public function favorites(int $page)
    {
        return $this->em->getRepository(Shop::class)->findByUser($this->getUser(), $page);
    }

    /**
     * @SWG\Put(
     *     tags={"SHOP"},
     *     description="Add a shop to the user's favorites",
     *     @SWG\Response(
     *         response=204,
     *         description="Shop successfully added to user's favorites"
     *     )
     * )
     *
     * @Rest\Put("/{id<\d+>}/favorite", name="favorite")
     * @Rest\View()
     *
     * @param Shop $shop
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function favorite(Shop $shop)
    {
        if ($this->em->getRepository(FavoriteShop::class)->findOneByUserAndShop($this->getUser(), $shop)) {
            return;
        }
        $this->getUser()->addFavoriteShop((new FavoriteShop())->setShop($shop));
        $this->em->persist($this->getUser());
        $this->em->flush();
    }

    /**
     * @SWG\Put(
     *     tags={"SHOP"},
     *     description="Remove a shop from the user's favorites",
     *     @SWG\Response(
     *         response=204,
     *         description="Shop successfully removed from user's favorites"
     *     )
     * )
     *
     * @Rest\Put("/{id<\d+>}/unfavorite", name="unfavorite")
     * @Rest\View()
     *
     * @param Shop $shop
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function unfavorite(Shop $shop)
    {
        if (!$favoriteShop = $this->em->getRepository(FavoriteShop::class)->findOneByUserAndShop($this->getUser(), $shop)) {
          throw $this->createNotFoundException();
        }
        $this->getUser()->removeFavoriteShop($favoriteShop);
        $this->em->persist($this->getUser());
        $this->em->flush();
    }

    /**
     * @SWG\Put(
     *     tags={"SHOP"},
     *     description="Add a shop to the user's dislikes",
     *     @SWG\Response(
     *         response=204,
     *         description="Shop successfully added to user's dislikes"
     *     )
     * )
     *
     * @Rest\Put("/{id<\d+>}/dislike", name="dislike")
     * @Rest\View()
     *
     * @param Shop $shop
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function dislike(Shop $shop)
    {
        if ($this->em->getRepository(FavoriteShop::class)->findOneByUserAndShop($this->getUser(), $shop)) {
            return;
        }
        $this->getUser()->addDislikedShop((new DislikedShop())->setShop($shop));
        $this->em->persist($this->getUser());
        $this->em->flush();
    }
}
