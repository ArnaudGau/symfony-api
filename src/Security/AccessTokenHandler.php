<?php

namespace App\Security;

use App\Entity\ApiToken;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

final class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        $apiToken = $this->entityManager->getRepository(ApiToken::class)->findOneBy([
            'tokenHash' => hash('sha256', $accessToken),
        ]);

        if (!$apiToken instanceof ApiToken || $apiToken->isExpired()) {
            throw new BadCredentialsException('Invalid or expired token.');
        }

        return new UserBadge($apiToken->getUser()->getUserIdentifier());
    }
}
