<?php

namespace App\Controller;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Routing\Attribute\Route;

final class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user, EntityManagerInterface $entityManager): JsonResponse
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $plainToken = bin2hex(random_bytes(32));
        $expiresAt = new \DateTimeImmutable('+1 day');

        $entityManager->persist(new ApiToken($user, $plainToken, $expiresAt));
        $entityManager->flush();

        return $this->json([
            'token_type' => 'Bearer',
            'token' => $plainToken,
            'expires_at' => $expiresAt->format(\DateTimeInterface::ATOM),
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getUserIdentifier(),
                'roles' => $user->getRoles(),
            ],
        ]);
    }
}
