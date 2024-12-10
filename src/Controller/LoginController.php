<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class LoginController extends AbstractController
{
    private $encoder;
    private $jwtManager;

    public function __construct(UserPasswordEncoderInterface $encoder, JWTTokenManagerInterface $jwtManager)
    {
        $this->encoder = $encoder;
        $this->jwtManager = $jwtManager;
    }

    /**
     * @Route("/api/login_check", name="api_login_check", methods={"POST"})
     */
    public function login(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $password = $data['password'];

        $user = $this->getDoctrine()->getRepository(User::class)->findOneByEmail($email);

        if (!$user || !$this->encoder->isPasswordValid($user, $password)) {
            return new JsonResponse(['message' => 'Invalid credentials'], 401);
        }

        $token = $this->jwtManager->create($user);

        return new JsonResponse(['token' => $token]);
    }
}