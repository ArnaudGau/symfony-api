<?php

namespace App\Tests\Helper;

use App\Entity\User;

final class UserFactory
{
    public static function admin(): User
    {
        return (new User())
            ->setEmail('admin@test.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('fake-password');
    }

    public static function user(): User
    {
        return (new User())
            ->setEmail('user@test.fr')
            ->setRoles(['ROLE_USER'])
            ->setPassword('fake-password');
    }
}
