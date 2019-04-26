<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Security\UsernamePasswordAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class SecurityController extends AbstractFOSRestController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * SecurityController constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    /**
     * @SWG\Post(
     *     tags={"Authentication"},
     *     description="Client phone number registration",
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         type="string",
     *         required=true,
     *         description="Basic auth",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Return client data after successful authentication",
     *     )
     * )
     *
     * @Rest\Post(name="login", path="/login")
     * @Rest\View(serializerGroups={"login"})
     *
     */
    public function login()
    {
        return $this->getUser();
    }

    /**
     * @SWG\Post(
     *     tags={"Registration"},
     *     description="User account creation",
     *     @SWG\Parameter(
     *        name="User",
     *        in="body",
     *        description="User data",
     *        required=true,
     *        @Model(type="App\Entity\User", groups={"signup_doc"})
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Return client data",
     *     )
     * )
     *
     * @Rest\Post(name="signup", path="/public/signup")
     * @ParamConverter(name="user", converter="fos_rest.request_body", options={"validator"={ "groups"={"signup"} }})
     * @Rest\View(serializerGroups={"signup"})
     *
     * @param User $user
     * @param UsernamePasswordAuthenticator $authenticator
     * @param GuardAuthenticatorHandler $guardHandler
     * @param Request $request
     * @param ConstraintViolationListInterface $violations
     * @return User
     */
    public function signup(User $user, UsernamePasswordAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request, ConstraintViolationListInterface $violations)
    {
        if ($violations->count()) {
            $violation = $violations->get(0);
            throw new \RuntimeException(sprintf('Validation failed: %s: %s', $violation->getPropertyPath(), $violation->getMessage()));
        }
        $user
          ->setPassword($this->encoder->encodePassword($user, $user->getPlainPassword()))
          ->setCreatedAt(new \DateTime())
        ;
        $this->em->persist($user);
        $this->em->flush();
        $guardHandler->authenticateUserAndHandleSuccess($user, $request, $authenticator, 'api');
        return $this->getUser();
    }

    /**
     * @Rest\Get("/security/logout", name="logout")
     * @return void
     * @throws \RuntimeException
     */
    public function logoutAction(): void
    {
        throw new \RuntimeException('This should not be reached!');
    }
}
