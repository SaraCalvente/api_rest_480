<?php

namespace App\Service;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class JwtAuthService
{
    private $passwordEncoder;
    private $jwtEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, JWTEncoderInterface $jwtEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->jwtEncoder = $jwtEncoder;
    }

    public function login(string $email, string $password): array
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);

        if (!$user) {
            throw new \InvalidArgumentException('Invalid email or password');
        }

        if (!$this->passwordEncoder->isPasswordValid($user, $password)) {
            throw new \InvalidArgumentException('Invalid email or password');
        }

        return $this->createToken($user);
    }

    public function getUserFromToken(string $token): User
    {
        try {
            $payload = $this->jwtEncoder->decode($token);
        } catch (JWTDecodeFailureException $e) {
            throw new \InvalidArgumentException('Invalid token');
        }

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['email' => $payload['email']]);

        if (!$user) {
            throw new \InvalidArgumentException('Invalid token');
        }

        return $user;
    }

    private function createToken(User $user): array
    {
        try {
            $token = $this->jwtEncoder->encode([
                'email' => $user->getEmail(),
                'exp' => time() + 3600, // 1 hour expiration
            ]);
        } catch (JWTEncodeFailureException $e) {
            throw new \RuntimeException('Error while encoding token');
        }

        return [
            'token' => $token,
            'user' => $user,
        ];
    }
}