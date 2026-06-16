<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $data = json_decode($request->getContent(), true);
        $rawContent = $request->getContent();
        $data = json_decode($rawContent, true);

        $form->submit($data, false);
        if ($form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $data['plainPassword'] ?? null;


            if (!$plainPassword) {
                return $this->json(['error' => 'Le mot de passe est manquant dans la requête.'], 400);
            }

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->json([
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
            ], Response::HTTP_CREATED);
        }
        return $this->json(['error' => 'Invalid data', 'details' => (string) $form->getErrors(true, false)], 400);
    }
}
